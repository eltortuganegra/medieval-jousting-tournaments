<?php

/**
 * This is the model class for table "inventory".
 *
 * The followings are the available columns in table 'inventory':
 * @property string $id
 * @property string $knights_id
 * @property string $type
 * @property string $identificator
 * @property integer $position
 * @property integer $amount
 *
 * The followings are the available model relations:
 * @property Knights $knights
 * @property Constants $type0
 */
class Inventory extends CActiveRecord
{
	const EQUIPMENT_TYPE_ARMOUR = 56;
	const EQUIPMENT_TYPE_SPEAR = 57;
	const EQUIPMENT_TYPE_TRICK = 68;

	const POSITION_RIGHT_SHOULDER = 1;
	const POSITION_HELMET = 2;
	const POSITION_LEFT_SHOULDER = 3;
	const POSITION_RIGHT_ELBOW = 4;
	const POSITION_LEFT_ELBOW = 5;
	const POSITION_RIGHT_HAND = 6;
	const POSITION_LEFT_HAND = 7;
	const POSITION_SPEAR = 8;
	const POSITION_CHEST = 9;
	const POSITION_SHIELD = 10;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Inventory the static model class
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
		return 'inventory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('knights_id, type, identificator, position', 'required'),
			array('position, amount', 'numerical', 'integerOnly'=>true),
			array('knights_id, type, identificator', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, knights_id, type, identificator, position, amount', 'safe', 'on'=>'search'),
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
			'position' => 'Position',
			'amount' => 'Amount',
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
		$criteria->compare('position',$this->position);
		$criteria->compare('amount',$this->amount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * Return de position of inventory from attack position combat.
	 * @param unknown_type $attack_position
	 * @return Ambigous <NULL, string>
	 */
	public function getPositionFromAttackPosition( $attack_position ){
		$conversion = array(			
			'1'=>null,
			'2'=>null,
			'3'=>null,
			'4'=>self::POSITION_HELMET,
			'5'=>self::POSITION_HELMET,
			'6'=>null,
			'7'=>null,
			'8'=>null,
				
			'9'=>null,
			'10'=>null,
			'11'=>null,
			'12'=>self::POSITION_HELMET,
			'13'=>self::POSITION_HELMET,
			'14'=>null,
			'15'=>null,
			'16'=>null,
				
			'17'=>null,
			'18'=>self::POSITION_RIGHT_SHOULDER,
			'19'=>self::POSITION_RIGHT_SHOULDER,
			'20'=>self::POSITION_CHEST,
			'21'=>self::POSITION_CHEST,
			'22'=>self::POSITION_LEFT_SHOULDER,
			'23'=>self::POSITION_LEFT_SHOULDER,
			'24'=>null,
				
			'25'=>self::POSITION_RIGHT_ELBOW,
			'26'=>self::POSITION_RIGHT_ELBOW,
			'27'=>self::POSITION_CHEST,
			'28'=>self::POSITION_CHEST,
			'29'=>self::POSITION_CHEST,
			'30'=>self::POSITION_CHEST,
			'31'=>self::POSITION_LEFT_ELBOW,
			'32'=>self::POSITION_LEFT_ELBOW,
				
			'33'=>self::POSITION_RIGHT_ELBOW,
			'34'=>self::POSITION_RIGHT_ELBOW,
			'35'=>self::POSITION_CHEST,
			'36'=>self::POSITION_CHEST,
			'37'=>self::POSITION_CHEST,
			'38'=>self::POSITION_CHEST,
			'39'=>self::POSITION_LEFT_ELBOW,
			'40'=>self::POSITION_LEFT_ELBOW,
				
			'41'=>self::POSITION_RIGHT_HAND,
			'42'=>self::POSITION_RIGHT_HAND,
			'43'=>self::POSITION_CHEST,
			'44'=>self::POSITION_CHEST,
			'45'=>self::POSITION_CHEST,
			'46'=>self::POSITION_CHEST,
			'47'=>self::POSITION_LEFT_HAND,
			'48'=>self::POSITION_LEFT_HAND
		);
		return $conversion[$attack_position];		
	}
	
	/**
	 * Return spear, shield and armour in use for a knight in one round.
	 * @param unknown_type $knigth_id
	 * @param unknown_type $armourPosition
	 * @param unknown_type $shieldPosition
	 * @param unknown_type $spearPosition
	 * @return multitype:NULL
	 */
	public static function getCurrentEquipment4Round( $knigth_id, $armourPosition = "null" , $shieldPosition = self::POSITION_SHIELD, $spearPosition =self::POSITION_SPEAR  ){
		$equipment = array(
				'spear_object'=>null,				
				'spear'=>null,
				'shield_object'=>null,
				'shield'=>null,
				'armour_object'=>null,
				'armour'=>null,
		);
		$sql = 'SELECT
					identificator,
					position 
				FROM 
					inventory
				WHERE 
					knights_id = :knights_id AND
					(position = '.$armourPosition.' OR position = '.$shieldPosition.' OR position = '.$spearPosition.' )';
		//echo $sql;die;
		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue( 'knights_id', $knigth_id);
		$result = $command->queryAll();
		
		foreach( $result as $element ){		
			switch( $element['position'] ){
				case Inventory::POSITION_SHIELD:					 
					$equipment['shield_object'] = ArmoursObjects::model()->findByPk( $element['identificator'] );
					$equipment['shield'] = Armours::model()->findByPk( $equipment['shield_object']->armours_id);
					break;
				case Inventory::POSITION_SPEAR:					 
					$equipment['spear_object'] = SpearsObjects::model()->findByPk( $element['identificator'] );
					$equipment['spear'] = Spears::model()->findByPk( $equipment['spear_object']->spears_id );
					break;
				default:					
					$equipment['armour_object'] = ArmoursObjects::model()->findByPk( $element['identificator'] );
					$equipment['armour'] = Armours::model()->findByPk( $equipment['armour_object']->armours_id);									
			}
		}
		return $equipment;
	}
	/**
	 * Check if knight has a replacement for a item. Return true or false.
	 * @param unknown_type $knight_id
	 * @param unknown_type $inventory_type spear or armour
	 * @param unknown_type $identificator from object item (armours_object or spears_object)
	 * @return boolean
	 */
	public static function checkHasReplacement( $knight_id, $inventory_type, $identificator ){
		Yii::trace( '[INVENTORY][checkHasReplacement] start for knight('.$knight_id.') inventory type('.$inventory_type.') identificator('.$identificator.') ' );
		
		//Check if is a spear or armour
		if( $inventory_type == Inventory::EQUIPMENT_TYPE_SPEAR ){ 
			$sql = "SELECT
						COUNT(*) as total
					FROM
						spears_objects					
					WHERE						
						knights_id = :knights_id AND
						id != :identificator";
			$command = Yii::app()->db->createCommand($sql);			
			$command->bindValue(':knights_id', $knight_id);
			$command->bindValue(':identificator', $identificator);
			
		}else{				
			//Load item to replacement
			$sql = "SELECT 
						COUNT(*) as total
					FROM
						armours_objects
					INNER JOIN 
						armours ON armours.id = armours_objects.armours_id
					WHERE
						armours.type = :type AND
						knights_id = :knights_id AND 
						armours_objects.id != :identificator";
			$command = Yii::app()->db->createCommand($sql);
			$command->bindValue(':type', $inventory_type);
			$command->bindValue(':knights_id', $knight_id);
			$command->bindValue(':identificator', $identificator);			
		}
	
		$result = $command->queryRow();
		return $result['total'];
	}

	public static function updateOrDeleteEquipment( &$item ){
		Yii::trace( '[INVENTORY][updateOrDeleteEquipment] Check item\'s pde ('.$item->current_pde.') knight ('.$item->knights_id.') identificator ('.$item->id.')' );
		if( $item->current_pde > 0 ){
			//Update object
			Yii::trace( 'Update item' );
			$item->save();
		}else{
			//We need delete from inventory and armours or spears object
			Yii::trace( 'delete item' );
			$data = array(
				':knights_id'=>$item->knights_id,
				':identificator'=>$item->id
			);
			//Delete item from inventary			
			if( Inventory::model()->deleteAll( 'knights_id = :knights_id AND identificator = :identificator', $data ) == 0){
				Yii::trace( 'Error to delete item in inventory' );
			}
			//delete item from armours or spears
			if( !$item->delete() ){
				Yii::trace( 'Error to delete item' );
			}			
		}
	}
	
	/**
	 *  Search for empty socket in inventory. return empty position or false is is full 
	 * @param unknown_type $knight_id
	 * @return number|boolean
	 */
	public static function getFirstEmptySocket( $knight_id ){
		Yii::trace( '[INVENTORY][getFirstEmptySocket] Check empty socket');
		$criteria = new CDbCriteria();
		$criteria->select = 'position';
		$criteria->condition = 'knights_id = :knights_id AND position > '. Yii::app()->params['inventory']['useEquipmentPosition'];
		$criteria->params =  array(':knights_id'=>$knight_id);
		$criteria->order = 'position ASC';
		$items = Inventory::model()->findAll( $criteria );		
		Yii::trace( '[INVENTORY][getFirstEmptySocket] Total items ('.count($items ).') maximum items ('.(Yii::app()->params['inventory']['maxPosition']-Yii::app()->params['inventory']['useEquipmentPosition']).')' );
		//Check if secondary equipment is full
		if( count($items ) < (Yii::app()->params['inventory']['maxPosition'] - Yii::app()->params['inventory']['useEquipmentPosition']) ){
						
			//Check first position free
			$position = 11;
			foreach( $items as $item ){
				//Yii::trace( 'Check sockect '.$position.' with position object '.$item->position );
				//check if position is free
				if(  $item->position != $position ){
					//This position is empty
					return $position;
				}
				
				//Next position
				$position++;
			}
			//Amount of items is less than total of sockets. No socket beetwen items then last sokect is empty.
			return $position;
		}else{
			return false;
		}
	}
	
	/**
	 * Check if user has primary equipment complete.
	 * 
	 * @param unknown_type $knights_id
	 * @return boolean
	 */
	public static function checkIfPrimaryEquipmentIsCompleted($knight_id){
		//Load all equipment of knight
		$allEquipment = self::model()->findAll( array( 'select'=>'position','condition'=>'knights_id = :knights_id AND position <= :position', 'order'=>'position ASC', 'params'=>array( ':knights_id'=>$knight_id, ':position'=>self::POSITION_SHIELD), 'index'=>'position' ) );
		Yii::trace('[INVENTORY][checkIfPrimaryEquipmentIsCompleted] total equipment ('.count( count($allEquipment) ).')');
		return count($allEquipment)==10;
	}
	
	
}