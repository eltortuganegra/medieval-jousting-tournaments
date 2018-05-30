<?php

$rootPath = dirname(__FILE__);
require($rootPath . '/protected/components/Environment.php');

$host = $_SERVER['HTTP_HOST'];
$environment = new Environment($host, $rootPath);
$environment->buildConfiguration();
$configPath = $environment->getConfigPath();


$yiiPath = $rootPath . '/../../yii-1.1.11.58da45/framework/yii.php';
require_once($yiiPath);

Yii::createWebApplication($configPath)->run();