<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Скороход',
	'sourceLanguage' => 'en',
	'language' => 'ru',
	'homeUrl'=>'http://skorohod.by/',
	

	// preloading 'log' component
	'preload'=>array('log'),
	
	'aliases' => array(
		'bootstrap' => 'application.modules.bootstrap'
	),	

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
		
		'bootstrap.behaviors.*',
		'bootstrap.helpers.*',
		'bootstrap.widgets.*'
		
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
			'ipFilters'=>array('127.0.0.1','::1','91.149.156.111', '93.125.44.177',),
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
            'loginUrlModal' => array('/user/loginmodal'),
 
            # page after login
            'returnUrl' => array('/user/my'),
 
            # page after logout
            //'returnLogoutUrl' => array('/user/login'),
            'returnLogoutUrl' => array('/'),
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
			'connectionString' => 'mysql:host=localhost;dbname=neoli357_skoro',
			'emulatePrepare' => true,
			'username' => 'neoli357_skoro',
			'password' => 'vfca3X8D',
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
		
		'image' => array (
			'class'=>'application.extensions.image.CImageComponent',
			// GD or ImageMagick
			'driver'=>'GD',
			// ImageMagick setup path
			'params'=>array('directory'=>'/opt/local/bin'),
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
					'js' => array('js/lightbox.js', 'js/init.js'),
					'css' => array('css/lightbox.css'), // mylightboxstyle.css тоже в папке WEB_ROOT/jq
					'depends' => array('jquery'),
				),
				
				'fancybox' => array(
					'baseUrl' => '/',
					'js' => array(
                        'js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js', 
                        'js/fancyBox/source/jquery.fancybox.js?v=2.1.5', 
                        'js/fancyBox/source/fancybox-init.js'
                    ),
					'css' => array(
                        'js/fancyBox/source/jquery.fancybox.css?v=2.1.5',
                    ),
					'depends' => array('jquery'),
				),

				'formstyler' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/formstyler/jquery.formstyler.min.js', 
						'js/formstyler/jquery.formstyler.init.js'
					),
					'css' => array('js/formstyler/jquery.formstyler.css '),
					'depends' => array('jquery'),
				),
				
				'jcarousel' => array(
					'baseUrl' => '/',
					'js' => array('js/jcarousel/jquery.jcarousel.min.js'),
					'css' => array('js/jcarousel/jcarousel.basic.css '),
					'depends' => array('jquery'),
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
					'depends' => array('jquery'),
				),
				
				'bootstrap-js' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/bootstrap/bootstrap.min.js',
						'js/bootstrap/bootstrap-tooltip-init.js',
						'js/bootstrap/bootstrap-tab.js',
						'js/bootstrap/bootstrap-tab-init.js',
						'js/bootstrap/bootstrap-switch.min.js',
					),
				),
				'ajax-upload' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/jquery.ajax.upload.js',
					),
					'depends' => array('jquery'),
				),
				
				'flexcroll' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/flexcroll.js',
					),
					'css' => array(
						'css/flexcrollstyles.css',
						'css/tutorsty.css',
					),
				),
				
				'rating' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/jquery.rating.pack.js',
						'js/jquery.MetaData.js',
					),
					'css' => array(
						'css/jquery.rating.css',
					),
					'depends' => array('jquery'),
				),
				
				'simplyCountable' => array(
					'baseUrl' => '/',
					'js' => array(
						'js/jquery.simplyCountable.js',
					),
					'depends' => array('jquery'),
				),
				
				
				'template' => array(
					'baseUrl' => '/',
					'js' => array('js/scripts.js'),
                    'css' => array('themes/perevozkin/css/screen.css'),
					'depends' => array('jquery'),
				),
            ),
        ),
		
		'dpsMailer' => array(
				'class' => 'ext.dpsmailer.components.dpsMailer',
				'sViewPath' => './protected/views/email', // путь к шаблонам
				'aFrom' => array( 'suport@skorohod.by' => 'Администрация' ), // от кого будут отправляться письма по умолчанию
				'aBehaviors' => array(
					'swift' => array(
						'class' => 'ext.dpsmailer.behaviors.dpsSwiftMailerBehavior',
						'sLibPath'=> './protected/extensions/swiftmailer/lib', // путь к папке, c библиотекой swift http://swiftmailer.org/
						'sTransport' => 'Swift_SmtpTransport',
						'aOptions' => array(// настройки swift
							'Host'            => 'mail.skorohod.by',
							'Port'            => 465,
							'Encryption'        => 'ssl',
							'Username'        => 'suport@skorohod.by',
							'Password'        => 'fJqjKJ5B',
						),
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
		'transport_imageLive' => '/images/transport/',
		'transport_imagePath' => 'webroot.images.transport',
		'transport_tmb_params' => array('width' => 105, 'height' => 105),	//параметры для создания миниатюр
		
		'UnitsListArray' => array(
			1 => array('id' => 1, 'name' => 'кг'),
			2 => array('id' => 2, 'name' => 'тонн'),
		),
	),
);