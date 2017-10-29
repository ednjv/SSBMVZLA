<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$loader = require(dirname(__FILE__) . '/protected/vendor/autoload.php');
Yii::$classMap = $loader->getClassMap();

// load custom environment variables
$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/vendor/yiisoft/yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
