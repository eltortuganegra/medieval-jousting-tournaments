<?php

/**
 * This is the model class for table "spears_objects".
 *
 * The followings are the available columns in table 'spears_objects':
 * @property string $id
 * @property string $spears_id
 * @property string $knights_id
 * @property integer $current_pde
 *
 * The followings are the available model relations:
 * @property Spears $spears
 * @property Knights $knights
 */
class SpearsObjects extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpearsObjects the static model class
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
		return 'spears_objects';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('spears_id, knights_id, current_pde', 'required'),
			array('current_pde', 'numerical', 'integerOnly'=>true),
			array('spears_id, knights_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, spears_id, knights_id, current_pde', 'safe', 'on'=>'search'),
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
			'spears' => array(self::BELONGS_TO, 'Spears', 'spears_id'),
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
			'spears_id' => 'Spears',
			'knights_id' => 'Knights',
			'current_pde' => 'Current Pde',
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
		$criteria->compare('spears_id',$this->spears_id,true);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('current_pde',$this->current_pde);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}