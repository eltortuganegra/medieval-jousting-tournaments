<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'DEV Campeonato justas medievales',	

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.KEmail.KEmail'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		)		
	),

	// application components
	'components'=>array(
		
		 //Session in db		 
		/*			
		'session'=>array(
			'class' => 'CDbHttpSessionUser',
			'connectionID' => 'db',
            'sessionTableName'  =>  'sessions',
            'autoCreateSessionTable' => false,
            'timeout' => 1440
            //Extension properties
           // 'compareIpAddress'=>true,
           // 'compareUserAgent'=>true,
           // 'compareIpBlocks'=>0
		),
		*/
		'session'=>array(
			'class'=>'CCacheHttpSession',
			'cacheID'=>'cache'
		),
		'cache'=>array(
			'class'=>'system.caching.CMemCache',
			'useMemcached'=>true,				
			'servers'=>array(
				array( 'host'=>'localhost', 'port'=>11211 )
			),				
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		//Vista
		'viewRenderer'=>array(
				'class'=>'ext.smarty.ESmartyViewRender',
		),				
		// uncomment the following to enable URLs in path-format		
		'urlManager'=>array(
			'urlFormat'=>'path',			
			/*	'rules'=>array(
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			*/
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=caballeros',
			'emulatePrepare' => true,
			'username' => '',
			'password' => '',
			'charset' => 'utf8',
		),		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'trace',
					'logFile'=>'traceMessages.log'
				),
				array(
						'class'=>'CFileLogRoute',
						'levels'=>'info',
						'logFile'=>'infoMessages.log'
				)
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'email'=>array(
                'class'=>'KEmail',
                'host_name'=>'', //Hostname or IP of smtp server
				'user'=>'',
				'password'=>'',
				'host_port'=>465,
				'ssl'=>'true',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'keypassword'=>'',
		'adminEmail'=>'',
		'url_domain'=>'http://campeonatojustasmedievales.dev:8090',
		'statics_cdn'=>'http://campeonatojustasmedievales.dev:8090',
		'paths' => array(
			'icons'=>'/images/icons/',
			'avatars'=>'/images/avatars/',
			'items'=>'/images/items/',
			'general'=>'/images/general/'
		),		
		'email_templates_path'=>'/views/emails/',
		'security'=>array(
			'password_md5_algo'=>'md5',
			'password_sha512_algo'=>'sha512',
		),
		'cacheKeys'=>array(
			'knights'=>'knight_id_',
			'knights_by_name'=>'knight_by_name_',
			'knights_card'=>'knights_card_id_',
			'knights_stats'=>'knights_stats_id_',
			'combat_for_knights_id'=>'combat_for_knights_id',//identificator of combat for this knight
			'combat'=>'combat_id_',
			'knight_connected'=>'knight_connected_id_'
		),
		'cachetime'=>array(
			'appSetting'=> 86400,//24 hours
			'knight'=>1200,//20 minutes
			'friends'=>300,//5minutes
			'combat'=>300,//5 minutes
		),
		'knight_default'=> array(
			'level'=>2,
			'experiencie_earned'=>2700,//Que es el nivel 2
			'experiencie_used' => 880,//Para subir al nivel 1 como mínimo
		),
		'inventory'=>array(
			'useEquipmentPosition'=>10,
			'maxPosition'=>42
		),		
		'messages'=>array(
			'max_lenght_short'=>70,
			'max_by_page' => 10
		),
		'events'=> array(
			'event_last'=>array(
				'maximum'=> 25 //max events
			)
		),
		'desqualifyTime'=>5, //Maximun time for countdown
		'healingTime'=>60,	//in seconds
	),
);