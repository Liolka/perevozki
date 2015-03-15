<?php
/* @var $this AdscategoriesController */
/* @var $model AdsCategories */

$this->breadcrumbs=array(
	'Список категорий'=>array('admin'),
	'Новая категория',
);

$this->menu=array(
	array('label'=>'Список категорий', 'url'=>array('admin')),
);
?>

<h1>Новая категория</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>