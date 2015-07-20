<?php

class JobsController extends Controller
{
	
	public $layout = '2columnas';
	
	public $user_data = array(
			'knights'=>null //Storage user's knight data
	);
	public $app_data = array();
	
	
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
				array('allow', // allow authenticated user to perform this actions
						'actions'=>array('index','cancel'),
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
	
	
	
	
	public function actionIndex()
	{		
		Yii::trace( '[JOBS][actionIndex] Show jobs page' );
		//Initial
		$data = array(
			'knight'=>&$this->user_data['knights'],
			'spearsMaterial'=>SpearsMaterials::model()->findAll(array('index'=>'id')),
			'app_rules_level'=>AppRulesLevel::model()->findAll(array('index'=>'level')),
			'job'=> Jobs::model()->find( 'knights_id=:knights_id AND status = :status', array(':knights_id'=>Yii::app()->user->knights_id, ':status'=>Jobs::STATUS_WORKING) )						
		);
		
		//Check if user is not at job and user wants one and his status is enable.
		if( !$data['job'] && ($this->user_data['knights']->status == Knights::STATUS_ENABLE || $this->user_data['knights']->status == Knights::STATUS_WITHOUT_EQUIPMENT) && isset($_POST['hours'] )  && is_numeric( $_POST['hours'] ) && $_POST['hours']>0 && $_POST['hours'] < 9 ){
			Yii::trace( '[JOBS][actionIndex] Inserting a new job' );
			$data['job'] = new Jobs();
			$data['job']->attributes = array(
				'knights_id'=>Yii::app()->user->knights_id,
				'knight_level'=>$this->user_data['knights']->level,
				'date'=>date( "Y-m-d H:i:s", strtotime( date("Y-m-d H:i:s").' +'.$_POST['hours'].' hour'.( ($_POST['hours']>1)?'s':'') ) ),
				'hours'=>$_POST['hours'],
				'status'=>Jobs::STATUS_WORKING
			); 	
			//Insert new job
			if( $data['job']->save() ){				
				//Change status of knight
				$this->user_data['knights']->status = Knights::STATUS_AT_WORK;	
				if( !$this->user_data['knights']->save() ) Yii::trace( '[JOBS][index] No se ha podido poner al caballero en estado trabajando' );
			}else{
				//Upss fail job
				Yii::trace( '[JOBS][index] Jobs save is fail' );
				$data['job']=null;
			}
		}else{
			if( isset($_POST['hours'] ) ){
				if( $data['job']) 
					Yii::app()->user->setFlash('error','Ya tienes un trabajo. No puedes hacer como los políticos de trabajar en otra cosa mientras estás contratado.');
				if( ($this->user_data['knights']->status != Knights::STATUS_ENABLE && $this->user_data['knights']->status != Knights::STATUS_WITHOUT_EQUIPMENT) ) 
					Yii::app()->user->setFlash('error','No puedes trabajar si ya estás trabajando o en mitad de un combate.');
				if( !is_numeric( $_POST['hours'] ) || $_POST['hours']<=0 || $_POST['hours'] > 8 )
					Yii::app()->user->setFlash('error','El número de horas es confuso. ¿Que estás haciendo?'.$_POST['hours']);
			}
			
		}
				
		$this->render('index', $data);
	}

	/**
	 * Cancel a jobs. Change status of job to cancelled and is not payed
	 */
	public function actionCancel(){
		$data = array(
			'errno'=>1,
			'error'=>'',
			
		);
		
		//Check input
		if( isset($_GET['id'] ) && is_numeric( $_GET['id']) && $_GET['id']>0 ){
			//Find job
			if( $job = Jobs::model()->findByPk( $_GET['id']) ){
				//Check if job belong to knight
				if( $job->knights_id == Yii::app()->user->knights_id && $job->status == Jobs::STATUS_WORKING ){
					$job->status = Jobs::STATUS_CANCELLED;
					if( !$job->save() ) Yii::trace( '[JOBS][actionCancel] El job '.$job->id.' no se puede actualizar.', 'error' );
					
					//Check status of knight
					if( Inventory::checkIfPrimaryEquipmentIsCompleted($this->user_data['knights']->id) ){
						$this->user_data['knights']->status = Knights::STATUS_ENABLE;
					}else{
						$this->user_data['knights']->status = Knights::STATUS_WITHOUT_EQUIPMENT;
					}
					
					
					if( !$this->user_data['knights']->save() ) Yii::trace('[JOBS][actionCancel] No se puede actualizar el status del caballero a disponible', 'error');
				}
			}			
		}
		
		//Redirect to job
		$this->redirect( '/jobs' );
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