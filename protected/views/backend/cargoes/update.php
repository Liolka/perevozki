<?php
/* @var $this CargoesController */
/* @var $model Cargoes */

$this->breadcrumbs=array(
	'Cargoes'=>array('index'),
	$model->name=>array('view','id'=>$model->cargo_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Cargoes', 'url'=>array('index')),
	array('label'=>'Create Cargoes', 'url'=>array('create')),
	array('label'=>'View Cargoes', 'url'=>array('view', 'id'=>$model->cargo_id)),
	array('label'=>'Manage Cargoes', 'url'=>array('admin')),
);
?>

<h1>Update Cargoes <?php echo $model->cargo_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>