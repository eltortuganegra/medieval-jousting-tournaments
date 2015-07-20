<?php

/**
 * This is the model class for table "rounds".
 *
 * The followings are the available columns in table 'rounds':
 * @property string $combats_id
 * @property integer $number
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Combats $combats
 * @property Constants $status0
 */
class Rounds extends CActiveRecord
{
		const STATUS_PENDING = 130;
		const STATUS_FROM_KNIGHT_WIN = 131;
		const STATUS_TO_KNIGHT_WIN = 132;
		const STATUS_DRAW = 133;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Rounds the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rounds';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('combats_id, number, status', 'required'),
			array('number', 'numerical', 'integerOnly'=>true),
			array('combats_id, status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('combats_id, number, status', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'combats' => array(self::BELONGS_TO, 'Combats', 'combats_id'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'combats_id' => 'Combats',
			'number' => 'Number',
			'status' => 'Status',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('combats_id',$this->combats_id,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Check if impact is defended
	 * @param unknown_type $attack_point
	 * @param unknown_type $defense_point
	 */
	public static function isImpactDefended( $attack_point, $defense_point, $shield_width, $shield_height ){
		$totalCellByRow = 8;
		
		for( $y=0; $y<$shield_height;$y++ ){
			for( $x=0;$x<$shield_width;$x++ ){				
				if( $attack_point == $defense_point+$x+$y*$totalCellByRow ) return true;
			}
		}
		
		//Not defended
		return false;
	}
	
	/**
	 * Calculate the damage received an damage defended produced by one attaker
	 * @param unknown_type $attacker_round_data
	 * @param unknown_type $defender_round_data
	 * @param unknown_type $attacker_spear_damage
	 * @param unknown_type $attacker_pain
	 * @param unknown_type $defender_armour_enurance
	 * @param unknown_type $defender_shield_endurance
	 * @param unknown_type $defender_pain
	 * @return array 
	 */
	public static function calculateDamage( $attacker_round_data, $defender_round_data, $attacker_spear_damage, $attacker_pain, $defender_armour_endurance, $defender_shield_endurance, $defender_pain){
		
		$damage =array(
			'received_damage'=>
				$attacker_round_data->knights_skill +
				$attacker_round_data->knights_spear +
				$attacker_round_data->attack_throw	+
				$attacker_spear_damage -
				$attacker_pain,
			'defended_damage'=> 
				$defender_round_data->knights_dexterity +
				$defender_round_data->knights_shield +
				$defender_round_data->defense_throw +
				floor($defender_round_data->knights_constitution / 2 ) + //Defensa contundente
				$defender_armour_endurance +
				$defender_shield_endurance -
				$defender_pain
			);
			
		if( $damage['received_damage'] < 0 ) $damage['received_damage'] = 0 ;
		if( $damage['defended_damage'] < 0 ) $damage['defended_damage'] = 0 ;
		return $damage;		
	}
	
	/**
	 * Check if user fall. The limits of fall are 70%, 40% and 10% of endurance of knight 
	 * @param unknown_type $knight_endurance_maximum
	 * @param unknown_type $knight_endurance_before_attack
	 * @param unknown_type $knight_endurance_after_attack
	 * @return 0 or 1 for true or false
	 */
	public static function checkFall( $knight_endurance_maximum, $knight_endurance_before_attack, $knight_endurance_after_attack ){
		$limits = array( 70, 40, 10 );
		$percent_before_attack = 100*$knight_endurance_before_attack/$knight_endurance_maximum;
		$percent_after_attack = 100*$knight_endurance_after_attack/$knight_endurance_maximum;
		
		//echo "$knight_endurance_maximum - $knight_endurance_before_attack - $knight_endurance_after_attack - ".$percent_before_attack."% ".$percent_after_attack.'%';
		foreach( $limits as $limit ){
			if( $percent_before_attack > $limit && $percent_after_attack < $limit ) return 1;
		}
		return 0;
	}
	
	/**
	 * Check amount damage received and check the percent with life of knight. Return type of injury
	 * @param unknown_type $knight_maximun_life
	 * @param unknown_type $knight_life_damage_received
	 * @return string
	 */
	public static function getInjuryType( $knight_maximun_life, $knight_life_damage_received ){
		$limits = array( 
			100=> Knights::TYPE_INJURY_FATALITY,
			90=> Knights::TYPE_INJURY_VERY_SERIOUSLY,
			50=> Knights::TYPE_INJURY_SERIOUSLY,
			0=> Knights::TYPE_INJURY_LIGHT 
		);
		$percent_loose_life = $knight_life_damage_received * 100 / $knight_maximun_life;
		foreach($limits as $limit => $type_injury){
			if( $percent_loose_life > $limit) return $type_injury;
		}
	}

	/**
	 * Check pain associated to this injury type
	 */
	public static function getPainByInjuryType( $injuryType ){
		$pain = array(
			Knights::TYPE_INJURY_LIGHT => 1,
			Knights::TYPE_INJURY_SERIOUSLY => 3,
			Knights::TYPE_INJURY_VERY_SERIOUSLY => 6,
			Knights::TYPE_INJURY_FATALITY => 10 //Knight can not combat
		);
		return $pain[$injuryType];
	}
		
	
}