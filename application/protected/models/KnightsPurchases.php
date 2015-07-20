<?php

/**
 * This is the model class for table "knights_purchases".
 *
 * The followings are the available columns in table 'knights_purchases':
 * @property string $id
 * @property string $knights_id
 * @property string $inventory_type_id
 * @property string $identificator
 * @property string $date
 * @property string $status
 * @property integer $knights_card_charisma
 * @property integer $knights_card_trade
 * @property integer $throw
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $inventoryType
 * @property Constants $status0
 */
class KnightsPurchases extends CActiveRecord
{
	const STATUS_PURCHASED = 155;
	const STATUS_SEARCHING = 156;
	const STATUS_FOUND = 157;
	const STATUS_NOT_FOUND = 158;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsPurchases the static model class
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
		return 'knights_purchases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, inventory_type_id, identificator, date, status', 'required'),
			array('knights_card_charisma, knights_card_trade, throw', 'numerical', 'integerOnly'=>true),
			array('knights_id, inventory_type_id, identificator, status', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, inventory_type_id, identificator, date, status, knights_card_charisma, knights_card_trade, throw', 'safe', 'on'=>'search'),
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
			'inventoryType' => array(self::BELONGS_TO, 'Constants', 'inventory_type_id'),
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
			'inventory_type_id' => 'Inventory Type',
			'identificator' => 'Identificator',
			'date' => 'Date',
			'status' => 'Status',
			'knights_card_charisma' => 'Knights Card Charisma',
			'knights_card_trade' => 'Knights Card Trade',
			'throw' => 'Throw',
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
		$criteria->compare('inventory_type_id',$this->inventory_type_id,true);
		$criteria->compare('identificator',$this->identificator,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('knights_card_charisma',$this->knights_card_charisma);
		$criteria->compare('knights_card_trade',$this->knights_card_trade);
		$criteria->compare('throw',$this->throw);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}