<?php
/* @var $this PagesController */
/* @var $model Pages */



$this->breadcrumbs=array(
	$model->name,
);

$clientScript = $this->app->clientScript;


if ($model->meta_title)	{
  $this->pageTitle = $model->meta_title;
}	else	{
	$this->pageTitle = $model->name;
}

if ($model->meta_keywords)	
	$clientScript->registerMetaTag($model->meta_keywords, 'keywords');

if ($model->meta_description)		
	$clientScript->registerMetaTag($model->meta_description, 'description');

?>


<h1><?php echo $model->name; ?></h1>

<div class="page-text">
	<? echo $model->text; ?>
</div>