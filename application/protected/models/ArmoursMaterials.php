<?php

/**
 * This is the model class for table "armours_materials".
 *
 * The followings are the available columns in table 'armours_materials':
 * @property integer $id
 * @property string $name
 * @property integer $endurance
 * @property string $prize
 *
 * The followings are the available model relations:
 * @property Armours[] $armours
 */
class ArmoursMaterials extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ArmoursMaterials the static model class
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
		return 'armours_materials';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, endurance, prize', 'required'),
			array('endurance', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('prize', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, endurance, prize', 'safe', 'on'=>'search'),
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
			'armours' => array(self::HAS_MANY, 'Armours', 'armours_materials_id'),
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
			'endurance' => 'Endurance',
			'prize' => 'Prize',
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
		$criteria->compare('endurance',$this->endurance);
		$criteria->compare('prize',$this->prize,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}