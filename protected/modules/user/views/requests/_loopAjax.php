<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$itemView,
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'ajax-list', 'class'=>'ajax-list'),
)); ?>