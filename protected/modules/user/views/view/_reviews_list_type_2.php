<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_reviews_item_type_2',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	//'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix',
	'htmlOptions' => array('id'=>'listView', 'class'=>'requests1-list-items'),
)); ?>

<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Смотреть все</a>