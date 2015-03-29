<div class="last-requests">
	<p class="header">Последние заявки на перевозку</p>
		<ul class="requests-list-head clearfix mb-15">
			<li class="numb c_757575 font-12 fLeft">№</li>
			<li class="info c_757575 font-12 fLeft">Информация о грузе</li>
			<li class="addr from c_757575 font-12 fLeft">Откуда</li>
			<li class="addr to c_757575 font-12 fLeft">Куда</li>
			<li class="date c_757575 font-12 fLeft">Дата выезда / Предложения</li>
			<li class="price c_757575 font-12 fLeft">Предложенная стоимость</li>
		</ul>
	
		<div id="listView">

		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_view-last-requests',
			'ajaxUpdate'=>false,
			'template'=>"{items}",
			'pager'=>array(
				'htmlOptions'=>array(
					'class'=>'paginator'
				)
			),	
			'itemsCssClass' => 'requests-list-items',
		)); ?>


		</div>
<?/*	
	<ul class="requests-list-items">
		<li class="requests-list-item clearfix">
			<div class="requests-list-item_number">8523963</div>
			<div class="requests-list-item_info">
				<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
				<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
				<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
			</div>
			<div class="requests-list-item_from">
				<span class="requests-list-item_town counry-by">Гомель</span>
				<span class="requests-list-item_adress">ул. Малайчука, 12</span>
				<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр (*15)</a></p>
			</div>
			<div class="requests-list-item_to">
				<span class="requests-list-item_town counry-by">Брест</span>
				<span class="requests-list-item_adress">ул. Малайчука, 27</span>
			</div>
			<div class="requests-list-item_date">
				<span class="requests-list-item_created">11.06.2015</span>
				<p class="requests-list-item_suggestions"><span class="suggestion-green">0</span>предложений</p>
			</div>
			<div class="requests-list-item_price">
				<span class="requests-list-item-price_price">до 8 500 000 р.</span>
				<a class="btn-blue-33" href="#">Откликнуться</a>
			</div>
		</li>
		
		<li class="requests-list-item clearfix">
			<div class="requests-list-item_number">8523963</div>
			<div class="requests-list-item_info">
				<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
				<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
				<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
			</div>
			<div class="requests-list-item_from">
				<span class="requests-list-item_town counry-by">Гомель</span>
				<span class="requests-list-item_adress">ул. Малайчука, 12</span>
				<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр (*15)</a></p>
			</div>
			<div class="requests-list-item_to">
				<span class="requests-list-item_town counry-by">Брест</span>
				<span class="requests-list-item_adress">ул. Малайчука, 27</span>
			</div>
			<div class="requests-list-item_date">
				<span class="requests-list-item_created">11.06.2015</span>
				<p class="requests-list-item_suggestions"><span class="suggestion-orange">99</span>предложений</p>
			</div>
			<div class="requests-list-item_price">
				<span class="requests-list-item-price_price">до 500 000 р.</span>
				<a class="btn-blue-33" href="#">Откликнуться</a>
			</div>
		</li>
		
		<li class="requests-list-item clearfix">
			<div class="requests-list-item_number">8523963</div>
			<div class="requests-list-item_info">
				<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
				<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
				<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
			</div>
			<div class="requests-list-item_from">
				<span class="requests-list-item_town counry-by">Гомель</span>
				<span class="requests-list-item_adress">ул. Малайчука, 12</span>
				<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр Михайлович (*15)</a></p>
			</div>
			<div class="requests-list-item_to">
				<span class="requests-list-item_town counry-by">Брест</span>
				<span class="requests-list-item_adress">ул. Малайчука, 27</span>
			</div>
			<div class="requests-list-item_date">
				<span class="requests-list-item_created">11.06.2015</span>
				<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
			</div>
			<div class="requests-list-item_price">
				<span class="requests-list-item-price_price">до 10 500 000 р.</span>
				<a class="btn-blue-33" href="#">Откликнуться</a>
			</div>
		</li>
		
		<li class="requests-list-item clearfix">
			<div class="requests-list-item_number">8523963</div>
			<div class="requests-list-item_info">
				<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
				<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
				<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
			</div>
			<div class="requests-list-item_from">
				<span class="requests-list-item_town counry-by">Гомель</span>
				<span class="requests-list-item_adress">ул. Малайчука, 12</span>
				<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр Михайлович (*15)</a></p>
			</div>
			<div class="requests-list-item_to">
				<span class="requests-list-item_town counry-by">Брест</span>
				<span class="requests-list-item_adress">ул. Малайчука, 27</span>
			</div>
			<div class="requests-list-item_date">
				<span class="requests-list-item_created">11.06.2015</span>
				<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
			</div>
			<div class="requests-list-item_price">
				<span class="requests-list-item-price_price">до 10 500 000 р.</span>
				<a class="btn-blue-33" href="#">Откликнуться</a>
			</div>
		</li>
		
	</ul>
	*/?>
	
	<a href="<?=$this->controller->createUrl('/bids/index')?>" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>
</div>