<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Заявка на перевозку грузов',
);
/*
$this->menu=array(
	array('label'=>'List Bids', 'url'=>array('index')),
	array('label'=>'Manage Bids', 'url'=>array('admin')),
);
*/
/*
echo'<pre>';print_r($form);echo'</pre>';
echo'<pre>';print_r($category_id);echo'</pre>';
echo'<pre>';print_r($model);echo'</pre>';
echo'<pre>';var_dump($model_Cargoes);echo'</pre>';
echo'<pre>';print_r($categories_list_level1);echo'</pre>';
echo'<pre>';print_r($categories_list_level2);echo'</pre>';
echo'<pre>';print_r($categories_list);echo'</pre>';

die;
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