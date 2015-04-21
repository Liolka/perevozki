<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>
	
    <ul class="nav nav-tabs" id="myTab">
		<li><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Информация</a></li>
		<li><a href="#tab3" data-toggle="tab">Документы</a></li>
    </ul>
    
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'superuser'); ?>
				<?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
				<?php echo $form->error($model,'superuser'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'user_type'); ?>
				<?php echo $form->dropDownList($model, 'user_type', $user_type_dropdown, array('data-placeholder'=>'выберите...', 'options' => $user_type_selected));?>
				<?php echo $form->error($model,'user_type'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'user_status'); ?>
				<?php echo $form->dropDownList($model, 'user_status', $user_status_dropdown, array('data-placeholder'=>'выберите...', 'options' => $user_status_selected));?>
				<?php echo $form->error($model,'user_status'); ?>
			</div>

		<?php 
				$profileFields=$profile->getFields();
				if ($profileFields) {
					foreach($profileFields as $field) {
					?>
			<div class="row">
				<?php echo $form->labelEx($profile,$field->varname); ?>
				<?php 
				if ($widgetEdit = $field->widgetEdit($profile)) {
					echo $widgetEdit;
				} elseif ($field->range) {
					echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
				} elseif ($field->field_type=="TEXT") {
					echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
				} else {
					echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
				}
				 ?>
				<?php echo $form->error($profile,$field->varname); ?>
			</div>
					<?php
					}
				}
		?>
		
		</div>
		<div class="tab-pane" id="tab2">
			
			<? 
			switch($model->user_type) {
				case 2:
					include "_user_info_2.php";
					break;

				default:
				case 1:
					include "_user_info_1.php";
					break;
			}		

			?>
		
		</div>
		<div class="tab-pane" id="tab3">
		
		</div>
	</div>
	

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('color' => BsHtml::BUTTON_COLOR_SUCCESS)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->