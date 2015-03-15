<?php
/* @var $this CargoesController */
/* @var $model Cargoes */

$this->breadcrumbs=array(
	'Cargoes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Cargoes', 'url'=>array('index')),
	array('label'=>'Create Cargoes', 'url'=>array('create')),
	array('label'=>'Update Cargoes', 'url'=>array('update', 'id'=>$model->cargo_id)),
	array('label'=>'Delete Cargoes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->cargo_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Cargoes', 'url'=>array('admin')),
);
?>

<h1>View Cargoes #<?php echo $model->cargo_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cargo_id',
		'name',
		'comment',
		'weight',
		'unit',
		'foto',
		'porters',
		'lift_to_floor',
		'floor',
		'length',
		'width',
		'height',
		'volume',
	),
)); ?>
