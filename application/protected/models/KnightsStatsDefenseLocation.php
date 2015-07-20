<?php

/**
 * This is the model class for table "knights_stats_defense_location".
 *
 * The followings are the available columns in table 'knights_stats_defense_location':
 * @property string $knights_id
 * @property string $location
 * @property string $armours_type
 * @property string $amount
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $location0
 * @property Constants $armoursType
 */
class KnightsStatsDefenseLocation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsStatsDefenseLocation the static model class
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
		return 'knights_stats_defense_location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, location, armours_type', 'required'),
			array('knights_id, location, armours_type, amount', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('knights_id, location, armours_type, amount', 'safe', 'on'=>'search'),
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
			'location0' => array(self::BELONGS_TO, 'Constants', 'location'),
			'armoursType' => array(self::BELONGS_TO, 'Constants', 'armours_type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'knights_id' => 'Knights',
			'location' => 'Location',
			'armours_type' => 'Armours Type',
			'amount' => 'Amount',
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

		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('armours_type',$this->armours_type,true);
		$criteria->compare('amount',$this->amount,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}