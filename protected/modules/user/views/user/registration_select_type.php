<?php 
$app = Yii::app();

$this->pageTitle = $app->name . ' - '.UserModule::t("Registration");


$this->breadcrumbs=array(
	UserModule::t("Registration"),
);

$cs = $app->getClientScript();
$cs->registerCoreScript('jquery');

$app->clientScript->registerScript('search', "
$('#select_type_form a').on('click', function(){
	$('#user_type').val($(this).data('type'));
	$('#select_type_form').submit();
});

");

?>

<h1>Регистрация</h1>
<?php if(Yii::app()->user->hasFlash('registration')): ?>
	<div class="success flash-message-success">
		<?php echo Yii::app()->user->getFlash('registration'); ?>
	</div>
<?php else: ?>
	<div>
		<div class="header">Выберите кто вы:</div>
		<form action="" method="post" id="select_type_form">
			<input type="hidden" name="user_type" id="user_type" value="0" />
			<a href="javascript:void(0)" data-type="1">Грузодатель</a> или <a href="javascript:void(0)" data-type="2">Перевозчик</a>

		</form>

	</div>
	<div class="regform-footer">
		<p>Уже зарегистрированы?</p>
		<a href="javascript:void(0)">Войти</a>
	</div>
<?php endif; ?>
