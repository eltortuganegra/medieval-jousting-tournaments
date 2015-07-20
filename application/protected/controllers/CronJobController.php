<?php

class CronJobController extends Controller
{
	
	public function beforeAction( $action ){
		//Validation for cron
		if( $_SERVER['REMOTE_ADDR'] != '127.0.0.1'){
			Yii::log('[JOBS][actionPayJobs] Access denied for ip '.$_SERVER['REMOTE_ADDR']);
			throw new CHttpException(403,'Access denied.');
		}
		return true;
	}
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * This function pay for all jobs in working and date is expired.
	 * This function is a cronjob. Only use for cron
	 * Identificator job: 1
	 */
	public function actionPayJobs(){
		$controlCronJobId = 1;
		
	
		//Find all jobs for to pay
		Yii::trace('[JOBS][actionPayJobs] Pay jobs finished before'.date("Y-m-d H:i:s") );
		$jobs_list = Jobs::model()->findAll( 'status = :status AND date <= :date', array(':status'=>Jobs::STATUS_WORKING, 'date'=>date("Y-m-d H:i:s") ) );
		Yii::trace('[JOBS][actionPayJobs] Pay jobs ('.count($jobs_list).')');
		
		if( count($jobs_list)>0 ){
			//Load cache of knights
			$app_rule_level = AppRulesLevel::model()->findAll( array('index'=>'level') );
	
			foreach( $jobs_list as $job ){
				//Update Knight
				$knight = Knights::model()->findByPk( $job->knights_id );
				$knight->coins += $job->hours*$app_rule_level[$job->knight_level]->cache;
				//Check status of knight
				if( Inventory::checkIfPrimaryEquipmentIsCompleted($knight->id) ){
					$knight->status = Knights::STATUS_ENABLE;
				}else{
					$knight->status = Knights::STATUS_WITHOUT_EQUIPMENT;
				}
				if( !$knight->save() ) Yii::trace( '[JOBS][actionPayJobs] No se ha podido actualizar el caballero con sus rupias nuevas.' );
	
				//Update job
				$job->status = Jobs::STATUS_PAYED;
				if( !$job->save() ) Yii::trace( '[JOBS][actionPayJobs] No se ha podido actualizar el trabajo con el status "pagado".' );
	
				//Create event for knight
				$event = new KnightsEvents();
				$event->attributes = array(
						'knights_id'=>$job->knights_id,
						'type'=>KnightsEvents::TYPE_JOB,
						'identificator'=>$job->id
				);
				if(!$event->save() ) Yii::trace( '[JOBS][actionPayJobs] No se ha podido guardar un evento nuevo.', 'error' );
	
				//Update old event
				$lastEvent = KnightsEventsLast::getOldLastEvent( $job->knights_id );
				$lastEvent->type = KnightsEvents::TYPE_JOB;
				$lastEvent->identificator = $job->id;
				$lastEvent->date = date('Y-m-d H:i:s');
				if( !$lastEvent->save() ) Yii::trace( '[JOBS][actionPayJobs] No se ha podido actualizar el último evento más viejo.', 'error' );
				
				//Update stats and  stats by day with coins earned.
				$knight_stats = KnightsStats::model()->findByPk( $job->knights_id );
				if( $knight_stats ){
					$knight_stats->money_total_earned += $job->hours*$app_rule_level[$job->knight_level]->cache;
					if( !$knight_stats->save() ) Yii::trace( '[JOBS][actionPayJobs] No se han podido actualizar las estadisticas del caballero', 'error' );					
				}else{
					Yii::trace( '[JOBS][actionPayJobs] No hay stats del caballero', 'error' );
				}
				$knight_stats_by_date = KnightsStatsByDate::model()->find( 'knights_id = :knights_id AND date = :date', array(':knights_id'=>$job->knights_id, 'date'=>substr($job->date, 0,10) ) );
				if( !$knight_stats ){
					$knight_stats_by_date = new KnightsStatsByDate();
					$knight_stats_by_date->attributes = array(
						'knights_id'=>$job->knights_id,
						'date'=>substr($job->date, 0,10)
					);
				}
				$knight_stats_by->money_total_earned += $job->hours*$app_rule_level[$job->knight_level]->cache;
				if( !$knight_stats_by_date->save() ) Yii::trace( '[JOBS][actionPayJobs] No se han podido actualizar las estadisticas por día del caballero', 'error' );
					
			}
		}		
	}
	
	/**
	 * This function resolve item search of user.
	 * Under development.
	 * Identificator 2
	 */
	public function actionResolveItemSearch(){
		$controlCronJobId = 2;
	}
	
	/**
	 * Health knights. 
	 * Search in healths table all knights with a expired date of healing. Knights recovery 'constitution / 2' points of pain. If pain is greather than 0 then update
	 * the next healing date to next hour. If pain is 0 or less then next healing date is set null. 
	 * TIME: every minute of all days.
	 * identificator 3
	 */
	public function actionHealings(){
		$controlCronJobId = 3;
		//Search all next healings
		$result = Healings::model()->with( array( 'knights'=>array('knightsCard') ) )->findAll( 'next_healing_date IS NOT NULL AND next_healing_date < :date', array(':date'=>date('Y:m:d H:i:s')) );
		
		if( count( $result) > 0 ){
			foreach($result as $healing ){
				//Calculate new pain
				$healing_points = floor($healing->knights->knightsCard->constitution / 2);
				$healing->knights->pain -= ( $healing_points > 0)?$healing_points:1;//All healings recovery one point of pain at least 
								
				//Check next healing
				if( $healing->knights->pain > 0 ){
					$healing->next_healing_date =  date( "Y-m-d H:i:s", strtotime($healing->next_healing_date.' +'.Yii::app()->params['healingTime'].' seconds') );
				}else{
					$healing->knights->pain = 0;
					$healing->next_healing_date = null;
				}
				
				//Update knights and healings
				if( !$healing->knights->save() ){
					Yii::trace( '[CRONJOB][actionHealings] No se puede actualizar el caballero.', 'error' );
				}
				if( !$healing->save() ){
					Yii::trace( '[CRONJOB][actionHealings] No se puede actualizar la curación.', 'error' );
				}
			}
		}
		
		
	}
	
	/**
	 * Update app stats
	 * All days to 00:00:00 we update app_stats_by_date with sum of knights_stats_by_date and the result add to app_stats.
	 * We have the problem of combats than they not finished in the same day ... we would think about these.
	 * identificator 4
	 */
	public function actionUpdateAppStats(){
		$controlCronJobId = 4;
	}
	
	/**
	 * Send pending emails
	 * Execute all minutes
	 * identificator 5 
	 */
	public function actionSendPendingEmails(){
		$controlCronJobId = 5;
		
		//Check control job
		$control = ControlCronjobs::model()->findByPk($controlCronJobId);
		//Check if status is 0 for to execute
		if( $control->status == 0 ){
			$control->status = 1;
			if( $control->save() ){
				//Search all pending emails
				$emails = Emails::model()->findAll( 'status = :status', array( ':status'=>Emails::STATUS_PENDING) );
				if( count($emails) ){
					foreach($emails as $email){		
						if( Yii::app()->email->send( 'noreply@campeonatojustasmedievales.com',$email->destination , $email->title ,$email->body, array($email->headers) ) ){
							$email->status = Emails::STATUS_SENDED;					 	
							Yii::trace( '[CRONJOBS][actionSendPendingEmails] email enviado.' );
						}else{
							$email->status = Emails::STATUS_ERROR;
							Yii::trace( '[CRONJOBS][actionSendPendingEmails] No se puede enviar el email.', 'error' );
						}
						
						$email->date = date('Y-m-d H:i:s');
						if( !$email->save() ){
							Yii::trace( '[CRONJOBS][actionSendPendingEmails] No se puede actualizar el email a enviado', 'error' );
						}
					}
				}
				//Free job
				$control->status = 0;
				if( !$control->save()){
					Yii::trace( '[CRONJOBS][actionSendPendingEmails] No se ha podido salvar el control de proceso una vez finalizado.', 'warning' );
				}
			}else{
				Yii::trace( '[CRONJOBS][actionSendPendingEmails] No se ha podido salvar el control de proceso.', 'warning' );
			}
		}else{
			Yii::trace( '[CRONJOBS][actionSendPendingEmails] Hay otra ejecución en proceso.', 'warning' );
		}
	}
	
	
	
	public function actionTest(){
		
		var_dump( KnightsSettings::model()->findByPk( 3 ) );
		
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
}