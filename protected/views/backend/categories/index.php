<?php
/* @var $this AdscategoriesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ads Categories',
);

$this->menu=array(
	array('label'=>'Create AdsCategories', 'url'=>array('create')),
	array('label'=>'Manage AdsCategories', 'url'=>array('admin')),
);
?>

<h1>Ads Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
