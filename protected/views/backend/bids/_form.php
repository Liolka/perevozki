<?php
/* @var $this BidsController */
/* @var $model Bids */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bids-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id'); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created'); ?>
		<?php echo $form->textField($model,'created'); ?>
		<?php echo $form->error($model,'created'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'published'); ?>
		<?php echo $form->textField($model,'published'); ?>
		<?php echo $form->error($model,'published'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_transportation'); ?>
		<?php echo $form->textField($model,'date_transportation'); ?>
		<?php echo $form->error($model,'date_transportation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_transportation'); ?>
		<?php echo $form->textField($model,'time_transportation'); ?>
		<?php echo $form->error($model,'time_transportation'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'date_unknown'); ?>
		<?php echo $form->textField($model,'date_unknown'); ?>
		<?php echo $form->error($model,'date_unknown'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loading_town'); ?>
		<?php echo $form->textField($model,'loading_town',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'loading_town'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'loading_address'); ?>
		<?php echo $form->textField($model,'loading_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'loading_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_town_1'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_1',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_town_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_address_1'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_1',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_address_1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_town_2'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_town_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_address_2'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_2',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_address_2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_town_3'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_town_3',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_town_3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_loading_unloading_address_3'); ?>
		<?php echo $form->textField($model,'add_loading_unloading_address_3',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'add_loading_unloading_address_3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unloading_town'); ?>
		<?php echo $form->textField($model,'unloading_town',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'unloading_town'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unloading_address'); ?>
		<?php echo $form->textField($model,'unloading_address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'unloading_address'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->