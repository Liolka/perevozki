<?php
/*
$cs = $this->app->clientScript;

$cs->registerCoreScript('jquery.ui');    
//$cs=Yii::app()->getClientScript();
$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
$cs->registerCssFile($this->app->theme->baseUrl.'/css/tabs.css');
$cs->registerScript('#my-requests-tab',"jQuery('#my-requests-tab').tabs({'collapsible':true});");
*/

$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Заявки в которых вы отписывались',
);


?>


<h1>Заявки в которых вы отписывались <span>(<?=$totalBids.' '. Yii::t('app', 'штука|штуки|штук', $totalBids) ?>)</span></h1>

<div class="my-requests-block">
	
  	<? include ('_requests_sorting_filtering.php')?>
   
    <div class="profile-requests-block">
		<?php $this->renderPartial('_requests_list_perevozchik', array('dataProvider'=>$dataProvider)); ?>
	</div>
</div>


 
