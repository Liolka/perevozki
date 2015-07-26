<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Change Password");
$this->breadcrumbs=array(
	'Смена пароля',
);
?>

<h1>Смена пароля</h1>

<div class="blue-border-1 p-20 bg_f4fbfe">
<div class="form">
<?php echo CHtml::beginForm(); ?>

	<?php echo CHtml::errorSummary($form); ?>
	
	<div class="row mb-20">
		<p class="col-sm-12 mb-5"><?php echo CHtml::activeLabelEx($form,'password', array('class'=>'bold')); ?></p>
		<p class="col-sm-12"><?php echo CHtml::activePasswordField($form,'password', array('class'=>'width25')); ?></p>
		<p class="col-sm-12 hint">
			<?php echo UserModule::t("Minimal password length 4 symbols."); ?>
		</p>
	</div>
	
	<div class="row mb-20">
		<p class="col-sm-12 mb-5"><?php echo CHtml::activeLabelEx($form,'verifyPassword', array('class'=>'bold')); ?></p>
		<p class="col-sm-12"><?php echo CHtml::activePasswordField($form,'verifyPassword', array('class'=>'width25')); ?></p>
	</div>
	
	
	<div class="row submit">
		<p class="col-sm-3">
			<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn-grey-33 regBtn width100')); ?>
		</p>
	</div>

<?php echo CHtml::endForm(); ?>
</div><!-- form -->
</div>