<?php

$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Мои заявки',
);

?>

<? include (dirname(dirname(__FILE__))."/common/rating-init.php")?>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<h1>Мои заявки <span>(<?=$totalBids.' '. Yii::t('app', 'штука|штуки|штук', $totalBids) ?>)</span></h1>

<div class="my-requests-block">
 	
  	<?php $this->renderPartial('_requests_sorting_filtering', array(
		'filter'=>$filter,
		'order'=>$order,
	)); ?>

   
    <div class="profile-requests-block  mt-40">
		<?php $this->renderPartial('_requests_list_gruzodatel', array('dataProvider'=>$dataProvider)); ?>
		<?php $this->renderPartial('_requests_list_pagination_ajax', array('dataProvider'=>$dataProvider)); ?>
		
		<? /*<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать ещё</a> */ ?>
	</div>
</div>

 
