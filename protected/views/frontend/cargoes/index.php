<?php
/* @var $this CargoesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cargoes',
);

$this->menu=array(
	array('label'=>'Create Cargoes', 'url'=>array('create')),
	array('label'=>'Manage Cargoes', 'url'=>array('admin')),
);
?>

<h1>Cargoes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
