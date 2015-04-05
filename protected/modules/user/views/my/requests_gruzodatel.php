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


<h1>Мои заявки <span>(<?=count($lastBidsUser->data).' '. Yii::t('app', 'штука|штуки|штук', count($lastBidsUser->data)) ?>)</span></h1>

<div class="my-requests-block">
	<ul class="requests-show-block mb-30 clearfix">
		<li class="requests-show-block-item fLeft active"><a href="#" class="requests-show-block-link" title="Только текущие">Только текущие</a></li>
		<li class="requests-show-block-item fLeft"><a href="#" class="requests-show-block-link" title="Все">Все</a></li>
	</ul>

	<div class="my-requests-sort-block">
		<ul class="clearfix">
			<li>Сортировка:</li>
			<li class="active sort-block-item sort-block-date"><a href="#">По дате</a><span class="sort-direction">▼</span></li>
			<li class="sort-block-item sort-block-requests"><a href="#">По наличию отзывов</a></li>
		</ul>
	</div>
   
    <div class="profile-requests-block">
		<?php $this->renderPartial('_requests_list_gruzodatel', array('dataProvider'=>$lastBidsUser)); ?>
	</div>
</div>

 
