<?php

/**
 * This is the model class for table "friends".
 *
 * The followings are the available columns in table 'friends':
 * @property string $id
 * @property string $from_user
 * @property string $to_user
 * @property string $status
 * @property string $start_date
 * @property string $delete_by_user
 * @property string $end_date
 *
 * The followings are the available model relations:
 * @property Constants $status0
 * @property Users $fromUser
 * @property Users $toUser
 */
class Friends extends CActiveRecord
{
	const STATUS_ONWAITING = 95;
	const STATUS_ACCEPT = 96;
	const STATUS_REJECT = 97;
	const STATUS_FINISHED_BY_SENDER = 99;
	const STATUS_FINISHED_BY_RECEIVER = 100;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Friends the static model class
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
		return 'friends';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_user, to_user, status, start_date', 'required'),
			array('from_user, to_user, status, delete_by_user', 'length', 'max'=>10),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_user, to_user, status, start_date, delete_by_user, end_date', 'safe', 'on'=>'search'),
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
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
			'fromUser' => array(self::BELONGS_TO, 'Users', 'from_user'),
			'toUser' => array(self::BELONGS_TO, 'Users', 'to_user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_user' => 'From User',
			'to_user' => 'To User',
			'status' => 'Status',
			'start_date' => 'Start Date',
			'delete_by_user' => 'Delete By User',
			'end_date' => 'End Date',
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
		$criteria->compare('from_user',$this->from_user,true);
		$criteria->compare('to_user',$this->to_user,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('delete_by_user',$this->delete_by_user,true);
		$criteria->compare('end_date',$this->end_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}