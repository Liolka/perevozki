<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Редактировать Информация о компании, контакты',
);

$this->pageTitle = "Редактировать Информация о компании, контакты";

?>

<h1>Информация о компании, контакты</h1>

<div class="contact-info-edit bg_f4fbfe blue-border-1">
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
		<div class="my-contact-info-company-container p-20 mb-35 clearfix">
			<p class="narrow-bold-18 mb-25">Контактная информация</p>
				<ul class="phones mb-20">
					<li class="field-title">Телефонные номера:</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone11', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone1'); ?>
						<?php echo $form->error($user_company,'phone1'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone22', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone2'); ?>
						<?php echo $form->error($user_company,'phone2'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone33', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone3'); ?>
						<?php echo $form->error($user_company,'phone3'); ?>
					</li>
					<li>
						<?php echo $form->labelEx($user_company,'phone44', array('class'=>'c_2e3c54')); ?>
						<?php echo $form->textField($user_company,'phone4'); ?>
						<?php echo $form->error($user_company,'phone4'); ?>
					</li>
				</ul>
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
		
		<div class="my-contact-info-company-container p-20 mb-35 clearfix">
			<p class="narrow-bold-18 mb-25">Информация о компании</p>
			<div class="row">

				<?
				switch($user->user_status)	{
					case 1: 
					$tmpl = "info-edit-gruzodatel-ur.php";
					break;

					case 2: 
					default: 
					$tmpl = "info-edit-gruzodatel-fiz.php";
					break;
				}

				include ($tmpl);	
				?>

			</div>
		</div>
		
		<div class="my-contact-info-company-container p-20 clearfix">
			<p class="narrow-bold-18 mb-25"><?php echo $form->labelEx($user_company,'description', array('class'=>'field-title c_2e3c54')); ?></p>
			<div class="my-contact-info-company-container clearfix">
				<?php echo $form->textArea($user_company,'description',array('rows'=>6, 'cols'=>50, 'class'=>'width100')); ?>
			</div>
		</div>
		
		<div class="p-20">
			<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn-blue-33', 'name'=>'save')); ?>
			<?php echo CHtml::submitButton('Отменить', array('class'=>'btn-green-33', 'name'=>'cancel')); ?>
		</div>
	</div>
	
<?php $this->endWidget(); ?>
	
</div>

