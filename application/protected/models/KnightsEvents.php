<?php

/**
 * This is the model class for table "knights_events".
 *
 * The followings are the available columns in table 'knights_events':
 * @property string $id
 * @property string $knights_id
 * @property string $type
 * @property string $identificator
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $type0
 */
class KnightsEvents extends CActiveRecord
{
	const TYPE_COMBAT = 91;
	const TYPE_KNIGHTS_EVOLUTION = 92;
	const TYPE_VOID = 93;
	const TYPE_JOB = 163;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsEvents the static model class
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
		return 'knights_events';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, type, identificator', 'required'),
			array('knights_id, type, identificator', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, type, identificator', 'safe', 'on'=>'search'),
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
			'type0' => array(self::BELONGS_TO, 'Constants', 'type'),
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
			'type' => 'Type',
			'identificator' => 'Identificator',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('identificator',$this->identificator,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}