<?php

class CharacterController extends Controller
{
	public $layout = '3columnasConCaballero';
	public $user_data = array();
	public $knight = null;	 
	public $knight_is_online = false;
	public $app_data = array();
	public $are_they_friends= false;//Store if knight and user knight are friends (true/false)

	public function filters()
	{
		return array(
				'accessControl',
		);
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{		
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index', 'attributesAndSkills', 'inventory', 'evolution', 'stats', 'friends', 'achivements', 'events', 'showPrechallenge', 'showPrecombat','showFinishedRound','showPostcombat'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform this actions
						'actions'=>array('upgradeCharacteristic','moveItemPosition','sendFriendshipRequest','replyToFriendship','confirmRejectFrienshipRequest','rejectFrienshipRequest','messages','sendMessage','messagesWith','deleteNewMessages','confirmSendChallenge','sendChallenge','confirmRejectChallenge','confirmAcceptChallenge','responseChallenge','showPendingRoundDialog','showRoundSelectedPointsDialog','setCombatPoints','IsInCombat','desqualifyRival','isDesqualified'),
						'users'=>array('@'),
				),				
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
	/**
	 * Before action load knight data of user
	 * @param unknown_type $action
	 */

	public function beforeAction( $action ){
		
		//Check if user is login and load knight data of user
		if( !Yii::app()->user->isGuest ){
			//Update cache connected
			Yii::app()->cache->set( Yii::app()->params['cachekeys']['knight_connected'].Yii::app()->user->knights_id, true, Yii::app()->params['cachetime']['knight'] );
			
			$withStatement = array(
					'knightsCard',
					'knightsStats'
			);
			
				
			//Load data of knight
			//$this->user_data['knights'] = Knights::model()->cache( Yii::app()->params['cachetime']['knight']  )->with( $withStatement )->find( 'id=:id', array(':id'=>Yii::app()->user->knights_id) );
			if( !$this->user_data['knights'] = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights'].Yii::app()->user->knights_id ) ){
				$this->user_data['knights'] =  Knights::model()->findByPk( Yii::app()->user->knights_id );
				Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].Yii::app()->user->knights_id,$this->user_data['knights'], Yii::app()->params['cachetime']['knight']  ); 
			}  

			//Load knights card 
			if( !$this->user_data['knights_card'] = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights_card'].Yii::app()->user->knights_id ) ){
				$this->user_data['knights_card'] = $this->user_data['knights']->knightsCard;
				Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_card'].Yii::app()->user->knights_id, $this->user_data['knights_card'], Yii::app()->params['cachetime']['knight']  );
			}
				
			//Load stats of knight
			if( !$this->user_data['knights_stats'] = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights_stats'].Yii::app()->user->knights_id ) ){
				$this->user_data['knights_stats'] = $this->user_data['knights']->knightsStats;
				Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_stats'].Yii::app()->user->knights_id, $this->user_data['knights_stats'], Yii::app()->params['cachetime']['knight']  );
			}
				
			//Load if user has new friendship request
			$sql = 'SELECT friends.id as id, k1.name as name, k1.avatars_id as avatars_id FROM friends
					INNER JOIN users ON users.id = friends.from_user
					INNER JOIN knights as k1 ON k1.users_id = users.id
					WHERE friends.status = :status AND to_user = :users_knights_id1
					ORDER BY start_date DESC';
			$command = Yii::app()->db->cache(Yii::app()->params['cachetime']['friends'])->createCommand(  $sql );
			$command->bindValue( ':status', Friends::STATUS_ONWAITING, PDO::PARAM_INT );
			$command->bindValue( ':users_knights_id1',$this->user_data['knights']->id, PDO::PARAM_INT );
			$this->user_data['knights_new_friends'] =  $command->queryAll();

			//Load last messages
			$this->user_data['new_messages'] = Messages::getNewMessages(Yii::app()->user->users_id);
				
			//Load all attributes name attributes
			$this->app_data['attribute_list'] = Constants::model()->cache(Yii::app()->params['cachetime']['appSetting'])->findAll( 'type=:type', array(':type'=>Constants::KNIGHTS_ATTRIBUTES) );
			
			//Check if user is in combat
			if( $this->user_data['knights']->status == Knights::STATUS_AT_COMBAT ){	
				//Check combat identificator
				if( $combat_id = Yii::app()->cache->get(  Yii::app()->params['cacheKeys']['combat_for_knights_id'].Yii::app()->user->knights_id ) ){			
					$this->user_data['combat'] =  Yii::app()->cache->get(  Yii::app()->params['cacheKeys']['combat'].$combat_id ); 
				}else{					
					//Load from database
					 $this->user_data['combat'] = Combats::model()->cache(Yii::app()->params['cachetime']['combat'])->find( 'status = :status AND (from_knight = :from_knight OR to_knight = :to_knight)', array(':status'=>Combats::STATUS_ENABLE,':from_knight'=>Yii::app()->user->knights_id,':to_knight'=>Yii::app()->user->knights_id) );
					 Yii::app()->cache->set(  Yii::app()->params['cacheKeys']['combat_for_knights_id'].Yii::app()->user->knights_id, $this->user_data['combat']->id, Yii::app()->params['cachetime']['combat'] );
					 Yii::app()->cache->set(  Yii::app()->params['cacheKeys']['combat'].$this->user_data['combat']->id, $this->user_data['combat'], Yii::app()->params['cachetime']['combat'] );
				}
			}
				
		}

		//Load knight data
		if(!Yii::app()->user->isGuest && (!isset($_GET['sir']) || $_GET['sir'] == $this->user_data['knights']->name) ){
			//Load the user knight in the knight
			$this->knight = $this->user_data['knights'];
			$this->knight_is_online = true; 
		}else{
			//Load knight data
			//$this->knight = Knights::model()->cache(Yii::app()->params['cachetime']['knight'])->find( 'name=:name', array( ':name'=>$_GET['sir']) );				
			if( !$this->knight = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'] ) ){
				if( $this->knight = Knights::model()->cache(Yii::app()->params['cachetime']['knight'])->find( 'name=:name', array( ':name'=>$_GET['sir']) ) ){
					Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'], $this->knight, Yii::app()->params['cachetime']['knight']  );
				}
			}
			if( $this->knight ){
				if( $this->knight->status != Knights::STATUS_PENDING_VALIDATION ){
					if( !Yii::app()->user->isGuest ) {
						//Load stats vs
						$this->user_data['knights_stats_vs'] = KnightsStatsVs::model()->cache(Yii::app()->params['cachetime']['knight'])->find( 'knights_id = :knights_id AND opponent = :opponent', array(':knights_id'=>Yii::app()->user->knights_id, ':opponent'=>$this->knight->id) );
						
						if( $this->knight->status != Knights::STATUS_PENDING_VALIDATION ){
							//Check if knight and user knight are friends.
							$condition = "(from_user = :user_knight1 AND to_user = :knight1 AND status = :status1) OR (from_user = :knight2 AND to_user = :user_knight2 AND status = :status2)";
							$params = array(
									':knight1'=> $this->knight->users_id,
									':knight2'=> $this->knight->users_id,
									':user_knight1'=> $this->user_data['knights']->users_id,
									':user_knight2'=> $this->user_data['knights']->users_id,
									':status1'=>Friends::STATUS_ACCEPT,
									':status2'=>Friends::STATUS_ACCEPT,
							);
							$friendRelationship = Friends::model()->cache(Yii::app()->params['cachetime']['knight'])->find( $condition, $params);
							$this->are_they_friends = ($friendRelationship != null);
							
							//Load if knight is online knight
							//$this->knight_is_online = Sessions::model()->exists( 'users_id = :users_id AND expire > :expire', array(':users_id'=>$this->knight->users_id, ':expire'=>time() )  );
							$this->knight_is_online = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$this->knight->id );
							
						}else{
							$this->render('pending_activation');
						}				 
					}
				}else{
					//Knight is not exist
					throw new CHttpException(404,'Upsss! El caballero está pendiente de validar su cuenta.');
				}
			}else{
				//Knight is not exist
				throw new CHttpException(404,'Upsss! El caballero que buscas no existe.');
			}
		}
		
		//var_dump( Yii::app()->cache->getMemCache()->getAllKeys() );

		return true;
	}


	public function actionIndex()
	{
		$this->render('index');
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
	

	/**
	 * Show attributes for character
	 */
	public function actionAttributesAndSkills(){
		//Almacenamos los datos de la plantilla
		$data = array();
		//Check input
		if( isset($_GET['sir']) && $_GET['sir']!=''  ){
			if( !$knight = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'] ) ){
				$knight = Knights::model()->find( 'name=:name',	array( ':name'=>$_GET['sir']) );
				if( $knight ) Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'], $knight, Yii::app()->params['cachetime']['knight'] );
			}
			if( $knight ){
				//datos del caballero
				$data['knight'] = $knight;
				//cargamos la ficha del caballero
				$knightCard = KnightsCard::model();
				$data['knight_card'] = $knightCard->find(
						'knights_id=:knights_id',
						array( ':knights_id'=> $knight->id)
				);
				//añadimos la lista de atributos y habilidades
				$data['knight_attributes'] = Constants::model()->findAll(
						'type=:type',
						array(':type'=>Constants::KNIGHTS_ATTRIBUTES)
				);


				//añadimos la lista de atributos y habilidades
				$data['knight_skills'] = Constants::model()->findAll(
						'type=:type',
						array(':type'=>Constants::KNIGHTS_SKILLS)
				);

				$data['knight_card_labels'] = $knightCard->attributeLabels();

				//lista de coste de atributos y habilidades por nivel
				$app_rules_level = AppRulesLevel::model()->findAll();
				$data['app_rules_level'] = array();
				foreach($app_rules_level as $level){
					$data['app_rules_level'][$level->level] = $level;
				}


				//Datos del caballero del usuario
				$data['user_data'] = $this->user_data;

				//Load knights_status template
				// $data['knights_status_template'] = $this->renderFile(  Yii::app()->basePath.'/views/character/knights_status.php', array('knight'=>$knight), true );
					
				$this->render( 'attributesAndSkills', $data );
			}else{
				//User not valid
				$this->redirect(array('error'));
			}
		}else{
			//Input no valid
			//echo 'El nombre de usuario NO es válido.';
			$this->redirect(array('error'));
		}
	}
	/**
	 * Upgrade a characteristic.
	 *
	 * return
	 */
	public function actionUpgradeCharacteristic(){
		$output = array(
				'errno'=>1,
				'message'=>''
		);

		if( !Yii::app()->user->isGuest ){
			//Check characteritic name
			Yii::trace( '[CHARACTER][actionUpgradeCharacteristic] Check if characteristic exist:'.$_GET['name'] );
			if( $characteristic = Constants::model()->find( 'name=:name', array(':name'=>$_GET['name'])) ){
				//Check experiencie points
				$appRuleLevel =  AppRulesLevel::model()->find( 'level=:level', array( ':level'=>($this->user_data['knights_card'][$_GET['name']]+1) ) );
				$cost_level = ($characteristic->type == Constants::KNIGHTS_ATTRIBUTES )?$appRuleLevel->attribute_cost:$appRuleLevel->skill_cost;
				Yii::trace( '[CHARACTER][actionUpgradeCharacteristic] Check if user has enought experience. Cost level ('.$cost_level.') enable experience ('.($this->user_data['knights']['experiencie_earned'] - $this->user_data['knights']['experiencie_used']).')' );
				if( $cost_level  <= ($this->user_data['knights']['experiencie_earned'] - $this->user_data['knights']['experiencie_used'])  ){
						
					//echo ($this->user_data['knights_card'][$_GET['name']]+1).'-'.$this->user_data['knights_card']->getMaxValueCharacteristic();
						
					//Check limit of skill over attributes.
					$maxValueAttribute = $this->user_data['knights_card']->getMaxValueCharacteristic();
					Yii::trace( '[CHARACTER][actionUpgradeCharacteristic] If characteristic is a skill check max value of skill ('.$maxValueAttribute .')'  );
						
						
					if( $characteristic->type == Constants::KNIGHTS_ATTRIBUTES ||
							($this->user_data['knights_card'][$_GET['name']]+1 <= $maxValueAttribute  ) ){
							
						//Update level
						$this->user_data['knights_card']->{$_GET['name']} += 1;
						if( $this->user_data['knights_card']->save() ){
							//If is constitution or will update knight table with new valor for endurance and life.
							if( $characteristic->id == Constants::CHARACTERISTIC_WILL || $characteristic->id == Constants::CHARACTERISTIC_CONSTITUTION ){
								//Update endurance
								if( $characteristic->id == Constants::CHARACTERISTIC_CONSTITUTION ){
									//Update endurance and life
									$this->user_data['knights']->life = $this->user_data['knights_card']->constitution * 2;
									$this->user_data['knights']->endurance =  ($this->user_data['knights_card']->will+$this->user_data['knights_card']->constitution)*3;
								}else{
									//Only endurance
									$this->user_data['knights']->endurance =  ($this->user_data['knights_card']->will+$this->user_data['knights_card']->constitution)*3;
								}
							}
								
							//Update experiencie used
							$this->user_data['knights']->experiencie_used += $cost_level;
							if( $this->user_data['knights']->save() ){
								//Update cache
								Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].Yii::app()->user->knights_id, $this->user_data['knights'], Yii::app()->params['cachetime']['knight']  );
								
								//Load evolution
								$knights_evolution = new KnightsEvolution();
								$knights_evolution->attributes = array(
										'knights_id' => $this->user_data['knights']->id,
										'type' => KnightsEvolution::TYPE_UPGRADE,
										'characteristic' => $characteristic->id,
										'value' => $this->user_data['knights_card']->{$_GET['name']},
										'experiencie_used' => $cost_level,
										'date' => date("Y-m-d H:i:s")
								);
								if( $knights_evolution->save() ){
									//Load events tables
									$knights_events = new KnightsEvents();
									$knights_events ->attributes = array(
											'knights_id' => $this->user_data['knights']->id,
											'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
											'identificator'=>$knights_evolution->id
									);
									if( $knights_events ->save() ){
										$knights_events_last = new KnightsEventsLast();
										$knights_events_last->attributes = array(
												'knights_id' => $this->user_data['knights']->id,
												'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
												'identificator'=>$knights_evolution->id,
												'date'=>date("Y-m-d H:i:s")
										);
										if( $knights_events_last->save() ){
											$output['errno'] = 0;
											$output['message'] = 'Se ha subido la característica a nivel '.$this->user_data['knights_card']->{$_GET['name']}.'.';
										}else{
											$output['message'] = 'Se ha producido un error al registrar el ultimo evento';
										}
									}else{
										$output['message'] = 'Se ha producido un error al registrar el evento';
									}
								}else{
									$output['message'] = '¡Upps! Se ha producido un error al registrar la evolucion.';
								}
							}else{
								$output['message'] = '¡Upps! Se ha producido un error al subir la experiencia.';
							}
						}else{
							$output['message'] = '¡Upps! Se ha producido un error al subir al nivel.';
						}
					}else{
						$output['message'] = '¡Upps! No se puede tener una habilidad más alta que el atributo más alto.';
					}
				}else{
					$output['message'] = 'No tienes suficientes puntos de experiencia disponibles (coste '.$cost_level.' - px disponibles '.(($this->user_data['knights']['experiencie_earned'] - $this->user_data['knights']['experiencie_used']) ).').';
				}
			}else{
				$output['message'] = 'La caracterísctica no es válida.';
			}
		}else{
			$output['message'] = '<p>Tu sessión ha expirado.</p><p>Necesitas volver a hacer login.</p>';
		}

		echo CJSON::encode( $output );
	}

	public function actionInventory(){

		//Almacenamos los datos de la plantilla
		$data = array();
		//Check input
		if( isset($_GET['sir']) && $_GET['sir']!=''  ){
			if( !$knight = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'] ) ){
				$knight = Knights::model()->find( 'name=:name',	array( ':name'=>$_GET['sir']) );
				if( $knight ) Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$_GET['sir'], $knight, Yii::app()->params['cachetime']['knight'] );
			}
			if( $knight ){
				//datos del caballero
				$data['knight'] = $knight;

				//cargamos el inventario del caballero
				$item_list = Inventory::model()->findAll( 'knights_id=:knights_id', array( ':knights_id'=>$knight->id ) );
				$inventory = array();

				foreach( $item_list as $item ){
					switch( $item->type ){
						case Inventory::EQUIPMENT_TYPE_ARMOUR:
							$armours_object = ArmoursObjects::model()->with( array( 'armours' => array( 'with'=> array('type0', 'armoursMaterials', 'equipmentSize', 'equipmentQualities', 'equipmentRarity'  ) ) ) )->find( 't.id=:id', array( ':id'=>$item->identificator ) );
								
							$item_info['armours_id'] = $armours_object->armours->id;
							$item_info['name'] = $armours_object->armours->name;
							$item_info['armoursPDE'] = $armours_object->armours->pde;
							$item_info['current_pde'] = $armours_object->current_pde;
								
							$item_info['armours_type_name'] = $armours_object->armours->type0->name;
							$item_info['armoursMaterialName'] = $armours_object->armours->armoursMaterials->name;
							$item_info['armoursMaterialEndurance'] = $armours_object->armours->armoursMaterials->endurance;
							$item_info['armoursMaterialPrize'] = $armours_object->armours->armoursMaterials->prize;
							$item_info['armoursMaterialName'] = $armours_object->armours->armoursMaterials->name;
							$item_info['equipmentSizeName'] = $armours_object->armours->equipmentSize->name;
							$item_info['equipmentQualitiesName'] = $armours_object->armours->equipmentQualities->name;
							$item_info['equipmentRarityName'] = $armours_object->armours->equipmentRarity->name;
							
							// Load requirements							
							if ($equipmentRequirements_list = EquipmentRequirements::model()->findAll(
									'identificator=:identificator AND equipments_type=:equipments_type',
									array(
										':identificator' => $armours_object->armours->id,
										':equipments_type' => Inventory::EQUIPMENT_TYPE_ARMOUR,
									)
								)
							) {
								// Load all requirement
								$item_info['requirement_list'] = array();
								foreach ($equipmentRequirements_list as $equipmentRequirements) {
									$item_info['requirement_list'][] = Requirements::model()->findByPk($equipmentRequirements->requirements_id);
								}								
							} else {
								// No rquirement
								$item_info['requirement_list'] = null;
							}

							$template = 'armour';
							break;
						case Inventory::EQUIPMENT_TYPE_SPEAR:
							$spears_object = SpearsObjects::model()->with( array( 'spears' => array( 'with'=> array('equipmentQualities', 'equipmentRarity', 'equipmentSize', 'spearsMaterials', 'spearsObjects'  ) ) ) )->find( 't.id=:id', array( ':id'=>$item->identificator ) );
							$item_info['spears_id'] = $spears_object->spears->id;
							$item_info['name'] = $spears_object->spears->name;
							$item_info['PDE'] = $spears_object->spears->pde;
							$item_info['current_pde'] = $spears_object->current_pde;
							$item_info['spears_damage'] = $spears_object->spears->damage;
							$item_info['spearPrize'] = $spears_object->spears->prize;
							$item_info['spearsMaterialName'] = $spears_object->spears->spearsMaterials->name;
							$item_info['equipmentQualitiesName'] = $spears_object->spears->equipmentQualities->name;
							$item_info['equipmentSizeName'] = $spears_object->spears->equipmentSize->name;
							$item_info['equipmentRarityName'] = $spears_object->spears->equipmentRarity->name;

							// Load requirements
							if ($equipmentRequirements_list = EquipmentRequirements::model()->findAll(
									'identificator=:identificator AND equipments_type=:equipments_type',
									array(
											':identificator' => $spears_object->spears->id,
											':equipments_type' => Inventory::EQUIPMENT_TYPE_SPEAR,
									)
							)
							) {
								// Load all requirement
								$item_info['requirement_list'] = array();
								foreach ($equipmentRequirements_list as $equipmentRequirements) {
									$item_info['requirement_list'][] = Requirements::model()->findByPk($equipmentRequirements->requirements_id);
								}
							} else {
								// No rquirement
								$item_info['requirement_list'] = null;
							}
								
								
							$template = 'spear';
							break;
						case Inventory::EQUIPMENT_TYPE_TRICK:
							//FALTA DEFINIR LOS TRICKS!!
							$template = 'trick';
							break;
					}
						
						
					$data_template = array(
							'item'=>$item,
							'item_info'=>$item_info
					);
					$inventory[ $item->position ] = $this->renderFile( Yii::app()->basePath.'/views/character/item_'.$template.'.php', $data_template, true );
						
				}

				$data['inventory'] = $inventory;

				//Load knights_status template
				//$data['knights_status_template'] = $this->renderFile(  Yii::app()->basePath.'/views/character/knights_status.php', array('knight'=>$knight), true );

				//Datos del caballero del usuario
				$data['user_data'] = $this->user_data;
					
				$this->render( 'inventory', $data );
			}else{
				//User not valid
				$this->redirect(array('error'));
			}
		}else{
			//Input no valid
			//echo 'El nombre de usuario NO es válido.';
			$this->redirect(array('error'));
		}


	}

	/**
	 * Cambia las posiciones de un objeto
	 */
	public function actionMoveItemPosition(){
		$output = array(
				'errno'=>1,
				'message'=>'',
				'knight_status'=>''
		);
		//Check if session is expired
		if( !Yii::app()->user->isGuest ){
				
			//Check input
			if( isset( $_GET['initial_position']) && is_numeric( $_GET['initial_position']) &&
					isset( $_GET['final_position']) && is_numeric( $_GET['final_position']) &&
					($_GET['initial_position'] > 0) && ($_GET['initial_position']) <= Yii::app()->params['inventory']['maxPosition'] &&
					($_GET['final_position'] > 0) && ($_GET['final_position']) <= Yii::app()->params['inventory']['maxPosition'] ){


				if( isset( $_GET['sir']) && $_GET['sir'] == Yii::app()->user->knights_name ){
						
					//Comprobamos que las posiciones no sean las mismas
					if( $_GET['initial_position'] != $_GET['final_position'] ){
						//Check if object exist in initial position
						$initial_position_item = Inventory::model()->find( 	'knights_id=:knights_id AND position=:position',
								array( ':knights_id'=>Yii::app()->user->knights_id,
										':position' => $_GET['initial_position']) );

						$final_position_item = Inventory::model()->find( 	'knights_id=:knights_id AND position=:position',
								array( ':knights_id'=>Yii::app()->user->knights_id,
										':position' => $_GET['final_position']) );

						//Comprobamos si tenemos que verificar el tipo de los objetos para el cambio
						if( $final_position_item && ($initial_position_item->position <= 10) ){
							//Cargamos el tipo objeto de la posicion inicial
							if( $initial_position_item->type == Inventory::EQUIPMENT_TYPE_ARMOUR){
								$initial_item_type = Armours::model()->find( 'id=:id', array(':id'=>$initial_position_item->identificator) )->type;
							}else{
								$initial_item_type = $initial_position_item->type;
							}
								
							//Cargamos el tipo objeto de la posicion final
							if( $final_position_item->type == Inventory::EQUIPMENT_TYPE_ARMOUR){
								$final_item_type = Armours::model()->find( 'id=:id', array(':id'=>$initial_position_item->identificator) )->type;
							}else{
								$final_item_type = $initial_position_item->type;
							}
						}


						//Comprobamos si la posicion inicial es del equipo primario y la posicion final contiene un objeto
						if( $final_position_item == null ||
								($final_position_item && (
										($initial_position_item->position > 10 ) ||
										($initial_position_item->position <= 10) && ($initial_item_type == $final_item_type )
								)
								)
						){
							//Comprobamos que el tipo de los objetos sea el mismo
							//Modificamos el nuevo registro
							$initial_position_item->position = $_GET['final_position'];
							$initial_position_item->save();
								
							//Comprobamos si en la posicion final hay un objeto
							if( $final_position_item ){
								$final_position_item->position = $_GET['initial_position'];
								$final_position_item->save();
							}
							
							//Si el estado del caballero está 'listo para el combate' puede cambiar a 'sin equipo'. Si está en combate, trabajando, sin equipo tienen preferencia y no cambia  el estado del caballero.
							if( $this->user_data['knights']->status == Knights::STATUS_ENABLE || $this->user_data['knights']->status == Knights::STATUS_WITHOUT_EQUIPMENT){								
								if( Inventory::checkIfPrimaryEquipmentIsCompleted(Yii::app()->user->knights_id)){
									//El usuario está listo para el combate ya que tiene todo el equipo disponible.									
									$this->user_data['knights']->status = Knights::STATUS_ENABLE;									
								}else{
									//No tiene el equipo completo y el caballero esta 'listo para el combate' o 'sin equipo' porl o que lo cambiamos (aún que con 'sin equipo' esté igual).
									$this->user_data['knights']->status = Knights::STATUS_WITHOUT_EQUIPMENT;
								}
								//Update knight
								if( !$this->user_data['knights']->save() ) Yii::trace( '[][] Peta actualizar el caballero...'  );
								Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].Yii::app()->user->knights_id, $this->user_data['knights'], Yii::app()->params['cachetime']['knight']  );
								
								
								//Return								
								$output['knight_status_label'] = $this->user_data['knights']->statusHtml();
							}							
							$output['errno'] = 0;
						}else{
							$output['message'] = 'Se ha producido un error al mover el objeto.';
						}
					}else{
						//Las posiciones son las mismas por lo que no hacemos nada
						$output['errno'] = 0;
					}
				}else{
					$output['message'] = 'No se puede toquetear las cositas de otros caballeros... ;) ';
				}
			}else{
				$output['message'] = 'Los datos de entrada no son correctos.';
			}
		}else{
			$output['message'] = 'Tu sesión ha expirado. Debes volver a hacer login.';
		}
		//Display
		echo CJSON::encode( $output );
	}

	/**
	 * Show template evolution for a month.
	 * 
	 * Evolution data are wasted experience.
	 * 
	 * 
	 */
	public function actionEvolution(){
		$yearBegin = 2012;
		$data = array(
				'monthlyEvolution' => null, //Store rows of evolution by day
				'filter' => array(
					'years'=>array(),
					'months'=>array(
						'01' => 'enero', 
						'02' => 'febrero', 
						'03' => 'marzo', 
						'04' => 'abril', 
						'05' => 'mayo', 
						'06' => 'junio', 
						'07' => 'julio', 
						'08' => 'agosto', 
						'09' => 'septiembre', 
						'10' => 'octubre', 
						'11' => 'noviembre', 
						'12' => 'diciembre' ),
					'year_selected'=>null,
					'month_selected'=>null
				),
				'previouslyExperience' => 0,
				'is_future_day'=>false
		);
		
		//Load data filter		
		$year_current = date('Y');
		$month_current = date('m');
		
		for ($i=$yearBegin; $i<=$year_current;$i++){
			$data['filter']['years'][$i] = $i;
		}
		
		//Check input data
		if( isset( $_POST['filter']['year']) && is_numeric($_POST['filter']['year']) && $_POST['filter']['year'] >= $yearBegin && $_POST['filter']['year'] <= $year_current ){
			$data['filter']['year_selected'] = $_POST['filter']['year'];
		}else{
			//set current year
			$data['filter']['year_selected'] = $year_current;
		}
		if( isset( $_POST['filter']['month']) && is_numeric($_POST['filter']['month']) && $_POST['filter']['month'] > 0 && $_POST['filter']['month'] <= 12 ){
			$data['filter']['month_selected'] = $_POST['filter']['month'];
		}else{
			$data['filter']['month_selected'] = $month_current;//$month_current;			
		}
		//echo $data['filter']['year_selected'].'-'.$data['filter']['month_selected'] .' <='. $year_current.'-'.$month_current  ;
		if( $data['filter']['year_selected'].'-'.$data['filter']['month_selected'] <= $year_current.'-'.$month_current  ){
			
			//Load total wasted experience up to month
			$previouslyEvolution = KnightsEvolution::model()->findAll( 'knights_id = :knights_id AND date < :date', array( ':knights_id'=>$this->knight->id,':date'=>$data['filter']['year_selected'].'-'.$data['filter']['month_selected']) );
			
			
			//Calculate all before experience 
			$data['previouslyExperience'] = 0;
			if( count( $previouslyEvolution ) ){
				foreach( $previouslyEvolution as $preevolution){
					if( $preevolution['type'] == KnightsEvolution::TYPE_UPGRADE){
						//Add total
						$data['previouslyExperience'] += $preevolution['experiencie_used'];
					}else{
						//substrac total
						$data['previouslyExperience'] -= $preevolution['experiencie_used'];
					}
				}	
			}
			unset($previouslyEvolution);
			
														
			//Load names of characteristics
			$data['knightsCard_labels'] = KnightsCard::model()->attributeLabels();
			$data['knights_evolution_chart'] = array();
					
			//Load all evolution of selected month
			$data['monthlyEvolution'] = KnightsEvolution::model()->findAll( 'knights_id = :knights_id AND date LIKE :date', array( ':knights_id'=>$this->knight->id,':date'=>$data['filter']['year_selected'].'-'.$data['filter']['month_selected'].'%') );
			
			//calculate experience by day
			$knightEvolution = array();
			if( count($data['monthlyEvolution']) ){
				foreach(  $data['monthlyEvolution'] as $knightEvolutionRow ){
					//Add experience if one more by day
					if( isset($knightEvolution[ substr($knightEvolutionRow->date, 0, 10) ]) ){			
						if( $knightEvolutionRow->type == KnightsEvolution::TYPE_UPGRADE ){
							$knightEvolution[ substr($knightEvolutionRow->date, 0, 10) ] += $knightEvolutionRow->experiencie_used;
						}else{
							$knightEvolution[ substr($knightEvolutionRow->date, 0, 10) ] -= $knightEvolutionRow->experiencie_used;
						}															
					}else{
						$knightEvolution[ substr($knightEvolutionRow->date, 0, 10) ] = $knightEvolutionRow->experiencie_used;
					}					
				}
			}
			
			//Creamos un listado con todos los días
			$first_day = date('Y-m-d', strtotime( $data['filter']['year_selected'].'-'.$data['filter']['month_selected'].'-01 -1 day'));
			$last_date = date('Y-m-d', strtotime( $data['filter']['year_selected'].'-'.$data['filter']['month_selected'].'-01 next month'));
			if( date('Y-m-d') < $last_date) $last_date = date('Y-m-d'); 
			
			$day = $first_day;
			$total = $data['previouslyExperience'];
			
			
				
			while( $day <= $last_date ){
				//Creamos el registro con la experiencia acumulada para el día
				$data['knights_evolution_chart'][$day] = $total;
										
				//Comprobamos si existe registro para este dia y le sumamos el día
				if( isset( $knightEvolution[$day])){
					$data['knights_evolution_chart'][$day] += $knightEvolution[$day];
					//Actualizamos la experiencia acumulada para el día siguiente
					$total += $knightEvolution[$day];
				}
				//Calculamos el siguiente día
				$day = date('Y-m-d', strtotime( $day.' +1 day'));
			}
		}else{
			$data['is_future_day'] = true;
		}
		
			
		//display template
		$this->render( 'evolution', $data );
		
	}

	public function actionStats(){
		$data = array(
				'knights' => null //Store rows of evolution by day
		);
		//Load knight
		$data['knights']= Knights::model()->with( 'knightsStats' )->find( 't.name=:name', array(':name'=>$_GET['sir']) );

		if( $data['knights']){
			//Load knights_status template
			//$data['knights_status_template'] = $this->renderFile(  Yii::app()->basePath.'/views/character/knights_status.php', array('knight'=>$data['knights']), true );
				
			//Display
			$this->render( 'stats', $data );
		}else{
			$data['message'] = 'El caballero buscado no existe.';
			if($error=Yii::app()->errorHandler->error)
				$this->render('error', $error);

		}
	}

	public function actionFriends(){
		$data = array();
		/*
		$data = array(
				'knights' => null //Store rows of evolution by day
		);
		
		 //Load knight
		$with_array = array(
				'users' => array(
						'with' => array(
								array('friends' =>
										array( 'with' =>
												array('toUser' =>
														array( 'with' => array( 'knights') )
												)
										)
								),
								array('friends1'=>
										array( 'with' =>
												array( 'fromUser' =>
														array( 'with' => array('knights') )
												)
										)
								)
						)
				)
		);
		//$data['knights']= Knights::model()->with( $with_array )->find( 't.name=:name', array(':name'=>$_GET['sir']) );
		$sql = "SELECT
		k1.name, k1.level, k1.endurance, k1.life, k1.pain, k1.experiencie_earned, k1.experiencie_used, k1.avatars_id
		FROM friends
		INNER JOIN users as u1 ON u1.id = friends.from_user AND friends.to_user = :users_id1
		INNER JOIN users as u2 ON u2.id = friends.to_user AND friends.from_user = :users_id2
		INNER JOIN knights as k1 ON u1.id = k1.users_id
		INNER JOIN knights as k2 ON u2.id = k2.users_id
		WHERE friends.status = :status AND (friends.from_user = :users_id3 OR  friends.to_user = :users_id4)";

		*/
		$sql = "SELECT id, name, level, endurance, life, pain, experiencie_earned, experiencie_used, avatars_id
				FROM knights
				WHERE users_id IN (
				SELECT from_user as users_id FROM friends WHERE to_user = :users_id1 AND status = :status1
				UNION
				SELECT to_user as users_id FROM friends WHERE from_user = :users_id2 AND status = :status2)
				";

		$command = Yii::app()->db->createCommand($sql);
		$command->bindValue( ':users_id1', $this->knight->users_id );
		$command->bindValue( ':users_id2', $this->knight->users_id );
		//$command->bindValue( ':users_id3', $this->knight->id );
		//$command->bindValue( ':users_id4', $this->knight->id );
		$command->bindValue( ':status1', Friends::STATUS_ACCEPT );
		$command->bindValue( ':status2', Friends::STATUS_ACCEPT );
		$data = $command->queryAll();

		//Display
		$this->render( 'friends', array( 'friends' => $data ) );

	}

	public function actionAchivements(){
		$data = array(
				'knights' => null //Store rows of evolution by day
		);
		//Load knight
		$with_array = array(
				'knightsAchievements' => array(
						'with' => array(
								'achievements'
						)
				)
		);
		$data['knights']= Knights::model()->with( $with_array )->find( 't.name=:name', array(':name'=>$_GET['sir']) );

		if( $data['knights']){
			//Load knights_status template
			//$data['knights_status_template'] = $this->renderFile(  Yii::app()->basePath.'/views/character/knights_status.php', array('knight'=>$data['knights']), true );

			//Display
			$this->render( 'achievements', $data );
		}else{
			$data['message'] = 'El caballero buscado no existe.';
			if($error=Yii::app()->errorHandler->error)
				$this->render('error', $error);

		}
	}

	public function actionEvents(){
		$data = array(
				'knights' => null, //Store rows of evolution by dayob
				'events' => array()
		);
		$app_rules_level = AppRulesLevel::model()->findAll( array('index'=>'level')  );

		//Load knight
		//$data['knights']= Knights::model()->with( array('knightsEventsLasts'=>array('order'=>'knightsEventsLasts.date DESC', 'limit'=>Yii::app()->params['events']['event_last']['maximum']  )) )->find( 't.name=:name ', array(':name'=>$_GET['sir']) );
		
		$events_list = KnightsEventsLast::model()->findKnightEventLast($this->knight->id, Yii::app()->params['events']['event_last']['maximum'] );		
		Yii::trace( '[CHARACTER][actionEvents] START actionEvents' );
		if( $events_list ){
			//Load knights_status template
			//$data['knights_status_template'] = $this->renderFile(  Yii::app()->basePath.'/views/character/knights_status.php', array('knight'=>$data['knights']), true );			
			
			//Para cada evento cargamos los datos de ese evento.
			foreach( $events_list as $event ){

				//Check type event.
				switch( $event->type ){
					//Combate
					case KnightsEvents::TYPE_COMBAT:
						//Search combat
						$combat = Combats::model()->with( array( 'fromKnight', 'toKnight', array('rounds'=>array('order'=>'rounds.number DESC') ) ) )->find( 't.id=:id', array(':id'=>$event->identificator) );
						//Make status html
						switch ( $combat->status ){
							case Combats::STATUS_PENDING:
								Yii::trace( '[CHARACTER][actionEvents] COMBATE PENDIENTE' );


								//Check if knights are enable for combat
								if( $combat->fromKnight->status == Knights::STATUS_ENABLE && $combat->toKnight->status == Knights::STATUS_ENABLE ){
									$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_pending.php', array('combat'=>&$combat ), true );

									//Check why can not combat
								}else{
									//Check if somebudy is at combat
									if( $combat->fromKnight->status == Knights::STATUS_AT_COMBAT || $combat->toKnight->status == Knights::STATUS_AT_COMBAT ){
										$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable_but_somebody_is_at_combat.php', array('combat'=>&$combat ), true );
											
										//Check if somebody is at working
									}elseif( $combat->fromKnight->status == Knights::STATUS_AT_WORK || $combat->toKnight->status == Knights::STATUS_AT_WORK ){
										$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable_but_somebody_is_at_work.php', array('combat'=>&$combat ), true );
									}elseif( $combat->fromKnight->status == Knights::STATUS_WITHOUT_EQUIPMENT || $combat->toKnight->status == Knights::STATUS_WITHOUT_EQUIPMENT ){
										$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable_but_somebody_is_without_equipment.php', array('combat'=>&$combat ), true );
									}
								}

								break;
							case Combats::STATUS_ENABLE:

								$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable.php', array('combat'=>&$combat ), true );
								/*
								 //In first round
								if( count($combat->rounds)==1 ){
								$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable_accepted_challenge.php', array('combat'=>&$combat ), true );
									
								}else{
								//Several rounds
								$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable.php', array('combat'=>&$combat ), true );
								}
								*/
								break;
							case Combats::STATUS_FINISHED:
								if( $combat->result == Combats::RESULT_REJECT ){
									$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_finished_result_reject.php', array('combat'=>&$combat ), true );
								}else{
									$combatStatusHtml = $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat_status_enable.php', array('combat'=>&$combat ), true );
								}

								break;
						}

						array_push( $data['events'], $this->renderFile( Yii::app()->basePath.'/views/character/event_type_combat.php', array('combat'=>&$combat, 'combatStatusHtml'=>$combatStatusHtml ), true ) );
						break;
						//Evolucion de un personaje
					case KnightsEvents::TYPE_KNIGHTS_EVOLUTION:
						$knightsEventsData = array(
						'knight'=>&$data['knights'],
						'evolution'=> KnightsEvolution::model()->findByPk( $event->identificator )
						);
						array_push( $data['events'], $this->renderFile( Yii::app()->basePath.'/views/character/event_type_knights_evolution.php', $knightsEventsData, true ) );
						break;
					case KnightsEvents::TYPE_JOB:
						$knightsEventsData = array(
						'knight'=>&$data['knights'],
						'job'=>Jobs::model()->findByPk( $event->identificator ),
						'app_rules_level'=>&$app_rules_level
						);
						array_push( $data['events'], $this->renderFile( Yii::app()->basePath.'/views/character/event_type_job.php', $knightsEventsData, true ) );
					default:
						//Nothing to do here. for example if is void
				}
			}
				
			//Display
			$this->render( 'events', $data );
		}else{
			$data['message'] = 'El caballero buscado no existe.';
			if($error=Yii::app()->errorHandler->error)
				$this->render('error', $error);

		}
	}


	/**
	 * Registra una solicitud de amistad
	 */
	public function actionSendFriendshipRequest(){
		$output = array(
				'errno'=>1,
				'message'=>0
		);

		//Check if user is logged
		if( !Yii::app()->user->isGuest ){

			//check if they are friends now
			if( !$this->are_they_friends  ){
				//Check if is pending

				$condition = "(from_user = :user_knight1 AND to_user = :knight1 AND status = :status1) OR (from_user = :knight2 AND to_user = :user_knight2 AND status = :status2)";
				$params = array(
						':knight1'=> $this->knight->id,
						':knight2'=> $this->knight->id,
						':user_knight1'=> $this->user_data['knights']->id,
						':user_knight2'=> $this->user_data['knights']->id,
						':status1'=>Friends::STATUS_ONWAITING,
						':status2'=>Friends::STATUS_ONWAITING,
				);
				$friendRelationship = Friends::model()->find( $condition, $params);
				if( $friendRelationship == null ){
					//We create
					$friend = new Friends();
					$friend->attributes = array(
							'from_user'=>Yii::app()->user->users_id,
							'to_user'=>$this->knight->users_id,
							'status'=> Friends::STATUS_ONWAITING,
							'start_date'=> date('Y-m-d H:i:s'),

					);
						
					if( $friend->save() ){

						/*
						 * SEND EMAIL TO RIVAL
						*/
						Yii::trace( '[CHARACTER][sendChallenge] CHECK email' );
						//Check email of challenge
						if( $knight_setting = KnightsSettings::model()->findByPk( $this->knight->id ) ){
							if( $knight_setting->emailToFinishedCombat ){
								Yii::trace( '[CHARACTER][sendChallenge] Send email' );

								//Check email
								if( $knight_user = Users::model()->findByPk( $this->knight->users_id ) ){
									Yii::trace( '[CHARACTER][sendChallenge] Rival email'.$knight_user->email );

									//cargamos la plantilla
									$message = Yii::app()->controller->renderFile(
											Yii::app()->basePath.Yii::app()->params['email_templates_path'] . 'friendlyRequest.tpl',
											array(),
											true
									);

									// To send HTML mail, the Content-type header must be set
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

									// Additional headers
									$headers .= 'To: '.$knight_user->email. "\r\n";
									$headers .= 'From: <noreply@'.Yii::app()->params->url_domain.'>' . "\r\n";
									//$headers = array($headers);

									$email = new Emails();
									$email->attributes = array(
											'destination'=> $knight_user->email,
											'headers'=>$headers,
											'title'=> Yii::app()->name.': solicitud de amistad.',
											'body'=> $message,
											'status'=>Emails::STATUS_PENDING,
											'date'=>date('Y-m-d H:i:s')
									);
									//Old
									//$aux = Yii::app()->email->send( 'noreply@campeonatojustasmedievales.com',$knight_user->email , Yii::app()->name.': solicitud de amistad.' ,$message,$headers);
									if( !$email->save() ){
										Yii::trace( '[CHARACTER][actionSendFriendshipRequest] No se ha podido guardar el email');
									}
										
								}else{
									Yii::trace( '[CHARACTER][actionSendFriendshipRequest] No se ha encontrado usuario del caballero '.$this->knight->id, 'error');
								}
							}
						}else{
							Yii::trace( 'No se ha encontrado setting del caballero '.$this->knight->id, 'error');
						}


						$output['errno'] = 0;
						$output['message'] = 'La petición de amistad se ha enviado correctamente.';
					}else{
						$output['message'] = 'No se ha podido registrar la petición de amistad.';
					}
				}else{
					$output['message'] = '<p>Actualmente ya hay una solicitud en curso a la espera de que se acepte.</p>';
				}
			}else{
				$output['message'] = '<p>Sientes tanto aprecio por tu amigo como para hacerle una segunda petición de amistad.</p> <p>Eso es amor.</p>';
			}
		}else{
			$output['message'] = 'La sesion ha expirado. Necesitas hacer login de nuevo para realizar esta acción.';
		}

		echo CJSON::encode( $output );
	}

	public function actionReplyToFriendship(){
		$output = array(
				'errno'=>1,
				'message'=>0
		);


		//Check if user is logged
		if( !Yii::app()->user->isGuest ){
			//check input
			if( isset( $_GET['id'] ) && is_numeric( $_GET['id']) && $_GET['id']>0  ){
				//Check friendship
				$frienship = Friends::model()->findByPk( $_GET['id'] );
				if( $frienship ){
					//Check status is on waiting
					if( $frienship->status == Friends::STATUS_ONWAITING ){
						//Check final user is login user
						if( $frienship->to_user == Yii::app()->user->users_id ){
							//Set accept or reject
							if( $_GET['action'] == 'accept' ){
								$frienship->status = Friends::STATUS_ACCEPT;
							}else{
								$frienship->status = Friends::STATUS_REJECT;
							}
							//update row
							if( $frienship->save() ){
								$output['errno'] = 0;

								if( $frienship->status == Friends::STATUS_ACCEPT ){
									$output['message'] = '<p>Uoooohhh!! Tienes un amiguito nuevo con el que jugar.</p><p>¡¡MACHÁCALO SIN PIEDAD!!</p>';
								}else{
									$output['message'] = '<p>Hay veces que la gente no merece tu amistad. Esta parece ser una de ellas. A pesar de ello:</p><p>¡¡MACHÁCALO SIN PIEDAD!! </p>';
								}
							}else{
								$output['message'] = 'Se ha producido un error al registrar la solicitud.';
							}
						}else{
							$output['message'] = 'No se pueden toquetear las cositas de otros jugadores.';
						}
					}else{
						$output['message'] = 'La solicitud no está esperando aceptar o rechazarla...';
					}
				}else{
					$output['message'] = 'No se ha encontrado la solicitud de amistad.';
				}
			}else{
				$output['message'] = 'El identificador no es válido.';
			}
		}else{
			$output['message'] = 'La sesion ha expirado. Necesitas hacer login de nuevo para realizar esta acción.';
		}

		echo CJSON::encode( $output );
	}

	/**
	 * Show dialog of confirmation
	 */
	public function actionConfirmRejectFrienshipRequest(){
		$output = array(
				'errno'=>0,
				'html'=>''
		);

		//check session
		if(!Yii::app()->user->isGuest){
			//check friendship exist
			if( $this->are_they_friends){
				//Show dialog
				$output['errno'] = 0;
				$output['title'] = 'Mensaje';
				$output['html'] = $this->renderPartial( 'dialog_confirmRejectFriendshipRequest', null, true );
				$output['urlRequest'] = '/character/rejectFrienshipRequest/sir/'.$this->knight->name;

			}else{
				$output['html'] = '<p>Sir '.$this->knight->name.' y tú no sois amigos.</p>';
			}
		}else{
			$output['html'] = '<p>La sessión ha expirado. Debes volver a hacer login.</p>';
		}

		//Show output
		echo CJSON::encode($output);
	}
	public function actionRejectFrienshipRequest(){
		$output = array(
				'errno'=>0,
				'html'=>''
		);

		//check session
		if(!Yii::app()->user->isGuest){
			//check friendship exist
			if( $this->are_they_friends){
				//Update status of frienship
				$condition = "(from_user = :user_knight1 AND to_user = :knight1 AND status = :status1) OR (from_user = :knight2 AND to_user = :user_knight2 AND status = :status2)";
				$params = array(
						':knight1'=> $this->knight->users_id,
						':knight2'=> $this->knight->users_id,
						':user_knight1'=> $this->user_data['knights']->users_id,
						':user_knight2'=> $this->user_data['knights']->users_id,
						':status1'=>Friends::STATUS_ACCEPT,
						':status2'=>Friends::STATUS_ACCEPT,
				);
				$friendRelationship = Friends::model()->find( $condition, $params);
				$friendRelationship->delete_by_user = Yii::app()->user->users_id;
				$friendRelationship->end_date = date('Y-m-d H:i:s');
				if( $friendRelationship->from_user == Yii::app()->user->users_id){
					$friendRelationship->status = Friends::STATUS_FINISHED_BY_SENDER;
				}else{
					$friendRelationship->status = Friends::STATUS_FINISHED_BY_RECEIVER;
				}
				if( $friendRelationship->save() ){
					$output['errno'] = 0;
					$output['html'] = '<p>Seguro que le has partido el corazón. Ya no sois amigos.</p>';
				}else{
					$output['html'] = $this->renderPartial( 'dialog_confirmRejectFrienshipRequest' );
					Yii::trace( '[CHARACTER][actionConfirmRejectFrienshipRequest] No se puede actualizar la relación de amistad para terminarla.', 'error' );
				}
			}else{
				$output['html'] = '<p>Sir '.$this->knight->name.' y tú no sois amigos.</p>';
			}
		}else{
			$output['html'] = '<p>La sessión ha expirado. Debes volver a hacer login.</p>';
		}

		//Show output
		echo CJSON::encode($output);
	}

	/**
	 * Load all users with messages
	 */
	public function actionMessages(){
		if( !Yii::app()->user->isGuest && Yii::app()->user->knights_name == $_GET['sir']){
			//Load all messages
			/*
			$sql = "SELECT knights.name as name, knights.avatars_id as avatars_id, messages_last_one_by_user.text as text, messages_last_one_by_user.date as date
			FROM  messages_last_one_by_user
			INNER JOIN users ON users.id = messages_last_one_by_user.with_user
			INNER JOIN knights ON knights.users_id = users.id
			WHERE messages_last_one_by_user.users_id = :user_id";
			$command = Yii::app()->db->createCommand( $sql );
			$command->bindValue( ':user_id', Yii::app()->user->users_id, PDO::PARAM_INT  );
			$result = $command->queryAll();
			*/

			$this->render('messages', array( 'messages'=>Messages::getMessageLastByUser(Yii::app()->user->users_id)) );
		}else{
			$this->redirect( '/site/forbidden' );
		}
	}

	/**
	 * Received messages for users
	 */
	public function actionSendMessage(){
		$output = array(
				'errno' => 1,
				'html' => '',
				'message' => ''
		);
		//Check if knight exist
		if( $this->knight ){
			//Check if knight and user knight is the same
			if( $this->user_data['knights']->name != $this->knight->name ){
				//Check valid input
				if( isset($_POST['text']) && $_POST['text']!=''){
					//
					$message = new Messages();
					$message->attributes = array(
							'from_user'=> Yii::app()->user->users_id,
							'to_user'=>$this->knight->users_id,
							'status'=>Messages::STATUS_SENDED,
							'text'=>htmlentities($_POST['text'], ENT_QUOTES, 'UTF-8'),
							'date'=>date("Y-m-d H:i:s")
					);
						
					//Insert message
					if( $message->save() ){
						//We insert or update for two users and tables messages_las_one_by_user and insert/update for receiver user in table new

						//Update messages last one by user
						$sql = "INSERT INTO messages_last_one_by_user ( users_id, with_user, status, text, date) VALUES ( :users_id1, :with_user1, :status1, :text1, :date1 )
								ON DUPLICATE KEY UPDATE status = :status3, text = :text3, date = :date3;

								INSERT INTO messages_last_one_by_user ( users_id, with_user, status, text, date) VALUES ( :users_id5, :with_user5, :status5, :text5, :date5 )
								ON DUPLICATE KEY UPDATE status = :status6, text = :text6, date = :date6;

								INSERT INTO messages_last_one_new ( users_id, with_user, status, text, date) VALUES ( :with_user2, :users_id2, :status2, :text_short2, :date2 )
								ON DUPLICATE KEY UPDATE status = :status4, text = :text_short4, date = :date4;";
						$command = Yii::app()->db->createCommand($sql);

						$command->bindValue( ':users_id1', $message->from_user, PDO::PARAM_INT );
						$command->bindValue( ':with_user1', $message->to_user, PDO::PARAM_INT );
						$command->bindValue( ':status1', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text1', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date1', $message->date, PDO::PARAM_STR );
						$command->bindValue( ':status3', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text3', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date3', $message->date, PDO::PARAM_STR );

						$command->bindValue( ':users_id2', $message->from_user, PDO::PARAM_INT );
						$command->bindValue( ':with_user2', $message->to_user, PDO::PARAM_INT );
						$command->bindValue( ':status2', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text_short2', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date2', $message->date, PDO::PARAM_STR );
						$command->bindValue( ':status4', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text_short4', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date4', $message->date, PDO::PARAM_STR );

						$command->bindValue( ':users_id5',$message->to_user , PDO::PARAM_INT );
						$command->bindValue( ':with_user5', $message->from_user, PDO::PARAM_INT );
						$command->bindValue( ':status5', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text5', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date5', $message->date, PDO::PARAM_STR );
						$command->bindValue( ':status6', Messages::STATUS_SENDED, PDO::PARAM_INT );
						$command->bindValue( ':text6', $message->text, PDO::PARAM_STR );
						$command->bindValue( ':date6', $message->date, PDO::PARAM_STR );

						if( $command->execute() ){
							Yii::app()->db->setActive(false);
							$output['errno'] = 0;
							/*
							 * Check if we send email. Only send if user has not pending messages (now has one).
							*/
							if(  count($this->user_data['new_messages'])==0 ){
								/*
								 * SEND EMAIL TO RIVAL
								*/
								Yii::trace( '[CHARACTER][sendChallenge] CHECK email' );
								//Check email of challenge
								//Load  knights settings

								if( $knight_setting = KnightsSettings::model()->findByPk( $this->knight->id ) ){
									//if( $knight_setting = KnightsSettings::model()->findByPk( $this->knight->id ) ){

									if( $knight_setting->emailToSendMessage ){
										Yii::trace( '[CHARACTER][sendChallenge] Send email' );

										//Check email
										$knight_user = Users::model()->findByPk(  $this->knight->users_id );


										if( $knight_user ){
											Yii::trace( '[CHARACTER][sendChallenge] Rival email'.$knight_user->email );

											//cargamos la plantilla
											$message = Yii::app()->controller->renderFile(
													Yii::app()->basePath.Yii::app()->params['email_templates_path'] . 'pendingMessages.tpl',
													array(),
													true
											);

											// To send HTML mail, the Content-type header must be set
											$headers  = 'MIME-Version: 1.0' . "\r\n";
											$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

											// Additional headers
											$headers .= 'To: '.$knight_user->email. "\r\n";
											$headers .= 'From: <noreply@'.Yii::app()->params['url_domain'].'>' . "\r\n";
											

											$email = new Emails();
											$email->attributes = array(
													'destination'=> $knight_user->email,
													'headers'=>$headers,
													'title'=> Yii::app()->name.': mensajes pendientes.',
													'body'=> $message,
													'status'=>Emails::STATUS_PENDING,
													'date'=>date('Y-m-d H:i:s')
											);
											//Old
											//$aux = Yii::app()->email->send( 'noreply@campeonatojustasmedievales.com',$knight_user->email , Yii::app()->name.': solicitud de amistad.' ,$message,$headers);
											if( !$email->save() ){
												Yii::trace( '[CHARACTER][actionSendMessage] No se ha podido guardar el email');
											}
												
										}else{
											Yii::trace( '[CHARACTER][actionSendMessage] No se ha encontrado usuario del caballero '.$this->knight->id, 'error');
										}
									}
								}else{
									Yii::trace( 'No se ha encontrado setting del caballero '.$this->knight->id, 'error');
								}
							}
							$output['message'] = '<p>El mensaje se ha enviado correctamente.</p>';
						}else{
							$output['message'] = '<p>Se ha producido un error en la propagación del mensaje.</p>';
						}
					}else{
						//No se ha podido salvar el mensaje
						$output['message'] = 'Se ha producido un error al registrar el mensaje.';
					}
				}else{
					//Mensaje vacio posibilidad no válida en un principio
					$output['message'] = 'El mensaje llega vacio.';
				}
			}else{
				//Está mandandose mensajes a si mismo. Es un crack.
				$output['message'] = 'No puedes mandarte mensajes a ti mismo.';
			}
		}else{
			$output['message'] = 'El caballero no existe.';
		}
		echo CJSON::encode( $output );
	}

	/**
	 * conversation with user
	 */
	public function actionMessagesWith(){

		//Check if user is subnormal
		if( !Yii::app()->user->isGuest && Yii::app()->user->knights_name != $_GET['sir']){
			//Check page
			$page = 1;//Is the first page
			if( isset( $_GET['page']) && is_numeric( $_GET['page']) && $_GET['page']>0 ){
				$page = $_GET['page'];
			}
			$register_start = $page*Yii::app()->params['messages']['max_by_page']-Yii::app()->params['messages']['max_by_page'];
			//$message_list = Messages::model()->findAll( "(from_user = :users_id1 AND to_user =:knight_users_id1) OR (from_user = :knight_users_id2 AND to_user =:users_id2) ORDER BY " );

				
			$paramsCondition = array(
					':users_id1'=>Yii::app()->user->users_id,
					':users_id2'=>Yii::app()->user->users_id,
					':knight_users_id1'=>$this->knight->users_id,
					':knight_users_id2'=>$this->knight->users_id,
					':status_delete'=>Messages::STATUS_DELETED
			);
			$total_rows = Messages::model()->count( '(from_user = :users_id1 AND to_user =:knight_users_id1) OR (from_user = :knight_users_id2 AND to_user =:users_id2) AND status != :status_delete', $paramsCondition );

			//Set params
			$params = array(
					'messages'=>Messages::getMessageWith(Yii::app()->user->users_id, $this->knight->users_id, $register_start, Yii::app()->params['messages']['max_by_page'] ),
					'totalPages'=> ceil( $total_rows/Yii::app()->params['messages']['max_by_page'] ),
					'page'=>$page
			);
				
			$this->render('messagesWith', $params );
		}else{
			//No permitimos tener conversaciones con uno mismo.
			$this->redirect( '/site/error' );
		}
	}

	public function actionDeleteNewMessages(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		if( !Yii::app()->user->isGuest && Yii::app()->user->knights_name == $_GET['sir']){
			if( Messages::deleteNewMessages(Yii::app()->user->users_id) ){
				$output['errno'] = 0;
			}else{
				$output['html'] = '<p>Se ha producido un error al borrar.</p>';
			}
		}else{
			$output['html'] = '<p>Solo se pueden toquetear tus cositas.</p>';
		}
		echo CJSON::encode( $output);
	}

	/**
	 * Return html template for content dialog
	 */
	public function actionConfirmSendChallenge(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		if( !Yii::app()->user->isGuest ){
			if( $this->user_data['knights']->status == Knights::STATUS_ENABLE ){
				if( $this->user_data['knights']->name != $this->knight->name){
					//Check is exist a previous challenge pending or enable
					if( ! Combats::model()->exists( 'status != :status AND (from_knight = :knight1 AND to_knight = :rival1) OR (from_knight = :rival2 AND from_knight = :knight2)', array(':knight1'=>Yii::app()->user->knights_id, ':rival1'=>$this->knight->id, ':knight2'=>Yii::app()->user->knights_id, ':rival2'=>$this->knight->id, ':status'=>Combats::STATUS_FINISHED) )  ){
						//Show output
						$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/confirmSendChallenge.php', array( 'knight' => $this->knight), true );
						$output['errno'] = 0;
					}else{
						$output['html'] = '<p>No puedes retar al caballero si ya tienes un reto pendiente o en curso.</p>';
					}
				}else{
					$output['html'] = '<p>¿Cómo has llegado a tratar de retarte a ti mismo? En este momento no te parece tan buena idea.</p>';
				}
			}else{
				if( $this->user_data['knights']->status == Knights::STATUS_AT_WORK ){
					$output['html'] = '<p>Actualmente estás trabajando.</p><p>Puedes cancelar el trabajo pero perderás tu paga.</p><p><span clas="right"><a href="/jobs">cancelar el trabajo</a></span></p>';
				}elseif ($this->user_data['knights']->status == Knights::STATUS_AT_COMBAT){
					$output['html'] = '<p>No puedes realizar dos combates a la vez. Esto no es matrix.</p>';
				}else{
					$output['html'] = '<p>Tu caballero está en otras cosas que no le permiten combatir.</p>';
				}
			}
		}else{
			//User session expired
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}
		echo CJSON::encode( $output );
	}

	/**
	 * Make a combat  with initial status.
	 */
	public function actionSendChallenge( ){
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check if user is a cheater
			if( $this->user_data['knights']->name != $this->knight->name ){
				//Check if user has not a previous challenger enable
				$conditionParams = array(
						':status1' => Combats::STATUS_PENDING,
						':status2' => Combats::STATUS_ENABLE,
						':me1'=>Yii::app()->user->users_id,
						':me2'=>Yii::app()->user->users_id,
						':rival1'=>$this->knight->id,
						':rival2'=>$this->knight->id
				);
				//Check if knights have a pending or enable combat
				if( ! Combats::model()->exists( 'status != :status AND (from_knight = :knight1 AND to_knight = :rival1) OR (from_knight = :rival2 AND from_knight = :knight2)', array(':knight1'=>Yii::app()->user->knights_id, ':rival1'=>$this->knight->id, ':knight2'=>Yii::app()->user->knights_id, ':rival2'=>$this->knight->id, ':status'=>Combats::STATUS_FINISHED) )  ){
					//Insert a new combat
					$combat = new Combats();
					$combat->attributes = array(
							'from_knight' => Yii::app()->user->knights_id,
							'to_knight' =>  $this->knight->id,
							'date' => date( "Y-m-d H:i:s"),
							'type' => Combats::TYPE_FRIENDLY,
							'status' => Combats::STATUS_PENDING
					);
					if( $combat->save() ){
						//Insert a new combat knight event of both knights
						$knightEventMe = new KnightsEvents();
						$knightEventMe->attributes = array(
								'knights_id' => Yii::app()->user->knights_id,
								'type' => KnightsEvents::TYPE_COMBAT,
								'identificator' => $combat->id
						);
						if( $knightEventMe->save() ){
							$knightEventRival = new KnightsEvents();
							$knightEventRival->attributes = array(
									'knights_id' => $this->knight->id,
									'type' => KnightsEvents::TYPE_COMBAT,
									'identificator' => $combat->id
							);
							if( $knightEventRival->save() ){


								//Update rows from knight events last
								$sql = "UPDATE
										knights_events_last as k
										SET
										k.type = ".KnightsEvents::TYPE_COMBAT.",
												k.identificator = ".$combat->id.",
														k.date = '".date('Y-m-d H:i:s')."'
																WHERE
																k.id IN (
																SELECT id FROM (
																SELECT
																id
																FROM
																knights_events_last
																WHERE
																knights_id = ".Yii::app()->user->knights_id."
																		ORDER BY date ASC
																		LIMIT 1
																		) as trick
																		)";
								//echo $sql;	die();
								$command = Yii::app()->db->createCommand($sql);
								//$command->bindValue( ':user_knights_id', Yii::app()->user->knights_id );

								if( $command->query() ){
									$sql = "UPDATE
											knights_events_last
											SET
											type = ".KnightsEvents::TYPE_COMBAT.",
													identificator = ".$combat->id.",
															type = ".KnightsEvents::TYPE_COMBAT.",
																	date = '".date('Y-m-d H:i:s')."'
																			WHERE
																			id IN (
																			SELECT id FROM (
																			SELECT
																			id
																			FROM
																			knights_events_last
																			WHERE
																			knights_id = ".$this->knight->id."
																					ORDER BY date ASC
																					LIMIT 1
																					) as trick
																					)";
									$command = Yii::app()->db->createCommand($sql);
									//$command->bindValue( ':knight_id', $this->knight->id );
									if( $command->execute()){
										Yii::trace( '[CHARACTER][sendChallenge] CHECK email' );
										//Check email of challenge
										if( $knight_setting = KnightsSettings::model()->findByPk( $this->knight->id ) ){
											if( $knight_setting->emailToSendChallenge ){
												Yii::trace( '[CHARACTER][sendChallenge] Send email' );
												if( $knight_user = Users::model()->findByPk( $this->knight->users_id ) ){
													Yii::trace( '[CHARACTER][sendChallenge] Rival email'.$knight_user->email );
														
													//cargamos la plantilla
													$message = Yii::app()->controller->renderFile(
															Yii::app()->basePath.Yii::app()->params['email_templates_path'] . 'sendNewChallenge.tpl',
															array(),
															true
													);
														
													// To send HTML mail, the Content-type header must be set
													$headers  = 'MIME-Version: 1.0' . "\r\n";
													$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
														
													// Additional headers
													$headers .= 'To: '.$knight_user->email. "\r\n";
													$headers .= 'From: <noreply@'.Yii::app()->params->url_domain.'>' . "\r\n";
														
														
													$email = new Emails();
													$email->attributes = array(
															'destination'=> $knight_user->email,
															'headers'=>$headers,
															'title'=> Yii::app()->name.': tienes un reto pendiente.',
															'body'=> $message,
															'status'=>Emails::STATUS_PENDING,
															'date'=>date('Y-m-d H:i:s')
													);
													if( !$email->save() ){
														Yii::trace( '[CHARACTER][actionSendChallenge] No se ha podido guardar el email');
													}
												}else{
													Yii::trace( '[CHARACTER][actionSendChallenge] No se ha encontrado usuario del caballero '.$this->knight->id, 'error');
												}
											}
										}else{
											Yii::trace( '[CHARACTER][actionSendChallenge] No se ha encontrado setting del caballero '.$this->knight->id, 'error');
										}

										echo '<p>El guantazo resuena por toda la sala.</p><p>Una multitud mirando y una mejilla con 5 dedos marcados no dejan lugar a dudas. El desafio ha sido lanzado</p>
												<p>La reacción del adversario no debería hacerse esperar...</p>';

									}else{
										echo '<p>Se ha producido un error al guardar el evento rival del combate en la cache.</p>' ;
									}
								}else{
									echo '<p>Se ha producido un error al guardar el evento del combate en la cache.</p>' ;
								}


								//Update events
								/*
								$knightEventLastMe = new KnightsEventsLast();
								$knightEventLastMe->attributes = array(
										'knights_id' => Yii::app()->user->knights_id,
										'type' => KnightsEvents::TYPE_COMBAT,
										'identificator' => $combat->id,
										'date' => $combat->date
								);

								$criteria = new CDbCriteria();
								$criteria->condition = 'knights_id = :knights_id';
								$criteria->condition = 'knights_id = :knights_id';
								$knightEventMe = KnightsEvents::model()->find(  );


								if( $knightEventLastMe->save() ){
								$knightEventLastMe = new KnightsEventsLast();
								$knightEventLastMe->attributes = array(
										'knights_id' => $this->knight->id,
										'type' => KnightsEvents::TYPE_COMBAT,
										'identificator' => $combat->id,
										'date' => $combat->date
								);
								if( $knightEventLastMe->save() ){
								echo '<p>El guantazo resuena por toda la sala.</p><p>Una multitud mirando y una mejilla con 5 dedos marcados no dejan lugar a dudas. El desafio ha sido lanzado</p>
								<p>La reacción del adversario no debería hacerse esperar...</p>';
								}else{
								echo '<p>Se ha producido un error al guardar el evento rival en la caché .</p>' ;
								}
								}else{
								echo '<p>Se ha producido un error al guardar el evento en la caché .</p>' ;
								}


								//Update table caché knights events las
								$knightEventLastMe = KnightsEventsLast::model()->find( 'knights_id :knights_id' );
								*/

							}else{
								echo '<p>Se ha producido un error al guardar el evento rival del combate .</p>' ;
							}
						}else{
							echo '<p>Se ha producido un error al guardar el evento del combate.</p>' ;
						}
					}else{
						echo '<p>Se ha producido un error al guardar el desafio.</p>' ;
					}
				}else{
					//There is a combat pending or enable
					echo '<p>No se puede desafiar a alguien con el que tienes un desafio pendiente o en curso.</p>';
				}
			}else{
				echo '<p>¿Cómo has llegado a retarte a ti mismo? En este momento no te parece tan buena idea.</p>';
			}
		}else{
			echo '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}
	}

	/**
	 * Return html for to show in dialog
	 */
	public function actionConfirmRejectChallenge(){
		$output = array(
				'errno'=>0,
				'html'=>$this->renderFile( Yii::app()->basePath.'/views/character/confirmRejectChallenge.php', array(), true )
		);
		echo CJSON::encode( $output );
	}
	/**
	 * Return html for to show in dialog
	 */
	public function actionConfirmAcceptChallenge(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		if( ! Yii::app()->user->isGuest ){
				
			//Check input
			if( isset($_GET['combat']) && is_numeric($_GET['combat']) && $_GET['combat'] > 0 ){
				//Check if combat exit
				if( $combat = Combats::model()->findByPk( $_GET['combat']) ){
					//Check who is rival
					$rival = ($combat->toKnight->id == Yii::app()->user->knights_id)?$combat->fromKnight:$combat->toKnight;
					
					
					//Check if rival is online					
					//if( Sessions::model()->exists( 'users_id = :users_id AND expire > :expire', array(':users_id'=>$rival->users_id,':expire'=>time())) ){
					if(  Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$rival->id ) ){
										
						//Check if rival is enable to combat
						if( ($combat->toKnight->id == Yii::app()->user->knights_id && $combat->toKnight->status == Knights::STATUS_ENABLE) || ($combat->fromKnight->id == Yii::app()->user->knights_id && $combat->fromKnight->status == Knights::STATUS_ENABLE) ){
							//Check if rival has minimum equipment
							if( Inventory::checkIfPrimaryEquipmentIsCompleted( $rival->id ) ){
								$output['html'] =  $this->renderFile( Yii::app()->basePath.'/views/character/confirmAcceptChallenge.php', array(), true );
								$output['errno'] = 0;
							}else{
								$output['html'] = '<p>No puedes retar al caballero ahora mismo.</p><p>Al parecer le falta algún componente de su armadura y no puede combatir. Seguramente es una excusa para no perder ante ti. Vigílalo hasta que tenga el equipo completo y MACHÁCALO.</p>';
							}
						}else{
							//Check if is working or at combat
							if(($combat->toKnight->id == Yii::app()->user->knights_id && $combat->toKnight->status == Knights::STATUS_AT_WORK) || ($combat->fromKnight->id == Yii::app()->user->knights_id && $combat->fromKnight->status == Knights::STATUS_AT_WORK) ){
								$output['html'] = '<p>El adversario está trabajando y no puede combatir.</p>';
							}
							if(($combat->toKnight->id == Yii::app()->user->knights_id && $combat->toKnight->status == Knights::STATUS_AT_COMBAT) || ($combat->fromKnight->id == Yii::app()->user->knights_id && $combat->fromKnight->status == Knights::STATUS_AT_COMBAT) ){
								$output['html'] = '<p>El adversario está en otro combate y no puede combatir.</p>';
							}
						}
					}else{
						$output['html'] = '<p>¡Tu rival no está conectado!</p><p>Para poder resolver un combate los dos caballeros tienen que estar "online".</p><p>Puedes ver si un caballero está "online" si en la parte superior de su perfil sale como: "¡CONECTADO!"</p>';
					}
				}else{
					//Combat not exist
					$output['html'] = '<p>El combate no existe.</p>';
				}
			}else{
				$output['html'] = '<p>El identificador del combate no es válido.</p>';
			}
		}else{
			$output['html'] = '<p>La sesión ha expirado. Necesitas volver a hacer login.</p>';
		}
		echo CJSON::encode($output);

	}
	/**
	 * Accept or rejec a challenge.
	 */
	public function actionResponseChallenge(){
		$output = array(
			'errno'=>1,
			'html'=>'',
		);
		
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check input
			if( isset($_GET['action']) && ($_GET['action']=='accept' || $_GET['action']=='reject' ) &&
					isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0
			){
				//Check if combat exit
				$arrayWith = array(
						array( 'fromKnight' => array( 'knightsCard' ) ),
						array( 'toKnight' => array( 'knightsCard' ) ),
						'combatsPrecombat'
				);
				$combat = Combats::model()->with( $arrayWith )->findByPk( $_GET['id'] );
				//ECHO $combat->fromKnight->knightsCard->act;DIE();
				if( $combat ){
					//Check if combat is in status
					if( $combat->status == Combats::STATUS_PENDING){
						//Check if knights are free to combat
						if( $combat->fromKnight->status == Knights::STATUS_ENABLE && $combat->toKnight->status == Knights::STATUS_ENABLE ){
							//Check if user is in combat
							if( $combat->toKnight->id == Yii::app()->user->knights_id  ){
								//check if rival is connected
								//if( Sessions::model()->exists( 'users_id = :users_id AND expire > :expire', array(':users_id'=>$combat->fromKnight->users_id,':expire'=>time())) ){
									 
								if(  Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].$combat->fromKnight->id ) ){
									//Update combat
									if( $_GET['action'] == 'accept'){
										$combat->status = Combats::STATUS_ENABLE;
									}else{
										$combat->status = Combats::STATUS_FINISHED;
										$combat->result = Combats::RESULT_REJECT;
										$output['html'] = '<p>¡COMBATE RECHAZADO!</p><p>Sales de la sala lo más dignamente posible antes de que las lágrimas broten de tus ojos. Este acto de cobardía te perseguirá toda tu vida.</p>';
									}
									if( $combat->save() ){
										//Update cache combat
										Yii::app()->cache->set(  Yii::app()->params['cacheKeys']['combat'].$combat->id, $combat, Yii::app()->params['cachetime']['combat'] );
										if( $_GET['action'] == 'accept'){
											/*
											 * Create PRECOMBAT
											*/
											//For random
											srand();
											$from_knight_fans_throw = rand(1, 10);
											$to_knight_fans_throw = rand(1, 10);
	
											//Get cache of knights depending of his fame
											$from_knight_fame =  floor( ($combat->fromKnight->knightsCard->charisma + $combat->fromKnight->knightsCard->act)/2);
											$to_knight_fame =  floor( ($combat->toKnight->knightsCard->charisma + $combat->toKnight->knightsCard->act)/2);
											$from_knight_appRulesLevel = AppRulesLevel::model()->find( 'level=:level', array( ':level'=>$from_knight_fame ));
											$to_knight_appRulesLevel = AppRulesLevel::model()->find( 'level=:level', array( ':level'=>$to_knight_fame ));
	
	
											//Calculate gate
											$from_knight_prize_by_entrance = round( $from_knight_appRulesLevel->cache/($from_knight_fame+11/2), 2);
											$to_knight_prize_by_entrance =  round( $to_knight_appRulesLevel->cache/($to_knight_fame+11/2), 2);
											$from_knight_gate = round( ($from_knight_fame+$from_knight_fans_throw)*$from_knight_prize_by_entrance , 2);
											$to_knight_gate = round( ($to_knight_fame+$from_knight_fans_throw)*$to_knight_prize_by_entrance, 2);
	
	
											$precombat = new CombatsPrecombat();
											$precombat->attributes = array(
													'combats_id' => $combat->id,
													'from_knight_cache'=> $from_knight_appRulesLevel->cache,
													'from_knight_fame'=> $combat->fromKnight->knightsCard->charisma + $combat->fromKnight->knightsCard->act,
													'from_knight_fans_throw'=> $from_knight_fans_throw,
													'to_knight_cache'=>  $to_knight_appRulesLevel->cache,
													'to_knight_fame'=> $combat->toKnight->knightsCard->charisma + $combat->toKnight->knightsCard->act,
													'to_knight_fans_throw'=> $to_knight_fans_throw,
													'from_knight_gate'=>$from_knight_gate,
													'to_knight_gate'=>$to_knight_gate
											);
											if( $precombat->save() ){
													
												//Make first round
												$roundOne = new Rounds();
												$roundOne->attributes = array(
														'combats_id'=>$combat->id,
														'number'=>1,
														'status'=>Rounds::STATUS_PENDING
												);
												if( $roundOne->save() ){
	
													//Change status of knights in combat mode
													$combat->fromKnight->status = Knights::STATUS_AT_COMBAT;
													if( !$combat->fromKnight->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar el caballero from con status en combate' );
													//Update caches
													Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$combat->fromKnight->id, $combat->fromKnight, Yii::app()->params['cachetime']['knight']  );													
													Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$combat->fromKnight->name, $combat->fromKnight, Yii::app()->params['cachetime']['knight']  );
													
													
													$combat->toKnight->status = Knights::STATUS_AT_COMBAT;
													if( !$combat->toKnight->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar el caballero to knight con status en combate' );
													Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$combat->toKnight->id, $combat->toKnight, Yii::app()->params['cachetime']['knight']  );
													Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$combat->toKnight->name, $combat->toKnight, Yii::app()->params['cachetime']['knight']  );
	
													/*
													 * Check stats vs
													*/
													$from_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent', array( ':knights_id'=>$combat->fromKnight->id, ':opponent'=>$combat->toKnight->id ) );
													//If not exist we make a new
													if( !$from_knight_stats_vs ){
														$from_knight_stats_vs = new KnightsStatsVs();
														$from_knight_stats_vs->attributes = array(
																'knights_id'=>$combat->fromKnight->id,
																'opponent'=>$combat->toKnight->id,
																'money_total_earned'=>0
														);
														$from_knight_stats_vs->save();
													}
													$to_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent', array( ':knights_id'=>$combat->toKnight->id, ':opponent'=>$combat->fromKnight->id ) );
													if( !$to_knight_stats_vs ){
														$to_knight_stats_vs = new KnightsStatsVs();
														$to_knight_stats_vs->attributes = array(
																'knights_id'=>$combat->toKnight->id,
																'opponent'=>$combat->fromKnight->id,
																'money_total_earned'=>0
														);
														$to_knight_stats_vs->save();
													}
													/*
													 * Check stats by day
													*/
													$from_knight_stats_by_day = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array( ':knights_id'=>$combat->fromKnight->id, ':date'=>substr($combat->date, 0,10) ) );
													if(!$from_knight_stats_by_day){
														$from_knight_stats_by_day = new KnightsStatsByDate();
														$from_knight_stats_by_day->attributes = array(
																'knights_id'=>$combat->fromKnight->id,
																'date'=>substr($combat->date, 0,10)
														);
														if( !$from_knight_stats_by_day->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido crear la nueva columna de stats por dia del caballero from knight.', 'error' );
													}
													$to_knight_stats_by_day = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array( ':knights_id'=>$combat->toKnight->id, ':date'=>substr($combat->date, 0,10) ) );
													if(!$to_knight_stats_by_day){
														$to_knight_stats_by_day = new KnightsStatsByDate();
														$to_knight_stats_by_day->attributes = array(
																'knights_id'=>$combat->toKnight->id,
																'date'=>substr($combat->date, 0,10)
														);
														if( !$to_knight_stats_by_day->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido crear la nueva columna de stats por dia del caballero to knight.', 'error' );
													}
	
													//Update gained coins
													/*
													$from_knight_stats = KnightsStats::model()->findByPk( $combat->fromKnight->id );
													$from_knight_stats->money_total_earned += $precombat->from_knight_gate;
													$from_knight_stats_vs->money_total_earned += $precombat->from_knight_gate;
													if( $precombat->from_knight_gate > $from_knight_stats->money_maximum_earned_combat ) $from_knight_stats->money_maximum_earned_combat = $precombat->from_knight_gate;
													if( $precombat->from_knight_gate > $from_knight_stats_vs->money_maximum_earned_combat ) $from_knight_stats_vs->money_maximum_earned_combat = $precombat->from_knight_gate;
													if( $from_knight_stats->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar las stats de from knight', 'error' );
													if( $from_knight_stats_vs->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar las stats vs de from knight', 'error' );
													unset( $from_knight_stats );
													unset( $from_knight_stats_vs );
													$to_knight_stats = KnightsStats::model()->findByPk( $combat->toKnight->id );
													$to_knight_stats->money_total_earned += $precombat->to_knight_gate;
													$to_knight_stats_vs->money_total_earned += $precombat->to_knight_gate;
													if( $precombat->to_knight_gate > $to_knight_stats->money_maximum_earned_combat ) $to_knight_stats->money_maximum_earned_combat = $precombat->to_knight_gate;
													if( $precombat->to_knight_gate > $to_knight_stats_vs->money_maximum_earned_combat ) $to_knight_stats_vs->money_maximum_earned_combat = $precombat->to_knight_gate;
													if( $to_knight_stats->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar las stats de to knight', 'error' );
													if( $to_knight_stats_vs->save() ) Yii::trace( '[CHARACTER][actionResponseChallenge] No se ha podido actualizar las stats vs de to knight', 'error' );
													unset( $to_knight_stats );
													unset( $to_knight_stats_vs );
													*/
	
	
													//return precombat
													$combat->combatsPrecombat = $precombat;
													$output['errno'] = 0;
													$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_pre_combat.php', array( 'combat'=>$combat), true );
												}else{
													$output['html'] = '<p>Se ha producido un error al registrar la primera ronda.</p>';
													//REturn status of combat
													$combat->status = Combats::STATUS_PENDING;
													$combat->save();
													$precombat->delete();
												}
											}else{
												$combat->status = Combats::STATUS_PENDING;
												$combat->save();
												$output['html'] = '<p>Se ha producido un error al registrar el precombate.</p>';
											}
										}
									}else{
										$output['html'] = '<p>Se ha producido un error al registrar la respuesta.</p>';
									}
								}else{
									$output['html'] = '<p>¡Sir '.$combat->fromKnight->name.' ya no está conectado!</p><p>Tendrás que esperar a que se conecte para poder machacarle...</p>';
									//echo '('.Yii::app()->cache->get( Yii::app()->params['cachekey']['knight_connected'].$this->knight->id ).' - ('.Yii::app()->cache->get( Yii::app()->params['cacheKey']['knight_connected'].$combat->fromKnight->users_id ).')';
									
								}
							}else{
								$output['html'] = '<p>No te corresponde a ti aceptar o rechazar este combate.</p>';
							}
						}else{
							$output['html'] = '<p>Algún caballero o ya está combatiendo o está trabajando.</p>';
						}
					}else{
						$output['html'] = '<p>El combate no está pendiente de aceptar o rechazar.</p>';
					}
				}else{
					$output['html'] = '<p>El identificador no es válido.</p>';
				}
			}else{
				//Input no ovalid
				$output['html'] = '<p>Los datos recibidos no son válidos.</p>';
			}
		}else{
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}

		echo CJSON::encode($output);
	}

	/**
	 * Return dialog of pre-combat from combat
	 */
	public function actionShowPrechallenge(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check input combat
			if( isset($_GET['id']) && is_numeric( $_GET['id']) && $_GET['id']>0 ){
				//Check if exist this pre-combat
				//Check if combat exit
				$arrayWith = array(
						array( 'fromKnight' => array( 'knightsCard' ) ),
						array( 'toKnight' => array( 'knightsCard' ) ),
						'rounds',
						'combatsPrecombat'
				);
				$combat = Combats::model()->with( $arrayWith )->findByPk( $_GET['id'] );
				if( $combat ){
					//Check if combat is enable without rounds
					if( count( $combat->rounds ) == 1 ){
						//Check if user is in combat
						if( Yii::app()->user->knights_id == $combat->fromKnight->id || Yii::app()->user->knights_id == $combat->toKnight->id  ){
							$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_pre_combat.php', array( 'combat'=>$combat), true );
							$output['errno'] = 0;
						}else{
							$output['html'] = '<p>Sólo los implicados en el combate pueden manejarlo.</p>';
						}
					}else{
						$output['html'] = '<p>El desafio ya ha empezado.</p>';
					}
				}else{
					$output['html'] = '<p>Ese desafio no se ha realizado nunca.</p>';
				}
			}else{
				$output['html'] = '<p>Los datos recibidos no son válidos.</p>';
			}
		}else{
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}
		echo CJSON::encode( $output );
	}

	public function actionShowPendingRoundDialog(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check if user is in his page
			if( Yii::app()->user->knights_id == $this->knight->id ){
				//Check input
				if( isset($_GET['id']) && is_numeric( $_GET['id'] ) && $_GET['id']>0 ){
					//Search combat
					$combat = Combats::model()->with( 'rounds' )->find( 'id=:id', array(':id' =>$_GET['id'] ) );
					if( $combat ){
						//Check if status is enable
						if( $combat->status == Combats::STATUS_ENABLE ){
							//Check if user is in combat
							if( Yii::app()->user->knights_id == $combat->from_knight || Yii::app()->user->knights_id == $combat->to_knight ){
								//Check the last round is pending
								if( $combat->rounds[ count($combat->rounds )-1 ]->status == Rounds::STATUS_PENDING ){
										
									//cargamos el inventario del caballero
									$item_list = Inventory::model()->findAll( 'knights_id=:knights_id', array( ':knights_id'=>$this->knight->id ) );
									$inventory = array();
										
									foreach( $item_list as $item ){
										switch( $item->type ){
											case Inventory::EQUIPMENT_TYPE_ARMOUR:
												$armours_object = ArmoursObjects::model()->with( array( 'armours' => array( 'with'=> array('type0', 'armoursMaterials', 'equipmentSize', 'equipmentQualities', 'equipmentRarity'  ) ) ) )->find( 't.id=:id', array( ':id'=>$item->identificator ) );
													
												$item_info['armours_id'] = $armours_object->armours->id;
												$item_info['name'] = $armours_object->armours->name;
												$item_info['armoursPDE'] = $armours_object->armours->pde;
												$item_info['current_pde'] = $armours_object->current_pde;
													
												$item_info['armours_type_name'] = $armours_object->armours->type0->name;
												$item_info['armoursMaterialName'] = $armours_object->armours->armoursMaterials->name;
												$item_info['armoursMaterialEndurance'] = $armours_object->armours->armoursMaterials->endurance;
												$item_info['armoursMaterialPrize'] = $armours_object->armours->armoursMaterials->prize;
												$item_info['armoursMaterialName'] = $armours_object->armours->armoursMaterials->name;
												$item_info['equipmentSizeName'] = $armours_object->armours->equipmentSize->name;
												$item_info['equipmentQualitiesName'] = $armours_object->armours->equipmentQualities->name;
												$item_info['equipmentRarityName'] = $armours_object->armours->equipmentRarity->name;
													
												$template = 'armour';
												break;
											case Inventory::EQUIPMENT_TYPE_SPEAR:
												$spears_object = SpearsObjects::model()->with( array( 'spears' => array( 'with'=> array('equipmentQualities', 'equipmentRarity', 'equipmentSize', 'spearsMaterials', 'spearsObjects'  ) ) ) )->find( 't.id=:id', array( ':id'=>$item->identificator ) );
												$item_info['spears_id'] = $spears_object->spears->id;
												$item_info['name'] = $spears_object->spears->name;
												$item_info['PDE'] = $spears_object->spears->pde;
												$item_info['current_pde'] = $spears_object->current_pde;
												$item_info['spears_damage'] = $spears_object->spears->damage;
												$item_info['spearPrize'] = $spears_object->spears->prize;
												$item_info['spearsMaterialName'] = $spears_object->spears->spearsMaterials->name;
												$item_info['equipmentQualitiesName'] = $spears_object->spears->equipmentQualities->name;
												$item_info['equipmentSizeName'] = $spears_object->spears->equipmentSize->name;
												$item_info['equipmentRarityName'] = $spears_object->spears->equipmentRarity->name;
													
													
													
												$template = 'spear';
												break;
											case Inventory::EQUIPMENT_TYPE_TRICK:
												//FALTA DEFINIR LOS TRICKS!!
												$template = 'trick';
												break;
										}
											
											
										$data_template = array(
												'item'=>$item,
												'item_info'=>$item_info
										);
										$inventory[ $item->position ] = $this->renderFile( Yii::app()->basePath.'/views/character/item_'.$template.'.php', $data_template, true );

									}
										
										
									//return html
									$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_pending_round.php', array( 'inventory'=>$inventory ), true );
									$output['errno'] = 0;
								}else{
									$output['html'] = '<p>La última ronda no está pendiente.</p>';
								}
							}else{
								$output['html'] = '<p>No participas en este combate.</p>';
							}
						}else{
							$output['html'] = '<p>No se puede mostrar si el desafio no está en curso.</p>';
						}
					}else{
						$output['html'] = '<p>No se ha encontrado el desafio.</p>';
					}
				}else{
					$output['html'] = '<p>Los datos de entrada no tienen un formato válido.</p>';
				}
			}else{
				$output['html'] = '<p>Sólo puedes toquetear tu caballero.</p>';
			}
		}else{
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}

		echo CJSON::encode( $output );

	}

	/**
	 *
	 */
	public function actionShowRoundSelectedPointsDialog(){

		$output = array(
				'errno'=>1,
				'html'=>''
		);
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check if user is in his page
			if( Yii::app()->user->knights_id == $this->knight->id ){

				//Check if position object of shield
				$sql = "SELECT
						inventory.type as inventory_type,
						armours.id as armour_id,
						armours.type as armour_type
						FROM
						inventory
						INNER JOIN armours_objects ON armours_objects.id = inventory.identificator
						INNER JOIN armours ON armours.id = armours_objects.armours_id
						WHERE
						inventory.knights_id = :knights_id AND inventory.position = :position ";
				$command = Yii::app()->db->createCommand( $sql );
				$command->bindValue( ':knights_id', Yii::app()->user->knights_id );
				$command->bindValue( ':position', Inventory::POSITION_SHIELD );
				$result = $command->queryAll();

				//return html
				$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_attack_defense_points.php', array( 'result'=>$result), true );
				$output['errno'] = 0;

			}else{
				$output['html'] = '<p>Sólo puedes toquetear tu caballero.</p>';
			}
		}else{
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}

		echo CJSON::encode( $output );
	}

	/**
	 * Set combats points
	 */
	public function actionSetCombatPoints(){
		Yii::trace( '[CHARACTER][actionSetCombatPoints] Start' );
		
		$output = array(
				'errno'=>1,
				'html'=>'',				
				'isFinishedRound'=>false,
				'isCombatFinished'=>false,
				'round_id'=>null
		);
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check if user is in his page
			if( Yii::app()->user->knights_id == $this->knight->id ){
				//Check if input is valid
				if( isset($_GET['combat']) && is_numeric( $_GET['combat']) && $_GET['combat']>0 &&
						isset($_GET['attack_position']) && is_numeric( $_GET['attack_position']) && $_GET['attack_position']>0 &&
						isset($_GET['defense_position']) && is_numeric( $_GET['defense_position']) && $_GET['defense_position']>0  ){
					//Check if combat exist
					$combat = Combats::model()->with( 'rounds' )->findByPk( $_GET['combat'] );
					if( $combat ){
						//Check status of combat
						if( $combat->status == Combats::STATUS_ENABLE){
							//Check if user is in combat
							if( Yii::app()->user->knights_id == $combat->from_knight || Yii::app()->user->knights_id == $combat->to_knight  ){
								//Check if last round is pending
								$output['round_id'] = count($combat->rounds);
								if( $combat->rounds[ $output['round_id'] - 1 ]->status == Rounds::STATUS_PENDING ){
									 
									//Check if user has data for this round
									$roundData = RoundsData::model()->find( 'rounds_combats_id=:rounds_combats_id AND rounds_number=:rounds_number AND knights_id=:knights_id', array(':rounds_combats_id'=>$combat->id, ':rounds_number'=>$combat->rounds[ count($combat->rounds) -1 ]->number, ':knights_id'=>Yii::app()->user->knights_id ) );
									if( !$roundData ){

										//Check if rival set attack and defense
										if( $combat->from_knight == Yii::app()->user->knights_id ){
											$rival_id = $combat->to_knight;
										}else{
											$rival_id = $combat->from_knight;
										}
										$roundDataRival = RoundsData::model()->find( 'rounds_combats_id=:rounds_combats_id AND rounds_number=:rounds_number AND knights_id=:knights_id', array(':rounds_combats_id'=>$combat->id, ':rounds_number'=>$combat->rounds[ count($combat->rounds) - 1]->number, ':knights_id'=> $rival_id) );


										//Load knight card
										$knights_card = $this->knight->knightsCard;


										/*
										 * LOAD EQUIPMENT IN USE (spear, shield and armour) for this knight user
										*/
										if( $roundDataRival ){
											//Load spear, shield and armour. We have armour position of impact
											$from_knight_received_impact_inventory_position = Inventory::getPositionFromAttackPosition( $roundDataRival->attack_point );
											Yii::trace( '[CHARACTER][actionSetCombatPoints] Load equipment in use with attack position ('.$roundDataRival->attack_point.') and position in inventory ('.$from_knight_received_impact_inventory_position.')' );
											$user_knight_equipment = Inventory::getCurrentEquipment4Round( Yii::app()->user->knights_id, $from_knight_received_impact_inventory_position );
										}else{
											//Load only spear and shield.
											$from_knight_received_impact_inventory_position = null;
											Yii::trace( '[CHARACTER][actionSetCombatPoints] Load equipment in use without attack position.' );
											$user_knight_equipment = Inventory::getCurrentEquipment4Round( Yii::app()->user->knights_id);
										}

										//Check if user has all equipment
										if( $user_knight_equipment['spear_object'] != null &&
												$user_knight_equipment['shield_object'] != null &&
												((!$roundDataRival) || ($roundDataRival && $user_knight_equipment['armour_object'] != null)) ){

											//Insert round data for user
											srand();
											$roundData = new RoundsData();
											$roundData->attributes = array(
													'rounds_combats_id' => $combat->id ,
													'rounds_number'=> count( $combat->rounds ),
													'knights_id' => Yii::app()->user->knights_id,
													'date'=> date('Y-m-d H:i:s'),
													'knights_endurance'=> $this->knight->endurance,
													'knights_life'=>$this->knight->life,
													'knights_pain'=> $this->knight->pain,
													'attack_point'=> $_GET['attack_position'],
													'defense_point'=> $_GET['defense_position'],
													'pain_throw' => ($this->knight->pain)?rand(1,10):null,
													'knights_will'=> $knights_card->will,
													'knights_concentration'=> $knights_card->concentration,
													'knights_skill'=> $knights_card->skill,
													'knights_dexterity'=> $knights_card->dexterity,
													'knights_spear' => $knights_card->spear,
													'knights_shield'=> $knights_card->shield,
													'knights_constitution'=> $knights_card->constitution,
													'armour_id'=> ($user_knight_equipment['armour']!=null)?$user_knight_equipment['armour']->id:null,
													'armour_object_pde_initial'=> ($user_knight_equipment['armour_object']!=null)?$user_knight_equipment['armour_object']->current_pde:null,
													'shield_id'=> $user_knight_equipment['shield']->id,
													'shield_object_pde_initial'=> $user_knight_equipment['shield_object']->current_pde,
													'spears_id'=> $user_knight_equipment['spear']->id,
													'spears_object_pde_initial'=> $user_knight_equipment['spear_object']->current_pde,
													'attack_throw'=> rand(1,10),
													'defense_throw'=> rand(1,10)
											);
												
											/*
											 * STATS ATTACK AND DEFENSE POINTS
											*/
											$sql = "UPDATE knights_stats_attack_location
													SET amount = amount +1
													WHERE knights_id = :knights_id1 AND location = :location1;";
											$command = Yii::app()->db->createCommand($sql);
											$command->bindValue( ':knights_id1', Yii::app()->user->knights_id);
											$command->bindValue( ':location1', $_GET['attack_position']);
											if( $command->execute() == 0 ) Yii::trace( '[CHARACTER][actionSetCombatPoints] No se ha podido actualizar las estadisticas de el punto de ataque', 'error' );
											$command->text = "INSERT INTO knights_stats_defense_location (knights_id, location, armours_type, amount)
													VALUES ( :knights_id2, :location2, :armours_type2, 1)
													ON DUPLICATE KEY UPDATE amount = amount + 1;";
											$command->bindValue( ':knights_id2', Yii::app()->user->knights_id);
											$command->bindValue( ':location2', $_GET['defense_position']);
											$command->bindValue( ':armours_type2', $user_knight_equipment['shield']->type);
											if( $command->execute() == 0 ) Yii::trace( '[CHARACTER][actionSetCombatPoints] No se ha podido actualizar las estadisticas de el punto de defensa', 'error' );
											/*
											 $knight_statsAttackLocation = KnightsStatsAttackLocation::model()->find( 'knights_id = :knights_id AND location = :location', array(':knights_id'=>Yii::app()->user->knights_id, ':location'=>$_GET['attack_position'] ) );
											$knight_statsAttackLocation->amount += 1;
											if( !$knight_statsAttackLocation->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] Las estadisticas de locaclizacion de punto de ataque no se ha podido salvar', 'error' );
											unset( $knight_statsAttackLocation );
												
											$knight_statsDefenseLocation = KnightsStatsDefenseLocation::model()->find( 'knights_id = :knights_id AND location = :location', array(':knights_id'=>Yii::app()->user->knights_id, ':location'=>$_GET['attack_position'] ) );
											if( ! $knight_statsDefenseLocation ){
											$knight_statsDefenseLocation = new KnightsStatsDefenseLocation();
											$knight_statsDefenseLocation = 0;
											$knight_statsDefenseLocation->armours_type = $user_knight_equipment['shield']->type;
											}
											$knight_statsDefenseLocation->amount += 1;
											if( !$knight_statsDefenseLocation->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] Las estadisticas de locaclizacion de punto de defensa no se ha podido salvar', 'error' );
											unset( $knight_statsDefenseLocation );
											*/
												
												
											//Resolve combat if all data is insert
											if( $roundDataRival ){
												Yii::trace( '[CHARACTER][actionSetCombatPoints] RESOLVIENDO COMBATE' );
												$roundData->received_impact_inventory_position = $from_knight_received_impact_inventory_position;

												//Load inventory attack position
												$roundDataRival->received_impact_inventory_position = Inventory::getPositionFromAttackPosition( $roundData->attack_point );

												/*
												 * LOAD EQUIPMENT IN USE (spear, shield and armour) for this knight user
												*/
												$rival_knight_equipment = Inventory::getCurrentEquipment4Round($roundDataRival->knights_id, $roundDataRival->received_impact_inventory_position );

												//Load de armour by the attack point of user
												//$inventoryRival = Inventory::model()->find( 'knights_id=:knights_id AND position=:position', array( ':knights_id'=>$roundDataRival->knights_id,':position'=>$roundDataRival->received_impact_inventory_position ) );
												//echo "idetificaor:".$inventoryRival->identificator;
												//$armour_rival = ArmoursObjects::model()->findByPk( $inventoryRival->identificator );


												$roundDataRival->armour_id = $rival_knight_equipment['armour_object']->armours_id;
												$roundDataRival->armour_object_pde_initial = $rival_knight_equipment['armour_object']->current_pde;


												/*
												 * Save data rival knight and resolve round
												*/
												if(  $roundDataRival->save() ){
													//Check who is the from_knight and to_knight
													if( $combat->from_knight == Yii::app()->user->knights_id ){
														$from_knight = $this->knight; //Knight object
														$from_knight_card = &$knights_card; //Knights_card object
														$from_knight_round_data = &$roundData; //Round data
														$from_knight_equipment = &$user_knight_equipment;//Equipment
														$to_knight = Knights::model()->with( 'knightsCard' )->findByPk( $combat->to_knight );
														$to_knight_card = $to_knight->knightsCard;
														$to_knight_round_data = &$roundDataRival;
														$to_knight_equipment = &$rival_knight_equipment;
													}else{
														$from_knight = Knights::model()->with('knightsCard')->findByPk( $combat->from_knight );
														$from_knight_card = $from_knight->knightsCard;
														$from_knight_round_data = &$roundDataRival;
														$from_knight_equipment = &$rival_knight_equipment;
														$to_knight = &$this->knight;
														$to_knight_card = &$knights_card;
														$to_knight_round_data = &$roundData;
														$to_knight_equipment = &$user_knight_equipment;
													}
														
													/*
													 * RESOLVE ROUND
													*/
													$output['isFinishedRound'] = true;
													
													//Init default status rounds
													$from_knight_round_data->status = RoundsData::STATUS_RESISTED;
													$to_knight_round_data->status = RoundsData::STATUS_RESISTED;
														
													//Check pain value.
													Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECKEANDO TIRADAS DE DOLOR' );
													$from_knight_pain = $from_knight_round_data->knights_pain;
													if( $from_knight_pain > 0 ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] Tirada dolor from knight: voluntad('.$from_knight_round_data->knights_will.')+concentracion('.$from_knight_round_data->knights_concentration.')+tirada('.$from_knight_round_data->pain_throw.') > 18' );
														if( $from_knight_round_data->knights_will+$from_knight_round_data->knights_concentration+$from_knight_round_data->pain_throw > 18 ){
															$from_knight_round_data->is_pain_throw_pass = 1;
															$from_knight_pain = 0;
														}else{
															$from_knight_round_data->is_pain_throw_pass = 0;
														}
													}

													$to_knight_pain = $to_knight_round_data->knights_pain;
													if( $to_knight_pain > 0 ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] Tirada dolor to knight: voluntad('.$to_knight_round_data->knights_will.')+concentracion('.$to_knight_round_data->knights_concentration.')+tirada('.$to_knight_round_data->pain_throw.') > 18' );
														if($to_knight_round_data->knights_will+$to_knight_round_data->knights_concentration+$to_knight_round_data->pain_throw > 18 ){
															$to_knight_round_data->is_pain_throw_pass = 1;
															$to_knight_pain = 0;
														}else{
															$to_knight_round_data->is_pain_throw_pass = 0;
														}
													}
														
													//Calculate if impact is defended and add shield endurance
													Yii::trace( '[actionSetCombatPoints] CRUZANDO ATAQUE Y DEFENSAS' );
													$from_knight_shield_endurance = 0;
													$to_knight_shield_endurance = 0;
													if( Rounds::isImpactDefended($to_knight_round_data->attack_point, $from_knight_round_data->defense_point, Armours::getWidthShield($from_knight_equipment['shield']->type), Armours::getHeightShield($from_knight_equipment['shield']->type) ) ){
														Yii::trace( '[actionSetCombatPoints] from knight defiende el impacto' );
														$from_knight_shield_endurance= $from_knight_equipment['shield']->endurance;
														$from_knight_round_data->is_received_impact_defended = 1;
													}
														
													if( Rounds::isImpactDefended($from_knight_round_data->attack_point, $to_knight_round_data->defense_point, Armours::getWidthShield($to_knight_equipment['shield']->type), Armours::getHeightShield($to_knight_equipment['shield']->type) ) ){
														Yii::trace( '[actionSetCombatPoints] to knight defiende el impacto' );
														$to_knight_shield_endurance= $to_knight_equipment['shield']->endurance;
														$to_knight_round_data->is_received_impact_defended = 1;
													}
														
													/*
													 * CALCULATE DAMAGE
													*/
													Yii::trace( '[actionSetCombatPoints] CALCULO DE DAÑO' );
													$from_knight_damage = Rounds::calculateDamage(
															$to_knight_round_data,
															$from_knight_round_data,
															$to_knight_equipment['spear']->damage,
															$to_knight_pain,
															$from_knight_equipment['armour']->endurance,
															$from_knight_shield_endurance,
															$from_knight_pain
													);
													$from_knight_round_data->received_damage = $from_knight_damage['received_damage'];
													$from_knight_round_data->defended_damage = $from_knight_damage['defended_damage'];
													$from_knight_total_damage = ($from_knight_round_data->received_damage -$from_knight_round_data->defended_damage < 0)?0:$from_knight_round_data->received_damage -$from_knight_round_data->defended_damage;
													Yii::trace( '[actionSetCombatPoints] from knight daño recibido ('.$from_knight_round_data->received_damage.') daño defendido ('.$from_knight_round_data->defended_damage.')' );

													$to_knight_damage = Rounds::calculateDamage(
															$from_knight_round_data,
															$to_knight_round_data,
															$from_knight_equipment['spear']->damage,
															$from_knight_pain,
															$to_knight_equipment['armour']->endurance,
															$to_knight_shield_endurance,
															$to_knight_pain
													);
													$to_knight_round_data->received_damage = $to_knight_damage['received_damage'];
													$to_knight_round_data->defended_damage = $to_knight_damage['defended_damage'];
													$to_knight_total_damage = ($to_knight_round_data->received_damage-$to_knight_round_data->defended_damage<0)?0:$to_knight_round_data->received_damage-$to_knight_round_data->defended_damage;
													Yii::trace( '[actionSetCombatPoints] to knight daño recibido ('.$to_knight_round_data->received_damage.') daño defendido ('.$to_knight_round_data->defended_damage.')' );
														
													/*
													 * UPDATE PDE OF OBJECTS AND CALCULATE EXTRA DAMAGE
													*/
													$from_knight_round_data->pde_shield_loosed = 0;
													$from_knight_round_data->pde_armour_loosed = 0;
													Yii::trace( '[actionSetCombatPoints] CALCULANDO PDEs Y DAÑO EXTRA)' );
													if( $from_knight_total_damage > 0 ){
														//Check if impact is defend
														if( $from_knight_round_data->is_received_impact_defended ){
															//Check if shield can to get all damage
															if( $from_knight_round_data->shield_object_pde_initial - $from_knight_total_damage >= 0){
																//shield received all damage
																$from_knight_round_data->pde_shield_loosed = $from_knight_total_damage;
																$from_knight_equipment['shield_object']->current_pde -= $from_knight_total_damage;
																//Check if shield is destroy
																if( $from_knight_equipment['shield_object']->current_pde == 0 ) $from_knight_round_data->is_shield_destroyed = true;
															}else{
																//Shield is destroyed and armour is damage too
																$from_knight_round_data->is_shield_destroyed = 1;
																$from_knight_round_data->pde_shield_loosed = $from_knight_round_data->shield_object_pde_initial;
																$from_knight_equipment['shield_object']->current_pde = 0;
																$from_knight_round_data->pde_armour_loosed = $from_knight_total_damage - $from_knight_round_data->pde_shield_loosed;
																	
																//Check if Armour is destroyed and knight gets an extra damage
																if( $from_knight_round_data->pde_armour_loosed >= $from_knight_round_data->armour_object_pde_initial ){
																	$from_knight_round_data->pde_armour_loosed = $from_knight_round_data->armour_object_pde_initial;
																	$from_knight_round_data->is_armour_destroyed = 1;
																	$from_knight_equipment['armour_object']->pde = 0;
																	//check if there is extra damage
																	if( $from_knight_total_damage > $from_knight_round_data->pde_shield_loosed + $from_knight_round_data->pde_armour_loosed ){
																		$from_knight_round_data->extra_damage = $from_knight_total_damage - $from_knight_round_data->pde_shield_loosed - $from_knight_round_data->pde_armour_loosed;
																	}
																}
															}
														}else{
															//Check if armour can to get all damage
															if( $from_knight_total_damage >= $from_knight_round_data->armour_object_pde_initial ){
																//Armour crash and knight gets extra damage
																$from_knight_round_data->pde_armour_loosed = $from_knight_round_data->armour_object_pde_initial ;
																$from_knight_round_data->is_armour_destroyed = 1;
																$from_knight_equipment['armour_object']->current_pde = 0;
																//calculate extra damage
																$from_knight_round_data->extra_damage = $from_knight_total_damage -  $from_knight_round_data->pde_armour_loosed;
															}else{
																//armour receive all damage
																$from_knight_round_data->pde_armour_loosed = $from_knight_total_damage;
																$from_knight_equipment['armour_object']->current_pde -=  $from_knight_total_damage;
															}
														}
													}
														
														
													$to_knight_round_data->pde_shield_loosed = 0;
													$to_knight_round_data->pde_armour_loosed = 0;
													if( $to_knight_total_damage > 0 ){
														//Check if impact is defended
														if( $to_knight_round_data->is_received_impact_defended ){
															//Check if shield can to get all damage
															if( $to_knight_round_data->shield_object_pde_initial >= $to_knight_total_damage ){
																//shield received all damage
																$to_knight_round_data->pde_shield_loosed = $to_knight_total_damage;
																$to_knight_equipment['shield_object']->current_pde -= $to_knight_total_damage;
																//Check if shield is destroy
																if( $to_knight_equipment['shield_object']->current_pde == 0 ) $to_knight_round_data->is_shield_destroyed = true;
															}else{
																//Shield is destroyed and armour is damage too
																$to_knight_round_data->is_shield_destroyed = 1;
																$to_knight_round_data->pde_shield_loosed = $to_knight_round_data->shield_object_pde_initial;
																$to_knight_equipment['shield_object']->current_pde = 0;
																$to_knight_round_data->pde_armour_loosed = $to_knight_total_damage - $to_knight_round_data->pde_shield_loosed;
																	
																//Check if Armour is destroyed and knight gets an extra damage
																if( $to_knight_round_data->pde_armour_loosed >= $to_knight_round_data->armour_object_pde_initial ){
																	$to_knight_round_data->pde_armour_loosed = $to_knight_round_data->armour_object_pde_initial;
																	$to_knight_round_data->is_armour_destroyed = 1;
																	$to_knight_equipment['armour_object']->current_pde = 0;
																	//check if there is extra damage
																	if(  $to_knight_total_damage > $to_knight_round_data->pde_shield_loosed + $to_knight_round_data->pde_armour_loosed){
																		$to_knight_round_data->extra_damage = $to_knight_total_damage - $to_knight_round_data->pde_shield_loosed - $to_knight_round_data->pde_armour_loosed;
																	}
																}
															}
														}else{
															//Check if armour get all damage
															if( $to_knight_total_damage >= $to_knight_round_data->armour_object_pde_initial ){
																//Armour crash and knight gets extra damage
																$to_knight_round_data->pde_armour_loosed = $to_knight_round_data->armour_object_pde_initial;
																$to_knight_round_data->is_armour_destroyed = 1;
																$to_knight_equipment['armour_object']->current_pde = 0;
																//calculate extra damage
																$to_knight_round_data->extra_damage = $to_knight_total_damage - $to_knight_round_data->pde_armour_loosed;
															}else{
																//armour received all damage
																$to_knight_round_data->pde_armour_loosed = $to_knight_total_damage;
																$to_knight_equipment['armour_object']->current_pde -=  $to_knight_round_data->pde_armour_loosed;

															}
														}
													}
													//calculate pde of spear
													$pde_damage_spear = ($from_knight_equipment['spear']->damage <= $to_knight_total_damage)?0:$from_knight_equipment['spear']->damage - $to_knight_total_damage ;
													if( $from_knight_round_data->spears_object_pde_initial - $pde_damage_spear > 0){
														//Spear is not destroyed
														$from_knight_round_data->pde_spear_loosed = $pde_damage_spear;
														$from_knight_round_data->spears_object_pde_final = $from_knight_equipment['spear_object']->current_pde - $pde_damage_spear;
														$from_knight_equipment['spear_object']->current_pde = $from_knight_round_data->spears_object_pde_final;
													}else{
														//Spears is broken!
														$from_knight_round_data->pde_spear_loosed = $from_knight_round_data->spears_object_pde_initial;
														$from_knight_round_data->spears_object_pde_final = 0;
														$from_knight_round_data->is_spear_destroyed = 1;
														$from_knight_equipment['spear_object']->current_pde = 0;
													}
													$pde_damage_spear = ($to_knight_equipment['spear']->damage <= $from_knight_total_damage)?0:$to_knight_equipment['spear']->damage - $from_knight_total_damage;
													if( $to_knight_round_data->spears_object_pde_initial - $pde_damage_spear > 0){
														//Spear is not destroyed
														$to_knight_round_data->pde_spear_loosed = $pde_damage_spear;
														$to_knight_round_data->spears_object_pde_final = $to_knight_equipment['spear_object']->current_pde - $pde_damage_spear;
														$to_knight_equipment['spear_object']->current_pde = $to_knight_round_data->spears_object_pde_final;
													}else{
														//Spears is broken!
														$to_knight_round_data->pde_spear_loosed = $to_knight_round_data->spears_object_pde_initial;
														$to_knight_round_data->spears_object_pde_final = 0;
														$to_knight_round_data->is_spear_destroyed = 1;
														$to_knight_equipment['spear_object']->current_pde = 0;
													}
														
													Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight pde perdidos escudo ('.$from_knight_round_data->pde_shield_loosed.'), armadura('.$from_knight_round_data->pde_armour_loosed.'), lanza ('.$from_knight_round_data->pde_spear_loosed.'), daño extra ('.$from_knight_round_data->extra_damage.') ' );
													Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight pde perdidos escudo ('.$to_knight_round_data->pde_shield_loosed.'), armadura('.$to_knight_round_data->pde_armour_loosed.'), lanza ('.$to_knight_round_data->pde_spear_loosed.'), daño extra ('.$to_knight_round_data->extra_damage.') ' );
														
														
													//Update pde equipment
													Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE EQUIPMENT' );
													$from_knight_round_data->armour_object_pde_final = $from_knight_equipment['armour_object']->current_pde;
													$from_knight_round_data->shield_object_pde_final = $from_knight_equipment['shield_object']->current_pde;
													$from_knight_round_data->spears_object_pde_final = $from_knight_equipment['spear_object']->current_pde;
													$to_knight_round_data->armour_object_pde_final = $to_knight_equipment['armour_object']->current_pde;
													$to_knight_round_data->shield_object_pde_final = $to_knight_equipment['shield_object']->current_pde;
													$to_knight_round_data->spears_object_pde_final = $to_knight_equipment['spear_object']->current_pde;
														
														
														
													//Calculate new endurance of knights
													Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE ENDURANCE OF KNIGHTS' );
													$from_knight->endurance = $from_knight_round_data->knights_endurance - $from_knight_total_damage - $from_knight_round_data->extra_damage;
													$to_knight->endurance = $to_knight_round_data->knights_endurance - $to_knight_total_damage - $to_knight_round_data->extra_damage;
														
														
														
													//Calcula if knight fall. Fall is produced if pass one o more limits.
													Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK IF KNIGHTS  FALL' );
													if( $from_knight_round_data->is_falled = Rounds::checkFall(($from_knight_round_data->knights_will+$from_knight_round_data->knights_constitution)*3, $from_knight_round_data->knights_endurance, $from_knight->endurance ) ){
														$from_knight_round_data->status = RoundsData::STATUS_KNOCK_DOWN;
														Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight fall' );
													}
														
													if( $to_knight_round_data->is_falled = Rounds::checkFall(($to_knight_round_data->knights_will+$to_knight_round_data->knights_constitution)*3, $to_knight_round_data->knights_endurance, $to_knight->endurance ) ){
														$to_knight_round_data->status = RoundsData::STATUS_KNOCK_DOWN;
														Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight fall' );
													}

													//Check if knights are knock out
													Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK IF KNIGHTS ARE KNOCK OUT' );
													if( $from_knight->endurance == 0 ){
														$from_knight_round_data->is_falled = 1;
														$from_knight_round_data->status = RoundsData::STATUS_KNOCK_OUT;
														Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight is knock out' );
													}
													if( $to_knight->endurance == 0 ){
														$to_knight_round_data->is_falled = 1;
														$to_knight_round_data->status = RoundsData::STATUS_KNOCK_OUT;
														Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight is knock out' );
													}
														
													//Check injuries
													Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK INJURIES' );
													if( $from_knight->endurance < 0 ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight is injuried' );
														//Fall is obligatory
														$from_knight_round_data->is_falled = 1;

														//Load pain from new injury
														$from_knight_round_data->injury_type = Rounds::getInjuryType($from_knight->life, $from_knight_total_damage - $from_knight_round_data->knights_endurance );
														$from_knight_round_data->status = RoundsData::STATUS_INJURIED;
														$from_knight->pain = Rounds::getPainByInjuryType( $from_knight_round_data->injury_type );

													}
													if( $to_knight->endurance < 0 ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight is injuried' );
														//Fall is obligatory
														$to_knight_round_data->is_falled = 1;
															
														//Load pain from new injury
														$to_knight_round_data->injury_type = Rounds::getInjuryType($to_knight->life, $to_knight_total_damage - $to_knight_round_data->knights_endurance );
														$to_knight_round_data->status = RoundsData::STATUS_INJURIED;
														$to_knight->pain = Rounds::getPainByInjuryType( $to_knight_round_data->injury_type );
													}

													//Check final status of this round
													$round = Rounds::model()->find( 'combats_id = :combats_id AND number = :number', array( ':combats_id'=>$combat->id, ':number'=>count($combat->rounds) )   );
													if( $from_knight_round_data->is_falled == $to_knight_round_data->is_falled ){
														//Both are falled or not
														$round->status = Rounds::STATUS_DRAW;
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FINAL STATUS ROUND: DRAW' );
													}else{
														//One is falled and other is standing
														if( $from_knight_round_data->is_falled ){
															$round->status = Rounds::STATUS_TO_KNIGHT_WIN;
															Yii::trace( '[CHARACTER][actionSetCombatPoints] FINAL STATUS ROUND: TO KNIGHT WIN' );
														}else{
															$round->status = Rounds::STATUS_FROM_KNIGHT_WIN;
															Yii::trace( '[CHARACTER][actionSetCombatPoints] FINAL STATUS ROUND: FROM KNGHT WIN' );
														}
													}
														
														
													/*
													 * UPDATE ROUND
													*/
														
														
													//Update equipment
													Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE EQUIPMENT' );
													Inventory::updateOrDeleteEquipment( $from_knight_equipment['armour_object'] );
													Inventory::updateOrDeleteEquipment( $from_knight_equipment['shield_object'] );
													Inventory::updateOrDeleteEquipment( $from_knight_equipment['spear_object'] );
													Inventory::updateOrDeleteEquipment( $to_knight_equipment['armour_object'] );
													Inventory::updateOrDeleteEquipment( $to_knight_equipment['shield_object'] );
													Inventory::updateOrDeleteEquipment( $to_knight_equipment['spear_object'] );
														
													//Update round_data
													if( !$from_knight_round_data->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] ERROR TO SAVE FROM KNIGHT ROUND DATA', 'error' );
													if( !$to_knight_round_data->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] ERROR TO SAVE TO KNIGHT ROUND DATA', 'error' );
														
														
													//Round
													Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE ROUND' );
													if(!$round->save()) Yii::trace( '[CHARACTER][actionSetCombatPoints] ERROR TO UPDATE ROUND', 'warning');
														
													/*
													 * STATS
													*/
													$from_knight_stats = KnightsStats::model()->findByPk($from_knight->id );
													$to_knight_stats = KnightsStats::model()->findByPk($to_knight->id );
													$from_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$from_knight->id, ':opponent'=>$to_knight->id) );
													$to_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$to_knight->id, ':opponent'=>$from_knight->id) );
													$from_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$from_knight->id, ':date'=>substr($combat->date, 0,10) ) );
													$to_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$to_knight->id, ':date'=>substr($combat->date, 0,10) ) );
													if( !$from_knight_stats_by_date ){
														$from_knight_stats_by_date = new KnightsStatsByDate();
														$from_knight_stats_by_date = array(
																'knights_id'=>$combat->fromKnight->id,
																'date'=>date('Y-m-d')
														);
													}
													if( !$to_knight_stats_by_date ){
														$to_knight_stats_by_date = new KnightsStatsByDate();
														$to_knight_stats_by_date = array(
																'knights_id'=>$combat->toKnight->id,
																'date'=>date('Y-m-d')
														);
													}
														
													//Update stats
													$from_knight_stats->hits_total_produced += 1;
													$from_knight_stats_vs->hits_total_produced += 1;
													$from_knight_stats_by_date->hits_total_produced += 1;
													$to_knight_stats->hits_total_produced += 1;
													$to_knight_stats_vs->hits_total_produced += 1;
													$to_knight_stats_by_date->hits_total_produced += 1;
													$from_knight_stats->hits_total_received += 1;
													$from_knight_stats_vs->hits_total_received += 1;
													$from_knight_stats_by_date->hits_total_received += 1;
													$to_knight_stats->hits_total_received += 1;
													$to_knight_stats_vs->hits_total_received += 1;
													$to_knight_stats_by_date->hits_total_received += 1;
													$from_knight_stats->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
													$from_knight_stats_vs->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
													$from_knight_stats_by_date->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
													$to_knight_stats->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$to_knight_stats_vs->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$to_knight_stats_by_date->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$from_knight_stats->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$from_knight_stats_vs->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$from_knight_stats_by_date->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
													$to_knight_stats->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
													$to_knight_stats_vs->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
													$to_knight_stats_by_date->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
													if($to_knight_total_damage>0){
														$from_knight_stats->damage_total_produced += $to_knight_total_damage+$to_knight_round_data->extra_damage ;
														$from_knight_stats_vs->damage_total_produced += $to_knight_total_damage+$to_knight_round_data->extra_damage;
														$from_knight_stats_by_date->damage_total_produced += $to_knight_total_damage+$to_knight_round_data->extra_damage;
														$to_knight_stats->damage_total_received += $to_knight_total_damage+$to_knight_round_data->extra_damage;
														$to_knight_stats_vs->damage_total_received += $to_knight_total_damage+$to_knight_round_data->extra_damage;
														$to_knight_stats_by_date->damage_total_received += $to_knight_total_damage+$to_knight_round_data->extra_damage;
													}
													if( $from_knight_total_damage>0){
														$to_knight_stats->damage_total_produced += $from_knight_total_damage+$from_knight_round_data->extra_damage;
														$to_knight_stats_vs->damage_total_produced += $from_knight_total_damage+$from_knight_round_data->extra_damage;
														$to_knight_stats_by_date->damage_total_produced += $from_knight_total_damage+$from_knight_round_data->extra_damage;
														$from_knight_stats->damage_total_received += $from_knight_total_damage+$from_knight_round_data->extra_damage;
														$from_knight_stats_vs->damage_total_received += $from_knight_total_damage+$from_knight_round_data->extra_damage;
														$from_knight_stats_by_date->damage_total_received += $from_knight_total_damage+$from_knight_round_data->extra_damage;
													}
														
														
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $from_knight_stats->damage_maximum_produced ) $from_knight_stats->damage_maximum_produced = $to_knight_total_damage+$to_knight_round_data->extra_damage;
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $from_knight_stats_vs->damage_maximum_produced ) $from_knight_stats_vs->damage_maximum_produced = $to_knight_total_damage+$to_knight_round_data->extra_damage;
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $from_knight_stats_by_date->damage_maximum_produced ) $from_knight_stats_by_date->damage_maximum_produced = $to_knight_total_damage+$to_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $to_knight_stats->damage_maximum_produced ) $to_knight_stats->damage_maximum_produced = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $to_knight_stats_vs->damage_maximum_produced ) $to_knight_stats_vs->damage_maximum_produced = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $to_knight_stats_by_date->damage_maximum_produced ) $to_knight_stats_by_date->damage_maximum_produced = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $from_knight_stats->damage_maximum_received ) $from_knight_stats->damage_maximum_received = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $from_knight_stats_vs->damage_maximum_received ) $from_knight_stats_vs->damage_maximum_received = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $from_knight_total_damage+$from_knight_round_data->extra_damage > $from_knight_stats_by_date->damage_maximum_received ) $from_knight_stats_by_date->damage_maximum_received = $from_knight_total_damage+$from_knight_round_data->extra_damage;
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $to_knight_stats->damage_maximum_received ) $to_knight_stats->damage_maximum_received = $to_knight_total_damage+$to_knight_round_data->extra_damage;
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $to_knight_stats_vs->damage_maximum_received ) $to_knight_stats_vs->damage_maximum_received = $to_knight_total_damage+$to_knight_round_data->extra_damage;
													if( $to_knight_total_damage+$to_knight_round_data->extra_damage > $to_knight_stats_by_date->damage_maximum_received ) $to_knight_stats_by_date->damage_maximum_received = $to_knight_total_damage+$to_knight_round_data->extra_damage;
														
														
														
													/*
													 * CHECK IF COMBAT IS FINISHED
													* A combat is finished when knights is knock down 3 times, injuried or KO (endurance is 0 but not injuried)
													*/
													Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK IF COMBAT IS FINISHED' );
													//First, check if some knight is injuried
													if( $from_knight_round_data->status == RoundsData::STATUS_INJURIED || $to_knight_round_data->status == RoundsData::STATUS_INJURIED ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FINISH BY INJURIED' );
														//Combat is finished
														$combat->status = Combats::STATUS_FINISHED;

														//Combat result is by injury
														$combat->result_by = Combats::RESULT_BY_INJURY;

														if( $from_knight_round_data->status == $to_knight_round_data->status  ){
															//Both knights are injuried
															$combat->result = Combats::RESULT_DRAW;
															$combat->from_knight_injury_type = $from_knight_round_data->injury_type;
															$combat->to_knight_injury_type = $to_knight_round_data->injury_type;
															Yii::trace( '[CHARACTER][actionSetCombatPoints] draw combat by injury' );
														}else{
															//Check who is injuried knight
															if( $from_knight_round_data->status == RoundsData::STATUS_INJURIED ){
																//Win to_knight
																$combat->result = Combats::RESULT_TO_KNIGHT_WIN;
																$combat->from_knight_injury_type = $from_knight_round_data->injury_type;
																Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight win combat by injury' );
																	
															}else{
																//Win from_knight
																$combat->result = Combats::RESULT_FROM_KNIGHT_WIN;
																$combat->to_knight_injury_type = $to_knight_round_data->injury_type;
																Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight win combat by injury' );
															}
														}
														//Check if combat is finished by 3 fall
													}elseif( count( $combat->rounds) > 2  && ($from_knight_round_data->is_falled || $to_knight_round_data->is_falled) ) {
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FINISH BY 3 FALL' );
														//Check how many fall have knights
														$from_knight_total_fall = $to_knight_total_fall = 0;
														if( $from_knight_round_data->is_falled ) $from_knight_total_fall++;//Add last fall
														if( $to_knight_round_data->is_falled ) $to_knight_total_fall++;//Add last fall
														foreach( $combat->rounds as $round ){
															switch( $round->status ){
																case Rounds::STATUS_FROM_KNIGHT_WIN:
																	$to_knight_total_fall++;
																	break;
																case Rounds::STATUS_TO_KNIGHT_WIN:
																	$from_knight_total_fall++;
																	break;
																default:
																	//Nothing to do here
															}
														}

														//Check total combats
														if( $from_knight_total_fall== 3 || $to_knight_total_fall == 3){
															//Combat is finished by three fall
															$combat->status = Combats::STATUS_FINISHED;
															$combat->result_by = Combats::RESULT_BY_THREE_FALL;
																
															//Check result of combat
															if( $from_knight_total_fall == $to_knight_total_fall){
																$combat->result = Combats::RESULT_DRAW;
																Yii::trace( '[CHARACTER][actionSetCombatPoints] draw combat by three falls' );
															}else{
																if( $from_knight_total_fall == 3){
																	$combat->result = Combats::RESULT_TO_KNIGHT_WIN;
																	Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight win combat by three falls' );
																}else{
																	$combat->result = Combats::RESULT_FROM_KNIGHT_WIN_;
																	Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight win combat by three falls' );
																}
															}
														}
															
														//Check if somebody is KO.
													}elseif( $from_knight->endurance == 0 || $to_knight->endurance == 0 ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FINISH BY KO' );

														$combat->status = Combats::STATUS_FINISHED;
														$combat->result_by = Combats::RESULT_BY_KO;
														//Check result of combat
														if( $from_knight->endurance == $to_knight->endurance){
															$combat->result = Combats::RESULT_DRAW;
															Yii::trace( '[CHARACTER][actionSetCombatPoints] draw combat by ko' );
														}else{
															if( $from_knight->endurance == 0){
																$combat->result = Combats::RESULT_TO_KNIGHT_WIN;
																Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight win combat ko' );
															}else{
																$combat->result = Combats::RESULT_FROM_KNIGHT_WIN;
																Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight win combat by ko' );
															}
														}
														//Check if somebody has not enough equipment
													}elseif( $from_knight_equipment['armour_object']->current_pde == 0 || $from_knight_equipment['shield_object']->current_pde == 0 || $from_knight_equipment['spear_object']->current_pde == 0 ||
															$to_knight_equipment['armour_object']->current_pde == 0 || $to_knight_equipment['shield_object']->current_pde == 0 ||$to_knight_equipment['spear_object']->current_pde == 0  ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] NOT ENOUGH EQUIPMENT' );

														//Check if from knight armour, shield or spear are broken
														Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK SOMEBODY HAS NOT ENOGH EQUIPMENT' );
														if( ($from_knight_equipment['spear_object']->current_pde == 0 && !Inventory::checkHasReplacement( $from_knight->id,  Inventory::EQUIPMENT_TYPE_SPEAR, $from_knight_equipment['spear_object']->id ) ) ||
																($from_knight_equipment['armour_object']->current_pde == 0 && !Inventory::checkHasReplacement( $from_knight->id, $from_knight_equipment['armour']->type,  $from_knight_equipment['arnmour_object']->id ) ) ||
																($from_knight_equipment['shield_object']->current_pde == 0 && !Inventory::checkHasReplacement( $from_knight->id, $from_knight_equipment['shield']->type,  $from_knight_equipment['shield_object']->id ) )
														){
															Yii::trace( '[CHARACTER][actionSetCombatPoints] from knight has not replacement equipment' );
															$combat->status = Combats::STATUS_FINISHED;
															$combat->result = Combats::RESULT_TO_KNIGHT_WIN;
															$combat->result_by = Combats::RESULT_BY_NOT_EQUIPMENT_REPLACE;
														}
														if( ($to_knight_equipment['spear_object']->current_pde == 0 && !Inventory::checkHasReplacement( $to_knight->id, Inventory::EQUIPMENT_TYPE_SPEAR,  $to_knight_equipment['spear_object']->id) ) ||
																($to_knight_equipment['armour_object']->current_pde == 0 && !Inventory::checkHasReplacement( $to_knight->id, $to_knight_equipment['armour']->type,  $to_knight_equipment['armour_object']->id ) ) ||
																($to_knight_equipment['shield_object']->current_pde == 0 && !Inventory::checkHasReplacement( $to_knight->id, $to_knight_equipment['shield']->type,  $to_knight_equipment['shield_object']->id ) )
														){
															$combat->status = Combats::STATUS_FINISHED;
															$combat->result_by = Combats::RESULT_BY_NOT_EQUIPMENT_REPLACE;
															Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight has not replacement equipment' );
															//Check if previously from knight has not enogh equipment too.
															if( $combat->result == Combats::RESULT_TO_KNIGHT_WIN ){
																$combat->result = Combats::RESULT_DRAW;
															}else{
																$combat->result = Combats::RESULT_FROM_KNIGHT_WIN;
															}
														}
													}
														
													//if combat is finished then we save it and reset endurance and life of knight
													if( $combat->status == Combats::STATUS_FINISHED ){														
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FINISHED COMBAT -> SAVE COMBAT' );																												
														if( $combat->save() ){
															//Update combat cache
															Yii::app()->cache->set( Yii::app()->params['cacheKeys']['combat'].$combat->id, $combat, Yii::app()->params['cachetime']['combat'] );															
														}else{
															Yii::trace('[CHARACTER][actionSetCombatPoints]', 'error');
														}
														$output['isCombatFinished'] = true;

														//Reset Knights
														Yii::trace( '[actionSetCombatPoints] RESET KNIGHTS' );
														$from_knight->endurance = ($from_knight_card->will+$from_knight_card->constitution)*3;
														$from_knight->life = $from_knight_card->constitution*2;
														$from_knight->status = Knights::STATUS_ENABLE;
														$to_knight->endurance = ($to_knight_card->will+$to_knight_card->constitution)*3;
														$to_knight->life = $to_knight_card->constitution*2;
														$to_knight->status = Knights::STATUS_ENABLE;

														/*
														 * CALCULATE POSTCOMBAT
														*/
														//Calculate experience
														Yii::trace( '[CHARACTER][actionSetCombatPoints] CALCULATE EXPERIENCE' );
														$precombat = $combat->combatsPrecombat;
														$postcombatData = CombatsPostcombat::calculateEarnedExperience($combat, $from_knight->level, $to_knight->level);

														Yii::trace( '[CHARACTER][actionSetCombatPoints] SAVE POSTCOMBATS' );
														$from_knight_post_combat = new CombatsPostcombat();
														$from_knight_post_combat->attributes = array(
																'combats_id' => $combat->id,
																'knights_id' => $from_knight->id,
																'knight_rival_level' => $from_knight->level,
																'experience_generate' =>$postcombatData['from_knight_experience_generate'],
																'percent_by_result' =>$postcombatData['from_knight_percent_by_result'] ,
																'percent_by_injury' =>$postcombatData['from_knight_percent_by_injury'] ,
																'earned_experience' =>$postcombatData['from_knight_earned_experience'] ,
																'total_experience'=>$from_knight->experiencie_earned + $postcombatData['from_knight_earned_experience'],
																'total_coins'=>$precombat->from_knight_gate + $from_knight->coins,
																'earned_coins'=>$precombat->from_knight_gate,
																'injury_type'=>$from_knight_round_data->injury_type

														);
														if( !$from_knight_post_combat->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] se ha producido un error al salvar postcombate para from knight', 'error' );
															
														$to_knight_post_combat = new CombatsPostcombat();
														$to_knight_post_combat->attributes = array(
																'combats_id' => $combat->id,
																'knights_id' => $to_knight->id,
																'knight_rival_level' => $to_knight->level,
																'experience_generate' =>$postcombatData['to_knight_experience_generate'] ,
																'percent_by_result' =>$postcombatData['to_knight_percent_by_result'] ,
																'percent_by_injury' =>$postcombatData['to_knight_percent_by_injury'] ,
																'earned_experience' =>$postcombatData['to_knight_earned_experience'] ,
																'total_experience'=>$to_knight->experiencie_earned + $postcombatData['to_knight_earned_experience'],
																'total_coins'=>$precombat->to_knight_gate + $to_knight->coins,
																'earned_coins'=>$precombat->to_knight_gate,
																'injury_type'=>$to_knight_round_data->injury_type

														);

														if( !$to_knight_post_combat->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] se ha producido un error al salvar postcombate para to knight', 'error' );



														//Update experience of knights
														Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE EXPERIECE');
														$from_knight->experiencie_earned = $from_knight_post_combat->total_experience;
														$to_knight->experiencie_earned = $to_knight_post_combat->total_experience;

														/*
														 * Check if enable experience is less than 0 then downgrade last upgrade.
														*/
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FROM KNIGHT DOWNGRADE earned experience ('.$from_knight->experiencie_earned.') < used experience ('.$from_knight->experiencie_used.') ');
														if( $from_knight->experiencie_earned < $from_knight->experiencie_used ){

															//Select all evolution
															$knight_evolutions = KnightsEvolution::model()->findAll( 'knights_id = :knights_id ORDER BY date DESC', array(':knights_id'=>$from_knight->id) );
																
															if( $knight_evolutions ){
																	
																//Downgrade up to earned experience more than used experience
																$jump = 0;//Store jumps over rows with associate downgrade. Serveral downgrades would be consecutive
																foreach( $knight_evolutions as $evolution ){
																		
																	//Check if is a upgrade
																	if( $evolution->type == KnightsEvolution::TYPE_UPGRADE ){
																		if($jump>0 ){
																			$jump--;
																			continue;

																		}
																		//Add a downgrade
																		$downgrade = new KnightsEvolution();
																		$downgrade->attributes = array(
																				'knights_id'=> $from_knight->id,
																				'type'=>KnightsEvolution::TYPE_DOWNGRADE,
																				'characteristic'=> $evolution->characteristic,
																				'value'=>$evolution->value-1,
																				'experiencie_used'=>$evolution->experiencie_used,
																				'date'=>date('Y-m-d H:i:s'),
																				'combats_id'=>$combat->id
																		);
																		Yii::trace( '[CHARACTER][actionSetCombatPoints] Evolution value ('.$evolution->value.') downgrade ('.$downgrade->value.')' );
																		if( !$downgrade->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] From knight downgrade not save', 'error' );
																		
																		//Add to time line downgrade
																		//Load events tables
																		$knights_events = new KnightsEvents();
																		$knights_events ->attributes = array(
																				'knights_id' => $from_knight->id,
																				'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
																				'identificator'=>$downgrade->id
																		);
																		if( !$knights_events ->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] From knight events downgrade not save', 'error' );
																		
																		$knights_events_last = new KnightsEventsLast();
																		$knights_events_last->attributes = array(
																				'knights_id' =>$from_knight->id,
																				'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
																				'identificator'=>$downgrade->id,
																				'date'=>date("Y-m-d H:i:s")
																		);
																		if( !$knights_events_last->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] From knightevents last  downgrade not save', 'error' );
																			
																		
																		
																		
																		//Update experience of knight
																		$from_knight->experiencie_used -= $evolution->experiencie_used;

																		//Update characteristic
																		$characteristic = Constants::model()->findByPk( $evolution->characteristic );
																		$from_knight_card->{$characteristic->name}--;
																		if( $from_knight_card->save() ) Yii::trace( '[actionSetCombatPoints] No se ha podido guardar la caracteristica de from knight', 'error');


																		//Check if user has a positive experience then break loop.
																		if( $from_knight->experiencie_earned >= $from_knight->experiencie_used ){
																			break;
																		}
																	}else{
																		//This downgrade has associated the next upgrade
																		$jump++;
																	}
																}
															}
														}
														Yii::trace( '[CHARACTER][actionSetCombatPoints] TO KNIGHT DOWNGRADE earned experience ('.$to_knight->experiencie_earned.') < used experience ('.$to_knight->experiencie_used.') ');
														if( $to_knight->experiencie_earned < $to_knight->experiencie_used ){
																
															//Select all evolution
															$knight_evolutions = KnightsEvolution::model()->findAll( 'knights_id = :knights_id ORDER BY date DESC', array(':knights_id'=>$to_knight->id) );
																
															if( $knight_evolutions ){
																//Downgrade up to earned experience more than used experience
																$jump = 0;
																foreach( $knight_evolutions as $evolution ){
																	//Check if is a upgrade
																	if( $evolution->type == KnightsEvolution::TYPE_UPGRADE ){
																		if($jump>0 ){
																			$jump--;
																			continue;
																		}
																		//Add a downgrade
																		$downgrade = new KnightsEvolution();
																		$downgrade->attributes = array(
																				'knights_id'=> $to_knight->id,
																				'type'=>KnightsEvolution::TYPE_DOWNGRADE,
																				'characteristic'=> $evolution->characteristic,
																				'value'=>$evolution->value - 1,
																				'experiencie_used'=>$evolution->experiencie_used,
																				'date'=>date('Y-m-d H:i:s'),
																				'combats_id'=>$combat->id
																		);
																		Yii::trace( 'Evolution value ('.$evolution->value.') downgrade ('.$downgrade->value.')' );
																		if( !$downgrade->save() ) Yii::trace( 'to knight downgrade not save', 'error' );
																			
																		$knights_events = new KnightsEvents();
																		$knights_events ->attributes = array(
																				'knights_id' => $to_knight->id,
																				'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
																				'identificator'=>$downgrade->id
																		);
																		if( !$knights_events ->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] to knight events downgrade not save', 'error' );
																		
																		$knights_events_last = new KnightsEventsLast();
																		$knights_events_last->attributes = array(
																				'knights_id' =>$to_knight->id,
																				'type' => KnightsEvents::TYPE_KNIGHTS_EVOLUTION,
																				'identificator'=>$downgrade->id,
																				'date'=>date("Y-m-d H:i:s")
																		);
																		if( !$knights_events_last->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] From knightevents last  downgrade not save', 'error' );
																		
																		
																		//Update experience of knight
																		$to_knight->experiencie_used -= $evolution->experiencie_used;
																			
																		//Update characteristic
																		$characteristic = Constants::model()->findByPk( $evolution->characteristic );
																		$to_knight_card->{$characteristic->name} --;
																		if( !$to_knight_card->save() ) Yii::trace( '[actionSetCombatPoints] No se ha podido guardar la caracteristica de to knight', 'error');

																			
																		//Check if user has a positive experience then break loop.
																		if( $to_knight->experiencie_earned >= $to_knight->experiencie_used ){
																			break;
																		}
																	}else{
																		//This downgrade has associated the next upgrade
																		$jump++;
																	}
																}
															}
														}


														/*
														 * Calculate repair prize equipment
														*/
														Yii::trace( '[CHARACTER][actionSetCombatPoints]CALCULATE REPAIR PRIZE' );
														$from_knight_autorepair = CombatsPostcombat::autorepairObjectsEquipment( $combat, $from_knight );
														if( $from_knight_autorepair['errno']>0 ) Yii::trace( '[CHARACTER][actionSetCombatPoints] FROM KNIGHT AUTOREPAIR FAIL', 'error');

														$to_knight_autorepair = CombatsPostcombat::autorepairObjectsEquipment( $combat, $to_knight );
														if( $to_knight_autorepair['errno']>0 ) Yii::trace( '[CHARACTER][actionSetCombatPoints] TO KNIGHT AUTOREPAIR FAIL', 'error');

														/*
														 * Update coins of knights
														*/
														Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE COINS OF KNIGHTS' );
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FROM_KNIGHT earned coins: current coinds('.$from_knight->coins.') + gate coins ('.$precombat->from_knight_gate.') - autorrepair coins ('.$from_knight_autorepair['repair_cost'].') ' );
														$from_knight->coins += $precombat->from_knight_gate - $from_knight_autorepair['repair_cost'];
														Yii::trace( '[CHARACTER][actionSetCombatPoints] TO_KNIGHT earned coins: current coinds('.$to_knight->coins.') + gate coins ('.$precombat->to_knight_gate.') - autorrepair coins ('.$to_knight_autorepair['repair_cost'].') ' );
														$to_knight->coins += $precombat->to_knight_gate - $to_knight_autorepair['repair_cost'];


														/*
														 * Update healings of knights
														*/
														if( $from_knight->pain > 0 ){
															Yii::trace( '[CHARACTER][actionSetCombatPoints] Healing schule for from knigth');
															$healing = Healings::model()->findByPk($from_knight->id);
															$healing->next_healing_date = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d H:i:s' ).' +'.Yii::app()->params['healingTime'].' seconds' ) );
															if( !$healing->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] Error to update from knight next healing date', 'error');
														}
														if( $to_knight->pain > 0 ){
															Yii::trace( '[CHARACTER][actionSetCombatPoints] Healing schule for to knigth');
															$healing = Healings::model()->findByPk($to_knight->id);
															$healing->next_healing_date = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d H:i:s' ).' +'.Yii::app()->params['healingTime'].' seconds' ) );
															if( !$healing->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints] Error to update to knight next healing date', 'error');
														}

														/*
														 * STATS
														* Update stats of knights and platform
														*/
														/*
														 $from_knight_stats = KnightsStats::model()->findByPk($from_knight->id );
														$to_knight_stats = KnightsStats::model()->findByPk($to_knight->id );
														$from_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$from_knight->id, ':opponent'=>$to_knight->id) );
														$to_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$to_knight->id, ':opponent'=>$from_knight->id) );
														$from_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$from_knight->id, ':date'=>substr($combat->date, 0,10) ) );
														$to_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$to_knight->id, ':date'=>substr($combat->date, 0,10) ) );
														*/
														//who win combat
														if( $combat->result == Combats::RESULT_FROM_KNIGHT_WIN ){
															if( $combat->result_by == Combats::RESULT_BY_INJURY){
																$from_knight_stats->combats_wins_injury += 1;
																$from_knight_stats_vs->combats_wins_injury += 1;
																$from_knight_stats_by_date->combats_wins_injury += 1;
																$to_knight_stats->combats_loose_injury += 1;
																$to_knight_stats_vs->combats_loose_injury += 1;
																$to_knight_stats_by_date->combats_loose_injury += 1;
																switch ($to_knight_round_data->injury_type){
																	case Knights::TYPE_INJURY_LIGHT:
																		$from_knight_stats->injury_total_light_produced +=1;
																		$from_knight_stats_vs->injury_total_light_produced +=1;
																		$from_knight_stats_by_date->injury_total_light_produced +=1;
																		$to_knight_stats->injury_total_light_received +=1;
																		$to_knight_stats_vs->injury_total_light_received +=1;
																		$to_knight_stats_by_date->injury_total_light_received +=1;
																		break;
																	case Knights::TYPE_INJURY_SERIOUSLY:
																		$from_knight_stats->injury_total_serious_produced +=1;
																		$from_knight_stats_vs->injury_total_serious_produced +=1;
																		$from_knight_stats_by_date->injury_total_serious_produced +=1;
																		$to_knight_stats->injury_total_serious_received +=1;
																		$to_knight_stats_vs->injury_total_serious_received +=1;
																		$to_knight_stats_by_date->injury_total_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_VERY_SERIOUSLY:
																		$from_knight_stats->injury_total_very_serious_produced +=1;
																		$from_knight_stats_vs->injury_total_very_serious_produced +=1;
																		$from_knight_stats_by_date->injury_total_very_serious_produced +=1;
																		$to_knight_stats->injury_total_very_serious_received +=1;
																		$to_knight_stats_vs->injury_total_very_serious_received +=1;
																		$to_knight_stats_by_date->injury_total_very_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_FATALITY:
																		$from_knight_stats->injury_total_fatality_produced +=1;
																		$from_knight_stats_vs->injury_total_fatality_produced +=1;
																		$from_knight_stats_by_date->injury_total_fatality_produced +=1;
																		$to_knight_stats->injury_total_fatality_received +=1;
																		$to_knight_stats_vs->injury_total_fatality_received +=1;
																		$to_knight_stats_by_date->injury_total_fatality_received +=1;
																		break;
																	default:
																		Yii::trace( '[][] El tipo de herida no existe', 'error');
																}
															}else{
																$from_knight_stats->combats_wins += 1;
																$from_knight_stats_vs->combats_wins += 1;
																$from_knight_stats_by_date->combats_wins += 1;
																$to_knight_stats->combats_loose += 1;
																$to_knight_stats_vs->combats_loose += 1;
																$to_knight_stats_by_date->combats_loose += 1;
															}
														}elseif( $combat->result == Combats::RESULT_TO_KNIGHT_WIN ){
															if( $combat->result_by == Combats::RESULT_BY_INJURY){
																$from_knight_stats->combats_loose_injury += 1;
																$from_knight_stats_vs->combats_loose_injury += 1;
																$from_knight_stats_by_date->combats_loose_injury += 1;
																$to_knight_stats->combats_wins_injury += 1;
																$to_knight_stats_vs->combats_wins_injury += 1;
																$to_knight_stats_by_date->combats_wins_injury += 1;
																switch ($from_knight_round_data->injury_type){
																	case Knights::TYPE_INJURY_LIGHT:
																		$to_knight_stats->injury_total_light_produced +=1;
																		$to_knight_stats_vs->injury_total_light_produced +=1;
																		$to_knight_stats_by_date->injury_total_light_produced +=1;
																		$from_knight_stats->injury_total_light_received +=1;
																		$from_knight_stats_vs->injury_total_light_received +=1;
																		$from_knight_stats_by_date->injury_total_light_received +=1;
																		break;
																	case Knights::TYPE_INJURY_SERIOUSLY:
																		$to_knight_stats->injury_total_serious_produced +=1;
																		$to_knight_stats_vs->injury_total_serious_produced +=1;
																		$to_knight_stats_by_date->injury_total_serious_produced +=1;
																		$from_knight_stats->injury_total_serious_received +=1;
																		$from_knight_stats_vs->injury_total_serious_received +=1;
																		$from_knight_stats_by_date->injury_total_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_VERY_SERIOUSLY:
																		$to_knight_stats->injury_total_very_serious_produced +=1;
																		$to_knight_stats_vs->injury_total_very_serious_produced +=1;
																		$to_knight_stats_by_date->injury_total_very_serious_produced +=1;
																		$from_knight_stats->injury_total_very_serious_received +=1;
																		$from_knight_stats_vs->injury_total_very_serious_received +=1;
																		$from_knight_stats_by_date->injury_total_very_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_FATALITY:
																		$to_knight_stats->injury_total_fatality_produced +=1;
																		$to_knight_stats_vs->injury_total_fatality_produced +=1;
																		$to_knight_stats_by_date->injury_total_fatality_produced +=1;
																		$from_knight_stats->injury_total_fatality_received +=1;
																		$from_knight_stats_vs->injury_total_fatality_received +=1;
																		$from_knight_stats_by_date->injury_total_fatality_received +=1;
																		break;
																	default:
																		Yii::trace( '[][] El tipo de herida no existe', 'error');
																}
															}else{
																$from_knight_stats->combats_loose += 1;
																$from_knight_stats_vs->combats_loose += 1;
																$from_knight_stats_by_date->combats_loose += 1;
																$to_knight_stats->combats_wins += 1;
																$to_knight_stats_vs->combats_wins += 1;
																$to_knight_stats_by_date->combats_wins += 1;
															}
														}else{
															if( $combat->result_by == Combats::RESULT_BY_INJURY){
																$from_knight_stats->combats_draw_injury += 1;
																$from_knight_stats_vs->combats_draw_injury += 1;
																$from_knight_stats_by_date->combats_draw_injury += 1;
																$to_knight_stats->combats_draw_injury += 1;
																$to_knight_stats_vs->combats_draw_injury += 1;
																$to_knight_stats_by_date->combats_draw_injury += 1;

																//Check knight
																switch ($from_knight_round_data->injury_type){
																	case Knights::TYPE_INJURY_LIGHT:
																		$to_knight_stats->injury_total_light_produced +=1;
																		$to_knight_stats_vs->injury_total_light_produced +=1;
																		$to_knight_stats_by_date->injury_total_light_produced +=1;
																		$from_knight_stats->injury_total_light_received +=1;
																		$from_knight_stats_vs->injury_total_light_received +=1;
																		$from_knight_stats_by_date->injury_total_light_received +=1;
																		break;
																	case Knights::TYPE_INJURY_SERIOUSLY:
																		$to_knight_stats->injury_total_serious_produced +=1;
																		$to_knight_stats_vs->injury_total_serious_produced +=1;
																		$to_knight_stats_by_date->injury_total_serious_produced +=1;
																		$from_knight_stats->injury_total_serious_received +=1;
																		$from_knight_stats_vs->injury_total_serious_received +=1;
																		$from_knight_stats_by_date->injury_total_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_VERY_SERIOUSLY:
																		$to_knight_stats->injury_total_very_serious_produced +=1;
																		$to_knight_stats_vs->injury_total_very_serious_produced +=1;
																		$to_knight_stats_by_date->injury_total_very_serious_produced +=1;
																		$from_knight_stats->injury_total_very_serious_received +=1;
																		$from_knight_stats_vs->injury_total_very_serious_received +=1;
																		$from_knight_stats_by_date->injury_total_very_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_FATALITY:
																		$to_knight_stats->injury_total_fatality_produced +=1;
																		$to_knight_stats_vs->injury_total_fatality_produced +=1;
																		$to_knight_stats_by_date->injury_total_fatality_produced +=1;
																		$from_knight_stats->injury_total_fatality_received +=1;
																		$from_knight_stats_vs->injury_total_fatality_received +=1;
																		$from_knight_stats_by_date->injury_total_fatality_received +=1;
																		break;
																	default:
																		Yii::trace( '[][] El tipo de herida no existe', 'error');
																}
																switch ($to_knight_round_data->injury_type){
																	case Knights::TYPE_INJURY_LIGHT:
																		$from_knight_stats->injury_total_light_produced +=1;
																		$from_knight_stats_vs->injury_total_light_produced +=1;
																		$from_knight_stats_by_date->injury_total_light_produced +=1;
																		$to_knight_stats->injury_total_light_received +=1;
																		$to_knight_stats_vs->injury_total_light_received +=1;
																		$to_knight_stats_by_date->injury_total_light_received +=1;
																		break;
																	case Knights::TYPE_INJURY_SERIOUSLY:
																		$from_knight_stats->injury_total_serious_produced +=1;
																		$from_knight_stats_vs->injury_total_serious_produced +=1;
																		$from_knight_stats_by_date->injury_total_serious_produced +=1;
																		$to_knight_stats->injury_total_serious_received +=1;
																		$to_knight_stats_vs->injury_total_serious_received +=1;
																		$to_knight_stats_by_date->injury_total_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_VERY_SERIOUSLY:
																		$from_knight_stats->injury_total_very_serious_produced +=1;
																		$from_knight_stats_vs->injury_total_very_serious_produced +=1;
																		$from_knight_stats_by_date->injury_total_very_serious_produced +=1;
																		$to_knight_stats->injury_total_very_serious_received +=1;
																		$to_knight_stats_vs->injury_total_very_serious_received +=1;
																		$to_knight_stats_by_date->injury_total_very_serious_received +=1;
																		break;
																	case Knights::TYPE_INJURY_FATALITY:
																		$from_knight_stats->injury_total_fatality_produced +=1;
																		$from_knight_stats_vs->injury_total_fatality_produced +=1;
																		$from_knight_stats_by_date->injury_total_fatality_produced +=1;
																		$to_knight_stats->injury_total_fatality_received +=1;
																		$to_knight_stats_vs->injury_total_fatality_received +=1;
																		$to_knight_stats_by_date->injury_total_fatality_received +=1;
																		break;
																	default:
																		Yii::trace( '[][] El tipo de herida no existe', 'error');
																}

															}else{
																$from_knight_stats->combats_draw += 1;
																$from_knight_stats_vs->combats_draw += 1;
																$from_knight_stats_by_date->combats_draw += 1;
																$to_knight_stats->combats_draw += 1;
																$to_knight_stats_vs->combats_draw += 1;
																$to_knight_stats_by_date->combats_draw += 1;
															}
														}
														/*
														 * UPDATE STATS
														*/
														Yii::trace('[CHARACTER][actionSetCombatPoints] UPDATE STATS ');
														if( !$from_knight_stats->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística de from knight', 'error');
														if( !$from_knight_stats_vs->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística vs de from knight stats', 'error');
														if( !$from_knight_stats_by_date->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística por dia de from knight stats', 'error');
														if( !$to_knight_stats->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística de to knight', 'error');
														if( !$to_knight_stats_vs->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística vs de to knight', 'error');
														if( !$to_knight_stats_by_date->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística diarias de to knight', 'error');
														unset($from_knight_stats);
														unset($to_knight_stats);
														unset($from_knight_stats_vs);
														unset($to_knight_stats_vs);
														unset($from_knight_stats_by_date);
														unset($to_knight_stats_by_date);
														/*
														 //Update stats
														$from_knight_stats->hits_total_produced += 1;
														$from_knight_stats_vs->hits_total_produced += 1;
														$from_knight_stats_by_date->hits_total_produced += 1;
														$to_knight_stats->hits_total_produced += 1;
														$to_knight_stats_vs->hits_total_produced += 1;
														$to_knight_stats_by_date->hits_total_produced += 1;
														$from_knight_stats->hits_total_received += 1;
														$from_knight_stats_vs->hits_total_received += 1;
														$from_knight_stats_by_date->hits_total_received += 1;
														$to_knight_stats->hits_total_received += 1;
														$to_knight_stats_vs->hits_total_received += 1;
														$to_knight_stats_by_date->hits_total_received += 1;
														$from_knight_stats->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
														$from_knight_stats_vs->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
														$from_knight_stats_by_date->hits_total_blocked += $to_knight_round_data->is_received_impact_defended;
														$to_knight_stats->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$to_knight_stats_vs->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$to_knight_stats_by_date->hits_total_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$from_knight_stats->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$from_knight_stats_vs->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$from_knight_stats_by_date->hits_total_received_blocked += $from_knight_round_data->is_received_impact_defended;//sum 0 or 1
														$to_knight_stats->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
														$to_knight_stats_vs->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
														$to_knight_stats_by_date->hits_total_received_blocked += $to_knight_round_data->is_received_impact_defended;
														$from_knight_stats->damage_total_produced += $to_knight_round_data->received_damage;
														$from_knight_stats_vs->damage_total_produced += $to_knight_round_data->received_damage;
														$from_knight_stats_by_date->damage_total_produced += $to_knight_round_data->received_damage;
														$to_knight_stats->damage_total_produced += $from_knight_round_data->received_damage;
														$to_knight_stats_vs->damage_total_produced += $from_knight_round_data->received_damage;
														$to_knight_stats_by_date->damage_total_produced += $from_knight_round_data->received_damage;
														$from_knight_stats->damage_total_received += $from_knight_round_data->received_damage;
														$from_knight_stats_vs->damage_total_received += $from_knight_round_data->received_damage;
														$from_knight_stats_by_date->damage_total_received += $from_knight_round_data->received_damage;
														$to_knight_stats->damage_total_received += $to_knight_round_data->received_damage;
														$to_knight_stats_vs->damage_total_received += $to_knight_round_data->received_damage;
														$to_knight_stats_by_date->damage_total_received += $to_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $from_knight_stats->damage_maximum_produced ) $from_knight_stats->damage_maximum_produced = $to_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $from_knight_stats_vs->damage_maximum_produced ) $from_knight_stats_vs->damage_maximum_produced = $to_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $from_knight_stats_by_date->damage_maximum_produced ) $from_knight_stats_by_date->damage_maximum_produced = $to_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $to_knight_stats->damage_maximum_produced ) $to_knight_stats->damage_maximum_produced = $from_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $to_knight_stats_vs->damage_maximum_produced ) $to_knight_stats_vs->damage_maximum_produced = $from_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $to_knight_stats_by_date->damage_maximum_produced ) $to_knight_stats_by_date->damage_maximum_produced = $from_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $from_knight_stats->damage_maximum_received ) $from_knight_stats->damage_maximum_received = $from_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $from_knight_stats_vs->damage_maximum_received ) $from_knight_stats_vs->damage_maximum_received = $from_knight_round_data->received_damage;
														if( $from_knight_round_data->received_damage > $from_knight_stats_by_date->damage_maximum_received ) $from_knight_stats_by_date->damage_maximum_received = $from_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $to_knight_stats->damage_maximum_received ) $to_knight_stats->damage_maximum_received = $to_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $to_knight_stats_vs->damage_maximum_received ) $to_knight_stats_vs->damage_maximum_received = $to_knight_round_data->received_damage;
														if( $to_knight_round_data->received_damage > $to_knight_stats_by_date->damage_maximum_received ) $to_knight_stats_by_date->damage_maximum_received = $to_knight_round_data->received_damage;

														//Update all stats
														if( !$from_knight_stats->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística de from knight', 'error');
														if( !$from_knight_stats_vs->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística vs de from knight stats', 'error');
														if( !$from_knight_stats_by_date->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística por dia de from knight stats', 'error');
														if( !$to_knight_stats->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística de to knight', 'error');
														if( !$to_knight_stats_vs->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística vs de to knight', 'error');
														if( !$to_knight_stats_by_date->save() ) trace( '[CHARACTER][actionSetCombatPoints] No se puede salvar las estadística diarias de to knight', 'error');

														unset($from_knight_stats);
														unset($to_knight_stats);
														unset($from_knight_stats_vs);
														unset($to_knight_stats_vs);
														unset($from_knight_stats_by_date);
														unset($to_knight_stats_by_date);
														*/

														/*
														 * SEND EMAIL TO RIVAL
														*/
														/*
														Yii::trace( '[CHARACTER][actionSetCombatPoints] CHECK if send email to rival' );
														//Check email of challenge
														if( $knight_setting = KnightsSettings::model()->findByPk( $rival_id ) ){
															if( $knight_setting->emailToFinishedCombat ){
																

																//Check email
																if( $rival_id == $combat->fromKnight->id ){
																	$knight_user = Users::model()->findByPk( $combat->fromKnight->users_id );
																}else{
																	$knight_user = Users::model()->findByPk( $combat->toKnight->users_id );
																}

																if( $knight_user ){
																	Yii::trace( '[CHARACTER][actionSetCombatPoints] Yes, we send email to: '.$knight_user->email );

																	//cargamos la plantilla
																	$message = Yii::app()->controller->renderFile(
																			Yii::app()->basePath.Yii::app()->params['email_templates_path'] . 'finishedCombat.tpl',
																			array(),
																			true
																	);

																	// To send HTML mail, the Content-type header must be set
																	$headers  = 'MIME-Version: 1.0' . "\r\n";
																	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

																	// Additional headers
																	$headers .= 'To: '.$knight_user->email. "\r\n";
																	$headers .= 'From: <'.Yii::app()->params['adminEmail'].'>' . "\r\n";
																		

																	$email = new Emails();
																	$email->attributes = array(
																			'destination'=> $knight_user->email,
																			'headers'=>$headers,
																			'title'=> Yii::app()->name.': combate terminado.',
																			'body'=> $message,
																			'status'=>Emails::STATUS_PENDING,
																			'date'=>date('Y-m-d H:i:s')
																	);
																	if( !$email->save() ){
																		Yii::trace( '[CHARACTER][actionSetCombatPoints] No se ha podido guardar el email', 'error');
																	}
																}else{
																	Yii::trace( '[CHARACTER][actionSetCombatPoints] No se ha encontrado usuario del caballero '.$this->knight->id, 'error');
																}
															}
														}else{
															Yii::trace( '[CHARACTER][actionSetCombatPoints]No se ha encontrado setting del caballero '.$this->knight->id, 'error');
														}
														*/
													}else{
														//Combat is not finished. Create a new round.
														Yii::trace( '[CHARACTER][actionSetCombatPoints] CREATE NEXT ROUND' );
														$nextRound = new Rounds();
														$nextRound->attributes = array(
																'combats_id'=>$combat->id,
																'number'=>count( $combat->rounds ) + 1,
																'status'=>Rounds::STATUS_PENDING
														);
														if( !$nextRound->save() ) Yii::trace( '[CHARACTER][actionSetCombatPoints]actionSetCombatPoints', 'error' );
													}

													
														
													/*
													 * UPDATE KNIGHTS
													*/
													Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE KNIGHTS');
													if( !$from_knight->save() ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FROM KNIGHT SAVE FAIL', 'error');
														Yii::trace( '[CHARACTER][actionSetCombatPoints] FROM KNIGHT SAVE FAIL');
													}else{
														Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$from_knight->id, $from_knight, Yii::app()->params['cachetime']['knight']  );
														Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$from_knight->name, $from_knight, Yii::app()->params['cachetime']['knight']  );
													}
													
													if( !$to_knight->save() ){
														Yii::trace( '[CHARACTER][actionSetCombatPoints] TO KNIGHT SAVE FAIL', 'error');
														Yii::trace( '[CHARACTER][actionSetCombatPoints] TO KNIGHT SAVE FAIL');
													}else{
														Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$to_knight->id, $to_knight, Yii::app()->params['cachetime']['knight']  );
														Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$to_knight->name, $to_knight, Yii::app()->params['cachetime']['knight']  );
													}
														
														
													/*
													 * SHOW DIALOG FOR USER
													*/
													/*
													 $data = array(
													 		'from_knight_round_data'=>$from_knight_round_data,
													 		'from_knight'=>$from_knight,
													 		'from_knight_total_damage'=>$from_knight_total_damage,
													 		'to_knight_round_data'=>$to_knight_round_data,
													 		'to_knight'=>$to_knight,
													 		'to_knight_total_damage'=>$to_knight_total_damage,
													 		'injuryType'=> Constants::getLabelsTypeInjuries(),
													 		'modifiers'=>''//under development
													 );*/
													$data = array(
															'from_knight_round_data'=>$from_knight_round_data,
															'from_knight'=>$combat->fromKnight,
															'from_knight_total_damage'=>($from_knight_round_data['defended_damage']>=$from_knight_round_data['received_damage'])?0:$from_knight_round_data['received_damage']-$from_knight_round_data['defended_damage'],
															'from_knight_equipment'=>array(
																	'spear'=>Spears::model()->findByPk($from_knight_round_data->spears_id),
																	'shield'=>Armours::model()->findByPk($from_knight_round_data->shield_id),
																	'armour'=>Armours::model()->findByPk($from_knight_round_data->armour_id),
															),
															'from_knight_pain_value'=>($from_knight_round_data->is_pain_throw_pass)?0:$from_knight_round_data->knights_pain,
															'to_knight_round_data'=>$to_knight_round_data,
															'to_knight'=>$combat->toKnight,
															'to_knight_total_damage'=>($to_knight_round_data['defended_damage']>=$to_knight_round_data['received_damage'])?0:$to_knight_round_data['received_damage']-$to_knight_round_data['defended_damage'],
															'to_knight_equipment'=>array(
																	'spear'=>Spears::model()->findByPk($to_knight_round_data->spears_id),
																	'shield'=>Armours::model()->findByPk($to_knight_round_data->shield_id),
																	'armour'=>Armours::model()->findByPk($to_knight_round_data->armour_id),
															),
															'to_knight_pain_value'=>($to_knight_round_data->is_pain_throw_pass)?0:$to_knight_round_data->knights_pain,
															'injuryType'=> Constants::getLabelsTypeInjuries(),
															'modifiers'=>''//under development
													);
													$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_result.php', $data, true );
													$output['errno'] = 0;
												}else{
													$output['html'] = '<p>Se ha producido un error al calcular el punto de ataque del adversario.</p>';
												}
											}else{
												//Salvamos el round data
												if( $roundData->save() ){
													$output['errno'] = 0;													
													$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_waiting_for_rival.php', array('desqualifyTime'=>Yii::app()->params['desqualifyTime']), true );
												}else{
													$output['html'] = '<p>Se ha producido un error al guardar tu ataque y defensa.</p>';
												}
											}
										}else{
											$output['html'] = '';
											if( $user_knight_equipment['spear_object'] == null) $output['html'] .= '<p>Debes llevar la lanza al combate.</p>';
											if( $user_knight_equipment['shield_object'] == null) $output['html'] .= '<p>Debes llevar el escudo al combate.</p>';
											if( $user_knight_equipment['armour_object'] == null) $output['html'] .= '<p>Debes llevar la armadura completa al combate.</p>';
										}
									}else{
										$output['html'] = '<p>Ya has seleccionado los puntos de ataque y defensa para esta ronda. Falta tu adversario.</p>';
									}
								}else{
									$output['html'] = '<p>El round no está pendiente.</p>';
								}
							}else{
								$output['html'] = '<p>No puedes toquetear cositas de otros caballeros.</p>';
							}
						}else{
							$output['html'] = '<p>El combate no está en curso.</p>';
						}
					}else{
						$output['html'] = '<p>No se ha encontrado el combate.</p>';
					}
				}else{
					$output['html'] = '<p>Los datos de entrada no son válidos.</p>';
				}
			}else{
				$output['html'] = '<p>Sólo puedes toquetear tu caballero.</p>';
			}
		}else{
			$output['html'] = '<p>Tu sesión ha expirado. Tienes que volver a hacer login.</p>';
		}

		echo CJSON::encode( $output );
	}

	/*
	 * show precombat for all users
	*/
	public function actionShowPrecombat(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		//Valid input
		if( isset($_GET['id']) && is_numeric( $_GET['id']  ) && $_GET['id']>0 ){
			//Load combat
			if( $combat = Combats::model()->with( 'combatsPrecombat' )->findByPk( $_GET['id'] ) ){
				//Check if precombat exit
				if( $combat->combatsPrecombat ){
						
					//Load data
						
					//var_dump( $data );die();
					//Load html
					$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_pre_combat.php', $data = array( 'combat'=>$combat), true );
					$output['errno'] = 0;
				}else{
					$output['html'] = 'Se ha producido un error al cargar el precombate';
				}
			}else{
				$output['html'] = 'No se ha encontrado al combate.';
			}
		}else{
			$output['html'] = 'El identificador del combate no es válido.';
		}

		echo CJSON::encode( $output );
	}

	/**
	 * Desqualify a rival. Knight win combat by desqualify
	 */
	public function actionDesqualifyRival(){
		$output = array(
			'errno'=>1,
			'html'=>'',
			'isDesqualify'=>false
		);
		
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check input
			if( isset($_GET['combat']) && is_numeric( $_GET['combat']) && $_GET['combat'] > 0 ){
				//Check combat
				if( $combat = Combats::model()->with( array( 'combatsPrecombat','rounds', array('fromKnight'=>array('with'=>array('knightsCard'))), array('toKnight'=>array('with'=>'knightsCard') ) ) )->findByPk($_GET['combat']) ){
					//Check if user is in combat
					if( $combat->fromKnight->id == Yii::app()->user->knights_id || $combat->toKnight->id == Yii::app()->user->knights_id ){						
						//Check if combat is enable
						if( $combat->status == Combats::STATUS_ENABLE ){
							//Check last round
							if( $round_data = RoundsData::model()->find('rounds_combats_id = :combats_id AND rounds_number = :rounds_id AND knights_id = :knights_id', array( ':combats_id'=>$combat->id, ':rounds_id'=>(count($combat->rounds) ), ':knights_id'=>Yii::app()->user->knights_id) ) ){
								//Check time of desqualify
								$timeLimit =  strtotime( $round_data->date)+Yii::app()->params['desqualifyTime'];
								$requestTime = strtotime('now');
								Yii::trace( '[CHARACTER][actionDesqualifyRival] Check limit time of desqualify request ('.$requestTime.') > $timelimit ('.$timeLimit.') ' );
								if( $requestTime >= $timeLimit ){
									//Finish combat
									Yii::trace( '[CHARACTER][actionDesqualifyRival] FINISH COMBAT  ' );
									$output['isDesqualified'] = true;
									$combat->status = Combats::STATUS_FINISHED;
									$combat->result_by = Combats::RESULT_BY_DESQUALIFY;
									//Load round and knights
									$round = Rounds::model()->find( 'combats_id=:combats_id AND number=:number', array(':combats_id'=>$combat->id, ':number'=>count($combat->rounds)));
									if(Yii::app()->user->knights_id==$combat->from_knight){
										$combat->result = Combats::RESULT_FROM_KNIGHT_WIN;
										$round->status = Rounds::STATUS_FROM_KNIGHT_WIN;
										
										$fromKnight = &$this->user_data['knights'];
										$toKnight = Knights::model()->findByPk($combat->toKnight->id );

										
									}else{
										$combat->result = Combats::RESULT_TO_KNIGHT_WIN;
										$round->status = Rounds::STATUS_TO_KNIGHT_WIN;
										
										$fromKnight = Knights::model()->findByPk($combat->fromKnight->id );
										$toKnight = &$this->user_data['knights'];
										
									}
									/*
									 * Update round and combat
									 */
									Yii::trace( '[CHARACTER][actionDesqualifyRival] update round and combat  ' );
									if( !$round->save()  ) Yii::trace( '[CHARACTER][actionDesqualifyRival] No se ha podido salvar el round' );
									if( $combat->save() ){
										//Update combat cache
										Yii::app()->cache->set( Yii::app()->params['cacheKeys']['combat'].$combat->id, $combat, Yii::app()->params['cachetime']['combat'] );										
									}else{
										Yii::trace( '[CHARACTER][actionDesqualifyRival] No se ha podido salvar el combate' );
									}
									
									/*
									 * Update knights to ready to challenge 
									 */	
																	
									$fromKnight->endurance = ($combat->fromKnight->knightsCard->will+$combat->fromKnight->knightsCard->constitution)*3;
									$fromKnight->life = $combat->fromKnight->knightsCard->constitution*2;
									$fromKnight->status = Knights::STATUS_ENABLE;
									$toKnight->endurance = ($combat->toKnight->knightsCard->will+$combat->toKnight->knightsCard->constitution)*3;
									$toKnight->life = $combat->toKnight->knightsCard->constitution*2;
									$toKnight->status = Knights::STATUS_ENABLE;
									
									
									
									/*
									 *Calcula postcombat 
									 */
									
									//Calculate experience
									Yii::trace( '[CHARACTER][actionDesqualifyRival] CALCULATE EXPERIENCE' );
									$precombat = $combat->combatsPrecombat;
									$postcombatData = CombatsPostcombat::calculateEarnedExperience($combat, $combat->fromKnight->level, $combat->toKnight->level);
									
									Yii::trace( '[CHARACTER][actionDesqualifyRival] SAVE POSTCOMBATS' );
									$from_knight_post_combat = new CombatsPostcombat();
									$from_knight_post_combat->attributes = array(
											'combats_id' => $combat->id,
											'knights_id' => $combat->fromKnight->id,
											'knight_rival_level' => $combat->fromKnight->level,
											'experience_generate' =>$postcombatData['from_knight_experience_generate'],
											'percent_by_result' =>$postcombatData['from_knight_percent_by_result'] ,
											'percent_by_injury' =>$postcombatData['from_knight_percent_by_injury'] ,
											'earned_experience' =>$postcombatData['from_knight_earned_experience'] ,
											'total_experience'=>$combat->fromKnight->experiencie_earned + $postcombatData['from_knight_earned_experience'],
											'total_coins'=>$precombat->from_knight_gate + $combat->fromKnight->coins,
											'earned_coins'=>$precombat->from_knight_gate,
											'injury_type'=>null
									
									);
									if( !$from_knight_post_combat->save() ) Yii::trace( '[CHARACTER][actionDesqualifyRival] se ha producido un error al salvar postcombate para from knight', 'error' );
										
									$to_knight_post_combat = new CombatsPostcombat();
									$to_knight_post_combat->attributes = array(
											'combats_id' => $combat->id,
											'knights_id' => $combat->toKnight->id,
											'knight_rival_level' => $combat->toKnight->level,
											'experience_generate' =>$postcombatData['to_knight_experience_generate'] ,
											'percent_by_result' =>$postcombatData['to_knight_percent_by_result'] ,
											'percent_by_injury' =>$postcombatData['to_knight_percent_by_injury'] ,
											'earned_experience' =>$postcombatData['to_knight_earned_experience'] ,
											'total_experience'=>$combat->toKnight->experiencie_earned + $postcombatData['to_knight_earned_experience'],
											'total_coins'=>$precombat->to_knight_gate + $combat->toKnight->coins,
											'earned_coins'=>$precombat->to_knight_gate,
											'injury_type'=>null							
									);
									
									if( !$to_knight_post_combat->save() ) Yii::trace( '[CHARACTER][actionDesqualifyRival] se ha producido un error al salvar postcombate para to knight', 'error' );
									
									
									//Update experience of knights
									Yii::trace( '[CHARACTER][actionSetCombatPoints] UPDATE EXPERIECE');
									$fromKknight->experiencie_earned = $from_knight_post_combat->total_experience;
									$toKnight->experiencie_earned = $to_knight_post_combat->total_experience;
									
									
									/*
									 * Calculate repair prize equipment
									*/
									Yii::trace( '[CHARACTER][actionDesqualifyRival]CALCULATE REPAIR PRIZE' );
									$from_knight_autorepair = CombatsPostcombat::autorepairObjectsEquipment( $combat, $combat->fromKnight );
									if( $from_knight_autorepair['errno'] > 0 ) Yii::trace( '[CHARACTER][actionDesqualifyRival] FROM KNIGHT AUTOREPAIR FAIL', 'error');
									
									$to_knight_autorepair = CombatsPostcombat::autorepairObjectsEquipment( $combat, $combat->toKnight );
									if( $to_knight_autorepair['errno'] > 0 ) Yii::trace( '[CHARACTER][actionDesqualifyRival] TO KNIGHT AUTOREPAIR FAIL', 'error');
										
									/*
									 * Update coins of knights
									*/
									Yii::trace( '[CHARACTER][actionDesqualifyRival] UPDATE COINS OF KNIGHTS' );
									Yii::trace( '[CHARACTER][actionDesqualifyRival] FROM_KNIGHT earned coins: current coinds('.$combat->fromKnight->coins.') + gate coins ('.$precombat->from_knight_gate.') - autorrepair coins ('.$from_knight_autorepair['repair_cost'].') ' );
									$fromKnight->coins += $precombat->from_knight_gate - $from_knight_autorepair['repair_cost'];
									Yii::trace( '[CHARACTER][actionDesqualifyRival] TO_KNIGHT earned coins: current coinds('.$toKnight->coins.') + gate coins ('.$precombat->to_knight_gate.') - autorrepair coins ('.$to_knight_autorepair['repair_cost'].') ' );
									$toKnight->coins += $precombat->to_knight_gate - $to_knight_autorepair['repair_cost'];
									
									
									/*
									 * Update healings of knights
									*/
									if( $combat->fromKnight->pain > 0 ){
										Yii::trace( '[CHARACTER][actionDesqualifyRival] Healing schule for from knigth');
										$healing = Healings::model()->findByPk($combat->fromKnight->id);
										$healing->next_healing_date = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d H:i:s' ).' +'.Yii::app()->params['healingTime'].' seconds' ) );
										if( !$healing->save() ) Yii::trace( '[CHARACTER][actionDesqualifyRival] Error to update from knight next healing date', 'error');
									}
									if( $combat->toKnight->pain > 0 ){
										Yii::trace( '[CHARACTER][actionDesqualifyRival] Healing schule for to knigth');
										$healing = Healings::model()->findByPk($combat->toKnight->id);
										$healing->next_healing_date = date( 'Y-m-d H:i:s', strtotime( date( 'Y-m-d H:i:s' ).' +'.Yii::app()->params['healingTime'].' seconds' ) );
										if( !$healing->save() ) Yii::trace( '[CHARACTER][actionDesqualifyRival] Error to update to knight next healing date', 'error');
									}
									
									/*
									 * STATS
									* Update stats of knights and platform
									*/
									Yii::trace( '[CHARACTER][actionDesqualifyRival] update stats' );
									$from_knight_stats = KnightsStats::model()->findByPk($combat->fromKnight->id );
									$to_knight_stats = KnightsStats::model()->findByPk($combat->toKnight->id );
									$from_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$fromKnight->id, ':opponent'=>$toKnight->id) );
									$to_knight_stats_vs = KnightsStatsVs::model()->find( 'knights_id = :knights_id AND opponent = :opponent',array(':knights_id'=>$toKnight->id, ':opponent'=>$fromKnight->id) );
									
									if( !$from_knight_stats_vs ){
										$from_knight_stats_vs = new KnightsStatsVs();
										$from_knight_stats_vs->attributes = array(
												'knights_id'=>$combat->fromKnight->id,
												'opponent'=>$combat->toKnight->id,
												'money_total_earned'=>0
										);
									}
									if( !$to_knight_stats_vs ){
										$to_knight_stats_vs = new KnightsStatsVs();
										$to_knight_stats_vs->attributes = array(
												'knights_id'=>$combat->toKnight->id,
												'opponent'=>$combat->fromKnight->id,
												'money_total_earned'=>0
										);
									}
									
									$from_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$fromKnight->id, ':date'=>substr($combat->date, 0,10) ) );
									$to_knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$toKnight->id, ':date'=>substr($combat->date, 0,10) ) );
									if( !$from_knight_stats_by_date ){
										$from_knight_stats_by_date = new KnightsStatsByDate();
										$from_knight_stats_by_date = array(
											'knights_id'=>$combat->fromKnight->id,
											'date'=>date('Y-m-d')
										);
									}
									if( !$to_knight_stats_by_date ){
										$to_knight_stats_by_date = new KnightsStatsByDate();
										$to_knight_stats_by_date = array(
												'knights_id'=>$combat->toKnight->id,
												'date'=>date('Y-m-d')
										);
									}
									
									if( $combat->result == Combats::RESULT_FROM_KNIGHT_WIN ){
										$from_knight_stats->combats_wins +=1;
										$from_knight_stats_vs->combats_wins +=1;
										$from_knight_stats_by_date->combats_wins +=1;
										$to_knight_stats->combats_loose +=1;
										$to_knight_stats_vs->combats_loose +=1;
										$to_knight_stats_by_date->combats_loose +=1;										
									}else if($combat->result == Combats::RESULT_TO_KNIGHT_WIN) {
										$to_knight_stats->combats_wins +=1;
										$to_knight_stats_vs->combats_wins +=1;
										$to_knight_stats_by_date->combats_wins +=1;
										$from_knight_stats->combats_loose +=1;
										$from_knight_stats_vs->combats_loose +=1;
										$from_knight_stats_by_date->combats_loose +=1;
									}else{
										$to_knight_stats->combats_draw +=1;
										$to_knight_stats_vs->combats_draw +=1;
										$to_knight_stats_by_date->combats_draw +=1;
										$from_knight_stats->combats_draw +=1;
										$from_knight_stats_vs->combats_draw +=1;
										$from_knight_stats_by_date->combats_draw +=1;
									}
									
									//stats desquality
									if( Yii::app()->user->knights_id == $combat->fromKnight->id){
										$from_knight_stats->desquality_produced += 1;
										$to_knight_stats->desquality_received += 1;
									}else{
										$from_knight_stats->desquality_received += 1;
										$to_knight_stats->desquality_produced += 1;
									}
									//stats money
									$from_knight_stats->money_total_earned +=  $precombat->from_knight_gate;
									$to_knight_stats->money_total_earned +=  $precombat->to_knight_gate;
									
									Yii::trace('[CHARACTER][actionDesqualifyRival] UPDATE STATS ');
									if( !$from_knight_stats->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística de from knight', 'error');
									if( !$from_knight_stats_vs->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística vs de from knight stats', 'error');
									if( !$from_knight_stats_by_date->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística por dia de from knight stats', 'error');
									if( !$to_knight_stats->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística de to knight', 'error');
									if( !$to_knight_stats_vs->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística vs de to knight', 'error');
									if( !$to_knight_stats_by_date->save() ) trace( '[CHARACTER][actionDesqualifyRival] No se puede salvar las estadística diarias de to knight', 'error');
									
									//UPDATE knights
									Yii::trace( '[CHARACTER][actionDesqualifyRival] update knights ' );
									if( !$fromKnight->save() ){
										Yii::trace( '[CHARACTER][actionDesqualifyRival] No se ha podido salvar el caballero from knight' );
									}else{
										Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$fromKnight->id, $fromKnight, Yii::app()->params['cachetime']['knight']  );
										Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$fromKnight->name, $fromKnight, Yii::app()->params['cachetime']['knight']  );
									}
									if( !$toKnight->save() ){
										Yii::trace( '[CHARACTER][actionDesqualifyRival] No se ha podido salvar el caballero to knight' );
									}else{
										Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights'].$fromKnight->id, $fromKnight, Yii::app()->params['cachetime']['knight']  );
										Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knights_by_name'].$fromKnight, $fromKnight, Yii::app()->params['cachetime']['knight']  );
									}
									
									//Show desqualify  
									$desqualifyKnight = (Yii::app()->user->knights_id == $combat->fromKnight->id )?$combat->fromKnight->name:$combat->toKnight->name;
									$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_desqualified_by.php', array('desqualifiedKnight'=>$desqualifyKnight  ), true );
									$output['errno'] = 0;
									
									
								}else{
									$output['html'] = 'Todavía no ha pasado el tiempo para que le puedas descalificar. Faltan '.( $timeLimit - $requestTime ).' segundos.';
								}
							}else{
								$output['html'] = 'No puedes descalificar a tu adversario si no has enviado los datos para la última ronda.';
							}
						}else{
							$output['html'] = 'Este combate no está en curso.';
						}
					}else{
						$output['html'] = 'No puedes toquetear combates que no son tuyos.';
					}
				}else{
					$output['html'] = 'No se ha encontrado el combate.';
				}
			}else{
				$output['html'] = 'El identificador del combate no es válido.';
			}
		}else{
			$output['html'] = 'La sesión ha expirado. Necesitas volver a hacer login.';
		}
		
		//Show output
		echo CJSON::encode( $output );
	}
	
	/*
	 * Check if a user is desqualified by rival 
	 */
	public function actionIsDesqualified(){
		
		$output = array(
				'errno'=>1,
				'html'=>'',
				'isDesqualified'=>false
		);
		
		//Check session is enable
		if( !Yii::app()->user->isGuest ){
			//Check input
			if( isset($_GET['combat']) && is_numeric( $_GET['combat']) && $_GET['combat'] > 0 ){
				//Check combat
				if( !$combat = Yii::app()->cache->get( Yii::app()->params['cacheKeys']['combat'] )  ){
					if( $combat = Combats::model()->findByPk($_GET['combat']) ) Yii::app()->cache->set( Yii::app()->params['cacheKeys']['combat'].$combat->id, $combat, Yii::app()->params['cachetime']['combat'] );
				}
				if( $combat ){
					//Check if user is in combat
					if( $combat->from_knight == Yii::app()->user->knights_id || $combat->to_knight == Yii::app()->user->knights_id ){
						//Check if combat is finished and knight has loosed by desqualification
						$output['errno'] = 0;
						if( $combat->status == Combats::STATUS_FINISHED && 							
							( (Yii::app()->user->knights_id == $combat->from_knight && $combat->result == Combats::RESULT_TO_KNIGHT_WIN) || 
							  (Yii::app()->user->knights_id == $combat->to_knight && $combat->result == Combats::RESULT_FROM_KNIGHT_WIN) ) &&
							$combat->result_by == Combats::RESULT_BY_DESQUALIFY  ){
							
							$output['isDesqualified'] = true;							
							$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_desqualified.php', array(), true );						
						}
					}else{
						$output['html'] = 'No puedes toquetear combates que no son tuyos.';
					}
				}else{
					$output['html'] = 'No se ha encontrado el combate.';
				}
			}else{
				$output['html'] = 'El identificador del combate no es válido.';	
			}		
		}else{
			$output['html'] = 'La sesión ha expirado. Necesitas volver a hacer login.';
		}
		//Show output
		echo CJSON::encode( $output );
	}

	/*
	 * show precombat for all users
	*/
	public function actionShowFinishedRound(){
		$output = array(
				'errno'=>1,
				'html'=>'',
				'isFinishedRound' => true,
				'isCombatFinished' => false
		);
		//Valid input
		if( isset($_GET['combat']) && is_numeric( $_GET['combat']  ) && $_GET['combat']>0 &&
				isset($_GET['round']) && is_numeric( $_GET['round']  ) && $_GET['round']>0 ){
				
			//Load combat
			if( $combat = Combats::model()->with( 'fromKnight', 'toKnight', array('rounds'=>array('condition'=>'number='.$_GET['round']) ) )->findByPk( $_GET['combat'] ) ){
				//Check if combat exist
				if( $combat->combatsPrecombat ){
					//Check if round is finished
					Yii::trace( 'STATUS combat('. $_GET['combat'].') - round('.$_GET['combat'].') total rounds ('.count($combat->rounds).')-> combat('.$combat->rounds[$_GET['round']-1]->combats_id.') round ('.$combat->rounds[$_GET['round']-1]->number.') status '.$combat->rounds[$_GET['round']-1]->status );
					if( $combat->rounds[$_GET['round']-1]->status != Rounds::STATUS_PENDING ){
						// Check if round is finished by descalification
						if( $combat->result_by != Combats::RESULT_BY_DESQUALIFY ){
							//Load round data
							$from_knight_round_data = RoundsData::model()->find('rounds_combats_id = :combats_id AND rounds_number = :number AND knights_id = :knights_id', array(':combats_id'=>$combat->id, ':number'=>$_GET['round'], ':knights_id'=>$combat->from_knight )  );
							$to_knight_round_data = RoundsData::model()->find('rounds_combats_id = :combats_id AND rounds_number = :number AND knights_id = :knights_id', array(':combats_id'=>$combat->id, ':number'=>$_GET['round'], ':knights_id'=>$combat->to_knight )  );
							$data = array(
									'from_knight_round_data'=>$from_knight_round_data,
									'from_knight'=>$combat->fromKnight,
									'from_knight_total_damage'=>($from_knight_round_data['defended_damage']>=$from_knight_round_data['received_damage'])?0:$from_knight_round_data['received_damage']-$from_knight_round_data['defended_damage'],
									'from_knight_equipment'=>array(
											'spear'=>Spears::model()->findByPk($from_knight_round_data->spears_id),
											'shield'=>Armours::model()->findByPk($from_knight_round_data->shield_id),
											'armour'=>Armours::model()->findByPk($from_knight_round_data->armour_id),
									),
									'from_knight_pain_value'=>($from_knight_round_data->is_pain_throw_pass)?0:$from_knight_round_data->knights_pain,
									'to_knight_round_data'=>$to_knight_round_data,
									'to_knight'=>$combat->toKnight,
									'to_knight_total_damage'=>($to_knight_round_data['defended_damage']>=$to_knight_round_data['received_damage'])?0:$to_knight_round_data['received_damage']-$to_knight_round_data['defended_damage'],
									'to_knight_equipment'=>array(
											'spear'=>Spears::model()->findByPk($to_knight_round_data->spears_id),
											'shield'=>Armours::model()->findByPk($to_knight_round_data->shield_id),
											'armour'=>Armours::model()->findByPk($to_knight_round_data->armour_id),
									),
									'to_knight_pain_value'=>($to_knight_round_data->is_pain_throw_pass)?0:$to_knight_round_data->knights_pain,
									'injuryType'=> Constants::getLabelsTypeInjuries(),
									'modifiers'=>''//under development
							);
							$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_result.php', $data, true );
							$output['errno'] = 0;
							$output['isCombatFinished'] = $combat->status == Combats::STATUS_FINISHED;
						}else{
							$data = array(
								'combat' => $combat
							);
							$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_round_result_disqualified.php', $data, true );
						}
					}else{
						//Round is pending 
						$output['errno'] = 0;
						$output['isFinishedRound'] = false;
					}
				}else{
					$output['html'] = 'Se ha producido un error al cargar el precombate';
				}
			}else{
				$output['html'] = 'No se ha encontrado al combate.';
			}
		}else{
			$output['html'] = 'El identificador del combate no es válido.';
		}

		echo CJSON::encode( $output );
	}

	public function actionShowPostcombat(){
		$output = array(
				'errno'=>1,
				'html'=>''
		);
		//Valid input
		if( isset($_GET['id']) && is_numeric( $_GET['id']  ) && $_GET['id']>0 ){
			//Load combat
			if( $combat = Combats::model()->with('fromKnight', 'toKnight')->findByPk( $_GET['id'] ) ){
				//Check if precombat exit
				$postcombats = CombatsPostcombat::model()->findAll( 'combats_id = :combats_id', array(':combats_id'=>$_GET['id']) );
				if( count( $postcombats )== 2){
					//Set data from knight and to knight
					if( $combat->from_knight==$postcombats[0]->knights_id){
						$data = array(
								'combat'=>$combat,
								'from_knight_postcombat' => &$postcombats[0],
								'from_knight_automatic_object_repairs'=> array(),
								'from_knight_downgrades'=> array(),
								'to_knight_postcombat' => &$postcombats[1],
								'to_knight_automatic_object_repairs'=> array(),
								'to_knight_downgrades'=> array(),
								'injuryLabels' => Constants::getLabelsTypeInjuries(),
								'knight_card_labels'=> array()
						);
					}else{
						$data = array(
								'combat'=>$combat,
								'from_knight_postcombat' =>&$postcombats[1],
								'from_knight_automatic_object_repairs'=> array(),
								'from_knight_downgrades'=> array(),
								'to_knight_postcombat' => &$postcombats[0],
								'to_knight_automatic_object_repairs'=> array(),
								'to_knight_downgrades'=> array(),
								'injuryLabels' => Constants::getLabelsTypeInjuries(),
								'knight_card_labels'=> array()
						);
					}
					//Load repairs
					$result = ObjectRepairs::model()->findAll( 'combats_id = :combats_id', array( ':combats_id' => $combat->id) );
					//sort result by knight
					if( count( $result) ){
						foreach( $result as $repair ){
							if( $repair['knights_id'] == $combat->from_knight ){
								//Add to from knight
								array_push($data['from_knight_automatic_object_repairs'], $repair);
							}else{
								array_push($data['to_knight_automatic_object_repairs'], $repair);
							}
						}
					}
						
					//Load downgrades!!
					$downgrades = KnightsEvolution::model()->findAll( 'combats_id = :combats_id', array( ':combats_id'=>$combat->id ) );
					//sort result by knight
					if( count($downgrades) ){
						foreach( $downgrades as $downgrade ){
							if( $downgrade->knights_id == $combat->from_knight ){
								array_push($data['from_knight_downgrades'], $downgrade);
							}else{
								array_push($data['to_knight_downgrades'], $downgrade);
							}
						}
						//Load knight card labels
						$data['knight_card_labels'] = KnightsCard::model()->attributeLabelsById();
					}
						
						
					//	var_dump($data);die;
					$output['html'] = $this->renderFile( Yii::app()->basePath.'/views/character/dialog_post_combat.php', $data, true );
					$output['errno'] = 0;
				}else{
					$output['html'] = 'Se ha producido un error al cargar el postcombate '.count($postcombats);
				}
			}else{
				$output['html'] = 'No se ha encontrado al combate.';
			}
		}else{
			$output['html'] = 'El identificador del combate no es válido.';
		}

		echo CJSON::encode( $output );
	}

	/*
	 * Check if user is in combat
	 */
	function actionIsInCombat(){
		Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knight_connected'].$knight->id, true, Yii::app()->params['cachetime']['knight'] );
		echo CJSON::encode( array( 'isInCombat'=>$this->user_data['knights']->status == Knights::STATUS_AT_COMBAT) );
	}
}