<?php
/* @var $this CargoesController */
/* @var $model Cargoes */

$this->breadcrumbs=array(
	'Cargoes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Cargoes', 'url'=>array('index')),
	array('label'=>'Manage Cargoes', 'url'=>array('admin')),
);
?>

<h1>Create Cargoes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>