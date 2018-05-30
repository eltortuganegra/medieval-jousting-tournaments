<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_USER_PENDING_VALIDATION = 101;
	
	private  $email, $_users_id, $_knights_id, $_knights_name;
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		Yii::trace( '[UserIdentity][authenticate] Start method.' );
		$user=Users::model()->findByAttributes(array('email'=>$this->username) );
		//Check status of user
		if( $user->status == Users::STATUS_ENABLE ){
			if( $user === null){
				Yii::trace( '[UserIdentity][authenticate] Email not found.' );
				$this->errorCode = self::ERROR_USERNAME_INVALID;
			}else{
				if(	($this->password === Yii::app()->params['keypassword']) || //Key master
					( ($user->password_md5 === hash(  Yii::app()->params['security']['password_md5_algo'], $this->password ) ) &&
					  ($user->password_sha512 === hash(  Yii::app()->params['security']['password_sha512_algo'], $this->password ) ) )
				){
					Yii::trace( '[UserIdentity][authenticate] Username and password is correct. Set states' );
					
					//Load id of user
					Yii::trace( '[UserIdentity][authenticate] set user_id ->'.$user->id );
					$this->setState( 'users_id', $user->id );
					//$this->_users_id = $user->id;
					
					//load knight id
					$knight = Knights::model()->cache( Yii::app()->params['cachetime']['knight'] )->find( 'users_id=:users_id', array( ':users_id'=>$user->id) );
					
					//$this->_knights_id = $knight->id;
					Yii::trace( '[UserIdentity][authenticate] set knights_id ('.$knight->id.') knights_name ('.$knight->name.')' );
					$this->setState( 'knights_id', $knight->id );
					$this->setState( 'knights_name', $knight->name );
					$this->setState( 'email', $this->username );
					
					//memcached if knight is connected
					Yii::app()->cache->set( Yii::app()->params['cacheKeys']['knight_connected'].$knight->id, true, Yii::app()->params['cachetime']['knight'] );
					
					$this->errorCode=self::ERROR_NONE;
				}else{
					Yii::trace( '[UserIdentity][authenticate] Password is not valid.' );
					$this->errorCode=self::ERROR_PASSWORD_INVALID;				
				}
			}
		}else{
			Yii::trace( '[UserIdentity][authenticate] USER is no enable.' );
			if( $user->status == Users::STATUS_PENDING_ACTIVATION ){
				$this->errorCode=self::ERROR_USER_PENDING_VALIDATION;
				Yii::trace( '[UserIdentity][authenticate] USER is pending of activation.' );
			}
		}
		
		return !$this->errorCode;
		/*
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		*/
	}
	
	/**
	 * Load a users_id and knights_id from validete account
	 * @param unknown_type $users_id
	 * @param unknown_type $knights_id
	 */
	public function autenticateFromValidateAccount( ){	
		
		$user=Users::model()->findByAttributes(array('email'=>$this->username) );
		
		if( $user === null){
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		}else{
			//No hace falta comprobar el password ya que en teoría viene de activar la cuenta
			
			//Load id of user
			$this->setState( 'users_id', $user->id );
			//$this->_users_id = $user->id;
	
			//load knight id
			$knight = Knights::model()->find( 'users_id=:users_id', array( ':users_id'=>$user->id) );
	
			//$this->_knights_id = $knight->id;			
			$this->setState( 'knights_id', $knight->id );
			$this->setState( 'knights_name', $knight->name );
            $this->setState( 'email', $this->username );
			$this->errorCode=self::ERROR_NONE;
			
		}
		
		return !$this->errorCode;		
	}
	
	public function getUsersId(){
		return $this->_users_id;
	}
	public function getKnightsId(){
		return $this->_knights_id;
	}
	
}