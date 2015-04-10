<?php /* @var $this Controller */ ?>


<?php include('init-variables.php'); ?>

<?php $this->beginContent('//layouts/main'); ?>

<?php if(isset($this->breadcrumbs)):?>
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
		'separator'=>'&mdash;',
	)); ?><!-- breadcrumbs -->
<?php endif?>


<div class="content column1">
	<?php echo $content; ?>
	
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Operations',
		));
		$this->widget('zii.widgets.CMenu', array(
			'items'=>$this->menu,
			'htmlOptions'=>array('class'=>'operations'),
		));
		$this->endWidget();
	?>
	
</div>
<?php $this->endContent(); ?>