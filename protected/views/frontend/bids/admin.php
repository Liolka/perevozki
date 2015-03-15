<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Bids'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Create Bids', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bids-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Bids</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bids-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'bid_id',
		'user_id',
		'created',
		'published',
		'date_transportation',
		'time_transportation',
		/*
		'date_unknown',
		'price',
		'loading_town',
		'loading_address',
		'add_loading_unloading_town_1',
		'add_loading_unloading_address_1',
		'add_loading_unloading_town_2',
		'add_loading_unloading_address_2',
		'add_loading_unloading_town_3',
		'add_loading_unloading_address_3',
		'unloading_town',
		'unloading_address',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
