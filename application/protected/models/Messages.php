<?php

/**
 * This is the model class for table "messages".
 *
 * The followings are the available columns in table 'messages':
 * @property string $id
 * @property string $from_user
 * @property string $to_user
 * @property string $status
 * @property string $text
 * @property string $date
 *
 * The followings are the available model relations:
 * @property MessageLastOneNew[] $messageLastOneNews
 * @property Constants $status0
 * @property Users $fromUser
 * @property Users $toUser
 * @property MessagesLastOneByUser[] $messagesLastOneByUsers
 */
class Messages extends CActiveRecord
{
	const STATUS_SENDED = 102;
	const STATUS_READED = 103;
	const STATUS_DELETED = 104;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Messages the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'messages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_user, to_user, status, text, date', 'required'),
			array('from_user, to_user, status', 'length', 'max'=>10),
			array('text', 'length', 'max'=>140),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, from_user, to_user, status, text, date', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'messageLastOneNews' => array(self::HAS_MANY, 'MessageLastOneNew', 'messages_id'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
			'fromUser' => array(self::BELONGS_TO, 'Users', 'from_user'),
			'toUser' => array(self::BELONGS_TO, 'Users', 'to_user'),
			'messagesLastOneByUsers' => array(self::HAS_MANY, 'MessagesLastOneByUser', 'messages_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'from_user' => 'From User',
			'to_user' => 'To User',
			'status' => 'Status',
			'text' => 'Text',
			'date' => 'Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('from_user',$this->from_user,true);
		$criteria->compare('to_user',$this->to_user,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('date',$this->date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Select last new messages
	 * @param unknown_type $users_id
	 */
	public static function getNewMessages( $users_id ){
		$sql = "SELECT knights.name as name, knights.avatars_id as avatars_id, messages_last_one_new.text as text, messages_last_one_new.date as date
					FROM  messages_last_one_new
					INNER JOIN users ON users.id = messages_last_one_new.with_user
					INNER JOIN knights ON knights.users_id = users.id
					WHERE messages_last_one_new.users_id = :users_id";
		$command = Yii::app()->db->createCommand( $sql );
		$command->bindValue( ':users_id', $users_id, PDO::PARAM_INT  );
		return $command->queryAll();
	}
	
	public static function getMessageLastByUser( $users_id ){
		$sql = "SELECT knights.name as name, knights.avatars_id as avatars_id, messages_last_one_by_user.text as text, messages_last_one_by_user.date as date
					FROM  messages_last_one_by_user
					INNER JOIN users ON users.id = messages_last_one_by_user.with_user
					INNER JOIN knights ON knights.users_id = users.id
					WHERE messages_last_one_by_user.users_id = :users_id";
		$command = Yii::app()->db->createCommand( $sql );
		$command->bindValue( ':users_id', $users_id, PDO::PARAM_INT  );
		return $command->queryAll();		
	}
	
	/**
	 * Return set of messages for page
	 */
	public static function getMessageWith( $users_id, $knight_users_id, $register_start, $max_by_page){
		$sql = "SELECT
					knights.name as name,				
					knights.avatars_id as avatars_id,
					messages.text as text,
					messages.date as date
				FROM
					messages
				INNER JOIN
					users ON users.id = messages.from_user
				INNER JOIN 
					knights ON knights.users_id = users.id
				WHERE
					(from_user = :users_id1 AND to_user =:knight_users_id1) OR (from_user = :knight_users_id2 AND to_user =:users_id2) AND messages.status != :status_delete
				ORDER BY
					messages.date DESC
				LIMIT 
					:register_start, :length
				 ";
		//var_dump( $user.'.'.$knight_users_id.'.'.$register_start.'.'. $max_by_page );die();
		$command = Yii::app()->db->createCommand( $sql );
		$command->bindValue( ':users_id1', $users_id, PDO::PARAM_INT  );
		$command->bindValue( ':knight_users_id1', $knight_users_id, PDO::PARAM_INT  );
		$command->bindValue( ':knight_users_id2', $knight_users_id, PDO::PARAM_INT  );
		$command->bindValue( ':users_id2', $users_id, PDO::PARAM_INT  );
		$command->bindValue( ':register_start', $register_start, PDO::PARAM_INT  );
		$command->bindValue( ':length', $max_by_page, PDO::PARAM_INT  );
		$command->bindValue( ':status_delete', self::STATUS_DELETED, PDO::PARAM_INT  );
		return $command->queryAll();
	}

	/**
	 * delete from messages last one new rows for user
	 */
	public static function deleteNewMessages( $users_id ){
		$sql = "DELETE FROM messages_last_one_new
				WHERE
					users_id = :users_id
				";
		$command = Yii::app()->db->createCommand( $sql );
		$command->bindValue( ':users_id', $users_id );
		return $command->execute();
	}
	
}