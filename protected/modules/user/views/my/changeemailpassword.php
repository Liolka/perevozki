<?php $this->pageTitle = $app->name . ' - '.UserModule::t("Change Password");


$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Регистрационные данные',
);

?>


<h1>Регистрационные данные</h1>

<?php if($app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success"><?php echo $app->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php if($app->user->hasFlash('error')): ?>
	<div class="flash-message flash-error"><?php echo $app->user->getFlash('error'); ?></div>
<?php endif; ?>

<?php if($app->user->hasFlash('warning')): ?>
	<div class="flash-message flash-warning"><?php echo $app->user->getFlash('warning'); ?></div>
<?php endif; ?>
<div class="row">
	

	<div class="change-email-block col-lg-6">
		<div class="p-20 blue-border-1 bg_f4fbfe">
			<p class="narrow_bold_24">Смена e-maila учетной записи</p>


			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'changeemail-form',
				'enableAjaxValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

				<?php echo $form->errorSummary($model_ChangeEmail); ?>

				<div class="row">
					<p>Текущий e-mal:</p>
					<p class="current-email c_0a80cb bold"><?php echo $app->user->email; ?></p>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model_ChangeEmail,'newEmail'); ?>
					<?php echo $form->textField($model_ChangeEmail,'newEmail'); ?>
					<?php echo $form->error($model_ChangeEmail,'newEmail'); ?>
				</div>

				<div class="row">
					<?php echo $form->labelEx($model_ChangeEmail,'password'); ?>
					<?php echo $form->passwordField($model_ChangeEmail,'password'); ?>
					<?php echo $form->error($model_ChangeEmail,'password'); ?>
				</div>

				<div class="submit clearfix">
					<?php echo CHtml::submitButton(UserModule::t("Save"), array('name'=>'apply', 'class'=>'btn-blue-33')); ?>
					<?php //echo CHtml::submitButton(UserModule::t("Cancel"), array('name'=>'cancel', 'class'=>'btn-grey-33')); ?>
					<a href="<?=$this->createUrl('my')?>" class="btn-grey-33 cancel-btn"><?=UserModule::t("Cancel")?></a>
				</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
	<div class="change-password-block col-lg-6">
		<div class="p-20 blue-border-1 bg_f4fbfe">
			<p class="narrow_bold_24">Смена пароля</p>

			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'changepassword-form',
				'enableAjaxValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),
			)); ?>

				<?php echo $form->errorSummary($model_ChangePassword); ?>

				<div class="row">
				<?php echo $form->labelEx($model_ChangePassword,'oldPassword'); ?>
				<?php echo $form->passwordField($model_ChangePassword,'oldPassword'); ?>
				<?php echo $form->error($model_ChangePassword,'oldPassword'); ?>
				</div>

				<div class="row">
				<?php echo $form->labelEx($model_ChangePassword,'password'); ?>
				<?php echo $form->passwordField($model_ChangePassword,'password'); ?>
				<?php echo $form->error($model_ChangePassword,'password'); ?>
				<?/*
				<p class="hint">
				<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
				</p>
				*/?>
				</div>


				<div class="row">
				<?php echo $form->labelEx($model_ChangePassword,'verifyPassword'); ?>
				<?php echo $form->passwordField($model_ChangePassword,'verifyPassword'); ?>
				<?php echo $form->error($model_ChangePassword,'verifyPassword'); ?>
				</div>

				<div class="submit clearfix">
					<?php echo CHtml::submitButton(UserModule::t("Save"), array('name'=>'apply', 'class'=>'btn-blue-33')); ?>
					<?php //echo CHtml::submitButton(UserModule::t("Cancel"), array('name'=>'cancel', 'class'=>'btn-grey-33')); ?>
					<a href="<?=$this->createUrl('my')?>" class="btn-grey-33 cancel-btn"><?=UserModule::t("Cancel")?></a>
				</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
