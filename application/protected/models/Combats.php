<?php

/**
 * This is the model class for table "combats".
 *
 * The followings are the available columns in table 'combats':
 * @property string $id
 * @property string $from_knight
 * @property string $to_knight
 * @property string $date
 * @property string $type
 * @property string $status
 * @property string $result
 * @property string $result_by
 * @property string $from_knight_injury_type
 * @property string $to_knight_injury_type
 *
 * The followings are the available model relations:
 * @property Knights $fromKnight
 * @property Knights $toKnight
 * @property Constants $status0
 * @property Constants $result0
 * @property Constants $type0
 * @property Constants $fromKnightInjuryType
 * @property Constants $toKnightInjuryType
 * @property Constants $resultBy
 * @property Knights[] $knights
 * @property CombatsPrecombat $combatsPrecombat
 * @property CombatsTricks[] $combatsTricks
 * @property Rounds[] $rounds
 */
class Combats extends CActiveRecord
{
	
	const STATUS_PENDING = 106;
	const STATUS_ENABLE = 107;
	const STATUS_FINISHED = 108;
	const TYPE_FRIENDLY = 110;
	const TYPE_TOURNAMENT = 111;
	
	const RESULT_REJECT = 113;
	const RESULT_FROM_KNIGHT_WIN = 114;
	/*
	 const RESULT_FROM_KNIGHT_WIN_WITH_INJURY_LIGHT = 115;
	const RESULT_FROM_KNIGHT_WIN_WITH_INJURY_SERIOUSLY = 116;
	const RESULT_FROM_KNIGHT_WIN_WITH_INJURY_VERY_SERIOUSLY = 117;
	const RESULT_FROM_KNIGHT_WIN_WITH_INJURY_FATALITY = 118;
	*/
	const RESULT_TO_KNIGHT_WIN = 119;
	/*
	 const RESULT_TO_KNIGHT_WIN_WITH_INJURY_LIGHT = 120;
	const RESULT_TO_KNIGHT_WIN_WITH_INJURY_SERIOUSLY = 121;
	const RESULT_TO_KNIGHT_WIN_WITH_INJURY_VERY_SERIOUSLY = 122;
	const RESULT_TO_KNIGHT_WIN_WITH_INJURY_FATALITY = 123;
	*/
	const RESULT_DRAW = 124;
	/*
	 const RESULT_DRAW_WITH_INJURY = 125;
	const RESULT_DRAW_WITH_INJURY_VERY_SERIOUSLY = 126;
	const RESULT_DRAW_WITH_INJURY_FATALITY = 127;
	const RESULT_FROM_KNIGHT_WIN = 128;
	const RESULT_FROM_KNIGHT_WIN_BY_THREE_FALL = 146;
	const RESULT_TO_KNIGHT_WIN_BY_THREE_FALL = 147;
	const RESULT_DRAW_BY_THREE_FALL = 148;
	*/
	const RESULT_BY_THREE_FALL = 150;
	const RESULT_BY_INJURY = 151;
	const RESULT_BY_KO = 152;
	const RESULT_BY_NOT_EQUIPMENT_REPLACE = 153;//Knight has not replace for broken equipment
	const RESULT_BY_DESQUALIFY = 200;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Combats the static model class
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
		return 'combats';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_knight, to_knight, type, status', 'required'),
			array('from_knight, to_knight, type, status, result, result_by, from_knight_injury_type, to_knight_injury_type', 'length', 'max'=>10),
			array('date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_knight, to_knight, date, type, status, result, result_by, from_knight_injury_type, to_knight_injury_type', 'safe', 'on'=>'search'),
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
			'fromKnight' => array(self::BELONGS_TO, 'Knights', 'from_knight'),
			'toKnight' => array(self::BELONGS_TO, 'Knights', 'to_knight'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
			'result0' => array(self::BELONGS_TO, 'Constants', 'result'),
			'type0' => array(self::BELONGS_TO, 'Constants', 'type'),
			'fromKnightInjuryType' => array(self::BELONGS_TO, 'Constants', 'from_knight_injury_type'),
			'toKnightInjuryType' => array(self::BELONGS_TO, 'Constants', 'to_knight_injury_type'),
			'resultBy' => array(self::BELONGS_TO, 'Constants', 'result_by'),
			'knights' => array(self::MANY_MANY, 'Knights', 'combats_postcombat(combats_id, knights_id)'),
			'combatsPrecombat' => array(self::HAS_ONE, 'CombatsPrecombat', 'combats_id'),
			'combatsTricks' => array(self::HAS_MANY, 'CombatsTricks', 'combats_id'),
			'rounds' => array(self::HAS_MANY, 'Rounds', 'combats_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_knight' => 'From Knight',
			'to_knight' => 'To Knight',
			'date' => 'Date',
			'type' => 'Type',
			'status' => 'Status',
			'result' => 'Result',
			'result_by' => 'Result By',
			'from_knight_injury_type' => 'From Knight Injury Type',
			'to_knight_injury_type' => 'To Knight Injury Type',
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
		$criteria->compare('from_knight',$this->from_knight,true);
		$criteria->compare('to_knight',$this->to_knight,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('result',$this->result,true);
		$criteria->compare('result_by',$this->result_by,true);
		$criteria->compare('from_knight_injury_type',$this->from_knight_injury_type,true);
		$criteria->compare('to_knight_injury_type',$this->to_knight_injury_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}