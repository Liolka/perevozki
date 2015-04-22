<div class="row">
	<?php echo $form->labelEx($user_info,'company_name'); ?>
	<?php echo $form->textField($user_info,'company_name',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'company_name'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'main_office'); ?>
	<?php echo $form->textField($user_info,'main_office',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'main_office'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'unp'); ?>
	<?php echo $form->textField($user_info,'unp',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'unp'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'filials'); ?>
	<?php echo $form->textField($user_info,'filials',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'filials'); ?>
</div>