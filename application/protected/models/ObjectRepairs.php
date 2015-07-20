<?php

/**
 * This is the model class for table "object_repairs".
 *
 * The followings are the available columns in table 'object_repairs':
 * @property string $id
 * @property string $knights_id
 * @property string $inventory_type
 * @property string $combats_id
 * @property string $object_identificator
 * @property string $class_identificator
 * @property integer $current_pde
 * @property integer $maximum_pde
 * @property string $repair_cost
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Constants $inventoryType
 * @property Knights $knights
 * @property Combats $combats
 */
class ObjectRepairs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ObjectRepairs the static model class
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
		return 'object_repairs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, inventory_type, object_identificator, class_identificator, current_pde, maximum_pde, repair_cost, date', 'required'),
			array('current_pde, maximum_pde', 'numerical', 'integerOnly'=>true),
			array('knights_id, inventory_type, combats_id, object_identificator, class_identificator, repair_cost', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, inventory_type, combats_id, object_identificator, class_identificator, current_pde, maximum_pde, repair_cost, date', 'safe', 'on'=>'search'),
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
			'inventoryType' => array(self::BELONGS_TO, 'Constants', 'inventory_type'),
			'knights' => array(self::BELONGS_TO, 'Knights', 'knights_id'),
			'combats' => array(self::BELONGS_TO, 'Combats', 'combats_id'),
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
			'inventory_type' => 'Inventory Type',
			'combats_id' => 'Combats',
			'object_identificator' => 'Object Identificator',
			'class_identificator' => 'Class Identificator',
			'current_pde' => 'Current Pde',
			'maximum_pde' => 'Maximum Pde',
			'repair_cost' => 'Repair Cost',
			'date' => 'Date',
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
		$criteria->compare('inventory_type',$this->inventory_type,true);
		$criteria->compare('combats_id',$this->combats_id,true);
		$criteria->compare('object_identificator',$this->object_identificator,true);
		$criteria->compare('class_identificator',$this->class_identificator,true);
		$criteria->compare('current_pde',$this->current_pde);
		$criteria->compare('maximum_pde',$this->maximum_pde);
		$criteria->compare('repair_cost',$this->repair_cost,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}