<?php

$cs = $app->clientScript;

//$cs->registerCssFile('/css/chosen.css', 'screen');
//$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);
//$cs->registerScriptFile('/js/tabs.js', CClientScript::POS_END);
/*
$cs->registerScript('loading', "
	$('.my-docs-files-item-ok').hover(
        function(){ $(this).children('.document-delete-wr').fadeIn(100)    },
        function(){ $(this).children('.document-delete-wr').fadeOut(100)    }
    );
	
");
*/


$cs->registerCoreScript('jquery.ui');    
//$cs=Yii::app()->getClientScript();
$cs->registerCssFile($cs->getCoreScriptUrl().'/jui/css/base/jquery-ui.css');
$cs->registerCssFile($app->theme->baseUrl.'/css/tabs.css');
$cs->registerScript('#my-requests-tab',"jQuery('#my-requests-tab').tabs({'collapsible':true});");


$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Заявки в которых вы отписывались',
);


?>


<h1>Заявки в которых вы отписывались <span>(10 323 штук)</span></h1>

<div class="my-requests-block">
    <div id="my-requests-tab">
        <ul>
            <li><a href="#tab_1" title="tab_1">Только текущие</a></li>
            <li><a href="#tab_2" title="tab_2">Все</a></li>
        </ul>

        <div id="tab_1">

            <? $this->renderPartial('requests_current');?>
        </div>

        <div id="tab_2">   
            <? $this->renderPartial('requests_all');?>
        </div>
    </div>
</div>

 
