<?php

/**
 * This is the model class for table "knights_events_last".
 *
 * The followings are the available columns in table 'knights_events_last':
 * @property string $id
 * @property string $knights_id
 * @property string $type
 * @property string $identificator
 * @property string $date
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $type0
 */
class KnightsEventsLast extends CActiveRecord
{
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsEventsLast the static model class
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
		return 'knights_events_last';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, type, identificator, date', 'required'),
			array('knights_id, type, identificator', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, type, identificator, date', 'safe', 'on'=>'search'),
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
			'identificator' => 'Identificator',
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
		$criteria->compare('type',$this->type,true);
		$criteria->compare('identificator',$this->identificator,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of last events of knight order by date
	 */
	public static function findKnightEventLast( $knights_id, $limit = null, $start = null   ){
		$params = array(
				'condition' =>'knights_id = :knights_id',
				'params' =>  array(':knights_id'=>$knights_id  ),
				'order' => 'date DESC',
		);
		
		if( $limit ){
			if( $start ){
				$params['limit'] = $start.', '.$limit;
			}else{
				$params['limit'] = $limit;
			}
		}
		
		return self::model()->findAll( $params ); 	
	}
	
	/**
	 * Retrieves old last event of knight
	 * @param unknown_type $knight_id
	 */
	public static function getOldLastEvent( $knight_id ){
		return KnightsEventsLast::model()->find( array(
				'condition' =>'knights_id = :knights_id',
				'params' =>  array(':knights_id'=>$knight_id  ),
				'order' => 'date ASC',
				'limit' => '1'
		));
	}
}