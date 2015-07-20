<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $email
 * @property string $password_md5
 * @property string $password_sha512
 * @property string $status
 * @property string $suscribe_date
 * @property string $unsuscribe_date
 *
 * The followings are the available model relations:
 * @property Friends[] $friends
 * @property Friends[] $friends1
 * @property Knights[] $knights
 * @property Constants $status0
 */
class Users extends CActiveRecord
{
	const STATUS_PENDING_ACTIVATION = 4;
	const STATUS_ENABLE = 7;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Users the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password_md5, password_sha512, status, suscribe_date', 'required'),
			array('email', 'length', 'max'=>255),
			array('password_md5', 'length', 'max'=>32),
			array('password_sha512', 'length', 'max'=>128),
			array('status', 'length', 'max'=>10),
			array('unsuscribe_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password_md5, password_sha512, status, suscribe_date, unsuscribe_date', 'safe', 'on'=>'search'),
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
			'friends' => array(self::HAS_MANY, 'Friends', 'from_user'),
			'friends1' => array(self::HAS_MANY, 'Friends', 'to_user'),
			'knights' => array(self::HAS_MANY, 'Knights', 'users_id'),
			'status0' => array(self::BELONGS_TO, 'Constants', 'status'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password_md5' => 'Password Md5',
			'password_sha512' => 'Password Sha512',
			'status' => 'Status',
			'suscribe_date' => 'Suscribe Date',
			'unsuscribe_date' => 'Unsuscribe Date',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password_md5',$this->password_md5,true);
		$criteria->compare('password_sha512',$this->password_sha512,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('suscribe_date',$this->suscribe_date,true);
		$criteria->compare('unsuscribe_date',$this->unsuscribe_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}