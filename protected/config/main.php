<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SSBM Venezuela',
	'language'=>'es',
	'defaultController'=>'jugador/admin',
	'theme'=>'classic',

	// preloading 'log' component
	'preload'=>array(
		'log',
		'booster',
	),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
		'application.modules.rights.*',
		'application.modules.rights.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'application.gii',
				'booster.gii',

			),
		),
		'rights'=>array(
			'superuserName'=>'Admin',
			'authenticatedName' =>'Authenticated'
			//'install'=>true,
		)
	),

	// application components
	'components'=>array(
		'curl' => array(
			'class' => 'ext.curl-master.Curl',
			'options' => array(/* additional curl options */),
		),

		'user'=>array(
			// enable cookie-based authentication
			'class'=>'RWebUser',
			'loginUrl'=>array(
				'site/login'
			),
			'allowAutoLogin'=>true,
		),

		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'connectionID'=>'db',
			'defaultRoles' =>array(
				'Authenticated', 'Guest'
			),
		),

		'booster'=>array(
			'class'=>'ext.booster.components.Booster',
			'responsiveCss'=>true,
			'fontAwesomeCss'=>true,
			'enableBootboxJS'=>false,
			'enableNotifierJS'=>false,
		),

		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),


		// database settings are configured in database.php
		'db'=>array(
			'connectionString'=>'mysql:host=localhost;dbname=ssbmvzla',
			'username'=>'root',
			'password'=>'18946172',
			'charset'=>'utf8',
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
					'levels'=>'error, warning, trace',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
	),
);
