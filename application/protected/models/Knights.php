<?php

/**
 * This is the model class for table "knights".
 *
 * The followings are the available columns in table 'knights':
 * @property string $id
 * @property string $users_id
 * @property string $suscribe_date
 * @property string $unsuscribe_date
 * @property string $name
 * @property string $status
 * @property integer $level
 * @property integer $endurance
 * @property integer $life
 * @property integer $pain
 * @property string $coins
 * @property string $experiencie_earned
 * @property string $experiencie_used
 * @property string $avatars_id
 *
 * The followings are the available model relations:
 * @property ArmoursObjects[] $armoursObjects
 * @property Combats[] $combats
 * @property Combats[] $combats1
 * @property CombatsTricks[] $combatsTricks
 * @property Healings $healings
 * @property Inventory[] $inventories
 * @property Jobs[] $jobs
 * @property Avatars $avatars
 * @property Constants $status0
 * @property Users $users
 * @property KnightsAchievements[] $knightsAchievements
 * @property KnightsCard $knightsCard
 * @property KnightsEvents[] $knightsEvents
 * @property KnightsEventsLast[] $knightsEventsLasts
 * @property KnightsEvolution[] $knightsEvolutions
 * @property KnightsPurchases[] $knightsPurchases
 * @property KnightsSettings $knightsSettings
 * @property KnightsStats $knightsStats
 * @property Constants[] $constants
 * @property KnightsStatsByDate[] $knightsStatsByDates
 * @property KnightsStatsDefenseLocation[] $knightsStatsDefenseLocations
 * @property KnightsStatsVs[] $knightsStatsVs
 * @property KnightsStatsVs[] $knightsStatsVs1
 * @property ObjectRepairs[] $objectRepairs
 * @property RoundsData[] $roundsDatas
 * @property SpearsObjects[] $spearsObjects
 * @property YellowPagesTotalByLetter[] $yellowPagesTotalByLetters
 */
class Knights extends CActiveRecord
{
	
	const STATUS_PENDING_VALIDATION = 6;
	const STATUS_ENABLE = 8;
	const STATUS_AT_COMBAT = 165;
	const STATUS_AT_WORK = 164;
	const STATUS_WITHOUT_EQUIPMENT = 198;
	
	const TYPE_INJURY_LIGHT = 136;
	const TYPE_INJURY_SERIOUSLY = 137;
	const TYPE_INJURY_VERY_SERIOUSLY = 138;
	const TYPE_INJURY_FATALITY = 139;
	
	const PATTERN_FOR_NAME = '/^[0-9a-zA-Z]\w+\w$/';
	const PATTERN_FOR_SEARCH_NAME = '/^[0-9a-zA-Z]\w*$/';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Knights the static model class
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
		return 'knights';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users_id, suscribe_date, name, status', 'required'),
			array('level, endurance, life, pain', 'numerical', 'integerOnly'=>true),
			array('users_id, status, coins, experiencie_earned, experiencie_used, avatars_id', 'length', 'max'=>10),
			array('name', 'length', 'max'=>10),
			array('name', 'match', 'pattern'=>self::PATTERN_FOR_NAME),	
			array('unsuscribe_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users_id, suscribe_date, unsuscribe_date, name, status, level, endurance, life, pain, coins, experiencie_earned, experiencie_used, avatars_id', 'safe', 'on'=>'search'),
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
			'armoursObjects' => array(self::HAS_MANY, 'ArmoursObjects', 'knights_id'),
			'combats' => array(self::MANY_MANY, 'Combats', 'combats_postcombat(knights_id, combats_id)'),
			'combats1' => array(self::HAS_MANY, 'Combats', 'to_knight'),
			'combatsTricks' => array(self::HAS_MANY, 'CombatsTricks', 'knights_id'),
			'healings' => array(self::HAS_ONE, 'Healings', 'knights_id'),
			'inventories' => array(self::HAS_MANY, 'Inventory', 'knights_id'),
			'jobs' => array(self::HAS_MANY, 'Jobs', 'knights_id'),
			'avatars' => array(self::BELONGS_TO, 'Avatars', 'avatars_id'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
			'users' => array(self::BELONGS_TO, 'Users', 'users_id'),
			'knightsAchievements' => array(self::HAS_MANY, 'KnightsAchievements', 'knights_id'),
			'knightsCard' => array(self::HAS_ONE, 'KnightsCard', 'knights_id'),
			'knightsEvents' => array(self::HAS_MANY, 'KnightsEvents', 'knights_id'),
			'knightsEventsLasts' => array(self::HAS_MANY, 'KnightsEventsLast', 'knights_id'),
			'knightsEvolutions' => array(self::HAS_MANY, 'KnightsEvolution', 'knights_id'),
			'knightsPurchases' => array(self::HAS_MANY, 'KnightsPurchases', 'knights_id'),
			'knightsSettings' => array(self::HAS_ONE, 'KnightsSettings', 'knights_id'),
			'knightsStats' => array(self::HAS_ONE, 'KnightsStats', 'knights_id'),
			'constants' => array(self::MANY_MANY, 'Constants', 'knights_stats_attack_location(knights_id, location)'),
			'knightsStatsByDates' => array(self::HAS_MANY, 'KnightsStatsByDate', 'knights_id'),
			'knightsStatsDefenseLocations' => array(self::HAS_MANY, 'KnightsStatsDefenseLocation', 'knights_id'),
			'knightsStatsVs' => array(self::HAS_MANY, 'KnightsStatsVs', 'knights_id'),
			'knightsStatsVs1' => array(self::HAS_MANY, 'KnightsStatsVs', 'opponent'),
			'objectRepairs' => array(self::HAS_MANY, 'ObjectRepairs', 'knights_id'),
			'roundsDatas' => array(self::HAS_MANY, 'RoundsData', 'knights_id'),
			'spearsObjects' => array(self::HAS_MANY, 'SpearsObjects', 'knights_id'),
			'yellowPagesTotalByLetters' => array(self::HAS_MANY, 'YellowPagesTotalByLetter', 'knights_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users_id' => 'Users',
			'suscribe_date' => 'Suscribe Date',
			'unsuscribe_date' => 'Unsuscribe Date',
			'name' => 'Name',
			'status' => 'Status',
			'level' => 'Level',
			'endurance' => 'Endurance',
			'life' => 'Life',
			'pain' => 'Pain',
			'coins' => 'Coins',
			'experiencie_earned' => 'Experiencie Earned',
			'experiencie_used' => 'Experiencie Used',
			'avatars_id' => 'Avatars',
		);
	}
	/**
	 * 
	 */
	public function statusLabel(){
		$labels = array(
			self::STATUS_AT_COMBAT => 'EN COMBATE',
			self::STATUS_AT_WORK => 'TRABAJANDO',
			self::STATUS_ENABLE => 'LISTO PARA EL COMBATE',
			self::STATUS_PENDING_VALIDATION => 'PENDIENTE DE VALIDACIÓN',
			self::STATUS_WITHOUT_EQUIPMENT => 'EL EQUIPO NO ESTÁ COMPLETO'			
		);
		
		return $labels[$this->status];
	}
	
	public function statusHtml(){
		$html = array(
				self::STATUS_AT_COMBAT => '<span class="colorRed">'.$this->statusLabel().'</span>',
				self::STATUS_AT_WORK => '<span class="colorRed">'.$this->statusLabel().'</span>',
				self::STATUS_ENABLE => '<span class="colorBlue">'.$this->statusLabel().'</span>',
				self::STATUS_PENDING_VALIDATION => '<span class="colorRed">'.$this->statusLabel().'</span>',
				self::STATUS_WITHOUT_EQUIPMENT => '<span class="colorRed">'.$this->statusLabel().'</span>'
		);
		return $html[$this->status];
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
		$criteria->compare('users_id',$this->users_id,true);
		$criteria->compare('suscribe_date',$this->suscribe_date,true);
		$criteria->compare('unsuscribe_date',$this->unsuscribe_date,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('level',$this->level);
		$criteria->compare('endurance',$this->endurance);
		$criteria->compare('life',$this->life);
		$criteria->compare('pain',$this->pain);
		$criteria->compare('coins',$this->coins,true);
		$criteria->compare('experiencie_earned',$this->experiencie_earned,true);
		$criteria->compare('experiencie_used',$this->experiencie_used,true);
		$criteria->compare('avatars_id',$this->avatars_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}