<?php

/**
 * This is the model class for table "knights_settings".
 *
 * The followings are the available columns in table 'knights_settings':
 * @property string $knights_id
 * @property integer $emailToSendChallenge
 * @property integer $emailToFinishedCombat
 * @property integer $emailToSendMessage
 * @property integer $emailToSendFriendlyRequest
 *
 * The followings are the available model relations:
 * @property Knights $knights
 */
class KnightsSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsSettings the static model class
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
		return 'knights_settings';				
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id', 'required'),
			array('emailToSendChallenge, emailToFinishedCombat, emailToSendMessage, emailToSendFriendlyRequest', 'numerical', 'integerOnly'=>true),
			array('knights_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('knights_id, emailToSendChallenge, emailToFinishedCombat, emailToSendMessage, emailToSendFriendlyRequest', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'knights_id' => 'Knights',
			'emailToSendChallenge' => 'Email To Send Challenge',
			'emailToFinishedCombat' => 'Email To Finished Combat',
			'emailToSendMessage' => 'Email To Send Message',
			'emailToSendFriendlyRequest' => 'Email To Send Friendly Request',
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
		$criteria->compare('emailToSendChallenge',$this->emailToSendChallenge);
		$criteria->compare('emailToFinishedCombat',$this->emailToFinishedCombat);
		$criteria->compare('emailToSendMessage',$this->emailToSendMessage);
		$criteria->compare('emailToSendFriendlyRequest',$this->emailToSendFriendlyRequest);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}