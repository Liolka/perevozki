<ul class="contact-info-list col-lg-5 col-md-5">
	<li>
		<p><?php echo $form->labelEx($user_company,'fio', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'fio'); ?>
			<?php echo $form->error($user_company,'fio'); ?>
		</p>
	</li>
	
	<li>
		<p><?php echo $form->labelEx($user_company,'country', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'country'); ?>
			<?php echo $form->error($user_company,'country'); ?>
		</p>
	</li>
	<li>
		<p><?php echo $form->labelEx($user_company,'experience', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'experience'); ?>
			<?php echo $form->error($user_company,'experience'); ?>
		</p>
	</li>
</ul>


<ul class="contact-info-list col-lg-7 col-md-7">
	<li>
		<p><?php echo $form->labelEx($user_company,'birthday', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'birthday', array('class'=>'wide')); ?>
			<?php echo $form->error($user_company,'birthday'); ?>
		</p>
	</li>
	<li>
		<p><?php echo $form->labelEx($user_company,'town', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'town', array('class'=>'wide')); ?>
			<?php echo $form->error($user_company,'town'); ?>
		</p>
	</li>
	
</ul>

