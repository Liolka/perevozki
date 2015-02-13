<?php
return CMap::mergeArray(

    require_once(dirname(__FILE__).'/main.php'),
    
    array(
		'name'=>'perevozkin_backend',
		'theme'=>'perevozkin_cms',
		
		

        // стандартный контроллер
        //'defaultController' => 'shopcategories',
        //'defaultController' => 'companiescategories',
		
		'aliases' => array(
			'bootstrap' => 'application.modules.bootstrap'
		),
		
		'import' => array(

			'bootstrap.behaviors.*',
			'bootstrap.helpers.*',
			'bootstrap.widgets.*'
		),		
        
        // компоненты
        'components'=>array(
            
            // пользователь
            'user'=>array(
                //'loginUrl'=>array('/site/login'),
            ),
			

			// mailer
			'mailer' => array (
				'pathViews' => 'application.views.backend.email',
				'pathLayouts' => 'application.views.email.backend.layouts'
			),
			
			'image' => array (
				'class'=>'application.extensions.image.CImageComponent',
				// GD or ImageMagick
				'driver'=>'GD',
				// ImageMagick setup path
				'params'=>array('directory'=>'/opt/local/bin'),
			),
			
			'bootstrap' => array(
				'class' => 'bootstrap.components.BsApi'
			),
			
			'BsHtml' => array(
				'class' => 'bootstrap.helpers.BsHtml'
			),			
			

        ),
		
		'params'=>array	(
			'product_imagePath' => 'webroot.images.shop.products',
			'product_images_liveUrl' => '/images/shop/products/',
			'product_tmb_params' => array('width' => 215, 'height' => 215),	//параметры для создания миниатюр
			
			'pageSize' => 25,
			'selectPageCount' => array(
				'20' => '25',
				'30' => '30',
				'50' => '75',
				'100' => '100',
				'500' => '500',
				'1000000' => 'Все',
			),		
		),		
    )
);
?>