<?php

class KnightsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('headerSearch'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array( Yii::app()->params['adminEmail'] ),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Knights;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Knights']))
		{
			$model->attributes=$_POST['Knights'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Knights']))
		{
			$model->attributes=$_POST['Knights'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Knights');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Knights('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Knights']))
			$model->attributes=$_GET['Knights'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Knights::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='knights-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	/**
	 * Return JSON with results for header search
	 */
	public function actionHeaderSearch(){
		//Init
		$output = array(
			'errno'=>1,
			'html' => '',
		);
		
		//Check input
		if( isset($_GET['value']) && $_GET['value'] != '' ){
			//Check value of input
			if( preg_match( Knights::PATTERN_FOR_SEARCH_NAME, $_GET['value']  ) ){
				//Search knights
				
				$knightList = Knights::model()->findAll(array(					
					'condition'=> 'name LIKE :name',
					'params'=>array(
						':name'=>$_GET['value']."%",						
					),
					'limit'=>'10'
				));
				
				//$knightList = Knights::model()->findAll('name like :name',array(':name'=>"3"));
				
				if( count($knightList)>0 ){
					
					//Make  html
					foreach( $knightList as $knight ){
						$output['html'] .= $this->renderPartial( '_view_header_search_bar', array( 'knight'=>$knight), true );
					}
				}else{
					$output['html'] = '<p>No hay resultados para "'.$_GET['value'].'"</p>';
				}
				$output['errno'] = 0;
			}else{
				//
				$output['html'] = '<p>Los nombres tienen que empezar por una letra o un número.</p>';
			}
		}else{
			$output['html'] = '<p>Valor vacio</p>';
		}
		
		echo CJSON::encode( $output );
	}
}
