<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_reviews',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix',
	'htmlOptions' => array('id'=>'requests1-list-items', 'class'=>'requests1-list-items',),
)); ?>

<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>