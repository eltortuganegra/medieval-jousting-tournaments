<?php

/**
 * This is the model class for table "rounds_data".
 *
 * The followings are the available columns in table 'rounds_data':
 * @property string $rounds_combats_id
 * @property integer $rounds_number
 * @property string $knights_id
 * @property string $date
 * @property integer $knights_endurance
 * @property integer $knights_life
 * @property integer $knights_pain
 * @property integer $attack_point
 * @property integer $defense_point
 * @property integer $pain_throw
 * @property integer $knights_will
 * @property integer $knights_concentration
 * @property integer $knights_skill
 * @property integer $knights_dexterity
 * @property integer $knights_spear
 * @property integer $knights_shield
 * @property integer $knights_constitution
 * @property string $armour_id
 * @property integer $armour_object_pde_initial
 * @property integer $armour_object_pde_final
 * @property string $shield_id
 * @property integer $shield_object_pde_initial
 * @property integer $shield_object_pde_final
 * @property string $spears_id
 * @property integer $spears_object_pde_initial
 * @property integer $spears_object_pde_final
 * @property integer $attack_throw
 * @property integer $defense_throw
 * @property integer $is_pain_throw_pass
 * @property integer $received_impact_inventory_position
 * @property integer $is_received_impact_defended
 * @property integer $received_damage
 * @property integer $defended_damage
 * @property integer $is_falled
 * @property string $status
 * @property string $injury_type
 * @property integer $pde_armour_loosed
 * @property integer $pde_shield_loosed
 * @property integer $pde_spear_loosed
 * @property integer $is_armour_destroyed
 * @property integer $is_shield_destroyed
 * @property integer $is_spear_destroyed
 * @property integer $extra_damage
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Armours $armour
 * @property Armours $shield
 * @property Constants $status0
 * @property Constants $injuryType
 * @property Rounds $roundsCombats
 * @property Rounds $roundsNumber
 * @property Spears $spears
 */
class RoundsData extends CActiveRecord
{
	const STATUS_PENDING = 141;
	const STATUS_RESISTED = 142;
	const STATUS_KNOCK_DOWN = 143;
	const STATUS_KNOCK_OUT = 144;
	const STATUS_INJURIED = 145;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RoundsData the static model class
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
		return 'rounds_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rounds_combats_id, rounds_number, knights_id, date, knights_endurance, knights_life, knights_pain, attack_point, defense_point, knights_will, knights_concentration, knights_skill, knights_dexterity, knights_spear, knights_shield, knights_constitution, shield_id, shield_object_pde_initial, spears_id, spears_object_pde_initial, attack_throw, defense_throw', 'required'),
			array('rounds_number, knights_endurance, knights_life, knights_pain, attack_point, defense_point, pain_throw, knights_will, knights_concentration, knights_skill, knights_dexterity, knights_spear, knights_shield, knights_constitution, armour_object_pde_initial, armour_object_pde_final, shield_object_pde_initial, shield_object_pde_final, spears_object_pde_initial, spears_object_pde_final, attack_throw, defense_throw, is_pain_throw_pass, received_impact_inventory_position, is_received_impact_defended, received_damage, defended_damage, is_falled, pde_armour_loosed, pde_shield_loosed, pde_spear_loosed, is_armour_destroyed, is_shield_destroyed, is_spear_destroyed, extra_damage', 'numerical', 'integerOnly'=>true),
			array('rounds_combats_id, knights_id, armour_id, shield_id, spears_id, status, injury_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('rounds_combats_id, rounds_number, knights_id, date, knights_endurance, knights_life, knights_pain, attack_point, defense_point, pain_throw, knights_will, knights_concentration, knights_skill, knights_dexterity, knights_spear, knights_shield, knights_constitution, armour_id, armour_object_pde_initial, armour_object_pde_final, shield_id, shield_object_pde_initial, shield_object_pde_final, spears_id, spears_object_pde_initial, spears_object_pde_final, attack_throw, defense_throw, is_pain_throw_pass, received_impact_inventory_position, is_received_impact_defended, received_damage, defended_damage, is_falled, status, injury_type, pde_armour_loosed, pde_shield_loosed, pde_spear_loosed, is_armour_destroyed, is_shield_destroyed, is_spear_destroyed, extra_damage', 'safe', 'on'=>'search'),
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
			'knights' => array(self::BELONGS_TO, 'Knights', 'knights_id'),
			'armour' => array(self::BELONGS_TO, 'Armours', 'armour_id'),
			'shield' => array(self::BELONGS_TO, 'Armours', 'shield_id'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
			'injuryType' => array(self::BELONGS_TO, 'Constants', 'injury_type'),
			'roundsCombats' => array(self::BELONGS_TO, 'Rounds', 'rounds_combats_id'),
			'roundsNumber' => array(self::BELONGS_TO, 'Rounds', 'rounds_number'),
			'spears' => array(self::BELONGS_TO, 'Spears', 'spears_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'rounds_combats_id' => 'Rounds Combats',
			'rounds_number' => 'Rounds Number',
			'knights_id' => 'Knights',
			'date' => 'Date',
			'knights_endurance' => 'Knights Endurance',
			'knights_life' => 'Knights Life',
			'knights_pain' => 'Knights Pain',
			'attack_point' => 'Attack Point',
			'defense_point' => 'Defense Point',
			'pain_throw' => 'Pain Throw',
			'knights_will' => 'Knights Will',
			'knights_concentration' => 'Knights Concentration',
			'knights_skill' => 'Knights Skill',
			'knights_dexterity' => 'Knights Dexterity',
			'knights_spear' => 'Knights Spear',
			'knights_shield' => 'Knights Shield',
			'knights_constitution' => 'Knights Constitution',
			'armour_id' => 'Armour',
			'armour_object_pde_initial' => 'Armour Object Pde Initial',
			'armour_object_pde_final' => 'Armour Object Pde Final',
			'shield_id' => 'Shield',
			'shield_object_pde_initial' => 'Shield Object Pde Initial',
			'shield_object_pde_final' => 'Shield Object Pde Final',
			'spears_id' => 'Spears',
			'spears_object_pde_initial' => 'Spears Object Pde Initial',
			'spears_object_pde_final' => 'Spears Object Pde Final',
			'attack_throw' => 'Attack Throw',
			'defense_throw' => 'Defense Throw',
			'is_pain_throw_pass' => 'Is Pain Throw Pass',
			'received_impact_inventory_position' => 'Received Impact Inventory Position',
			'is_received_impact_defended' => 'Is Received Impact Defended',
			'received_damage' => 'Received Damage',
			'defended_damage' => 'Defended Damage',
			'is_falled' => 'Is Falled',
			'status' => 'Status',
			'injury_type' => 'Injury Type',
			'pde_armour_loosed' => 'Pde Armour Loosed',
			'pde_shield_loosed' => 'Pde Shield Loosed',
			'pde_spear_loosed' => 'Pde Spear Loosed',
			'is_armour_destroyed' => 'Is Armour Destroyed',
			'is_shield_destroyed' => 'Is Shield Destroyed',
			'is_spear_destroyed' => 'Is Spear Destroyed',
			'extra_damage' => 'Extra Damage',
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

		$criteria->compare('rounds_combats_id',$this->rounds_combats_id,true);
		$criteria->compare('rounds_number',$this->rounds_number);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('knights_endurance',$this->knights_endurance);
		$criteria->compare('knights_life',$this->knights_life);
		$criteria->compare('knights_pain',$this->knights_pain);
		$criteria->compare('attack_point',$this->attack_point);
		$criteria->compare('defense_point',$this->defense_point);
		$criteria->compare('pain_throw',$this->pain_throw);
		$criteria->compare('knights_will',$this->knights_will);
		$criteria->compare('knights_concentration',$this->knights_concentration);
		$criteria->compare('knights_skill',$this->knights_skill);
		$criteria->compare('knights_dexterity',$this->knights_dexterity);
		$criteria->compare('knights_spear',$this->knights_spear);
		$criteria->compare('knights_shield',$this->knights_shield);
		$criteria->compare('knights_constitution',$this->knights_constitution);
		$criteria->compare('armour_id',$this->armour_id,true);
		$criteria->compare('armour_object_pde_initial',$this->armour_object_pde_initial);
		$criteria->compare('armour_object_pde_final',$this->armour_object_pde_final);
		$criteria->compare('shield_id',$this->shield_id,true);
		$criteria->compare('shield_object_pde_initial',$this->shield_object_pde_initial);
		$criteria->compare('shield_object_pde_final',$this->shield_object_pde_final);
		$criteria->compare('spears_id',$this->spears_id,true);
		$criteria->compare('spears_object_pde_initial',$this->spears_object_pde_initial);
		$criteria->compare('spears_object_pde_final',$this->spears_object_pde_final);
		$criteria->compare('attack_throw',$this->attack_throw);
		$criteria->compare('defense_throw',$this->defense_throw);
		$criteria->compare('is_pain_throw_pass',$this->is_pain_throw_pass);
		$criteria->compare('received_impact_inventory_position',$this->received_impact_inventory_position);
		$criteria->compare('is_received_impact_defended',$this->is_received_impact_defended);
		$criteria->compare('received_damage',$this->received_damage);
		$criteria->compare('defended_damage',$this->defended_damage);
		$criteria->compare('is_falled',$this->is_falled);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('injury_type',$this->injury_type,true);
		$criteria->compare('pde_armour_loosed',$this->pde_armour_loosed);
		$criteria->compare('pde_shield_loosed',$this->pde_shield_loosed);
		$criteria->compare('pde_spear_loosed',$this->pde_spear_loosed);
		$criteria->compare('is_armour_destroyed',$this->is_armour_destroyed);
		$criteria->compare('is_shield_destroyed',$this->is_shield_destroyed);
		$criteria->compare('is_spear_destroyed',$this->is_spear_destroyed);
		$criteria->compare('extra_damage',$this->extra_damage);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}