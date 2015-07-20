<?php

/**
 * This is the model class for table "equipment_requirements".
 *
 * The followings are the available columns in table 'equipment_requirements':
 * @property string $id
 * @property string $identificator
 * @property string $equipments_type
 * @property string $requirements_id
 *
 * The followings are the available model relations:
 * @property Constants $equipmentsType
 * @property Requirements $requirements
 */
class EquipmentRequirements extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EquipmentRequirements the static model class
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
		return 'equipment_requirements';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identificator, equipments_type, requirements_id', 'required'),
			array('identificator, equipments_type, requirements_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, identificator, equipments_type, requirements_id', 'safe', 'on'=>'search'),
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
			'equipmentsType' => array(self::BELONGS_TO, 'Constants', 'equipments_type'),
			'requirements' => array(self::BELONGS_TO, 'Requirements', 'requirements_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'identificator' => 'Identificator',
			'equipments_type' => 'Equipments Type',
			'requirements_id' => 'Requirements',
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
		$criteria->compare('identificator',$this->identificator,true);
		$criteria->compare('equipments_type',$this->equipments_type,true);
		$criteria->compare('requirements_id',$this->requirements_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Check if a knight accomplish with requirements for item
	 * @param unknown $equipment_type
	 * @param unknown $identificator
	 * @param unknown $knight_id
	 * @return boolean
	 */
	static public function checkAccomplish($equipments_type, $identificator, $knight_id) {
		Yii::trace('[APP] Cehck for  ' ."$equipments_type, $identificator, $knight_id");
		// Search all requirements
		$equipmentRequirementsList = self::model()->findAll(
			'identificator=:identificator AND equipments_type=:equipments_type',
			array(':identificator'=>$identificator, ':equipments_type'=>$equipments_type)
		);
		
		if ($equipmentRequirementsList) {
			Yii::trace('[APP] equipment requirement exist');
			// Load knight card
			$knight = Knights::model()->findByPk($knight_id);
			$knightCard = KnightsCard::model()->findByPk($knight_id);
			
			// Check for each requirement if knight accomplish with it
		// Check if all requirements are accomplish. Load requirements
			foreach ($equipmentRequirementsList as $equipmentRequirements) {
				Yii::trace('[APP] check requirement ' . $equipmentRequirements->requirements_id);
				// Load requirement
				$requirement = Requirements::model()->findByPk($equipmentRequirements->requirements_id);
				Yii::trace('[APP] Load requirement ' . $requirement->id . ': ' . $requirement->level . ' - ' . $requirement->attribute .' - ' . $requirement->skill );
				// Check level
				if (($requirement->level!=null && $requirement->value > $knight->level)) {
					Yii::trace('[APP] No level');
					return false;
					 
				} //Check attribute 
				else if ($requirement->attribute!=null) {
					Yii::trace('[APP] Is attribute');
					// Load name of characteristic					
					$attributeName = Constants::model()->findByPk($requirement->attribute);									
					if ($requirement->value > $knightCard->{$attributeName->name}){
						Yii::trace('[APP] NO attribute');
						return false;
					}
				} // Check skill
				else if ($requirement->skill!=null) {
					Yii::trace('[APP] Is skill');
					$attributeName = Constants::model()->findByPk($requirement->skill);
					if ($requirement->value > $knightCard->{$attributeName->name}) {
						Yii::trace('[APP] No skill');
						return false;
					}
				}
				Yii::trace('[APP] requirement pass');
			}			
		}
		Yii::trace('[APP] Fuck yeah');
		return true;
	}
	
}