<ul class="contact-info-list col-lg-5 col-md-5">
	<li class="mb-10">
		<p><?php echo $form->labelEx($user_company,'company_name', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'company_name'); ?>
			<?php echo $form->error($user_company,'company_name'); ?>
		</p>
	</li>
	<li class="mb-10">
		<p><?php echo $form->labelEx($user_company,'main_office', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'main_office'); ?>
			<?php echo $form->error($user_company,'main_office'); ?>
		</p>
	</li>
</ul>


<ul class="contact-info-list col-lg-7 col-md-7">
	<li class="mb-10">
		<p><?php echo $form->labelEx($user_company,'unp', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'unp', array('class'=>'wide')); ?>
			<?php echo $form->error($user_company,'unp'); ?>
		</p>
	</li>

	<li class="mb-10">
		<p><?php echo $form->labelEx($user_company,'filials', array('class'=>'field-title c_2e3c54')); ?></p>
		<p>
			<?php echo $form->textField($user_company,'filials', array('class'=>'wide')); ?>
			<?php echo $form->error($user_company,'filials'); ?>
		</p>
	</li>

</ul>

