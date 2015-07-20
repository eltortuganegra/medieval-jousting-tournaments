<?php

/**
 * SigninForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SiginForm extends CFormModel
{
	public $email;
	public $password;
	public $knight_name;

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
			array('email, password, knight_name', 'required'),
			// check email format
			array('email', 'email'),
			// check max length
			array('email', 'length', 'max'=>255),
			array('password', 'length', 'max'=>60),
			//Check min length knight name
			array( 'knight_name', 'length', 'min'=>4)
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'email',
			'password'=>'password',
			'knight_name'=>'name',
		);
	}

	
	/**
	 * Sigin user
	 * @return boolean whether login is successful
	 */
	public function existEmail( $email ){
		//Check if user and mail is used
		$user = Users::model()->findByAttributes( array(
			'select'=>'*',
			'condition'=>'email=:email',
			'params'=>array(':email'=>$email )
		));
		
		var_dump($user);
		
	
	}
}
