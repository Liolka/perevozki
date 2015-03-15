<?php
/* @var $this AdscategoriesController */
/* @var $model AdsCategories */

$this->breadcrumbs=array(
	'Ads Categories'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdsCategories', 'url'=>array('index')),
	array('label'=>'Create AdsCategories', 'url'=>array('create')),
	array('label'=>'View AdsCategories', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AdsCategories', 'url'=>array('admin')),
);
?>

<h1>Update AdsCategories <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>