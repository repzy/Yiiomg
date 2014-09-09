<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Web Application',
	

	// preloading 'log' component
	'preload'=>array(
		'log',
		'booster',
		'bootstrap',
		),

    
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.user.models.*',
	    'application.modules.user.components.*',
	    'application.modules.rights.*',
	    'application.modules.rights.models.*',
	    'application.modules.rights.components.*', 
	    'ext.eoauth.*',
	    'ext.eoauth.lib.*',
	    'ext.lightopenid.*',
	    'ext.eauth.*',
	    'ext.eauth.services.*',
	    'bootstrap.helpers.TbHtml',
        'bootstrap.helpers.TbArray',
        'bootstrap.behaviors.TbWidget',
        'booster.helpers.TbHtml',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'admin',
		'user'=>array(
		    'hash' => 'md5',
		    'sendActivationMail' => true,
		    'loginNotActiv' => false,
            'activeAfterRegister' => false,
     	    'autoLogin' => true,
		    'registrationUrl' => array('/user/registration'),
		    'recoveryUrl' => array('/user/recovery'),
		    'loginUrl' => array('/user/login'),
		    'returnUrl' => array('/user/profile'),
		    'returnLogoutUrl' => array('/user/login'),
	    ),
    	'rights',
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths' => array('bootstrap.gii'),
		),
		
	),

	// application components
		'components'=>array(
			'user'=>array(
		        'allowAutoLogin'=>true,
		        'class' => 'RWebUser'
		    ),
		
			'db'=>array(
		        'connectionString' => 'mysql:host=localhost;dbname=blog',
		        'emulatePrepare' => true,
		        'username' => 'root',
		        'password' => '',
		        'charset' => 'utf8',
		        'tablePrefix' => 'tbl_',
		    ),

		    'authManager'=>array(
		        'class'=>'RDbAuthManager',
		        'defaultRoles' => array('Guest,ServiceAuth'),
		    ),

		    'eauth' => array(
			    'class' => 'ext.eauth.EAuth',
			      // Использовать всплывающее окно вместо перенаправления.
			    'popup' => true,
			      // Имя компонента кэширования или false для отключения.
			      // По умолчанию 'cache'.
			    'cache' => false,
			      // Время жизни кэша.
		        'cacheExpire' => 0,
			      // Провайдеры
	    	    'services' => array(
			        'vkontakte' => array(
			          //register your app here: https://vk.com/editapp?act=create&site=1
			            'class' => 'VKontakteOAuthService',
			            'client_id' => '...',
			            'client_secret' => '...',
			        ),

			        'facebook' => array(
		                'class' => 'FacebookOAuthService',
		                'client_id' => '...',
		                'client_secret' => '...',
		            ),

		            'twitter' => array(
		                'class' => 'TwitterOAuthService',
		                'key' => '...',
		                'secret' => '...',
		            ),
			    ),
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
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					*/
				),
			),
			/*'bootstrap' => array(
            	'class' => 'bootstrap.components.TbApi',   
        	),*/

        	'booster' => array(
    			'class' => 'booster.components.Booster',
			),
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
		

	'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary	
        'booster'  => realpath(__DIR__ . '/../extensions/booster'),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);