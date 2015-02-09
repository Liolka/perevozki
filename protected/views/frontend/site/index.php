<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;


?>


<?php $this->widget('application.components.NewProductsWidget'); ?>



<div class="news-block clearfix">
	<div class="news-block-shop floatLeft width50">
		<div class="header-wr">
			<h3 class="uppercase">Новости магазина</h3>
			<a href="#" class="all-items">Все новости магазина</a>			
		</div>
		<div class="news-block-body news-block-body-shop">
			<ul>
				<li class="news-block-item news-block-item-first">
					<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
					</div>
				</li>
				<li class="news-block-item" >
					<img src="<?=$images_live_url?>images/turbo2.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Завершена работа по установки переднего бампера RS4 на AUDI A4 B6 от компании S-TURBO.BY </a>
					</div>
				</li>
				<li class="news-block-item news-block-item-last">
					<img src="<?=$images_live_url?>images/turbo3.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>						
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<div class="news-block-companies floatLeft width50">
		<div class="header-wr">
			<h3 class="uppercase">Новости компаний</h3>
			<a href="#" class="all-items">Все новости компаний</a>
		</div>
		<div class="news-block-body news-block-body-companies">
			<ul>
				<li class="news-block-item news-block-item-first">
					<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
						
					</div>
				</li>
				<li class="news-block-item">
					<img src="<?=$images_live_url?>images/turbo1.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
					</div>
					
				</li>
				<li class="news-block-item news-block-item-last">
					<img src="<?=$images_live_url?>images/turbo3.jpg" alt="turbo1.jpg" />
					<div class="text-block">
						<span class="created">29.10.2014</span>
						<a href="" class="item-title">Чип-тюнинг бокс OBD - чипуй сам!</a>
					</div>
				</li>
			</ul>

		</div>		
	</div>
</div>

<div class="products-on-auto news-block">
	<div class="header-wr">
		<h3 class="ptsans-bold uppercase">Наши товары на вашем авто</h3>
		<a href="#" class="all-items">Открыть галерею</a>
	</div>
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-products-on-auto">
			<ul class="jcarousel products-on-auto-list">
				<li class="products-on-auto-item floatLeft">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo1.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo2.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo2.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>mages/turbo3.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo3.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo1.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo1.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo2.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo2.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
				<li class="products-on-auto-item floatLeft ">
					<a class="fancybox" rel="group" href="<?=$images_live_url?>images/turbo3.jpg">
						<span class="hover-span"><span class="hover-span-ico sprite"> </span></span>
						<img src="<?=$images_live_url?>images/turbo3.jpg" alt="" class="medium-image" id="medium-image">
					</a>					
				</li>
			</ul>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-products-on-auto-control-prev sprite">‹</a> <a href="#" class="jcarousel-control-next jcarousel-products-on-auto-control-next sprite">›</a>
	</div>

</div>


<div class="content-text">
	<h2>ИНТЕРНЕТ-МАГАЗИН S-TURBO.BY</h2>
	<p>S-Turbo.BY –  уникальный на белорусском профессиональном пространстве проект с перспективой роста до крупнейшего в РБ портала специалистов и любителей автотюнинга. В отличие от других подобных тюнинг – магазинов, S-Turbo.BY это беспрецедентный проект, который объединяет в себе сразу несколько видов деятельности.</p>
	<p>•    Интернет - магазин тюнинга<br />Это основная и самая важная часть нашей работы. Мы продаем автоаксессуары для тюнинга от лучших мировых  производителей и с каждым днем наш ассортимент неуклонно растет. Наша цель -  обеспечить достойный выбор товаров по каждому наименованию. Поскольку магазин работает без посредников, цены у нас самые лояльные. Мы работаем по всей Беларуси, поэтому нет необходимости искать другие тюнинг - магазины  в Минске или другом городе! Товар будет доставлен нашим курьером прямо к порогу вашего дома в любую точку страны. Также вы сможете посмотреть какие компании оказывают услуги по ремонту авто.</p>
	<p>•     Каталог автокомпаний <br />Тюнинг - магазин S-Turbo.BY это еще и отличная рекламная площадка для успешного развития вашего бизнеса. Компаниям, оказывающим различные автомобильные услуги, мы предлагаем ярко заявить о себе на нашем сайте и в группе Вконтакте. Подробнее о возможностях S-Turbo читайте здесь.</p>
	<p>•     Клуб/форум<br> Ну и наконец, S-Turbo.BY это большое интернет-сообщество любителей тюнинга автомобилей. На базе портала действует клуб и форум, где обсуждаются  самые интересные и актуальные автотемы. Стать членом нашего дружного клуба может каждый, пройдя предварительную регистрацию. Участники клуба получают возможность задавать на форуме вопросы профессионалам в сфере тюнинга, оставлять свои отзывы об услугах компаний, участвовать в закрытых встречах клуба, получать приятные скидки на товары и многие  другие бонусы!</p>
	<p>Будем рады видеть вас в числе наших клиентов и партнеров!</p>
</div>

<div class="how-it-work">
	
	<h2 class="uppercase">Как мы работаем</h2>
	
	<ul class="how-it-work-list clearfix">
		<li class="step1">
			<div class="wr">Вы оставляете заявку на сайте или по телефону</div>
		</li>
		<li class="step2">
			<div class="wr">Менеджер связывается с Вами для подтверждения заказа</div>
		</li>
		<li class="step3">
			<div class="wr">Мы быстро доставляем Вашу посылку по указанному адресу</div>
		</li>
		<li class="step4">
			<div class="wr">Вы получаете свой товар и платите за него на почте или курьеру</div>
		</li>
	</ul>
</div>
