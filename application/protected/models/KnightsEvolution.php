<?php

/**
 * This is the model class for table "knights_evolution".
 *
 * The followings are the available columns in table 'knights_evolution':
 * @property string $id
 * @property string $knights_id
 * @property string $type
 * @property string $characteristic
 * @property integer $value
 * @property string $experiencie_used
 * @property string $date
 * @property string $combats_id
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $type0
 * @property Constants $characteristic0
 * @property Combats $combats
 */
class KnightsEvolution extends CActiveRecord
{
	const TYPE_UPGRADE = 88;
	const TYPE_DOWNGRADE = 89;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsEvolution the static model class
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
		return 'knights_evolution';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, type, characteristic, value, experiencie_used, date', 'required'),
			array('value', 'numerical', 'integerOnly'=>true),
			array('knights_id, type, characteristic, experiencie_used, combats_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, type, characteristic, value, experiencie_used, date, combats_id', 'safe', 'on'=>'search'),
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
			'type0' => array(self::BELONGS_TO, 'Constants', 'type'),
			'characteristic0' => array(self::BELONGS_TO, 'Constants', 'characteristic'),
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
			'type' => 'Type',
			'characteristic' => 'Characteristic',
			'value' => 'Value',
			'experiencie_used' => 'Experiencie Used',
			'date' => 'Date',
			'combats_id' => 'Combats',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('characteristic',$this->characteristic,true);
		$criteria->compare('value',$this->value);
		$criteria->compare('experiencie_used',$this->experiencie_used,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('combats_id',$this->combats_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}