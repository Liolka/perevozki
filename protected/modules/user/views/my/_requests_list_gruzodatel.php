<ul class="requests1-list-head clearfix p-20">
	<li class="col1 fLeft c_757575 font-12 text_c">№</li>
	<li class="col2 fLeft c_757575 font-12">Информация о грузе</li>
	<li class="col3 fLeft c_757575 font-12 text_c">Дата</li>
	<li class="col4 fLeft c_757575 font-12">Перевозчик</li>
	<li class="col5 fLeft c_757575 font-12 text_c"><p class="review-perevoz-ttl pos-rel"><span class="bold c_2e3c54 otziv-lbl">Отзыв перевозчика<span class="notice bold c_fcb60e font-20 pos-abs db">*</span></span></p></li>
	<li class="col6 fLeft c_757575 font-12">Заказчик</li>
	<li class="col7 fLeft c_757575 font-12">Отзыв заказчика</li>
</ul>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_requests_gruzodate',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	//'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h pos-rel clearfix',
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'requests1-list-items', 'class'=>'requests1-list-items',),
)); ?>

<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>

