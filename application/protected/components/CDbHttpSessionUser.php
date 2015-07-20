<?php

/**
 * CDbHttpSessionUser
 * 
 * @package Yii
 * @author SmithAgentZ
 * @copyright 2012
 * @version 0.1
 * @access public
 */
class CDbHttpSessionUser extends CDbHttpSession
{

	public $_user_id=null;
    
    
	/**
	 * CDbHttpSessionUser::createSessionTable()
	 * 
	 * @param mixed $db
	 * @param mixed $tableName
	 * @return
	 */
	protected function createSessionTable($db, $tableName)
	{
	   $sql="CREATE TABLE IF NOT EXISTS `{$tableName}` (
          `id` char(32) NOT NULL,
          `user_id` int(11) DEFAULT NULL,          
          `expire` int(11) DEFAULT NULL,
          `data` text,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";	   
	   /*
	   $all = "CREATE TABLE IF NOT EXISTS `sessions` (
          `id` char(32) NOT NULL,
          `users_id` int(11) DEFAULT NULL,
          `expire` int(11) DEFAULT NULL,
          `data` text,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	   
	   "CREATE  TABLE IF NOT EXISTS `sessions` (
		  `id` CHAR(32) NOT NULL ,
		  `users_id` INT(11) UNSIGNED NULL DEFAULT NULL ,
		  `expire` INT(11) NULL DEFAULT NULL ,
		  `data` TEXT NOT NULL DEFAULT '' ,
		  PRIMARY KEY (`id`) )
		ENGINE = InnoDB"
	 	*/
		$db->createCommand($sql)->execute();
	}

	/**
	 * CDbHttpSessionUser::openSession()
	 * 
	 * @param string $savePath
	 * @param string $sessionName
	 * @return true
	 */
	public function openSession(string $savePath, string $sessionName){ 
		Yii::trace( '[CDbHttpSessionUser][readSession] $savePath ('.$savePath.') $sessionName ('.$sessionName.')' );		
		//session_start();
		return true;
	}
	
	/**
	 * CDbHttpSessionUser::readSession()
	 * 
	 * @param mixed $id
	 * @return mixed $data on success, empty string on failure
	 */
	public function readSession($id)
	{	
		
		$db=$this->getDbConnection();
        $toBind=array();
        
        $sql = "SELECT `data` FROM `{$this->sessionTableName}` WHERE `id`=:id AND `expire`>:expire LIMIT 1";
        $toBind[':id']=$id;              
        $toBind[':expire']=time();

		$data=$db->createCommand($sql)->queryScalar($toBind);
		if($data === false){
			Yii::trace( '[CDbHttpSessionUser][readSession] $id ('.$id.') -> data \'\'' );
			return '';			
		}else{
			Yii::trace( '[CDbHttpSessionUser][readSession] $id ('.$id.') -> data \''.$data.'\'' );
			return $data;	
		}
		
		
	}
	
	/**
	 * CDbHttpSessionUser::writeSession()
	 * 
	 * @param mixed $id
	 * @param mixed $data
	 * @return boolean
	 */
	public function writeSession($id, $data)
	{
		Yii::trace( '[CDbHttpSessionUser][writeSession] $id ('.$id.') $data ('.$data.')' );
        try
        {
    		$db=$this->getDbConnection();
            $toBind=array();
            $expire=time() + $this->getTimeout();
            
            $sql = "SELECT `id` FROM `{$this->sessionTableName}` WHERE `id`=:id LIMIT 1";
            $toBind[':id']=$id;
            
            if(false===$db->createCommand($sql)->queryScalar($toBind))
            {
            	/*
                $sql = "DELETE FROM `{$this->sessionTableName}` WHERE `id`=:id LIMIT 1";
    			$db->createCommand($sql)->bindValue(':id', $id)->execute();
    			*/	
                
                $toBind=array();
                $sql = "INSERT INTO `{$this->sessionTableName}` (`id`,`users_id`, `expire`,`data`) ";
                $toBind[':id']=$id;
                $toBind[':users_id'] = (isset( Yii::app()->user->users_id ) )?Yii::app()->user->users_id:null;
                $toBind[':expire']=$expire;	               
                $toBind[':data']=$data;
                
                $sql.='VALUES ('.implode(',',array_keys($toBind)).')';
                $db->createCommand($sql)->execute($toBind);
            }
            else
            {
                $toBind=array();
                $sql = "UPDATE `{$this->sessionTableName}` SET `users_id`=:users_id,`expire`=:expire, `data`=:data WHERE `id`=:id LIMIT 1";
                $toBind[':expire']=$expire;
                $toBind[':data']=$data;
                $toBind[':users_id'] = (isset( Yii::app()->user->users_id ) )?Yii::app()->user->users_id:null;               
                $toBind[':id']=$id;                
                $db->createCommand($sql)->execute($toBind);
            }          
        }
        catch(Exception $e)
        {
            if(YII_DEBUG)
				echo $e->getMessage();
			return false;
        }
        return true;
	}
	
	
	/*
    public function closeSession(){
    	Yii::trace( '[CDbHttpSessionUser][closeSession] CLOSE ' );
    	
    	return true;
    }
    */
    public function destroySession($id){
    	Yii::trace( '[CDbHttpSessionUser][destroySession] Start '.$id );
    	$db=$this->getDbConnection();
    	$toBind=array();
    	$sql = "DELETE FROM `{$this->sessionTableName}` WHERE `id`=:id LIMIT 1";
    	$db->createCommand($sql)->bindValue(':id', $id)->execute();
    	return true;
    }
}

?>