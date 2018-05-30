<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
				
		//Load register box
		//$this->render( '', array('register'), $data['view_register']);
		 if( !Yii::app()->user->isGuest ) $this->redirect( '/character/events/sir/'.Yii::app()->user->knights_name );
		
		//Display index
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				/*
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','El mensaje se ha enviado correctamente. Trataremos de responderte lo antes posible. ¡Gracias!');
				$this->refresh();
				*/
				$name='=?UTF-8?B?'.base64_encode($model->email).'?=';
				$subject='=?UTF-8?B?'.base64_encode( Yii::app()->name.' ADMIN: CONTACTO').'?=';
				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					
				// Additional headers
				$headers .= 'To: '.$model->email. "\r\n";
				$headers .= 'From: <'.Yii::app()->params['adminEmail'].'>' . "\r\n";
				
				
				//if( mail(Yii::app()->params['adminEmail'],$subject,$body,$headers) ){
				if( Yii::app()->email->send( $model->email, Yii::app()->params['adminEmail'],$subject ,$model->body, array($headers) ) ){
					Yii::app()->user->setFlash('contact','El mensaje se ha enviado correctamente. Trataremos de responderte lo antes posible. ¡Gracias!');
				}else{
					Yii::trace( '[SITE][actionRecoveryPassword] Se ha producido un error al enviar el email. Inténtalo de nuevo.', 'error');
					Yii::app()->user->setFlash('contact','El mensaje no se ha podido enviar. Vuelve a intentarlo, por favor.');
				}
				$this->refresh();
				
			}
		}
		$this->render('contact',array('model'=>$model));
	}
	/**
	 * Displays the recovery password page
	 */
	public function actionRecoveryPassword()
	{
		$model=new RecoveryPasswordForm;

		if(isset($_POST['RecoveryPasswordForm']))
		{			
			$model->attributes=$_POST['RecoveryPasswordForm'];
			if($model->validate()){
				
				//Search user
				$user = Users::model()->find('email = :email', array(':email'=>$_POST['RecoveryPasswordForm']['email']) );
				
				if( $user ){
					$randomPass = substr(hash(Yii::app()->params['security']['password_md5_algo'], $_POST['RecoveryPasswordForm']['email'].strtotime(date('Y-m-d H-m-s')).rand(0, 1000) ), 0, 10);
					$user->password_md5 = hash(Yii::app()->params['security']['password_md5_algo'], $randomPass );
					$user->password_sha512 = hash(Yii::app()->params['security']['password_sha512_algo'], $randomPass );
					if( $user->save() ){
						$name='=?UTF-8?B?'.base64_encode($model->email).'?=';
						$subject='=?UTF-8?B?'.base64_encode( Yii::app()->name.': recuperación de contraseña').'?=';
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
						// Additional headers
						$headers .= 'To: '.$model->email. "\r\n";
						$headers .= 'From: <'.Yii::app()->params['adminEmail'].'>' . "\r\n";
						$body = $this->renderFile(Yii::app()->basePath.Yii::app()->params['email_templates_path'].'recoveryPassword.tpl',array('randomPass'=>$randomPass), true );
													 
						//if( mail(Yii::app()->params['adminEmail'],$subject,$body,$headers) ){
						if( Yii::app()->email->send( Yii::app()->params['adminEmail'], $model->email ,$subject ,$body, array($headers) ) ){
							Yii::app()->user->setFlash('contact','El mensaje se ha enviado correctamente. Revisa tu email para ver la nueva contraseña. ¡Gracias!');
						}else{
							Yii::trace( '[SITE][actionRecoveryPassword] Se ha producido un error al enviar el email. Inténtalo de nuevo.', 'error');
							Yii::app()->user->setFlash('contact','El mensaje no se ha podido enviar. Vuelve a intentarlo, por favor.');
						}					
					}else{
						Yii::trace( '[SITE][actionRecoveryPassword] No se ha podido actualizar el password ', 'error');
						Yii::app()->user->setFlash('contact','Se ha producido un error al actualizar la contraseña. Inténtelo de nuevo o ponte en contacto con nosotros.');					
					}
				}else{
					echo "ASDF";
					Yii::app()->user->setFlash('contact','**El correo electrónico "'.$_POST['RecoveryPasswordForm']['email'].'"no está registrado. Comprueba que es con el que te diste de alta y vuelve a intentarlo.');
				}
				$this->refresh();
			}
		}
		$this->render('recoveryPassword',array('model'=>$model));
	}
	

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		//if user is login redirect to events
		if( !Yii::app()->user->isGuest ) $this->redirect('/character/events/sir/'.Yii::app()->user->knights_name );
		
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{			
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	
		// collect user input data
		if(isset($_POST['LoginForm']))
		{	
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			
			if($model->validate() && $model->login() ){			
				Yii::trace( '[SiteController][actionLogin] Login done!' );	
				//Redirec to referer url
				//$this->redirect(Yii::app()->user->returnUrl);
				$this->redirect(Yii::app()->getRequest()->getUrlReferrer());
				Yii::trace( '[LoginForm][login] Redirigido.' );
			}
		}
		// display the login form
		Yii::trace( '[LoginForm][login] Show login page.' );
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if( !Yii::app()->user->isGuest ){
						   
			//echo "VALOR (".Yii::app()->cache->get( Yii::app()->params['cacheKeys']['knight_connected'].Yii::app()->user->knights_id )."):".Yii::app()->cache->delete( Yii::app()->params['cacheKeys']['knight_connected'].Yii::app()->user->knights_id );
			Yii::app()->cache->delete( Yii::app()->params['cacheKeys']['knight_connected'].Yii::app()->user->knights_id );
			Yii::app()->user->logout();
		}
		
		$this->redirect(Yii::app()->getRequest()->getUrlReferrer());
	}
	
	/**
	 * REturn html for sing in waiting
	 * @return string JSON
	 */
	public function actionSigninWaiting(){
		$output = array(
			'title'=>'Creando cuenta...',
			'html'=>$this->renderPartial('singinWaiting',null,true )					
		);
		
		echo CJSON::encode($output);
	}
	
	
	/**
	 * Register a new user
	 */
	public function actionSignin(){
		$output = array(
			'errno'=>0,
			'message'=>'',
			'html'=>null,
			'params'=>null
		);
		
		//CHECK INPUT		
		$user = new Users;
		$user->attributes =  array(
			'id'=>null,
			'email'=>$_POST['email'],
			'password_md5'=>hash(  Yii::app()->params['security']['password_md5_algo'],$_POST['password'] ),
			'password_sha512'=>hash( Yii::app()->params['security']['password_sha512_algo'], $_POST['password'] ),
			'status'=> Users::STATUS_PENDING_ACTIVATION,
			'suscribe_date'=> date('Y-m-d H:i:s')				
		);
		
		
		
		//Validate user data
		if( $user->validate() ){		
			//CHECK email is in use			
			$userSearch = Users::model()->find( array(
				'select'=>'*',
				'condition'=>'email=:email',
				'params'=>array(':email'=>$_POST['email'] )
			));
			if( $userSearch ){
				//el email está siendo utilizado
				$output['message'] = 'El email está siendo utilizado. Si quieres recuperar la cuenta, ponte en contacto con nosotros.';
				$output['errno'] = 1;
			}
		}else{
			//El email no es correcto.
			$output['message'] = 'El email está siendo utilizado.';
			$output['errno'] = 1;
		}
		
		
		
		//Seach name of knight
		$knight = Knights::model()->find( array(
			'select'=>'*',
			'condition'=>'name=:name',
			'params'=>array(':name'=>ucfirst(strtolower($_POST['name'])) )
		));
		if( $knight ){
			//caballero con nombre en uso
			$message = 'El nombre del caballero está en uso. Elige otro.';
			$output['errno'] = 1;
			if( $output['errno'] === 0){
				$output['message'] = $message;
			}else{
				$output['message'] .= $message;
			}
			
		}
	
		//INSERT USER AND KNIGHT INTO DATA BASE IF IS FREE ERROR
		if( $output['errno'] == 0 ){			
			if( $user->save(false) ){
				//Set attribute knight
				$knight = new Knights;				
				$knight->attributes = array(
					'users_id' => $user->id, 
					'suscribe_date' => date('Y-m-d H:i:s'),
					'name' => ucfirst(strtolower($_POST['name'])),
					'status' => Knights::STATUS_PENDING_VALIDATION,
					'level' => Yii::app()->params['knight_default']['level'],
					'endurance' =>  1,
					'life'=>1 ,					
					'experiencie_earned' => Yii::app()->params['knight_default']['experiencie_earned'],
					'experiencie_used' => Yii::app()->params['knight_default']['experiencie_used'],
										 
				);
				//Comprobamos si valida.
				if( $knight->validate() ){
					//Insertamos el caballero.
					if( $knight->save() ){						
						//ENVIAMOS EMAIL
						
						//creamos el codigo de activacion. Va ser el md5 de email, nombre del caballero, password y la fecha en la que se da de alta
						$codigo_activacion = md5( $_POST['email'].$knight->name.hash( 'md5', $_POST['password']).$user->suscribe_date );
						
						//cargamos la plantilla
						$message = Yii::app()->controller->renderFile(
								Yii::app()->basePath.Yii::app()->params['email_templates_path'] . 'sigin.tpl',
								array(
										'enlace_activacion' => Yii::app()->params->url_domain.'/site/AccountActivation/email/'.$user->email.'/code/'.$codigo_activacion,
										'knights_name'=>$_POST['name']
								),
								true
						);
						
						//echo $message;
						
						// To send HTML mail, the Content-type header must be set
						$headers  = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
						
						// Additional headers
						$headers .= 'To: '.$_POST['email']. "\r\n";
						$headers .= 'From: <'.Yii::app()->params['adminEmail'].'>' . "\r\n";
						
						$headers = array($headers);
						
						if( !Yii::app()->email->send( Yii::app()->params['adminEmail'], $_POST['email'] , Yii::app()->name.': ¡ya eres parte de nuestra historia!' ,$message,$headers) ){						
							$output['message'] = '<p>Se ha producido un error al enviar el correo electrónico. Contacta con nosotros para solucionar la incidencia.</p><p>¡Lo sentimos!</p>' . Yii::app()->email->getErrors();
							$output['errno'] = 1;
						}						
					}else{
						//Usuario encontrado
						$output['message'] = 'Se ha producido un error al dar de alta el caballero.';
						$output['errno'] = 1;
					}
				}else{
					//Usuario encontrado
					$output['message'] = 'Se ha producido un error en la validación del caballero.';
					$output['errno'] = 1;
				}							
			}else{
				//No se ha podido dar de alta el usuario
				$output['message'] = 'Se ha producido un error al dar de alta un usuario.';
				$output['errno'] = 1;
				
			}
		}
		
		//echo "NOBORRAR";				
		if( $output['errno'] == 0 ){
			$output['message'] = $this->renderPartial('signin', null, true);
		}
		//SHOW OUTPUT
		echo CJSON::encode( $output );
	}	
	
	/**
	 * Activa una cuenta
	 */
	public function actionAccountActivation(){
		//Initi
		$template = 'error';
		$data = array( 
			'message' => '',
			'code' => 'en la activación.'
		);
		
		
		//Validation input
		/*
		$user = new Users();
		$user->attributes = array(
			'email'=>$_GET['email']				
		);
		*/
		
		
		//Check email
//		$validator = new CEmailValidator();
//		if( $validator->validateValue($_GET['email']) ){

		if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
			
			//Check if user exist
			$user = Users::model()->find(
					'email=:email',
					array( ':email'=>$_GET['email'])
			);
			
			if( $user ){
				//User found
				if( $user->status == Users::STATUS_PENDING_ACTIVATION ){
					//Load his knight
					$knight = Knights::model()->find(
						'users_id=:users_id',
						array( 'users_id'=>$user->id )
					);
					//Check if code is the same
					$codigo_activacion = md5( $user->email.$knight->name.$user->password_md5.$user->suscribe_date );
					if( $_GET['code'] === $codigo_activacion ){
						//ACTIVATED ACCOUNT
						
						//1.- change status
						$user->status = Users::STATUS_ENABLE;
						$user->save();
						$knight->status = Knights::STATUS_WITHOUT_EQUIPMENT;
						$knight->save();
						
						//2.- create card
						$knight_card = new KnightsCard();
						$knight_card->attributes = array(
							'knights_id'=>$knight->id
						);
						$knight_card->save();
						
						//3.- Create general stats
						$knight_stats = new KnightsStats();
						$knight_stats->attributes = array(
							'knights_id'=>$knight->id		
						);
						if( !$knight_stats->save() ) Yii::trace( '[Site][actionAccountActivation] No se puede salvar las stats del caballero','error');
						
						//4.- set stats attack location
						//load all location
						/*
						$locations = Constants::model()->findAll( 
							'type=:type',
							array( ':type'=> Constants::KNIGHTS_LOCATION)
						);
						
						if( count($locations) > 0 ){
							//Foreach location set a value for attack location. Defense is depending of shield
							foreach( $locations as $location ){
								$knights_stats_attack_location = new KnightsStatsAttackLocation();
								$knights_stats_attack_location->attributes = array(
									'knights_id'=>$knight->id,
									'location'=>$location['id']
								);
								$knights_stats_attack_location->save();
							}
							
						}else{
							$data['message'] .= 'No hay datos de localizaciones';
						}
						*/
						//Change for points of location. 48 is the maximun position number in the attack and defense points 
						for($i=1;$i<=48;$i++){
							$knights_stats_attack_location = new KnightsStatsAttackLocation();
							$knights_stats_attack_location->attributes = array(
									'knights_id'=>$knight->id,
									'location'=>$i
							);
							$knights_stats_attack_location->save();
						}
						
						
						//6.- Set default equipment
						
						
						//Set armours
						foreach( Armours::getDefaultEquipment() as $key => $id ){
							//Find armour														
							$armour = Armours::model()->findByPk( $id );
							if( $armour ){
								//creamos nuevo objeto de la armadura
								$armour_object = new ArmoursObjects();
								$armour_object->attributes = array(
									'armours_id' => $id,
									'knights_id' => $knight->id,
									'current_pde' => $armour->pde
								);
								
								if( !$armour_object->save() ){									
									//$data['message'] .= '<p>Armadura '.$id.' ('.$armour_object->attributes['armours_id'].') generada ('.var_dump( $armour_object->getErrors()).') ';
									Yii::trace('[SITE][actionAccountActivation] Error al salvar la armadura '.$armour->name,'error');
								}
								
								
								//Lo inventariamos. Como son los primeros objetos la posición que ocupa será empezando desde 1
								$inventory = new Inventory();
								//Sabemos que no hay objetos por lo que ocupamos las primeras posiciones, que concuerdan con el id
								$inventory->attributes = array(
										'knights_id' => $knight->id,
										'type' => Inventory::EQUIPMENT_TYPE_ARMOUR,
										'identificator' => $armour_object->id,
										'position' => $key+11 //Las posiciones 11 en adelante del inventario ocupan el inventario secundario
								);
									
								$data['message'] .= 'e inventariada ('.$inventory->save().')</p>';
							}else{
								$data['message'] .= '<p>KAKUNA MATATA!!';
							}
							
							
							
						}
						//Set spears
						$position = 27;
						$spear = Spears::model()->findByPk( 1 );//Lanza de entrenamiento
						foreach( Spears::getDefaultEquipment() as $key => $id ){
							//Creamos el bojeto lanza
							
							$spear_object = new SpearsObjects();
							$spear_object->attributes = array(
								'spears_id' => $spear->id,
								'knights_id' => $knight->id,
								'current_pde' => $spear->pde
							);
							$spear_object->save();
							$data['message'] .= '<p>Lanza '.$id.' generada</p>';
							//La inventariamos
							$inventory = new Inventory();
							$inventory->attributes = array(
								'knights_id' => $knight->id,
								'type' => Inventory::EQUIPMENT_TYPE_SPEAR,
								'identificator' => $spear_object->id,
								'position' => $position++ //para continuar rellenando el listado
							);
							
							$data['message'] .= 'e inventariada ('.$inventory->save().')</p>';
						}
						
						//Creamos las eventos de knights_events_last
						$sql = '';
						for( $i = 0; $i< Yii::app()->params['events']['event_last']['maximum']; $i++){
							$sql .= 'INSERT INTO knights_events_last (knights_id, type, identificator, date) VALUES ('.$knight->id.', '. KnightsEvents::TYPE_VOID.', 0, \'2012-01-01 00:00:'.(($i<10)?'0'.$i:$i).'\' );';
							/*
							$event = new KnightsEventsLast();
							$event->attributes = array(
								'knights_id'=>$knight->id,
								'type'=> KnightsEvents::TYPE_VOID,
								'identificator'=>0,
								'date'=>'2012-01-01 00:00:'.(($i<10)?'0'.$i:$i)//for update
							);
							$event->save();
							*/							
						}
						$command = Yii::app()->db->createCommand($sql);
						$command->execute();
						Yii::app()->db->setActive(false);
						
						
						//Create healing row
						$healing = new Healings();
						$healing->attributes = array(
							'knights_id'=>$knight->id,
							'next_healing_date'=>null
						);
						if( !$healing->save() ) Yii::trace( '[SITE][actionAccountActivation] I can not insert healing row.','error' );
						
						//Create settings
						$knights_settings = new KnightsSettings();
						$knights_settings->attributes = array(
							'knights_id'=>$knight->id
						);
						if( !$knights_settings->save() ) Yii::trace('[SITE][actionAccountActivation] I can not insert setting row.','error' );
						unset($knights_settings);

						//UPDATE YELLOW PAGES
						$initial_character = substr( $knight->name, 0, 1);
						if( is_numeric($initial_character) ){
							$initial_character =  '[0-9]';
						}else{
							$initial_character =  strtoupper($initial_character);
						}
						$yellow_pages_total = YellowPagesTotal::model()->with( 'letter0' )->find( 'letter0.name = :letter', array(':letter'=>$initial_character));
						$yellow_pages_total->total += 1;
						if( !$yellow_pages_total->save() ) Yii::trace( '[SITE][actionAccountActivation] No se ha podido actualizar yellow pages total','error' );
						
						
						$yellow_pages_total_by_letter = new YellowPagesTotalByLetter();
						$yellow_pages_total_by_letter->attributes = array(
							'letter'=> $yellow_pages_total->letter,
							'knights_id'=> $knight->id
						);
						if( !$yellow_pages_total_by_letter->save() ) Yii::trace( '[SITE][actionAccountActivation] No se ha podido crear yellow pages total by letter','error' );
						
						
						
						//Hacemos el login de alta
						$model=new LoginForm;
						$model->attributes=array(
							'email'=>$user->email,
							'username'=>$knight->name,
							'password'=>'nolosabemos'
						);
						
						
						//Check if all is ok		
						if( $model->loginFromValidation() ){
							$template = 'accountActivation';
						}else{									
							$data['message'] = 'Se ha producido un error al validar la cuenta. Escribenos un correo a '.Yii::app()->params['adminEmail'];
						}	
					}else{
						$data['message'] = 'El usuario y el código de activación no son correctos.';
					}
				}else{
					//Message Error: user is not pending of activation
					$data['message'] = 'El usuario no está pendiente de activación';
				}
			}else{
				//User not found
				$data['message'] = 'El usuario o código de activación no están relacionados.';
			}
		}else{
			//Input not valid
			$data['message'] = 'Los datos de entrada no son correctos.';			
		}
		
		//Show Output		
		$this->render( $template, $data);		
	}
	
	public function actionAccountActivation2(){
		$template = 'accountActivation';
		$data = array(
			'knights' => Knights::model()->find( 'id=:id', array( ':id'=>1) )
		);		
		
		$model=new LoginForm;
		$model->attributes=array(
			'username'=>'jsanchezweb@gmail.com',
			'password'=>'nolosabemos'
		);
	
		//Check if all is ok		
		if( !$model->loginFromValidation() ){
			$template = 'error';		
			$data['message'] = 'Se ha producido un error al validar la cuenta. Escribenos un correo a '.Yii::app()->params['adminEmail'];
		}	
		
		//Display index
		$this->render($template, $data);
	}

	public function actionConditionsOfUse(){
		if( isset($_GET['ajax']) && $_GET['ajax']=='1'){
			//show ajax
			$output = array('html'=>$this->renderPartial('conditionsOfUse', null, true) );
			echo CJSON::encode($output);
		}else{			
			$this->render('conditionsOfUse');
		}
	}
	public function actionPrivacyPolicy(){
		if( isset($_GET['ajax']) && $_GET['ajax']=='1'){
			//show ajax
			$output = array('html'=>$this->renderPartial('privacyPolicy', null, true) );
			echo CJSON::encode($output);
		}else{
			$this->render('privacyPolicy');
		}
		
	}
	/**
	 * return json with data for automatic logout
	 */
	public function actionGetAutomaticLogoutDialog(){
		$output = array(
			'title'=> 'Desconexión automática',
			'html'=>$this->renderPartial('automaticLogout', null, true),
			'logoutButtonLabel'=>'¡Sigo aquí!' 
		);
		
		echo CJSON::encode($output);
	}
}