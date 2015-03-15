<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Bids'=>array('index'),
	$model->bid_id,
);

$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Create Bids', 'url'=>array('create')),
	array('label'=>'Update Bids', 'url'=>array('update', 'id'=>$model->bid_id)),
	array('label'=>'Delete Bids', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->bid_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Bids', 'url'=>array('admin')),
);
?>

<h1>View Bids #<?php echo $model->bid_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bid_id',
		'user_id',
		'created',
		'published',
		'date_transportation',
		'time_transportation',
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
	),
)); ?>
