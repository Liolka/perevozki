<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Bids'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Manage Bids', 'url'=>array('admin')),
);
?>

<h1>Create Bids</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>