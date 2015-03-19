<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Bids'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Manage Bids', 'url'=>array('admin')),
);
*/
?>

<h1>Заявка на перевозку грузов</h1>

<?php 
$this->renderPartial($form, array(
	'category_id'=>$category_id,
	'model'=>$model,
	'model_Cargoes'=>$model_Cargoes,
	'categories_list_level1'=>$categories_list_level1,
	'categories_list_level2'=>$categories_list_level2,	
	'categories_list'=>$categories_list,	
)); 
?>