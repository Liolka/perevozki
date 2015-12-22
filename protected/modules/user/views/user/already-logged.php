<?php
$app = Yii::app();

$this->pageTitle = $app->name . ' - '.UserModule::t("Registration");


$this->breadcrumbs=array(
	UserModule::t("Registration"),
);

?>

<h1>Регистрация</h1>
<div class="blue-border-1 p-20 bg_f4fbfe">

	<div class="flash-message flash-error">
		<?php echo Yii::app()->user->getFlash('registration'); ?>
	</div>
	
	<?php echo CHtml::link("В кабинет", $this->createUrl('/user/my'), array('class'=>'btn-grey-33')); ?>
  
</div>
