<?php

/**
 * This is the model class for table "knights_card".
 *
 * The followings are the available columns in table 'knights_card':
 * @property string $knights_id
 * @property integer $strength
 * @property integer $dexterity
 * @property integer $constitution
 * @property integer $perception
 * @property integer $intelligence
 * @property integer $skill
 * @property integer $charisma
 * @property integer $will
 * @property integer $spear
 * @property integer $shield
 * @property integer $act
 * @property integer $trade
 * @property integer $manipulation
 * @property integer $concentration
 * @property integer $alert
 * @property integer $stealth
 *
 * The followings are the available model relations:
 * @property Knights $knights
 */
class KnightsCard extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return KnightsCard the static model class
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
		return 'knights_card';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id', 'required'),
			array('strength, dexterity, constitution, perception, intelligence, skill, charisma, will, spear, shield, act, trade, manipulation, concentration, alert, stealth', 'numerical', 'integerOnly'=>true),
			array('knights_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('knights_id, strength, dexterity, constitution, perception, intelligence, skill, charisma, will, spear, shield, act, trade, manipulation, concentration, alert, stealth', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'knights_id' => 'Sir',
			'strength' => 'FUERZA',
			'dexterity' => 'DESTREZA',
			'constitution' => 'CONSTITUCIÓN',
			'perception' => 'PERCEPCIÓN',
			'intelligence' => 'INTELIGENCIA',
			'skill' => 'HABILIDAD',
			'charisma' => 'CARISMA',
			'will' => 'VOLUNTAD',
			'spear' => 'lanza',
			'shield' => 'escudo',
			'act' => 'actuar',
			'trade' => 'comerciar',
			'manipulation' => 'manipular',
			'concentration' => 'concentración',
			'alert' => 'alerta',
			'stealth' => 'sigilo',
		);
	}
	public function attributeLabelsById()
	{
		return array(				
				'70' => 'FUERZA',
				'71' => 'DESTREZA',
				'72' => 'CONSTITUCIÓN',
				'73' => 'PERCEPCIÓN',
				'74' => 'INTELIGENCIA',
				'75' => 'HABILIDAD',
				'76' => 'CARISMA',
				'7' => 'VOLUNTAD',
				'79' => 'lanza',
				'80' => 'escudo',
				'81' => 'actuar',
				'82' => 'comerciar',
				'83' => 'manipular',
				'84' => 'concentración',
				'85' => 'alerta',
				'86' => 'sigilo',
		);
	}

	public static function getNameAttributeLabel( $characteristic ){
		$characteristics =  array(
			'knights_id' => 'Sir',
			'strength' => 'FUERZA',
			'dexterity' => 'DESTREZA',
			'constitution' => 'CONSTITUCIÓN',
			'perception' => 'PERCEPCIÓN',
			'intelligence' => 'INTELIGENCIA',
			'skill' => 'HABILIDAD',
			'charisma' => 'CARISMA',
			'will' => 'VOLUNTAD',
			'spear' => 'lanza',
			'shield' => 'escudo',
			'act' => 'actuar',
			'trade' => 'comerciar',
			'manipulation' => 'manipular',
			'concentration' => 'concentración',
			'alert' => 'alerta',
			'stealth' => 'sigilo',
				);
		return $characteristics[ $characteristic ];
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

		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('strength',$this->strength);
		$criteria->compare('dexterity',$this->dexterity);
		$criteria->compare('constitution',$this->constitution);
		$criteria->compare('perception',$this->perception);
		$criteria->compare('intelligence',$this->intelligence);
		$criteria->compare('skill',$this->skill);
		$criteria->compare('charisma',$this->charisma);
		$criteria->compare('will',$this->will);
		$criteria->compare('spear',$this->spear);
		$criteria->compare('shield',$this->shield);
		$criteria->compare('act',$this->act);
		$criteria->compare('trade',$this->trade);
		$criteria->compare('manipulation',$this->manipulation);
		$criteria->compare('concentration',$this->concentration);
		$criteria->compare('alert',$this->alert);
		$criteria->compare('stealth',$this->stealth);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Return maximun value for all characteristic
	 * @return Ambigous <number, unknown>
	 */
	public function getMaxValueCharacteristic(){
		$maxValue = 1;
		
		foreach( $this->attributes as $key => $value ){
			if( $key!='knights_id' && $maxValue < $value ) $maxValue = $value; 
		}		
		return $maxValue;
	}
	
}