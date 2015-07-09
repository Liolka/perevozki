<?
$this->breadcrumbs=array(
	$user_model->username => array('/user/view', 'id'=>$user_model->id),
	'Заявки перевозчика',
);

$cs = $this->app->getClientScript();
$cs->registerCoreScript('simplyCountable');

?>


<h1>Заявки перевозчика</h1>
<p class="bid-detail-number narrow-bold-23"><?php echo $user_model->username ?></p>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<div class="profile-page-requests-block profile-requests-block mt-40">
	<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider, 'itemView' => $itemView)); ?>
</div>