<?php

/**
 * This is the model class for table "armours".
 *
 * The followings are the available columns in table 'armours':
 * @property string $id
 * @property string $name
 * @property string $type
 * @property integer $armours_materials_id
 * @property integer $equipment_qualities_id
 * @property integer $equipment_size_id
 * @property integer $equipment_rarity_id
 * @property integer $endurance
 * @property integer $pde
 * @property string $prize
 *
 * The followings are the available model relations:
 * @property Constants $type0
 * @property ArmoursMaterials $armoursMaterials
 * @property EquipmentSize $equipmentSize
 * @property EquipmentQualities $equipmentQualities
 * @property EquipmentRarity $equipmentRarity
 * @property ArmoursObjects[] $armoursObjects
 */
class Armours extends CActiveRecord
{
	const TYPE = 42;
	const TYPE_SHIELD = 134;
	const TYPE_SHIELD_2X2 = 48;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Armours the static model class
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
		return 'armours';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, armours_materials_id, equipment_qualities_id, equipment_size_id, equipment_rarity_id, endurance, pde, prize', 'required'),
			array('armours_materials_id, equipment_qualities_id, equipment_size_id, equipment_rarity_id, endurance, pde', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('type, prize', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type, armours_materials_id, equipment_qualities_id, equipment_size_id, equipment_rarity_id, endurance, pde, prize', 'safe', 'on'=>'search'),
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
			'type0' => array(self::BELONGS_TO, 'Constants', 'type'),
			'armoursMaterials' => array(self::BELONGS_TO, 'ArmoursMaterials', 'armours_materials_id'),
			'equipmentSize' => array(self::BELONGS_TO, 'EquipmentSize', 'equipment_size_id'),
			'equipmentQualities' => array(self::BELONGS_TO, 'EquipmentQualities', 'equipment_qualities_id'),
			'equipmentRarity' => array(self::BELONGS_TO, 'EquipmentRarity', 'equipment_rarity_id'),
			'armoursObjects' => array(self::HAS_MANY, 'ArmoursObjects', 'armours_id'),
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
			'type' => 'Type',
			'armours_materials_id' => 'Armours Materials',
			'equipment_qualities_id' => 'Equipment Qualities',
			'equipment_size_id' => 'Equipment Size',
			'equipment_rarity_id' => 'Equipment Rarity',
			'endurance' => 'Endurance',
			'pde' => 'Pde',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('armours_materials_id',$this->armours_materials_id);
		$criteria->compare('equipment_qualities_id',$this->equipment_qualities_id);
		$criteria->compare('equipment_size_id',$this->equipment_size_id);
		$criteria->compare('equipment_rarity_id',$this->equipment_rarity_id);
		$criteria->compare('endurance',$this->endurance);
		$criteria->compare('pde',$this->pde);
		$criteria->compare('prize',$this->prize,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of types of armours
	 * @return unknown
	 */
	public function getTypeOptions(){
		$models = Constants::model()->findAll(
			array(
				'condition'=>'type=:type',
				'params'=>array(':type'=>self::TYPE )
			)				
		);	
		return CHtml::listData( $models, 'id', 'name' );
	}
	
	/**
	 * Retrieves a list of types of armours
	 * @return unknown
	 */
	public function getArmoursMaterialsOptions(){
		$models = ArmoursMaterials::model()->findAll();
		return CHtml::listData( $models, 'id', 'name' );
	}
	
	/**
	 * Retrieves a list of types of armours
	 * @return unknown
	 */
	public function getEquipmentQualitiesOptions(){
		$models = EquipmentQualities::model()->findAll();
		return CHtml::listData( $models, 'id', 'name' );
	}
	/**
	 * Retrieves a list of types of armours
	 * @return unknown
	 */
	public function getEquipmentSizeOptions(){
		$models = EquipmentSize::model()->findAll();
		return CHtml::listData( $models, 'id', 'name' );
	}
	
	/**
	 * Retrieves a list of types of armours
	 * @return unknown
	 */
	public function getEquipmentRarityOptions(){
		$models = EquipmentRarity::model()->findAll();
		return CHtml::listData( $models, 'id', 'name' );
	}
	
	/**
	 * Return the text of type
	 */
	public function getTypeText(){
		$model = Constants::model()->findByPk( $this->type );
		return $model->name;
	}
	
	public function getArmoursMaterialsText(){
		$model = ArmoursMaterials::model()->findByPk( $this->armours_materials_id );
		return $model->name;
	}
	
	public function getEquipmentQualitiesText(){
		$model = EquipmentQualities::model()->findByPk( $this->equipment_qualities_id );
		return $model->name;
	}
	public function getEquipmentSizeText(){
		$model = EquipmentSize::model()->findByPk( $this->equipment_size_id );
		return $model->name;
	}
	
	public function getEquipmentRarityText(){
		$model = EquipmentRarity::model()->findByPk( $this->equipment_rarity_id );
		return $model->name;
	}

	/**
	 * Devuelve los identificadores para un equipo básico
	 */
	public static function getDefaultEquipment(){
		return array(
			1, //Casco
			2, //Hombrera izquierda
			5, //Hombrera derecha
			3, //Guante izquierdo
			4, //guante derecho			
			6, //codera izquierda
			7, //codera derecha
			8, //coraza
			9 //escudo
		);
	}
	
	/**
	 * Return width of shield
	 * @param unknown_type $type
	 * @return number
	 */
	public static function getWidthShield( $type ){
		switch ($type){
			case self::TYPE_SHIELD_2X2:
				return 2;
			default:
				return 0;				
		}		
	}
	/*
	 * return height of shield
	 */
	public static function getHeightShield( $type ){
		switch ($type){
			case self::TYPE_SHIELD_2X2:
				return 2;
			default:
				return 0;
		}
	}
}