<?php

class YellowPagesController extends Controller
{
		public $layout = '2columnas';
		public $user_data = array(
				'knights'=>null //Storage user's knight data
		);
		public $app_data = array();
		
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
		
		
	public function actionIndex(){
		$data = array();
		
		//Load totalknights by letter
		$data['yellow_pages_total'] = YellowPagesTotal::model()->with('letter0')->findAll();
		
		//Load last 10 knights
		$data['last_knights_suscribe'] = Knights::model()->findAll( array( 'condition'=>'status != :status_pending AND unsuscribe_date IS NULL', 'params'=>array(':status_pending'=>Knights::STATUS_PENDING_VALIDATION) ,'order'=>'suscribe_date DESC','limit' => 9 ) );
		
		$this->render('index', $data);
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
	
	/**
	 * Show all knights of a letter
	 */
	public function actionShow(){
		//Init
		$data = array(
			'errno'=> 1,
			'error'=>'La letra no es válida',
			'letter'=>'',
			'page' => 1,
			'yellow_pages_total' => null,
			'totalPages' => 0,
			'knights_by_page' => 9,
			'knights_list' => array()
		);
		
		
		//Input
		if( isset( $_GET['letter'] ) && $_GET['letter']!='' ){
			//Load totalknights by letter
			$data['yellow_pages_total'] = YellowPagesTotal::model()->with('letter0')->findAll();
			
			//Check if a letter valid
			foreach( $data['yellow_pages_total'] as $yellow_page_letter){
				if( $yellow_page_letter->letter0->name == $_GET['letter'] ){
					$data['errno'] = 0;
					$data['error'] = '';
					$data['letter'] = $_GET['letter'];
					break;
				}
			}
			
			//Load list of knights
			if( $data['error'] == 0 ){
				//Load all knights
				$data['knights_list'] = YellowPagesTotalByLetter::model()->with( array('letter0', 'knights'))->findAll( array( 'select'=>'knitghts.*', 'condition'=>'letter0.name = :letter', 'params'=> array(':letter'=>$_GET['letter']), 'limit'=>$data['knights_by_page']*($data['page']-1).','.$data['knights_by_page'])  );
				
				//Calculate pages
				$data['totalPages'] = ceil( count($data['knights_list'])/$data['knights_by_page'] );								
			}
			
			//Show page
			$this->render( 'show', $data );
		}else{
			throw new CHttpException(404,'The specified id cannot be found.');
		}
	}
	
}