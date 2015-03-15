<?php
/* @var $this BidsController */
/* @var $model Bids */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'bid_id'); ?>
		<?php echo $form->textField($model,'bid_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_transportation'); ?>
		<?php echo $form->textField($model,'date_transportation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'time_transportation'); ?>
		<?php echo $form->textField($model,'time_transportation'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_unknown'); ?>
		<?php echo $form->textField($model,'date_unknown'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loading_town'); ?>
		<?php echo $form->textField($model,'loading_town',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'loading_address'); ?>
		<?php echo $form->textField($model,'loading_address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_town_1'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_address_1'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_1',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_town_2'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_2',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_address_2'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_2',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_town_3'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_3',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add_loading_unloading_address_3'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_3',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unloading_town'); ?>
		<?php echo $form->textField($model,'unloading_town',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'unloading_address'); ?>
		<?php echo $form->textField($model,'unloading_address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->