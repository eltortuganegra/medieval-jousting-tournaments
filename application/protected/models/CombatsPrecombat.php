<?php

/**
 * This is the model class for table "combats_precombat".
 *
 * The followings are the available columns in table 'combats_precombat':
 * @property string $combats_id
 * @property string $from_knight_cache
 * @property integer $from_knight_fame
 * @property integer $from_knight_fans_throw
 * @property string $to_knight_cache
 * @property integer $to_knight_fame
 * @property integer $to_knight_fans_throw
 * @property string $from_knight_gate
 * @property string $to_knight_gate
 *
 * The followings are the available model relations:
 * @property Combats $combats
 */
class CombatsPrecombat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CombatsPrecombat the static model class
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
		return 'combats_precombat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('combats_id, from_knight_cache, from_knight_fame, from_knight_fans_throw, to_knight_cache, to_knight_fame, to_knight_fans_throw, from_knight_gate, to_knight_gate', 'required'),
			array('from_knight_fame, from_knight_fans_throw, to_knight_fame, to_knight_fans_throw', 'numerical', 'integerOnly'=>true),
			array('combats_id, from_knight_cache, to_knight_cache, from_knight_gate, to_knight_gate', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('combats_id, from_knight_cache, from_knight_fame, from_knight_fans_throw, to_knight_cache, to_knight_fame, to_knight_fans_throw, from_knight_gate, to_knight_gate', 'safe', 'on'=>'search'),
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
			'combats' => array(self::BELONGS_TO, 'Combats', 'combats_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'combats_id' => 'Combats',
			'from_knight_cache' => 'From Knight Cache',
			'from_knight_fame' => 'From Knight Fame',
			'from_knight_fans_throw' => 'From Knight Fans Throw',
			'to_knight_cache' => 'To Knight Cache',
			'to_knight_fame' => 'To Knight Fame',
			'to_knight_fans_throw' => 'To Knight Fans Throw',
			'from_knight_gate' => 'From Knight Gate',
			'to_knight_gate' => 'To Knight Gate',
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

		$criteria->compare('combats_id',$this->combats_id,true);
		$criteria->compare('from_knight_cache',$this->from_knight_cache,true);
		$criteria->compare('from_knight_fame',$this->from_knight_fame);
		$criteria->compare('from_knight_fans_throw',$this->from_knight_fans_throw);
		$criteria->compare('to_knight_cache',$this->to_knight_cache,true);
		$criteria->compare('to_knight_fame',$this->to_knight_fame);
		$criteria->compare('to_knight_fans_throw',$this->to_knight_fans_throw);
		$criteria->compare('from_knight_gate',$this->from_knight_gate,true);
		$criteria->compare('to_knight_gate',$this->to_knight_gate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}