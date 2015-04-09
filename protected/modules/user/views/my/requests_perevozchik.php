<?php

$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Заявки в которых вы отписывались',
);

?>

<? include (dirname(dirname(__FILE__))."/common/rating-init.php")?>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<h1>Заявки в которых вы отписывались <span>(<?=$totalBids.' '. Yii::t('app', 'штука|штуки|штук', $totalBids) ?>)</span></h1>

<div class="my-requests-block">
	
  	<?php $this->renderPartial('_requests_sorting_filtering', array(
		'filter'=>$filter,
		'order'=>$order,
	)); ?>
   
    <div class="profile-requests-block mt-40">
		<?php $this->renderPartial('_requests_list_perevozchik', array('dataProvider'=>$dataProvider)); ?>
		<?php $this->renderPartial('_requests_list_pagination_ajax', array('dataProvider'=>$dataProvider)); ?>
	</div>
</div>


 
