<?php
/**
 * Headers show the header for guest o logged user.
 */
class Headers extends CWidget{
	
	public $_newMessages = array();
	public $_newFriends = array();
	
	/**
	 * Load data for widget template
	 */
	public function init(){
		//Check if user is login
		if( !Yii::app()->user->isGuest ){
			//Load if user has new friendship request
			$sql = 'SELECT friends.id as id, k1.name as name, k1.avatars_id as avatars_id FROM friends
					INNER JOIN users ON users.id = friends.from_user
					INNER JOIN knights as k1 ON k1.users_id = users.id
					WHERE friends.status = :status AND to_user = :users_knights_id1
					ORDER BY start_date DESC';
			$command = Yii::app()->db->createCommand(  $sql );
			$command->bindValue( ':status', Friends::STATUS_ONWAITING, PDO::PARAM_INT );
			$command->bindValue( ':users_knights_id1',Yii::app()->user->users_id, PDO::PARAM_INT );
			$this->_newFriends =  $command->queryAll();
			
			//Load new messages
			$this->_newMessages = Messages::getNewMessages(Yii::app()->user->users_id);
		}
	}
	
	/**
	 * This method is called by CController::endWidget()
	 */
	public function run(){
		$this->render( 'headers' );
	}
	
	
	
}