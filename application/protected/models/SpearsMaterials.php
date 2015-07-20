<?php

/**
 * This is the model class for table "spears_materials".
 *
 * The followings are the available columns in table 'spears_materials':
 * @property string $id
 * @property integer $level
 * @property double $maximum_damage
 * @property string $prize
 * @property integer $endurance
 * @property string $name
 *
 * The followings are the available model relations:
 * @property Spears[] $spears
 */
class SpearsMaterials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SpearsMaterials the static model class
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
		return 'spears_materials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level, maximum_damage, prize, endurance, name', 'required'),
			array('level, endurance', 'numerical', 'integerOnly'=>true),
			array('maximum_damage', 'numerical'),
			array('prize', 'length', 'max'=>10),
			array('name', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, level, maximum_damage, prize, endurance, name', 'safe', 'on'=>'search'),
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
			'spears' => array(self::HAS_MANY, 'Spears', 'spears_materials_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'level' => 'Level',
			'maximum_damage' => 'Maximum Damage',
			'prize' => 'Prize',
			'endurance' => 'Endurance',
			'name' => 'Name',
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
		$criteria->compare('level',$this->level);
		$criteria->compare('maximum_damage',$this->maximum_damage);
		$criteria->compare('prize',$this->prize,true);
		$criteria->compare('endurance',$this->endurance);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}