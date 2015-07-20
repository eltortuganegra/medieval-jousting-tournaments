<?php

/**
 * This is the model class for table "yellow_pages_total_by_letter".
 *
 * The followings are the available columns in table 'yellow_pages_total_by_letter':
 * @property string $id
 * @property string $letter
 * @property string $knights_id
 *
 * The followings are the available model relations:
 * @property Constants $letter0
 * @property Knights $knights
 */
class YellowPagesTotalByLetter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return YellowPagesTotalByLetter the static model class
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
		return 'yellow_pages_total_by_letter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('letter, knights_id', 'required'),
			array('letter, knights_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, letter, knights_id', 'safe', 'on'=>'search'),
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
			'letter0' => array(self::BELONGS_TO, 'Constants', 'letter'),
			'knights' => array(self::BELONGS_TO, 'Knights', 'knights_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'letter' => 'Letter',
			'knights_id' => 'Knights',
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
		$criteria->compare('letter',$this->letter,true);
		$criteria->compare('knights_id',$this->knights_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}