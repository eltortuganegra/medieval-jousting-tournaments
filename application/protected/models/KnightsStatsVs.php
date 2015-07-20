<?php

/**
 * This is the model class for table "knights_stats_vs".
 *
 * The followings are the available columns in table 'knights_stats_vs':
 * @property integer $id
 * @property string $knights_id
 * @property string $opponent
 * @property string $combats_wins
 * @property string $combats_wins_injury
 * @property string $combats_draw
 * @property string $combats_draw_injury
 * @property string $combats_loose
 * @property string $combats_loose_injury
 * @property string $hits_total_produced
 * @property string $hits_total_blocked
 * @property string $hits_total_received
 * @property string $hits_total_received_blocked
 * @property string $damage_total_produced
 * @property string $damage_total_received
 * @property string $damage_maximum_produced
 * @property string $damage_maximum_received
 * @property string $injury_total_light_produced
 * @property string $injury_total_light_received
 * @property string $injury_total_serious_produced
 * @property string $injury_total_serious_received
 * @property string $injury_total_very_serious_produced
 * @property string $injury_total_very_serious_received
 * @property string $injury_total_fatality_produced
 * @property string $injury_total_fatality_received
 * @property string $money_total_earned
 * @property string $money_maximum_earned_combat
 * @property string $tricks_total_used
 * @property string $tricks_total_used_successful
 * @property string $tricks_total_received
 * @property string $tricks_total_received_successful
 * @property string $desquality_produced
 * @property string $desquality_received
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Knights $opponent0
 */
class KnightsStatsVs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsStatsVs the static model class
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
		return 'knights_stats_vs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, opponent', 'required'),
			array('knights_id, opponent, combats_wins, combats_wins_injury, combats_draw, combats_draw_injury, combats_loose, combats_loose_injury, hits_total_produced, hits_total_blocked, hits_total_received, hits_total_received_blocked, damage_total_produced, damage_total_received, damage_maximum_produced, damage_maximum_received, injury_total_light_produced, injury_total_light_received, injury_total_serious_produced, injury_total_serious_received, injury_total_very_serious_produced, injury_total_very_serious_received, injury_total_fatality_produced, injury_total_fatality_received, money_total_earned, money_maximum_earned_combat, tricks_total_used, tricks_total_used_successful, tricks_total_received, tricks_total_received_successful, desquality_produced, desquality_received', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, opponent, combats_wins, combats_wins_injury, combats_draw, combats_draw_injury, combats_loose, combats_loose_injury, hits_total_produced, hits_total_blocked, hits_total_received, hits_total_received_blocked, damage_total_produced, damage_total_received, damage_maximum_produced, damage_maximum_received, injury_total_light_produced, injury_total_light_received, injury_total_serious_produced, injury_total_serious_received, injury_total_very_serious_produced, injury_total_very_serious_received, injury_total_fatality_produced, injury_total_fatality_received, money_total_earned, money_maximum_earned_combat, tricks_total_used, tricks_total_used_successful, tricks_total_received, tricks_total_received_successful, desquality_produced, desquality_received', 'safe', 'on'=>'search'),
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
			'opponent0' => array(self::BELONGS_TO, 'Knights', 'opponent'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'knights_id' => 'Knights',
			'opponent' => 'Opponent',
			'combats_wins' => 'Combats Wins',
			'combats_wins_injury' => 'Combats Wins Injury',
			'combats_draw' => 'Combats Draw',
			'combats_draw_injury' => 'Combats Draw Injury',
			'combats_loose' => 'Combats Loose',
			'combats_loose_injury' => 'Combats Loose Injury',
			'hits_total_produced' => 'Hits Total Produced',
			'hits_total_blocked' => 'Hits Total Blocked',
			'hits_total_received' => 'Hits Total Received',
			'hits_total_received_blocked' => 'Hits Total Received Blocked',
			'damage_total_produced' => 'Damage Total Produced',
			'damage_total_received' => 'Damage Total Received',
			'damage_maximum_produced' => 'Damage Maximum Produced',
			'damage_maximum_received' => 'Damage Maximum Received',
			'injury_total_light_produced' => 'Injury Total Light Produced',
			'injury_total_light_received' => 'Injury Total Light Received',
			'injury_total_serious_produced' => 'Injury Total Serious Produced',
			'injury_total_serious_received' => 'Injury Total Serious Received',
			'injury_total_very_serious_produced' => 'Injury Total Very Serious Produced',
			'injury_total_very_serious_received' => 'Injury Total Very Serious Received',
			'injury_total_fatality_produced' => 'Injury Total Fatality Produced',
			'injury_total_fatality_received' => 'Injury Total Fatality Received',
			'money_total_earned' => 'Money Total Earned',
			'money_maximum_earned_combat' => 'Money Maximum Earned Combat',
			'tricks_total_used' => 'Tricks Total Used',
			'tricks_total_used_successful' => 'Tricks Total Used Successful',
			'tricks_total_received' => 'Tricks Total Received',
			'tricks_total_received_successful' => 'Tricks Total Received Successful',
			'desquality_produced' => 'Desquality Produced',
			'desquality_received' => 'Desquality Received',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('opponent',$this->opponent,true);
		$criteria->compare('combats_wins',$this->combats_wins,true);
		$criteria->compare('combats_wins_injury',$this->combats_wins_injury,true);
		$criteria->compare('combats_draw',$this->combats_draw,true);
		$criteria->compare('combats_draw_injury',$this->combats_draw_injury,true);
		$criteria->compare('combats_loose',$this->combats_loose,true);
		$criteria->compare('combats_loose_injury',$this->combats_loose_injury,true);
		$criteria->compare('hits_total_produced',$this->hits_total_produced,true);
		$criteria->compare('hits_total_blocked',$this->hits_total_blocked,true);
		$criteria->compare('hits_total_received',$this->hits_total_received,true);
		$criteria->compare('hits_total_received_blocked',$this->hits_total_received_blocked,true);
		$criteria->compare('damage_total_produced',$this->damage_total_produced,true);
		$criteria->compare('damage_total_received',$this->damage_total_received,true);
		$criteria->compare('damage_maximum_produced',$this->damage_maximum_produced,true);
		$criteria->compare('damage_maximum_received',$this->damage_maximum_received,true);
		$criteria->compare('injury_total_light_produced',$this->injury_total_light_produced,true);
		$criteria->compare('injury_total_light_received',$this->injury_total_light_received,true);
		$criteria->compare('injury_total_serious_produced',$this->injury_total_serious_produced,true);
		$criteria->compare('injury_total_serious_received',$this->injury_total_serious_received,true);
		$criteria->compare('injury_total_very_serious_produced',$this->injury_total_very_serious_produced,true);
		$criteria->compare('injury_total_very_serious_received',$this->injury_total_very_serious_received,true);
		$criteria->compare('injury_total_fatality_produced',$this->injury_total_fatality_produced,true);
		$criteria->compare('injury_total_fatality_received',$this->injury_total_fatality_received,true);
		$criteria->compare('money_total_earned',$this->money_total_earned,true);
		$criteria->compare('money_maximum_earned_combat',$this->money_maximum_earned_combat,true);
		$criteria->compare('tricks_total_used',$this->tricks_total_used,true);
		$criteria->compare('tricks_total_used_successful',$this->tricks_total_used_successful,true);
		$criteria->compare('tricks_total_received',$this->tricks_total_received,true);
		$criteria->compare('tricks_total_received_successful',$this->tricks_total_received_successful,true);
		$criteria->compare('desquality_produced',$this->desquality_produced,true);
		$criteria->compare('desquality_received',$this->desquality_received,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}