<?php

/**
 * This is the model class for table "spears".
 *
 * The followings are the available columns in table 'spears':
 * @property string $id
 * @property string $name
 * @property string $spears_materials_id
 * @property integer $equipment_size_id
 * @property integer $equipment_qualities_id
 * @property integer $equipment_rarity_id
 * @property integer $damage
 * @property integer $pde
 * @property string $prize
 *
 * The followings are the available model relations:
 * @property EquipmentQualities $equipmentQualities
 * @property EquipmentRarity $equipmentRarity
 * @property EquipmentSize $equipmentSize
 * @property SpearsMaterials $spearsMaterials
 * @property SpearsObjects[] $spearsObjects
 */
class Spears extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Spears the static model class
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
		return 'spears';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, spears_materials_id, equipment_size_id, equipment_qualities_id, equipment_rarity_id, damage, pde, prize', 'required'),
			array('equipment_size_id, equipment_qualities_id, equipment_rarity_id, damage, pde', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>45),
			array('spears_materials_id, prize', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, spears_materials_id, equipment_size_id, equipment_qualities_id, equipment_rarity_id, damage, pde, prize', 'safe', 'on'=>'search'),
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
			'equipmentQualities' => array(self::BELONGS_TO, 'EquipmentQualities', 'equipment_qualities_id'),
			'equipmentRarity' => array(self::BELONGS_TO, 'EquipmentRarity', 'equipment_rarity_id'),
			'equipmentSize' => array(self::BELONGS_TO, 'EquipmentSize', 'equipment_size_id'),
			'spearsMaterials' => array(self::BELONGS_TO, 'SpearsMaterials', 'spears_materials_id'),
			'spearsObjects' => array(self::HAS_MANY, 'SpearsObjects', 'spears_id'),
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
			'spears_materials_id' => 'Spears Materials',
			'equipment_size_id' => 'Equipment Size',
			'equipment_qualities_id' => 'Equipment Qualities',
			'equipment_rarity_id' => 'Equipment Rarity',
			'damage' => 'Damage',
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
		$criteria->compare('spears_materials_id',$this->spears_materials_id,true);
		$criteria->compare('equipment_size_id',$this->equipment_size_id);
		$criteria->compare('equipment_qualities_id',$this->equipment_qualities_id);
		$criteria->compare('equipment_rarity_id',$this->equipment_rarity_id);
		$criteria->compare('damage',$this->damage);
		$criteria->compare('pde',$this->pde);
		$criteria->compare('prize',$this->prize,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Funciones para devolver las opciones de un select
	 */
	public function getSpearsMaterialsOptions(){
		$models = SpearsMaterials::model()->findAll( );
		return CHtml::listData( $models, 'id', 'level' );	
	}
	public function getEquipmentSizeOptions(){
		$models = EquipmentSize::model()->findAll( );
		return CHtml::listData( $models, 'id', 'name' );
	}
	public function getEquipmentQualityOptions(){
		$models = EquipmentQualities::model()->findAll( );
		return CHtml::listData( $models, 'id', 'name' );
	}
	public function getEquipmentRarityOptions(){
		$models = EquipmentRarity::model()->findAll( );
		return CHtml::listData( $models, 'id', 'name' );
	}

	/**
	 * Funciones para devolver el nombre del select elegido.
	 */
	public function getSpearsMaterialsText(){
		$model = SpearsMaterials::model()->findByPk( $this->spears_materials_id );
		return $model->level;
	}
	public function getEquipmentSizeText(){
		$model = EquipmentSize::model()->findByPk( $this->equipment_size_id );
		return $model->name;
	}
	public function getEquipmentQualitiesText(){
		$model = EquipmentQualities::model()->findByPk( $this->equipment_qualities_id );
		return $model->name;
	}
	public function getEquipmentRarityText(){
		$model = EquipmentRarity::model()->findByPk( $this->equipment_rarity_id );
		return $model->name;
	}
	/**
	 * Devuelve un array el id de las lanzas iniciales
	 */
	public function getDefaultEquipment(){
		return array(1,1,1,1,1,1);
	}
	
}