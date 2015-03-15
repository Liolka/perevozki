<?php
/* @var $this AdscategoriesController */
/* @var $model AdsCategories */

$this->breadcrumbs=array(
	'Ads Categories'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AdsCategories', 'url'=>array('index')),
	array('label'=>'Manage AdsCategories', 'url'=>array('admin')),
);
?>

<h1>Create AdsCategories</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>