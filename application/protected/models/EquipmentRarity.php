<?php

/**
 * This is the model class for table "equipment_rarity".
 *
 * The followings are the available columns in table 'equipment_rarity':
 * @property integer $id
 * @property string $name
 * @property integer $percent
 * @property integer $difficulty
 * @property integer $search_time
 *
 * The followings are the available model relations:
 * @property Armours[] $armours
 * @property Spears[] $spears
 */
class EquipmentRarity extends CActiveRecord
{
	const VERY_COMMON = 1;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentRarity the static model class
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
		return 'equipment_rarity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, percent, difficulty, search_time', 'required'),
			array('percent, difficulty, search_time', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, percent, difficulty, search_time', 'safe', 'on'=>'search'),
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
			'armours' => array(self::HAS_MANY, 'Armours', 'equipment_rarity_id'),
			'spears' => array(self::HAS_MANY, 'Spears', 'equipment_rarity_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'percent' => 'Percent',
			'difficulty' => 'Difficulty',
			'search_time' => 'Search Time',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('percent',$this->percent);
		$criteria->compare('difficulty',$this->difficulty);
		$criteria->compare('search_time',$this->search_time);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}