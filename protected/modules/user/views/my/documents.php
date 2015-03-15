<?php

$cs = $app->clientScript;

//$cs->registerCssFile('/css/chosen.css', 'screen');
//$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);

$cs->registerScript('loading', "
	$('.my-docs-files-item-ok').hover(
        function(){ $(this).children('.document-delete-wr').fadeIn(100)    },
        function(){ $(this).children('.document-delete-wr').fadeOut(100)    }
    );
	
");

$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Мои документы',
);


?>


<h1>Мои документы</h1>


<div class="my-docs-notice">Ваши документы <b>не будут</b> доступны для просмотра и скачивания перевозчикам и грузодателям <b>(Кроме примера договора)</b>. После проверки документа модератором его наличие будет отображено в вашем профиле.</div>


<ul class="my-docs-files-list">
	<li class="my-docs-files-item">
        <div class="fileform">
            <div class="selectbutton document-add">Обзор</div>
            <input id="upload" type="file" name="upload" />
        </div>
		<p class="info">Пример договора</p>
		
		<div class="popup-info">Данный файл будет доступен для скачивания всем пользователями портала после его публикации модератором.</div>
	</li>
	
	
	<li class="my-docs-files-item">
        <div class="fileform">
            <div class="selectbutton document-not-checked">Не проверен</div>
            
        </div>
		<p class="info">Свидетельство о постановке на налоговый учет (ИНН)</p>
		
	</li>
	
	
	<li class="my-docs-files-item my-docs-files-item-ok">
        <div class="fileform">
            <div class="selectbutton document-ok">Проверен</div>
        </div>
		<p class="info">Свидетельство о постановке на налоговый учет (ИНН)</p>
		<div class="document-delete-wr">
		    <button class="document-delete-btn btn-red">Удалить х</button>
		</div>
	</li>
	
	<li class="my-docs-files-item my-docs-files-item-ok">
        <div class="fileform">
            <div class="selectbutton document-ok">Проверен</div>
        </div>
		<p class="info">Свидетельство о постановке на налоговый учет (ИНН)</p>
		<div class="document-delete-wr">
		    <button class="document-delete-btn btn-red">Удалить х</button>
		</div>
		
	</li>
	
	<li class="my-docs-files-item">
        <div class="fileform">
            <div class="selectbutton document-add">Обзор</div>
            <input id="upload" type="file" name="upload" />
        </div>
		<p class="info">Свидетельство о постановке на налоговый учет (ИНН)</p>
		
	</li>
	
 </ul>