<?php

/**
 * This is the model class for table "jobs".
 *
 * The followings are the available columns in table 'jobs':
 * @property string $id
 * @property string $knights_id
 * @property integer $knight_level
 * @property string $date
 * @property integer $hours
 * @property string $status
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $status0
 */
class Jobs extends CActiveRecord
{
	const STATUS_WORKING = 160;
	const STATUS_PAYED = 161;
	const STATUS_CANCELLED = 162;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Jobs the static model class
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
		return 'jobs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, knight_level, date, hours, status', 'required'),
			array('knight_level, hours', 'numerical', 'integerOnly'=>true),
			array('knights_id, status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, knight_level, date, hours, status', 'safe', 'on'=>'search'),
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
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
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
			'knight_level' => 'Knight Level',
			'date' => 'Date',
			'hours' => 'Hours',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('knight_level',$this->knight_level);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('hours',$this->hours);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}