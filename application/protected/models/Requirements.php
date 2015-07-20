<?php

/**
 * This is the model class for table "requirements".
 *
 * The followings are the available columns in table 'requirements':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $level
 * @property string $attribute
 * @property string $skill
 * @property integer $value
 *
 * The followings are the available model relations:
 * @property EquipmentRequirements[] $equipmentRequirements
 * @property Constants $attribute0
 * @property Constants $skill0
 */
class Requirements extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Requirements the static model class
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
		return 'requirements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, description, value', 'required'),
			array('level, value', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('description', 'length', 'max'=>255),
			array('attribute, skill', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, level, attribute, skill, value', 'safe', 'on'=>'search'),
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
			'equipmentRequirements' => array(self::HAS_MANY, 'EquipmentRequirements', 'requirements_id'),
			'attribute0' => array(self::BELONGS_TO, 'Constants', 'attribute'),
			'skill0' => array(self::BELONGS_TO, 'Constants', 'skill'),
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
			'description' => 'Description',
			'level' => 'Level',
			'attribute' => 'Attribute',
			'skill' => 'Skill',
			'value' => 'Value',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('attribute',$this->attribute,true);
		$criteria->compare('skill',$this->skill,true);
		$criteria->compare('value',$this->value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}