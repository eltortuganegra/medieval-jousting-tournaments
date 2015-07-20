<?php

/**
 * This is the model class for table "constants".
 *
 * The followings are the available columns in table 'constants':
 * @property string $id
 * @property string $name
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Achievements[] $achievements
 * @property Achievements[] $achievements1
 * @property Armours[] $armours
 * @property Combats[] $combats
 * @property Combats[] $combats1
 * @property Combats[] $combats2
 * @property CombatsPostcombat[] $combatsPostcombats
 * @property Constants $type0
 * @property Constants[] $constants
 * @property EquipmentRequirements[] $equipmentRequirements
 * @property Friends[] $friends
 * @property Inventory[] $inventories
 * @property Knights[] $knights
 * @property KnightsEventsLast[] $knightsEventsLasts
 * @property KnightsEvolution[] $knightsEvolutions
 * @property KnightsEvolution[] $knightsEvolutions1
 * @property KnightsStatsDefenseLocation[] $knightsStatsDefenseLocations
 * @property KnightsStatsDefenseLocation[] $knightsStatsDefenseLocations1
 * @property Messages[] $messages
 * @property MessagesGeneral[] $messagesGenerals
 * @property Requirements[] $requirements
 * @property Requirements[] $requirements1
 * @property Rounds[] $rounds
 * @property Tricks[] $tricks
 * @property Tricks[] $tricks1
 * @property Tricks[] $tricks2
 * @property Tricks[] $tricks3
 * @property Users[] $users
 */
class Constants extends CActiveRecord
{
	const KNIGHTS_LOCATION = 9;
	const KNIGHTS_ATTRIBUTES = 69 ;
	const KNIGHTS_SKILLS =78;
	
	const CHARACTERISTIC_CONSTITUTION = 72;
	const CHARACTERISTIC_WILL = 77;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Constants the static model class
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
		return 'constants';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>45),
			array('type', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, type', 'safe', 'on'=>'search'),
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
			'achievements' => array(self::HAS_MANY, 'Achievements', 'status'),
			'achievements1' => array(self::HAS_MANY, 'Achievements', 'type'),
			'armours' => array(self::HAS_MANY, 'Armours', 'type'),
			'combats' => array(self::HAS_MANY, 'Combats', 'status'),
			'combats1' => array(self::HAS_MANY, 'Combats', 'result'),
			'combats2' => array(self::HAS_MANY, 'Combats', 'type'),
			'combatsPostcombats' => array(self::HAS_MANY, 'CombatsPostcombat', 'injury_type'),
			'type0' => array(self::BELONGS_TO, 'Constants', 'type'),
			'constants' => array(self::HAS_MANY, 'Constants', 'type'),
			'equipmentRequirements' => array(self::HAS_MANY, 'EquipmentRequirements', 'equipments_type'),
			'friends' => array(self::HAS_MANY, 'Friends', 'status'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'type'),
			'knights' => array(self::MANY_MANY, 'Knights', 'knights_stats_attack_location(location, knights_id)'),
			'knightsEventsLasts' => array(self::HAS_MANY, 'KnightsEventsLast', 'type'),
			'knightsEvolutions' => array(self::HAS_MANY, 'KnightsEvolution', 'type'),
			'knightsEvolutions1' => array(self::HAS_MANY, 'KnightsEvolution', 'characteristic'),
			'knightsStatsDefenseLocations' => array(self::HAS_MANY, 'KnightsStatsDefenseLocation', 'location'),
			'knightsStatsDefenseLocations1' => array(self::HAS_MANY, 'KnightsStatsDefenseLocation', 'form_shield'),
			'messages' => array(self::HAS_MANY, 'Messages', 'status'),
			'messagesGenerals' => array(self::HAS_MANY, 'MessagesGeneral', 'status'),
			'requirements' => array(self::HAS_MANY, 'Requirements', 'attribute'),
			'requirements1' => array(self::HAS_MANY, 'Requirements', 'skill'),
			'rounds' => array(self::HAS_MANY, 'Rounds', 'type'),
			'tricks' => array(self::HAS_MANY, 'Tricks', 'usedInTime'),
			'tricks1' => array(self::HAS_MANY, 'Tricks', 'knight_target'),
			'tricks2' => array(self::HAS_MANY, 'Tricks', 'effect_type'),
			'tricks3' => array(self::HAS_MANY, 'Tricks', 'target_effect'),
			'users' => array(self::HAS_MANY, 'Users', 'status'),
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

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 
	 */
	public static function getLabelsTypeInjuries(){
		return array(
			Knights::TYPE_INJURY_LIGHT => 'Lesión',
			Knights::TYPE_INJURY_SERIOUSLY => 'Lesión seria',
			Knights::TYPE_INJURY_VERY_SERIOUSLY => 'Lesión muy seria',
			Knights::TYPE_INJURY_FATALITY => 'Fatalidad'
		);
	} 
}