<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'template' => "{items}",
	'itemsCssClass' => 'requests-list-items',
)); ?>
