<?php

/**
 * This is the model class for table "app_rules_level".
 *
 * The followings are the available columns in table 'app_rules_level':
 * @property integer $level
 * @property integer $attribute_cost
 * @property integer $skill_cost
 * @property integer $wins_combats_next_level
 * @property integer $cache
 */
class AppRulesLevel extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AppRulesLevel the static model class
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
		return 'app_rules_level';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level', 'required'),
			array('level, attribute_cost, skill_cost, wins_combats_next_level, cache', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('level, attribute_cost, skill_cost, wins_combats_next_level, cache', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'level' => 'Level',
			'attribute_cost' => 'Attribute Cost',
			'skill_cost' => 'Skill Cost',
			'wins_combats_next_level' => 'Wins Combats Next Level',
			'cache' => 'Cache',
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

		$criteria->compare('level',$this->level);
		$criteria->compare('attribute_cost',$this->attribute_cost);
		$criteria->compare('skill_cost',$this->skill_cost);
		$criteria->compare('wins_combats_next_level',$this->wins_combats_next_level);
		$criteria->compare('cache',$this->cache);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}