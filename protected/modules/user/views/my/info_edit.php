<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Редактировать Информация о компании, контакты',
);

?>

<h1>Информация о компании, контакты</h1>

<div class="my-contact-info-company my-contact-info-company-edit">
	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'info-company-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		//'enableAjaxValidation'=>true,
		/*
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
		*/

	)); ?>

	<?php if($this->app->user->hasFlash('error')): ?>
		<div class="error flash-message flash-error">
			<?php echo $this->app->user->getFlash('error'); ?>
		</div>
	<?php endif; ?>

	<?php if($this->app->user->hasFlash('success')): ?>
		<div class="flash-message flash-success">
			<?php echo $this->app->user->getFlash('success'); ?>
		</div>
	<?php endif; ?>

	<?php echo $form->errorSummary($user_company); ?>


	<div class="my-contact-info-container-wr">
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header">Контактная информация</p>
			<div class="row">
				<ul class="phones">
					<li class="field-title">Телефонные номера:</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone1', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone1'); ?>
						<?php echo $form->error($user_company,'phone1'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone2', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone2'); ?>
						<?php echo $form->error($user_company,'phone2'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone3', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone3'); ?>
						<?php echo $form->error($user_company,'phone3'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone4', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone4'); ?>
						<?php echo $form->error($user_company,'phone4'); ?>
					</li>
				</ul>
			</div>
			<div class="row">
				<ul class="contacts">
					<li class="email">
						<?php echo $form->labelEx($user_company,'email', array('class'=>'field-title c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'email'); ?>
						<?php echo $form->error($user_company,'email'); ?>
					</li>
					<li class="skype">
						<?php echo $form->labelEx($user_company,'skype', array('class'=>'field-title c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'skype'); ?>
						<?php echo $form->error($user_company,'skype'); ?>
					</li>
					<li class="website">
						<?php echo $form->labelEx($user_company,'site', array('class'=>'field-title c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'site'); ?>
						<?php echo $form->error($user_company,'site'); ?>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header">Информация о компании</p>
			<div class="my-contact-info-company-container clearfix">
				<ul class="my-contact-info-company-list">
					<li>
						<p><?php echo $form->labelEx($user_company,'type', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'type'); ?>
							<?php echo $form->error($user_company,'type'); ?>
						</p>
					</li>
					<li>
						<p><?php echo $form->labelEx($user_company,'year', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'year'); ?>
							<?php echo $form->error($user_company,'year'); ?>
						</p>
					</li>
					<li>
						<p><?php echo $form->labelEx($user_company,'count_auto', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'count_auto'); ?>
							<?php echo $form->error($user_company,'count_auto'); ?>
						</p>
					</li>
					<li>
						<p><?php echo $form->labelEx($user_company,'count_staff', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'count_staff'); ?>
							<?php echo $form->error($user_company,'count_staff'); ?>
						</p>
					</li>
				</ul>

				<ul class="my-contact-info-company-list">
					<li>
						<p><?php echo $form->labelEx($user_company,'main_office', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'main_office', array('class'=>'wide')); ?>
							<?php echo $form->error($user_company,'main_office'); ?>
						</p>
					</li>
					
					<li>
						<p><?php echo $form->labelEx($user_company,'filials', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'filials', array('class'=>'wide')); ?>
							<?php echo $form->error($user_company,'filials'); ?>
						</p>
					</li>
					<li>
						<p><?php echo $form->labelEx($user_company,'terminals', array('class'=>'field-title c_2e3c54')); ?></p>
						<p>
							<?php echo $form->textField($user_company,'terminals', array('class'=>'wide')); ?>
							<?php echo $form->error($user_company,'terminals'); ?>
						</p>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header"><?php echo $form->labelEx($user_company,'description', array('class'=>'field-title c_2e3c54')); ?></p>
			<div class="my-contact-info-company-container clearfix">
				<?php echo $form->textArea($user_company,'description',array('rows'=>6, 'cols'=>50, 'class'=>'width100')); ?>
			</div>
		</div>
		
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn-blue-33', 'name'=>'save')); ?>
		<?php echo CHtml::submitButton('Отменить', array('class'=>'btn-green-33', 'name'=>'cancel')); ?>
		<?/*
		<a href="<?=$this->createUrl('/site/index')?>" class="btn-blue-33">Сохранить</a>
		<a href="<?=$this->createUrl('/user/my/info')?>" class="btn-green-33">Отменить</a>
		*/?>
	</div>
	
<?php $this->endWidget(); ?>
	
</div>

