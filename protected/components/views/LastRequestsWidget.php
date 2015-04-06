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
	<a href="<?=$this->controller->createUrl('/bids/index')?>" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>
</div>