<?php
$rootPath = dirname(__FILE__);

require($rootPath . '/protected/components/Environment.php');

// change the following paths if necessary
$yii = $rootPath . '/../../yii/framework/yii.php';

$host = $_SERVER['HTTP_HOST'];
$environment = new Environment($host, $rootPath);
$environment->buildConfiguration();
$config = $environment->getConfigPath();

//Load config development or production
//if ($environment->isProductionEnvironment()) {
//        $config=dirname(__FILE__).'/protected/config/production.php';
//} else if ($environment->isPreProduction()) {
//        $config=dirname(__FILE__).'/protected/config/pre-production.php';
//        // remove the following lines when in production mode
//        defined('YII_DEBUG') or define('YII_DEBUG',true);
//        // specify how many levels of call stack should be shown in each log message
//        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//} else {
//        $config=dirname(__FILE__).'/protected/config/development.php';
//        // remove the following lines when in production mode
//        defined('YII_DEBUG') or define('YII_DEBUG',true);
//        // specify how many levels of call stack should be shown in each log message
//        defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
//}


require_once($yii);
Yii::createWebApplication($config)->run();