<div class="row">
	<?php echo $form->labelEx($user_info,'fio'); ?>
	<?php echo $form->textField($user_info,'fio',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'fio'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'country'); ?>
	<?php echo $form->textField($user_info,'country',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'country'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'experience'); ?>
	<?php echo $form->textField($user_info,'experience',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'experience'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'birthday'); ?>
	<?php echo $form->textField($user_info,'birthday',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'birthday'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($user_info,'town'); ?>
	<?php echo $form->textField($user_info,'town',array('size'=>60,'maxlength'=>128)); ?>
	<?php echo $form->error($user_info,'town'); ?>
</div>