<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Bids'=>array('index'),
	$model->bid_id=>array('view','id'=>$model->bid_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Create Bids', 'url'=>array('create')),
	array('label'=>'View Bids', 'url'=>array('view', 'id'=>$model->bid_id)),
	array('label'=>'Manage Bids', 'url'=>array('admin')),
);
?>

<h1>Update Bids <?php echo $model->bid_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>