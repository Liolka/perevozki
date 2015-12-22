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
<div class="blue-border-1 p-20 bg_f4fbfe">
<?php if(Yii::app()->user->hasFlash('registration')): ?>
	<div class="success flash-message-success">
		<?php echo Yii::app()->user->getFlash('registration'); ?>
	</div>
<?php else: ?>


<div class="form ">
	<?php echo CHtml::beginForm('', 'post', array('class' => 'form-horizontal', 'id'=>'select_type_form')); ?>
		<div class="form-group">
			<p class="col-sm-12 select-user-type-lbl">Выберите кто вы:</p>
		</div>

		<div class="form-group">
		   <input type="hidden" name="user_type" id="user_type" value="0" />
			<p class="col-sm-5">
				<a href="javascript:void(0)" data-type="1" class="btn-green-52 select-user-type width100 p-0">Грузодатель</a>  
			</p>
			<p class="col-sm-2 select-user-type-lbl" style="line-height:52px;">или</p>
			<p class="col-sm-5">                    
				<a href="javascript:void(0)" data-type="2" class="btn-blue-52 select-user-type width100 p-0">Перевозчик</a>
			</p>

		</div>

		<h4 class="modal-title">Уже зарегистрированы?</h4>
		<?php echo CHtml::link("Войти", $this->createUrl('/user/login'), array('class'=>'btn-grey-33', 'id'=>'loginBtn')); ?>

	<?php echo CHtml::endForm(); ?>


</div>

<?php endif; ?>
</div>