<?php

/**
 * This is the model class for table "knights_achievements".
 *
 * The followings are the available columns in table 'knights_achievements':
 * @property integer $id
 * @property string $achievements_id
 * @property string $knights_id
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Achievements $achievements
 * @property Knights $knights
 */
class KnightsAchievements extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsAchievements the static model class
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
		return 'knights_achievements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('achievements_id, knights_id, date', 'required'),
			array('achievements_id, knights_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, achievements_id, knights_id, date', 'safe', 'on'=>'search'),
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
			'achievements' => array(self::BELONGS_TO, 'Achievements', 'achievements_id'),
			'knights' => array(self::BELONGS_TO, 'Knights', 'knights_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'achievements_id' => 'Achievements',
			'knights_id' => 'Knights',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('achievements_id',$this->achievements_id,true);
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}