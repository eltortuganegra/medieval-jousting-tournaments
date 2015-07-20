<?php

class SettingsController extends Controller
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
						'actions'=>array('index','updateSendEmails','updatePassword'),
						'users'=>array('@'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}
	
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
	
			//Load settings
			$this->user_data['knight_settings'] = KnightsSettings::model()->findByPk( Yii::app()->user->knights_id );
			$this->user_data['user'] = Users::model()->findByPk( Yii::app()->user->users_id );
		}else{
			$this->redirect( '/' );
		}
		return true;
	}
	
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionUpdatePassword(){
		$output = array(
			'errno'=>0,
			'html'=>''
		);
		
		//Check valid input
		if( isset($_POST['newPassword']) && $_POST['newPassword']!=''){
			if( strlen( $_POST['newPassword']) >= 6 ){
				if( $_POST['repeatPassword'] == $_POST['newPassword'] ){
					$this->user_data['user']->password_md5 = hash(  Yii::app()->params['security']['password_md5_algo'],$_POST['newPassword'] );
					$this->user_data['user']->password_sha512 = hash( Yii::app()->params['security']['password_sha512_algo'], $_POST['newPassword'] );
					if( $this->user_data['user']->save() ){
						$output['html'] = '<p>El password se ha actualizado correctamente.</p>';
						$output['errno'] = 0;
					}else{
						Yii::trace( '[SETTINGS][actionUpdatePassword] No se ha podido actualizar el password', 'error' );
						$output['html'] = '<p>Se ha producido un error al actulizar el password.</p>';
					}					
				}else{
					$output['html'] = '<p>Los passwords no son iguales.</p>';
				}
			}else{
				$output['html'] = '<p>El password tiene que tener más de 6 caracteres.</p>';
			}
		}else{
			$output['html'] = '<p>El password no puede llegar vacio.</p>';
		}
		
		echo CJSON::encode( $output );
	}
	
	public function actionUpdateSendEmails(){
		
		$output = array(
			'errno'=>0,
			'html'=>''
		);
		
		//Check valid input
		if( isset($_POST['emailToSendChallenge']) && $_POST['emailToSendChallenge']!='' && 
			isset($_POST['emailToFinishedCombat']) && $_POST['emailToFinishedCombat']!='' &&
			isset($_POST['emailToSendMessage']) && $_POST['emailToSendMessage']!='' &&
			isset($_POST['emailToSendFriendlyRequest']) && $_POST['emailToSendFriendlyRequest']!='' ){
			
			
			if( ($_POST['emailToSendChallenge'] == 'true' || $_POST['emailToSendChallenge'] == 'false') && 
				($_POST['emailToFinishedCombat'] == 'true' || $_POST['emailToFinishedCombat'] == 'false') &&
				($_POST['emailToSendMessage'] == 'true' || $_POST['emailToSendMessage'] == 'false') &&
				($_POST['emailToSendFriendlyRequest'] == 'true' || $_POST['emailToSendFriendlyRequest'] == 'false') ){
					//Update notifications
					$this->user_data['knight_settings']->emailToSendChallenge = ($_POST['emailToSendChallenge']=='true')?1:0;
					$this->user_data['knight_settings']->emailToFinishedCombat = ($_POST['emailToFinishedCombat']=='true')?1:0;
					$this->user_data['knight_settings']->emailToSendMessage = ($_POST['emailToSendMessage']=='true')?1:0;
					$this->user_data['knight_settings']->emailToSendFriendlyRequest = ($_POST['emailToSendFriendlyRequest']=='true')?1:0;
					
					//Update row
					if(	$this->user_data['knight_settings']->save() ){
						$output['html'] = '<p>Las notificaciones de email se ha actualizado correctamente.</p>';
						$output['errno'] = 0;
					}else{
						Yii::trace( '[SETTINGS][actionUpdatePassword] No se ha podido actualizar las notificaciones', 'error' );
						$output['html'] = '<p>Se ha producido un error al actualizar las notificaciones por email.</p>';						
					}				
			}else{
				$output['html'] = '<p>Los datos están corruptos.</p>';
			}
		}else{
			$output['html'] = '<p>Los datos están incompletos.</p>';
		}
		
		echo CJSON::encode( $output );
		
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