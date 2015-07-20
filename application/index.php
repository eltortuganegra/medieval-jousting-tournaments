<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii/framework/yii.php';


//Load config development or production
if( $_SERVER['HTTP_HOST']=='medievaljoustingtournaments.com'){
        $config=dirname(__FILE__).'/protected/config/production.php';
        // remove the following lines when in production mode
       // defined('YII_DEBUG') or define('YII_DEBUG',true);
        // specify how many levels of call stack should be shown in each log message
        //defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}elseif ( $_SERVER['HTTP_HOST']=='pre-production.medievaljoustingtournaments.com' ){
        $config=dirname(__FILE__).'/protected/config/pre-production.php';
        // remove the following lines when in production mode
        defined('YII_DEBUG') or define('YII_DEBUG',true);
        // specify how many levels of call stack should be shown in each log message
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}else{
        $config=dirname(__FILE__).'/protected/config/development.php';
        // remove the following lines when in production mode
        defined('YII_DEBUG') or define('YII_DEBUG',true);
        // specify how many levels of call stack should be shown in each log message
        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}



require_once($yii);
Yii::createWebApplication($config)->run();