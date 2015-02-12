<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<?



?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->theme_baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="wrapper">
	<div class="wrapperPage">
		<div class="header">
			<div class="header-row1">
				<div class="width-wrap">
					<?php $this->widget('zii.widgets.CMenu',array(
						'items'=>array(
							array('label'=>'Как это работает', 'url'=>array('/')),
							array('label'=>'Гарантии', 'url'=>array('/pages/view', 'id'=> 1)),
							array('label'=>'Контакты', 'url'=>array('/site/oplataidostavka'), 'itemOptions'=>array('class'=>'contacts')),
							array('label'=>'Помощь грузодателю', 'url'=>array('/site/contact'), 'itemOptions'=>array('class'=>'gruzodatel')),
							array('label'=>'Помощь перевозчику', 'url'=>array('/site/contact'), 'itemOptions'=>array('class'=>'perevozchik')),
							array('label'=>'Регистрация', 'url'=>array('/'), 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'reg login-items')),
							array('label'=>'или', 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'separator login-items')),
							array('label'=>'Вход', 'url'=>array('/'), 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'login login-items')),
							
							//array('label'=>'Вход', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
							//array('label'=>'Выход ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),

							//array('label'=>'Отзывы', 'url'=>array('/site/feedback'), 'itemOptions'=>array('class'=>'last-item'),),
						),'htmlOptions' => array('class'=>'header-row1-menu clearfix', 'id'=>'header-row1-menu')
					)); ?>
					
				</div>
			</div>
			<div class="header-row2">
				<div class="width-wrap clearfix">
					<a href="/" class="logo-top"><img src="<?=$this->theme_baseUrl?>/images/logo-top.png" alt="Перевозкин" /></a>
					<p class="buttons-block">
						<a href="#" class="btn-green-52 btn-zakazhu">Закажу перевозку</a>
						<a href="#" class="btn-blue-52 btn-perevezu">Перевезу груз</a>
					</p>
					<p class="questions">
						<span class="title">Есть вопросы?</span>
						+375 (33) <span class="phone-numb">678-98-11</span>
					</p>
				</div>
			</div>
			
			<?
			/*
			<div class="header-block width-wrap clearfix">
				<div class="block1 floatLeft">
					<?php //$this->widget('application.components.SearchWidget'); ?>
				</div>
				<div class="block2 floatRight">
					<?php //$this->widget('application.components.ContactsWidget'); ?>
					<?php //$this->widget('application.components.ConsultantWidget'); ?>					
				</div>
			
				<?php //$this->widget('application.components.CurrencyWidget'); ?>
			
			</div>
			*/
			?>
		</div>
		
		<div class="map-block">
			<p class="info">
				<span>Любой груз в любую точку</span>
				<a href="#" class="btn-green-66 btn-zakazhu">Закажу перевозку</a>
				<a href="#" class="btn-blue-66 btn-perevezu">Перевезу груз</a>
			</p>
		</div>
		
		<div class="stages-block clearfix">
			<ul>
				<li class="stage1">
					<p class="title">Размещаете заявку на перевозку</p>
					<p class="descr">Опишите груз и уточните маршрут</p>
				</li>
				<li class="stage2">
					<p class="title">Получаете предложения от перевозчиков</p>
					<p class="descr">Обращайте внимание на отзывы о перевозчике. Уточните все детали перевозки</p>
				</li>
				<li class="stage3">
					<p class="title">Выбираете подходящее предложение</p>
					<p class="descr">Перевозчик сам свяжется с вами. Оставьте отзыв после выполнения перевозки</p>
				</li>
			</ul>
		</div>

		<div class="middle">
			<div class="width-wrap">
			
				<?php if(isset($this->breadcrumbs)):?>
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'links'=>$this->breadcrumbs,
					)); ?><!-- breadcrumbs -->
				<?php endif?>
			
			
				<?php //$this->widget('application.components.SearchAutoWidget'); ?>
				<div class="central clearfix"><?php echo $content; ?></div>
			</div>
			
			<div class="statistic-block clearfix">
				<ul>
					<li><span>61759 гузов</span> Перевезено</li>
					<li><span>900 000 тонн</span> Общей массой</li>
					<li><span>500 000 км</span> Преодолено</li>
				</ul>
			</div>
			
			<div class="benefits-block clearfix">
				<p class="header">Преимущества сервиса</p>
				<ul>
					<li><span>Мы экономим ваше время</span> Обращайте внимание на отзывы о перевозчике. Уточните все детали перевозки</li>
					<li><span>Мы экономим ваши нервы</span> Обращайте внимание на отзывы о перевозчике. Уточните все детали перевозки</li>
					<li><span>Мы экономим ваши деньги</span> Обращайте внимание на отзывы о перевозчике. Уточните все детали перевозки</li>
				</ul>
			</div>
			
			
		</div>
		
		
	</div>
	
	
	<div class="footer">
		<div class="width-wrap clearfix">
			<div class="footer-cell">
				<a href="/" class="logo-bottom"><img src="<?=$this->theme_baseUrl?>/images/logo-bottom.png" alt="Перевозкин" /></a>
				<p class="questions">
					<span class="title">Есть вопросы?</span>
					+375 (33) 678-98-11
				</p>
				<div class="created-by">
					Разработка сайта - <a href="#" title="Farba Studio">Farba Studio</a>
				</div>
				
			</div>
			<div class="footer-cell">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Закажу перевозку', 'url'=>array('/')),
						array('label'=>'Помощь грузодателю', 'url'=>array('/')),
						array('label'=>'Рейтинг перевозчиков', 'url'=>array('/')),
					),'htmlOptions' => array('class'=>'footer-menu', 'id'=>'footer-menu1')
				)); ?>
				
			</div>
			<div class="footer-cell">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Перевезу груз', 'url'=>array('/')),
						array('label'=>'Помощь перевозчику', 'url'=>array('/')),
						array('label'=>'Рейтинг перевозчиков', 'url'=>array('/')),
					),'htmlOptions' => array('class'=>'footer-menu', 'id'=>'footer-menu2')
				)); ?>
			</div>
			<div class="footer-cell">
				<?php $this->widget('zii.widgets.CMenu',array(
					'items'=>array(
						array('label'=>'Как работает сайт', 'url'=>array('/')),
						array('label'=>'Частые вопросы', 'url'=>array('/')),
						array('label'=>'Интернет-магазинам', 'url'=>array('/')),
						array('label'=>'Система рейтинга', 'url'=>array('/')),
						array('label'=>'Гарантии', 'url'=>array('/')),
						array('label'=>'Контакты', 'url'=>array('/')),
					),'htmlOptions' => array('class'=>'footer-menu', 'id'=>'footer-menu3')
				)); ?>
			</div>

			<div class="footer-cell footer-cell-last">
					<?php $this->widget('zii.widgets.CMenu',array(
						'items'=>array(
							array('label'=>'Вход', 'url'=>array('/'), 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'login login-items')),
							array('label'=>'или', 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'separator login-items')),
							array('label'=>'Регистрация', 'url'=>array('/'), 'visible'=>$this->app->user->isGuest, 'itemOptions'=>array('class'=>'reg login-items')),							
						),'htmlOptions' => array('class'=>'footer-menu', 'id'=>'footer-menu4')
					)); ?>
			</div>


 		</div>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
