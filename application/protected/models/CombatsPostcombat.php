<?php

/**
 * This is the model class for table "combats_postcombat".
 *
 * The followings are the available columns in table 'combats_postcombat':
 * @property string $combats_id
 * @property string $knights_id
 * @property integer $knight_rival_level
 * @property string $experience_generate
 * @property integer $percent_by_result
 * @property integer $percent_by_injury
 * @property integer $earned_experience
 * @property string $total_experience
 * @property string $total_coins
 * @property string $earned_coins
 * @property string $injury_type
 */
class CombatsPostcombat extends CActiveRecord
{
	const EXPERIENCE_SAME_LEVEL = 32;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CombatsPostcombat the static model class
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
		return 'combats_postcombat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('combats_id, knights_id, knight_rival_level, experience_generate, percent_by_result, percent_by_injury, earned_experience, total_experience, total_coins, earned_coins', 'required'),
			array('knight_rival_level, percent_by_result, percent_by_injury, earned_experience', 'numerical', 'integerOnly'=>true),
			array('combats_id, knights_id, experience_generate, total_experience, total_coins, earned_coins, injury_type', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('combats_id, knights_id, knight_rival_level, experience_generate, percent_by_result, percent_by_injury, earned_experience, total_experience, total_coins, earned_coins, injury_type', 'safe', 'on'=>'search'),
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
			'combats_id' => 'Combats',
			'knights_id' => 'Knights',
			'knight_rival_level' => 'Knight Rival Level',
			'experience_generate' => 'Experience Generate',
			'percent_by_result' => 'Percent By Result',
			'percent_by_injury' => 'Percent By Injury',
			'earned_experience' => 'Earned Experience',
			'total_experience' => 'Total Experience',
			'total_coins' => 'Total Coins',
			'earned_coins' => 'Earned Coins',
			'injury_type' => 'Injury Type',
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
		$criteria->compare('knights_id',$this->knights_id,true);
		$criteria->compare('knight_rival_level',$this->knight_rival_level);
		$criteria->compare('experience_generate',$this->experience_generate,true);
		$criteria->compare('percent_by_result',$this->percent_by_result);
		$criteria->compare('percent_by_injury',$this->percent_by_injury);
		$criteria->compare('earned_experience',$this->earned_experience);
		$criteria->compare('total_experience',$this->total_experience,true);
		$criteria->compare('total_coins',$this->total_coins,true);
		$criteria->compare('earned_coins',$this->earned_coins,true);
		$criteria->compare('injury_type',$this->injury_type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * calculate experience  for a combat
	 * @param unknown_type $combat
	 * @param unknown_type $precombat
	 * @param unknown_type $from_knight_level
	 * @param unknown_type $to_knight_level
	 * @return multitype:number
	 */
	public static function calculateEarnedExperience( &$combat, $from_knight_level, $to_knight_level ){
		$data = array(
				'from_knight_experience_generate'=>0, //Base experience
				'from_knight_percent_by_result'=>0,//Percent by result
				'from_knight_percent_by_injury'=>0,//Percent by injury
				'from_knight_earned_experience' => 0,//Total earned experience
				'to_knight_experience_generate'=>0, //Base experience
				'to_knight_percent_by_result'=>0,//Percent by result
				'to_knight_percent_by_injury'=>0,//Percent by injury
				'to_knight_earned_experience' => 0,//Total earned experience
		);
		
		$data['from_knight_experience_generate'] = self::EXPERIENCE_SAME_LEVEL;
		$data['to_knight_experience_generate'] = self::EXPERIENCE_SAME_LEVEL;
	
		/*
		 * Experience point by combat. Change when knights have distinct levels
		*/
		if( $from_knight_level != $to_knight_level ){
			if( $from_knight_level > $to_knight_level){
				//Knight has more level than rival
				$data['from_knight_experience_generate'] = $experience_points_by_combat*pow( 2,  $to_knight_level - $from_knight_level);
				$data['to_knight_experience_generate'] = $experience_points_by_combat/pow( 2, $from_knight_level - $to_knight_level);
			}else{
				//Rival has more level than knight
				$data['from_knight_experience_generate'] = $experience_points_by_combat/pow( 2, $from_knight_level - $to_knight_level);
				$data['to_knight_experience_generate'] = $experience_points_by_combat*pow( 2,  $to_knight_level - $from_knight_level);
			}
		}
	
		/*
		 * add modificator of result combat
		*/
		//Check if from_knight win combat
		switch( $combat->result ){
			case Combats::RESULT_FROM_KNIGHT_WIN:
				$data['from_knight_percent_by_result'] = 100;
				$data['to_knight_percent_by_result'] = 25;
				break;
			case Combats::RESULT_TO_KNIGHT_WIN:
				$data['from_knight_percent_by_result'] = 25;
				$data['to_knight_percent_by_result'] = 100;
				break;
			case Combats::RESULT_DRAW:
				$data['from_knight_percent_by_result'] = 50;
				$data['to_knight_percent_by_result'] = 50;
				break;
			default:
				//nothing to do here
		}
	
	
	
		//Check injury
		if( $combat->result_by == Combats::RESULT_BY_INJURY ){
	
			//Check injury of from_knight
			if( $combat->from_knight_injury_type != null ){
				switch(  $combat->from_knight_injury_type ){
					case Knights::TYPE_INJURY_LIGHT:
						$data['from_knight_percent_by_injury'] = -50;
						break;
					case Knights::TYPE_INJURY_SERIOUSLY:
						$data['from_knight_percent_by_injury'] = -75;
						break;
					case Knights::TYPE_INJURY_VERY_SERIOUSLY:
						$data['from_knight_percent_by_injury'] = -125;
						break;
					case Knights::TYPE_INJURY_FATALITY:
						$data['from_knight_percent_by_injury'] = -225;
						break;
					default:
				}
				//Change experience to own knight's experience
				//$data['from_knight_experience_generate'] = EXPERIENCE_SAME_LEVEL;
				//$data['from_knight_earned_experience'] = $data['from_knight_earned_experience'] + floor( $data['from_knight_experience_generate']*$data['from_knight_percent_by_injury']/100 );
			}else{
				//$experience['from_knight_earned_experience'] = floor( $data['from_knight_experience_generate']*$data['from_knight_percent_by_result']/100 );
			}
			//Check injury of to knight
			if( $combat->to_knight_injury_type != null ){
				switch(  $combat->to_knight_injury_type ){
					case Knights::TYPE_INJURY_LIGHT:
						$data['to_knight_percent_by_injury'] = -50;
						break;
					case Knights::TYPE_INJURY_SERIOUSLY:
						$data['to_knight_percent_by_injury'] = -75;
						break;
					case Knights::TYPE_INJURY_VERY_SERIOUSLY:
						$data['to_knight_percent_by_injury'] = -125;
						break;
					case Knights::TYPE_INJURY_FATALITY:
						$data['to_knight_percent_by_injury'] = -225;
						break;
					default:
				}
				//$data['to_knight_experience_generate'] = EXPERIENCE_SAME_LEVEL;
				//$data['to_knight_earned_experience'] = $data['to_knight_earned_experience'] + floor( $data['to_knight_experience_generate']*$data['to_knight_percent_by_injury']/100 );
			}else{
				//$data['to_knight_earned_experience'] = floor( $data['from_knight_experience_generate']*$data['to_knight_percent_by_result']/100 );
			}
		}//else{
			//Calculate earned experience
			//$data['from_knight_earned_experience'] = floor( $data['from_knight_experience_generate']*$data['from_knight_percent_by_result']/100 );
			//$data['to_knight_earned_experience'] = floor( $data['to_knight_experience_generate']*$data['to_knight_percent_by_result']/100 );
		//}
	
		//Calculate
		$data['from_knight_earned_experience'] = floor( $data['from_knight_experience_generate']*$data['from_knight_percent_by_result']/100 )+floor( self::EXPERIENCE_SAME_LEVEL*$data['from_knight_percent_by_injury']/100 );
		$data['to_knight_earned_experience'] = floor( $data['to_knight_experience_generate']*$data['to_knight_percent_by_result']/100 )+floor( self::EXPERIENCE_SAME_LEVEL*$data['to_knight_percent_by_injury']/100 );
		
		return $data;
	}
	
	/**
	 * knight's equipment are repaired automatically. Looking for equipment with pde loosed, calculate repair cost, substract to knight coins and add pde points. 
	 * Return if error 
	 * @param unknown_type $combat
	 * @param unknown_type $knight
	 * @return multitype:number boolean
	 */
	public static function autorepairObjectsEquipment( &$combat, &$knight ){
		//
		$output = array(
			'errno'=>0,
			'error'=>'',
			'automatic_repair'=> true, //Si se ha podido hacer automáticamente la reparación
			'repair_cost' => 0,
			'not_enought_money' => false
		);
		//Prepared statement
		$sql = '';
		//Load all items of inventory of knight
		$inventory = Inventory::model()->findAll( 'knights_id = :knights_id AND (type = '.Inventory::EQUIPMENT_TYPE_ARMOUR.' OR type = '.Inventory::EQUIPMENT_TYPE_SPEAR.' )', array( ':knights_id'=>$knight->id) );
		
		if( count($inventory) ){
			//For each item check maximun pde
			foreach( $inventory as $item ){
				//Load class of item
				if( $item['type'] == Inventory::EQUIPMENT_TYPE_ARMOUR){
					$object = ArmoursObjects::model()->findByPk( $item['identificator']); 
					$classItem = Armours::model()->findByPk( $object->armours_id);
				}else{
					$object = SpearsObjects::model()->findByPk( $item['identificator']);
					$classItem = Spears::model()->findByPk( $object->spears_id );
				}
				//echo "\n".$knight->name.": ".$classItem->name." PDE MAX (".$classItem->pde.") object pde (".$object->current_pde.") ";
				
				//Check if need a repair
				if( $object->current_pde < $classItem->pde ){
					
					//Check prize of reparation
					$percentPDEloose = 1-$object->current_pde/$classItem->pde;
					$repair_cost = ceil( $classItem->prize * $percentPDEloose );
					
					//echo "coins (".$knight->coins.") percent ($percentPDEloose) prize class item(".$classItem->prize.") repair cost (".$repair_cost.")";
					
					//Check coins and cost
					if( $knight->coins > $repair_cost ){
						Yii::log( 'Reparando '.$classItem->name.' por '.$repair_cost.' MO' );
						//Add autorepair row
						$objectRepair = new ObjectRepairs();
						$objectRepair->attributes = array(
							'knights_id'=>$knight->id,
							'inventory_type'=>$item['type'],
							'combats_id'=>$combat->id,
							'object_identificator'=>$item['identificator'],
							'class_identificator'=>$classItem->id,
							'current_pde'=>$object->current_pde,
							'maximum_pde'=>$classItem->pde,
							'repair_cost'=>$repair_cost,
							'date'=>date('Y-m-d H:m:s')
						);
						if( !$objectRepair->save() ){
							$output['errno'] = 2;
							$output['error'] .= $objectRepair->getErrors();
						}
							
						//We can repair the object
						$object->current_pde = $classItem->pde;
						if( !$object->save() ){
							$output['errno'] = 4;
						}
						//Subtract coins
						$knight->coins -= $repair_cost;
						$output['repair_cost'] += $repair_cost;
						
											
					}else{
						//Upsss, knight has not enought money!! we break loop
						Yii::log( '¡¡No se puede reparar!!' );
						$output['not_enought_money'] = true;
						break;
					}
				}
			}	
		}else{
			$output['errno'] = 1;
		}
		//var_dump($output);
		return $output;
	}
}