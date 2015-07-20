<?php

class MedievalmarketController extends Controller
{
	
	public $layout = '2columnas';
	
	public $user_data = array(			
		'knights'=>null //Storage user's knight data
	);
	public $app_data = array();
	
	
	/**
	 * Before action load knight data of user
	 * @param unknown_type $action
	 */
	
	public function beforeAction( $action ){		
		//Load user's knight data
		if( !Yii::app()->user->isGuest ){		
			$this->user_data['knights'] = Knights::model()->with( 'knightsCard', 'knightsStats' )->find( 'id=:id', array(':id'=>Yii::app()->user->knights_id) );
			$this->user_data['knights_card'] = &$this->user_data['knights']->knightsCard; 
			
			//Load stats of knight
			$this->user_data['knights_stats'] = &$this->user_data['knights']->knightsStats;
			//Load if user has new friendship request
			$sql = 'SELECT friends.id as id, k1.name as name, k1.avatars_id as avatars_id FROM friends
					INNER JOIN users ON users.id = friends.from_user
					INNER JOIN knights as k1 ON k1.users_id = users.id
					WHERE friends.status = :status AND to_user = :users_knights_id1
					ORDER BY start_date DESC';
			$command = Yii::app()->db->createCommand(  $sql );
			$command->bindValue( ':status', Friends::STATUS_ONWAITING, PDO::PARAM_INT );
			$command->bindValue( ':users_knights_id1',$this->user_data['knights']->id, PDO::PARAM_INT );
			$this->user_data['knights_new_friends'] =  $command->queryAll();
			
			//Load last messages
			$this->user_data['new_messages'] = Messages::getNewMessages(Yii::app()->user->users_id);
				
			//Load all attributes name attributes
			$this->app_data['attribute_list'] = Constants::model()->findAll( 'type=:type', array(':type'=>Constants::KNIGHTS_ATTRIBUTES) );
			
	
		}
		return true;
	}

	public function actionIndex(){
		//Init
		$data = array(
			'defaultValues'=>array(
				'inventory_type'=>Inventory::EQUIPMENT_TYPE_ARMOUR,
				'spear_name'=>null,
				'spear_material'=>null,
				'spear_equipment_size'=>null,
				'spear_equipment_quality'=>null,
				'spear_equipment_rarity'=>null,
				'spear_damage_min'=>null,
				'spear_damage_max'=>null,
				'spear_pde_min'=>null,
				'spear_pde_max'=>null,
				'spear_prize_min'=>null,
				'spear_prize_max'=>null,
				'armour_name'=>null,
				'armour_material'=>null,
				'armour_equipment_size'=>null,
				'armour_equipment_quality'=>null,
				'armour_equipment_rarity'=>null,
				'armour_endurance_min'=>null,
				'armour_endurance_max'=>null,
				'armour_pde_min'=>null,
				'armour_pde_max'=>null,
				'armour_prize_min'=>null,
				'armour_prize_max'=>null,
				'armour_type'=>null
			),
			'result'=>array()
		);
		
		
		//Check input filter		
		if( isset($_POST['inventory_type']) && is_numeric($_POST['inventory_type']) ){
			$data['defaultValues']['inventory_type'] = $_POST['inventory_type'];
			//For search
			$conditions  = '1=1 ';
			$params = array();
			
			switch ( $_POST['inventory_type'] ){
				case Inventory::EQUIPMENT_TYPE_ARMOUR:										
					if( isset( $_POST['armour_name'] ) && $_POST['armour_name'] != '' ){
						$data['defaultValues']['armour_name'] = $_POST['armour_name'];
						$conditions .= 'AND name like :name ';
						$params[':name'] = '%'.$_POST['armour_name'].'%';
					}
					if( isset( $_POST['armour_material'] ) && is_numeric($_POST['armour_material'] ) ){
						$data['defaultValues']['armour_material'] = $_POST['armour_material'];
						$conditions .= 'AND armours_materials_id = :armours_materials_id ';
						$params[':armours_materials_id'] = $_POST['armour_material'];
					}
					if( isset( $_POST['armour_equipment_size'] ) && is_numeric($_POST['armour_equipment_size'] ) ){
						$data['defaultValues']['armour_equipment_size'] = $_POST['armour_equipment_size'];
						$conditions .= 'AND equipment_size_id = :equipment_size_id ';
						$params[':equipment_size_id'] = $_POST['armour_equipment_size'];
					}
					if( isset( $_POST['armour_equipment_quality'] ) && is_numeric($_POST['armour_equipment_quality'] ) ){
						$data['defaultValues']['armour_equipment_quality'] = $_POST['armour_equipment_quality'];
						$conditions .= 'AND armour_equipment_size_id = :armour_equipment_size_id ';
						$params[':armour_equipment_size_id'] = $_POST['armour_equipment_quality'];
					}
					if( isset( $_POST['armour_equipment_rarity'] ) && is_numeric($_POST['armour_equipment_rarity']) ){
						$data['defaultValues']['armour_equipment_rarity'] = $_POST['armour_equipment_rarity'];
						$conditions .= 'AND equipment_rarity_id = :equipment_rarity_id ';
						$params[':equipment_rarity_id'] = $_POST['armour_equipment_quality'];
					}
					if( isset( $_POST['armour_endurance_min'] ) && is_numeric($_POST['armour_endurance_min'] ) ){
						$data['defaultValues']['armour_endurance_min'] = $_POST['armour_endurance_min'];
						$conditions .= 'AND endurance >= :endurance_min ';
						$params[':endurance_min'] = ($_POST['armour_endurance_min']-1 < 0 )?0:$_POST['armour_endurance_min']-1;//Calcula min 
					}
					if( isset( $_POST['armour_endurance_max'] ) && is_numeric($_POST['armour_endurance_max'] ) ){
						$data['defaultValues']['armour_endurance_max'] = $_POST['armour_endurance_max'];
						$conditions .= 'AND endurance <= :endurance_max ';
						$params[':endurance_max'] = ($_POST['armour_endurance_max']-10<0 )?0:$_POST['armour_endurance_max']-10;//Calculate max
					}
					if( isset( $_POST['armour_pde_min'] ) && is_numeric($_POST['armour_pde_min']) ){
						$data['defaultValues']['armour_pde_min'] = $_POST['armour_pde_min'];
						$conditions .= 'AND pde >= :pde_min ';
						$params[':pde_min'] = $_POST['armour_pde_min'];
					}
					if( isset( $_POST['armour_pde_max'] ) && is_numeric($_POST['armour_pde_max']) ){
						$data['defaultValues']['armour_pde_max'] = $_POST['armour_pde_max'];
						$conditions .= 'AND pde <= :pde_max ';
						$params[':pde_max'] = $_POST['armour_pde_max'];
					}
					if( isset( $_POST['armour_prize_min'] ) && is_numeric($_POST['armour_prize_min'] ) ){
						$data['defaultValues']['armour_prize_min'] = $_POST['armour_prize_min'];
						$conditions .= 'AND prize >= :prize_min ';
						$params[':prize_min'] = $_POST['armour_prize_min'];
					}
					if( isset( $_POST['armour_prize_max'] ) && is_numeric($_POST['armour_prize_max'] ) ){
						$data['defaultValues']['armour_prize_max'] = $_POST['armour_prize_max'];
						$conditions .= 'AND prize <= :pde_max ';
						$params[':pde_max'] = $_POST['armour_prize_max'];
					}
					if( isset( $_POST['armour_type'] ) && is_numeric($_POST['armour_type'] ) ){
						$data['defaultValues']['armour_type'] = $_POST['armour_type'];
						$conditions .= 'AND type = :type ';
						$params[':type'] = $_POST['armour_type'];
					}					
					$data['result'] = Armours::model()->findAll( $conditions, $params);
					break;
				case Inventory::EQUIPMENT_TYPE_SPEAR:					
					if( isset( $_POST['spear_name'] ) && $_POST['spear_name'] !='' ){
						$data['defaultValues']['spear_name'] = $_POST['spear_name'];
						$conditions .= 'AND name like :spear_name';
						$params[':spear_name'] = '%'.$_POST['spear_name'].'%';
					}
					if( isset( $_POST['spear_material'] ) && is_numeric( $_POST['spear_material']) ){
						$data['defaultValues']['spear_material'] = $_POST['spear_material'];
						$conditions .= 'AND spears_materials_id = :spear_material';
						$params[':spear_material'] = $_POST['spear_material'];
					}
					if( isset( $_POST['spear_equipment_size'] ) && is_numeric( $_POST['spear_equipment_size']) ){
						$data['defaultValues']['spear_equipment_size'] = $_POST['spear_equipment_size'];
						$conditions .= 'AND equipment_size_id = :equipment_size_id';
						$params[':equipment_size_id'] = $_POST['spear_equipment_size'];
					}
					if( isset( $_POST['spear_equipment_quality'] ) && is_numeric( $_POST['spear_equipment_quality']) ){
						$data['defaultValues']['spear_equipment_quality'] = $_POST['spear_equipment_quality'];
						$conditions .= 'AND equipment_qualities_id = :equipment_qualities_id';
						$params[':equipment_qualities_id'] = $_POST['spear_equipment_quality'];
					}
					if( isset( $_POST['spear_equipment_rarity'] ) && is_numeric( $_POST['spear_equipment_rarity']) ){
						$data['defaultValues']['spear_equipment_rarity'] = $_POST['spear_equipment_rarity'];
						$conditions .= 'AND equipment_rarity_id = :equipment_rarity_id';
						$params[':equipment_rarity_id'] = $_POST['spear_equipment_rarity'];
					}
					if( isset( $_POST['spear_damage_min'] ) && is_numeric( $_POST['spear_damage_min']) ){
						$data['defaultValues']['spear_damage_min'] = $_POST['spear_damage_min'];
						$conditions .= 'AND damage >= :damage_min';
						$params[':damage_min'] = $_POST['spear_damage_min'];
					}
					if( isset( $_POST['spear_damage_max'] ) && is_numeric( $_POST['spear_damage_max']) ){
						$data['defaultValues']['spear_damage_max'] = $_POST['spear_damage_max'];
						$conditions .= 'AND damage <= :damage_max';
						$params[':damage_max'] = $_POST['spear_damage_max'];
					}
					if( isset( $_POST['spear_pde_min'] ) && is_numeric( $_POST['spear_pde_min']) ){
						$data['defaultValues']['spear_pde_min'] = $_POST['spear_pde_min'];
						$conditions .= 'AND pde >= :pde_min';
						$params[':pde_min'] = $_POST['spear_pde_min'];
					}
					if( isset( $_POST['spear_pde_max'] ) && is_numeric( $_POST['spear_pde_max']) ){
						$data['defaultValues']['spear_pde_max'] = $_POST['spear_pde_max'];
						$conditions .= 'AND pde <= :pde_max';
						$params[':pde_max'] = $_POST['spear_pde_max'];
					}
					if( isset( $_POST['spear_prize_min'] ) && is_numeric( $_POST['spear_prize_min']) ){
						$data['defaultValues']['spear_prize_min'] = $_POST['spear_prize_min'];
						$conditions .= 'AND prize >= :prize_min';
						$params[':prize_min'] = $_POST['spear_prize_min'];
					}
					if( isset( $_POST['spear_prize_max'] ) && is_numeric( $_POST['spear_prize_max']) ){
						$data['defaultValues']['spear_prize_max'] = $_POST['spear_prize_max'];
						$conditions .= 'AND prize <= :prize_min';
						$params[':prize_min'] = $_POST['spear_prize_max'];
					}
					$data['result'] = Spears::model()->findAll( $conditions, $params);
					break;
				case Inventory::EQUIPMENT_TYPE_TRICK:
					break;
				default:
					//inventory type is not define
			}
			
			
		}
		
		//Load data filter				
		$data['inventory_type_list'] = array(
			"".Inventory::EQUIPMENT_TYPE_ARMOUR => 'Armadura',
			"".Inventory::EQUIPMENT_TYPE_SPEAR => 'Lanza',
			"".Inventory::EQUIPMENT_TYPE_TRICK => 'Trampa'
		);
		
		//Load data for material, qualities, rarity
		$data['spear_material'] = SpearsMaterials::model()->findAll();
		$data['armour_material'] =  ArmoursMaterials::model()->findAll();
		$data['equipment_size'] =  EquipmentSize::model()->findAll();
		$data['equipment_quality'] =  EquipmentQualities::model()->findAll();
		$data['equipment_rarity'] =  EquipmentRarity::model()->findAll();
		$data['armour_type'] = Constants::model()->findAll( 'type = :type', array(':type' => Armours::TYPE) );
		
		//Load data for select		
		$data['spear_material_list'] = CHtml::listData(  $data['spear_material'], 'id', 'name' );
		$data['armour_material_list'] = CHtml::listData( ArmoursMaterials::model()->findAll(), 'id', 'name' );		 
		$data['equipment_size_list'] = CHtml::listData( EquipmentSize::model()->findAll(), 'id', 'name' );
		$data['equipment_quality_list'] = CHtml::listData( EquipmentQualities::model()->findAll(), 'id', 'name' );
		$data['equipment_rarity_list'] = CHtml::listData( EquipmentRarity::model()->findAll(), 'id', 'name' );
		$data['armour_type_list'] = CHtml::listData( Constants::model()->findAll( 'type = :type', array(':type' => Armours::TYPE) ), 'id', 'name' );
		
		//Render template
		$this->render('index', $data);
	}

	/**
	 * Show purchase history of knight
	 */
	public function actionPurchasesHistory(){
		//Init		
		$rowsByPage = 10;
		$data = array(
			'result'=> array(),
			'armours_list'=>array(),
			'spears_list'=>array(),
			'equipment_rarity'=>array(),
			'total_purchases'=> 0,
			'rowsByPage' => $rowsByPage,
			'page' => 1
		);
		
		//Check input
		if( isset($_GET['page']) && is_numeric( $_GET['page']) && $_GET['page'] > 0 ){
			$data['page'] = $_GET['page'];
		}
		
		//Load total of purchases
		$data['total_purchases'] = KnightsPurchases::model()->count( 'knights_id = :knights_id', array(':knights_id'=>Yii::app()->user->knights_id)  );
		
		//Load list of purchases 
		$criteria = new CDbCriteria();
		$criteria->offset = $rowsByPage*($data['page']-1);
		$criteria->limit = $rowsByPage;
		$criteria->order = 'date DESC';
		$criteria->condition = 'knights_id = :knights_id';
		$criteria->params = array( ':knights_id'=>Yii::app()->user->knights_id );
		$data['result'] = KnightsPurchases::model()->findAll( $criteria );
		
		//foreach purchase load item
		if( count($data['result']) ){
			$conditions_armours = '1=0 ';
			$conditions_spears = '1=0 ';
			$params_armours = array();
			$params_spears = array();
			
			foreach( $data['result'] as $row){
				if( $row->inventory_type_id == Inventory::EQUIPMENT_TYPE_ARMOUR ){
					$conditions_armours .= ' OR id = :id'.$row->identificator;
					$params_armours['id'.$row->identificator] = $row->identificator;
				}elseif ($row->inventory_type_id == Inventory::EQUIPMENT_TYPE_SPEAR){
					$conditions_spears .= ' OR id = :id'.$row->identificator;
					$params_spears['id'.$row->identificator] = $row->identificator;
				}
			}
			
			//Load spears and armours 			
			$data['armours_list'] = Armours::model()->findAll(array( 'index'=>'id', 'condition'=>$conditions_armours, 'params'=>$params_armours) );
			$data['spears_list'] = Spears::model()->findAll(array( 'index'=>'id', 'condition'=>$conditions_spears, 'params'=>$params_spears) );
			
			//Load equipment rarity table
			$data['equipment_rarity'] = EquipmentRarity::model()->findAll(array('index'=>'id') );
			
			
		}
		
		
		
		//Render template		
		$this->render( 'purchasesHistory', $data);
	} 
	
	public function actionConfirmBuy(){
		$output = array(
			'errno'=>1,
			'html'=>''		
		);
		//Check session
		if( !Yii::app()->user->isGuest ){
			if( $this->user_data['knights']->status != Knights::STATUS_AT_COMBAT ){
				//Check input
				if( isset( $_GET['equipments_type']) && is_numeric( $_GET['equipments_type']) && $_GET['equipments_type'] > 0 &&
					isset( $_GET['id']) && is_numeric( $_GET['id']) && $_GET['id'] > 0
				){
					//Search object
					switch( $_GET['equipments_type'] ){
						case Inventory::EQUIPMENT_TYPE_ARMOUR:
							$item = Armours::model()->findByPk($_GET['id']);
							break;
						case Inventory::EQUIPMENT_TYPE_SPEAR:
							$item = Spears::model()->findByPk($_GET['id']);
							break;
						case Inventory::EQUIPMENT_TYPE_TRICK:
							$item = null;
							break;
						default:
							$item = null;	
					}
					//Check item
					if( $item ){
						//Check requeriments
						if( EquipmentRequirements::checkAccomplish(
								$_GET['equipments_type'], 
								$_GET['id'], 
								$this->user_data['knights']->id)
						) {
							//Check coins
							if( $item->prize <= $this->user_data['knights']->coins ){
								$data = array(
									'equipments_type'=>$_GET['equipments_type'],
									'identificator'=>$_GET['id'],
									'item'=>$item		
								);
								$output['errno'] = 0;							
								$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/medievalmarket/confirm_dialog_buy_item.php', $data, true );
								$output['url'] = '/medievalmarket/buy/equipments_type/'.$_GET['equipments_type'].'/id/'.$_GET['id'];
							}else{
								$output['html'] = '<p>¡No tienes suficiente dinero!</p><p>Siempre puedes <a href="/jobs">ganar algo de dinero</a> prestando tus servicios como caballero.</p>';
							}
						}else{
							$output['html'] = '<p>No cumples con alguno de los requisitos.</p>';
						}
					}else{
						$output['html'] = '<p>El objecto no se ha encontrado.</p>';
					}
				}else{
					$output['html'] = '<p>Los datos del item no son correctos.</p>';
				}
			}else{				
				$output['html'] = '<p>No puedes comprar objetos si estás en mitad de un combate.</p>';				
			}
		}else{
			$output['html'] = '<p>La sesión ha expirado. Necesitas volver a hacer login.</p>';
		}
				
		echo CJSON::encode( $output );
	}
	
	public function actionBuy(){
		$output = array(
			'errno'=>1,
			'html'=>''		
		);
		//Check session		
		if( !Yii::app()->user->isGuest ){
			//Check input
			if( isset( $_GET['equipments_type']) && is_numeric( $_GET['equipments_type']) && $_GET['equipments_type'] > 0 &&
					isset( $_GET['id']) && is_numeric( $_GET['id']) && $_GET['id'] > 0
			){
				//Search object
				switch( $_GET['equipments_type'] ){
					case Inventory::EQUIPMENT_TYPE_ARMOUR:
						$item = Armours::model()->findByPk($_GET['id']);
						$itemObject = new ArmoursObjects();
						$itemObject->attributes = array(
							'armours_id'=>$item->id,
							'knights_id'=>$this->user_data['knights']->id,
							'current_pde'=>$item->pde
						);
						break;
					case Inventory::EQUIPMENT_TYPE_SPEAR:
						$item = Spears::model()->findByPk($_GET['id']);
						$itemObject = new SpearsObjects();
						$itemObject->attributes = array(
								'spears_id'=>$item->id,
								'knights_id'=>$this->user_data['knights']->id,
								'current_pde'=>$item->pde
						);
						break;
					case Inventory::EQUIPMENT_TYPE_TRICK:
						$item = null;
						break;
					default:
						$item = null;
				}
				//Check item
				if( $item ){
					//Check requeriments
					if( EquipmentRequirements::checkAccomplish(
							$_GET['equipments_type'],
							$_GET['id'],
							$this->user_data['knights']->id
						)
					) {
						//Check coins
						if( $item->prize <= $this->user_data['knights']->coins ){
							//add item to inventory of knight
							if( $emptyPosition = Inventory::getFirstEmptySocket($this->user_data['knights']->id) ){
								
								//Save item object
								$itemObject->save();
								
								//Add item to knight's inventory
								$inventoryObject = new Inventory();
								$inventoryObject->attributes = array(
									'knights_id'=>$this->user_data['knights']->id,
									'type'=>$_GET['equipments_type'],
									'identificator'=>$itemObject->id,
									'position'=>$emptyPosition,
									'amount'=>1
								);
								$inventoryObject->save();
								
								//sustract coins
								$this->user_data['knights']->coins -= $item->prize;
								$this->user_data['knights']->save();
								
								//Set purchase history
								$purchase = new KnightsPurchases();
								$purchase->attributes = array(
										'knights_id' => $this->user_data['knights']->id,
										'equipments_type_id'=>$_GET['equipments_type'],
										'identificator'=>$_GET['id'],
										'date'=>date('Y-m-d H:i:s'),
										'status'=>KnightsPurchases::STATUS_PURCHASED,
										'knights_card_charisma'=> $this->user_data['knights_card']->charisma,
										'knights_card_trade'=> $this->user_data['knights_card']->trade
								);
								if( !$purchase->save() ){
									Yii::log( 'No salva el historial de la compra.' );
								}
								
								$output['errno'] = 0;
								$output['html'] = '<p>Ya tienes el objeto en tu <a href="/character/inventory/sir/'.$this->user_data['knights']->name.'">inventario</a> listo para utilizar.</p>';
								$output['coins'] = number_format( $this->user_data['knights']->coins , 0, ',','.');
							}else{
								$output['html'] = '<p>No tienes suficiente espacio en el inventario secundario.</p>';
							}
						}else{
							$output['html'] = '<p>¡No tienes suficiente dinero!</p><p>Siempre puedes <a href="/jobs">ganar algo de dinero</a> prestando tus servicios como caballero.</p>';
						}
					}else{
						$output['html'] = '<p>No cumples con alguno de los requisitos.</p>';
					}
				}else{
					$output['html'] = '<p>El objecto no se ha encontrado.</p>';
				}
			}else{
				$output['html'] = '<p>Los datos del item no son correctos.</p>';
			}
		}else{
			$output['html'] = '<p>La sesión ha expirado. Necesitas volver a hacer login.</p>';
		}
		
		echo CJSON::encode($output);
	}
	
	/**
	 * Return JSON for to show all requirements of a item
	 */
	public function actionRequirements(){		
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		Yii::trace('[APP] apsta ');
		//Check session
		if( !Yii::app()->user->isGuest ){
			Yii::trace('[APP] ' . $_GET['equipments_type'] . ' - ' .$_GET['id'], 'system.web.CController');
			//Check input			
			if( isset( $_GET['equipments_type']) 
				&& is_numeric( $_GET['equipments_type']) 
				&& $_GET['equipments_type'] > 0 
				&& isset( $_GET['id']) 
				&& is_numeric( $_GET['id']) 
				&& $_GET['id'] > 0
			) {
				
				// Get requirements list
				$equipmentRequirementsList = EquipmentRequirements::model()->with('requirements')->findAll(
					'identificator=:identificator AND equipments_type=:equipments_type',
					array(
						':identificator'=>$_GET['id'],
						':equipments_type'=>$_GET['equipments_type'],
					)
				);
				
				// Check if list has items
				if ($equipmentRequirementsList) {
					// Build requirement list
					$list = '';
					foreach ($equipmentRequirementsList as $equipmentRequirement) {
						$list .= '<li />' . $equipmentRequirement->requirements->name . ': ' . $equipmentRequirement->requirements->description;
					}
					$output['errno'] = 0;
					$output['html'] = '<p>No puedes comprar este objeto ya que no cumples todos los requisitos necesarios:</p><ul>' . $list . '</ul>';
				} else {					
					$output['html'] = '<p>Este objeto no tiene requesitos.</p>';
				}							
			} else {
				$output['html'] = '<p>Los datos del item no son correctos '. $_GET['equipments_type'] . ' - ' .$_GET['id'].'</p>';
			}
		} else {
			$output['html'] = '<p>La sesión ha expirado. Necesitas volver a hacer login.</p>';
		}
			
		echo CJSON::encode($output);
		
	}
	
	
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}