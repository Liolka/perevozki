<?php
/* @var $this AdscategoriesController */
/* @var $model AdsCategories */

$this->breadcrumbs=array(
	'Список категорий',
);

$this->menu=array(
	array('label'=>'Создать', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ads-categories-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Список категорий</h1>

<?/*
<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
*/?>

<?php $this->widget('ext.CQTreeBsGridView', array(
	'id'=>'categories-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name' =>'id',
			'headerHtmlOptions' => array(
				'class' => 'id_column',
			),			
		),

		array(
			'name' =>'name',
			'headerHtmlOptions' => array(
				'class' => 'name_column',
			),			
		),

		array(
			'class' => 'CButtonColumn',
			'template' => '{update}&nbsp;{delete}&nbsp;{moveup}&nbsp;{movedown}',
			'buttons' => array(
				'update' => array(
					'imageUrl'=>'/img/grid-icons/update.png',
				),

				'delete' => array(
					'imageUrl'=>'/img/grid-icons/delete.png',
				),

				'moveup' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/uparrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("categories/moveup", array("id"=>$data->id))',

				),
				'movedown' => array(
					//url до картинки
					'imageUrl'=>'/img/grid-icons/downarrow.png',
					//здесь должен быть url для удаления записи
					'url' => 'Yii::app()->createUrl("categories/movedown", array("id"=>$data->id))',
				),
			),
		),	),
)); ?>
