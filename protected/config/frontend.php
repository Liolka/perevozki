<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
    
    array(
		
		'name'=>'Скороход',
		'theme'=>'perevozkin',
        
        
        // стандартный контроллер
        //'defaultController' => 'catalogcategories',
        
        // компоненты
        'components'=>array(


			// uncomment the following to enable URLs in path-format
			
			
			'urlManager'=>array(
				'class'=>'UrlManager',
				'showScriptName'=>false,
				'urlFormat'=>'path',
				'urlSuffix' => '.html',
				'rules'=>array(
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),
			/**/


			// mailer
			/*
			'mailer'=>array(
				'pathViews' => 'application.views.backend.email',
				'pathLayouts' => 'application.views.email.backend.layouts'
			),
			*/			

        ),
    )
);
?>