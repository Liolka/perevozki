<?php
/* @var $this AdscategoriesController */
/* @var $model AdsCategories */

$this->breadcrumbs=array(
	'Ads Categories'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List AdsCategories', 'url'=>array('index')),
	array('label'=>'Create AdsCategories', 'url'=>array('create')),
	array('label'=>'Update AdsCategories', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AdsCategories', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AdsCategories', 'url'=>array('admin')),
);
?>

<h1>View AdsCategories #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'root',
		'lft',
		'rgt',
		'level',
		'parent_id',
		'name',
		'meta_title',
		'meta_keywords',
		'meta_description',
		'ordering',
		'category_description',
	),
)); ?>
