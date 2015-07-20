<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('username, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			if(!$this->_identity->authenticate()){
				if( $this->_identity->errorCode == UserIdentity::ERROR_USER_PENDING_VALIDATION ){
					$this->addError('password','Hey figura! tienes que validar tu cuenta. Sino has recibido el email de validación prueba a tratar de mirar en SPAM. Ya te dijimos que no somos de fiar...');
				}else{
					$this->addError('password','Correo electrónico o contraseña incorrectos.');
				}
			}
				
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		Yii::trace( '[LoginForm][login] Start.' );
		if($this->_identity===null)
		{
			Yii::trace( '[LoginForm][login] identity null.' );
			$this->_identity=new UserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		Yii::trace( '[LoginForm][login] Check error user identity:'.UserIdentity::ERROR_NONE );
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::trace( '[LoginForm][login] Set remember me and login of user. Duration = '.$duration );
			Yii::app()->user->login($this->_identity,$duration);
			Yii::trace( '[LoginForm][login] component user loged' );
			return true;
		}else{
			if( $this->_identity->errorCode == UserIdentity::ERROR_USER_PENDING_VALIDATION ){
				$this->addError('password','Hey figura! tienes que validar tu cuenta. Sino has recibido el email de validación prueba a tratar de mirar en SPAM. Ya te dijimos que no somos de fiar...');
			}else{
				$this->addError('password','Correo electrónico o contraseña incorrectos.');
			}
			return false;
		}
	}
	
	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function loginFromValidation( )
	{
		Yii::trace( '[LoginForm][login] loginFromValidation.' );
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->autenticateFromValidateAccount();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
	
}
