<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Abra Valley Colleges HRIS',

	// preloading 'log' component
	'preload'=>array('log','bootstrap'),
	'theme'=>'bootstrap',

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.evaluation.models.*',
		'application.modules.profile.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'evaluation',
		'profile',	
		'admin',
		'recruitment',
		'leave',
	
		'gii'=>array(
			'generatorPaths' => array(
						'bootstrap.gii'
				),
			'class'=>'system.gii.GiiModule',
			'password'=>'secret',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'bootstrap' => array(
				'class' => 'ext.bootstrap.components.Bootstrap',
				'responsiveCss' => FALSE,
				'fontAwesomeCss' => TRUE,
				
				
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		//'db'=>array(
		//	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		//),
		// uncomment the following to use a MySQL database
		
	/*	'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=hrmisallanlao2',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'qwerty',
			'charset' => 'utf8',
		),
	*/	
		
		'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=hrmis_avc',
				'emulatePrepare' => true,
				'username' => 'root',
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
				// uncomment the following to show log messages on web pages
				
			//	array(
			//		'class'=>'CWebLogRoute',
			//	),
				
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	 'params' => array(
        // this is used in contact page
        'adminEmail' => 'admin@avc.edu',
        'clinic_head' => 1070, //
        'hr_head' => 841, //
        'director' => 24, //
        'hr_email' => 'hr@avc.edu',
        'company_name' => 'Abra Valley Colleges HRIS'
    ),
);