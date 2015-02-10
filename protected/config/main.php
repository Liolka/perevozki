<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'perevozki',
	'sourceLanguage' => 'en',
	'language' => 'ru',
	'homeUrl'=>'http://perevozki.gf-club.net',
	

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',

		'application.modules.user.*',
		'application.modules.user.models.*',
		'application.modules.user.components.*',

		'application.modules.pages.*',
		'application.modules.pages.models.*',
		/*		
		'application.modules.rights.*',
		'application.modules.rights.models.*',
		'application.modules.rights.components.*',
		*/
		'ext.aadThumbnails.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
            'generatorPaths' => array(
                'bootstrap.gii'
            ),			
			'class'=>'system.gii.GiiModule',
			'password'=>'alexey27',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1','91.149.156.111'),
		),
		

        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => true,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/user/profile'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
		
		'rights'=>array(
			//'install'=>true,
		),
		
		'pages' => array(
			'class' => 'application.modules.pages.PagesModule',
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			//'class'=>'RWebUser',
			'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl' => array('/user/login'),
		),
		/*
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'defaultRoles' => array('Guest'),
            'rightsTable' => '{{rbac_Rights}}',
            'itemTable' => '{{rbac_AuthItem}}',
            'itemChildTable' => '{{rbac_AuthItemChild}}',
            'assignmentTable' => '{{rbac_AuthAssignment}}',
		),
		*/
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=gfclubne_orisad',
			'emulatePrepare' => true,
			'username' => 'gfclubne_orisad',
			'password' => 'wkd?S#}nDVFk',
			'charset' => 'utf8',
			'tablePrefix' => '1gsk_',			
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

	
		'clientScript'=>array(
			
			'packages'=>array(
				/*
				'jquery' => array(
					'baseUrl' => '/',
					'js' => array('js/jquery.2.0.3.min.js'),
				),			
				*/
				
				'image_popup' => array(
					'baseUrl' => '/js/lightbox',
					//'js' => array('js/jquery-ui-1.8.18.custom.min.js', 'js/jquery.smooth-scroll.min.js', 'js/lightbox.js', 'js/init.js'),
					'js' => array('js/lightbox.js', 'js/init.js'),
					'css' => array('css/lightbox.css'), // mylightboxstyle.css тоже в папке WEB_ROOT/jq
					'depends' => array('jquery'),
				),
				
				'fancybox' => array(
					'baseUrl' => '/',
					//'js' => array('js/jquery.fancybox-1.3.4.pack.js', 'js/lightbox.js', 'js/fancybox-init.js'),
					'js' => array('js/jquery.fancybox-1.3.4.pack.js', 'js/fancybox-init.js'),
					'css' => array('css/jquery.fancybox-1.3.4.css'),
					'depends' => array('jquery'),
				),

				'formstyler' => array(
					'baseUrl' => '/',
					'js' => array('js/formstyler/jquery.formstyler.min.js', 'js/formstyler/jquery.formstyler.init.js'),
					'css' => array('js/formstyler/jquery.formstyler.css '),
					'depends' => array('jquery'),
				),
				
				'jcarousel' => array(
					'baseUrl' => '/',
					'js' => array('js/jcarousel/jquery.jcarousel.min.js'),
					'css' => array('js/jcarousel/jcarousel.basic.css '),
					'depends' => array('jquery'),
				),
				
				'jcarousel-new-positions' => array(
					'baseUrl' => '/',
					'js' => array('js/jcarousel/jcarousel.new-positions.js'),
					'depends' => array('jcarousel'),
				),
				
				'jcarousel-products-on-auto' => array(
					'baseUrl' => '/',
					'js' => array('js/jcarousel/jcarousel.products-on-auto.js'),
					'depends' => array('jcarousel'),
				),
				
				'bootstrap-pack' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/bootstrap/bootstrap.min.js',
						'js/bootstrap/bootstrap-tooltip-init.js',
						'js/bootstrap/bootstrap-tab.js',
						'js/bootstrap/bootstrap-tab-init.js',
						'js/bootstrap/bootstrap-switch.min.js',
					),
					'css' => array(
						'css/bootstrap/bootstrap.min.css',
						'css/bootstrap/bootstrap-theme.min.css',
						'css/bootstrap/bootstrap-switch.min.css',
					),
				),
				
				'scripts' => array(
					'baseUrl' => '/',
					'js' => array('js/scripts.js'),
					'depends' => array('jquery'),
				),
            ),
        ),	
	),

	'behaviors'=>array(
		'runEnd'=>array(
			'class'=>'application.behaviors.WebApplicationEndBehavior',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'pagination' => array('per_page' => 30, 'products_per_page' => 10),		//параметры для пагинации
		'images_live_url' => 'http://perevozki/',
	),
);