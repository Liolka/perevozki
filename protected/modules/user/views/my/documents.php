<?php

$cs = $this->app->clientScript;

//$cs->registerCssFile('/css/chosen.css', 'screen');
//$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);

$cs->registerScript('loading', "
	$('.my-docs-files-item-ok').hover(
        function(){ $(this).children('.document-delete-wr').fadeIn(100)    },
        function(){ $(this).children('.document-delete-wr').fadeOut(100)    }
    );
	
	$('.document-file').on('change', function(){
		var fileName = $(this).val();
		if (fileName) { 
			$('#documents-form').submit();
		}

	});	
	
");

$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Мои документы',
);

//$user->file1 = '12312312312.zip';
//$user->file1_checked = 1;

?>


<h1>Мои документы</h1>

<div class="my-docs-notice">Ваши документы <b>не будут</b> доступны для просмотра и скачивания перевозчикам и грузодателям <b>(Кроме примера договора)</b>. После проверки документа модератором его наличие будет отображено в вашем профиле.</div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
	/*
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	*/

)); ?>

<?php if($this->app->user->hasFlash('error')): ?>
	<div class="flash-message flash-error">
		<?php echo $this->app->user->getFlash('error'); ?>
	</div>
<?php endif; ?>

<?php if($this->app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success">
		<?php echo $this->app->user->getFlash('success'); ?>
	</div>
<?php endif; ?>

<?php echo $form->errorSummary($model); ?>


<ul class="my-docs-files-list">
	<li class="my-docs-files-item <? if($user->file1 != '') echo 'my-docs-files-item-ok'; ?>">
       <? if($user->file1 == '')	{	?>
        <div class="fileform">
            <div class="selectbutton document-add">Обзор</div>
			<?php echo $form->fileField($model,'file1', array('class'=>'document-file')); ?>            
            <? /*<input id="upload" type="file" name="upload" /> */?>
        </div>
		<p class="info"><?php echo $form->labelEx($model,'file1', array('class'=>'')); ?></p>
		
		<div class="popup-info">Данный файл будет доступен для скачивания всем пользователями портала после его публикации модератором.</div>
		<?	}	else	{	?>
			<div class="fileform">
				<div class="selectbutton <?=$user->file1_checked ? 'document-ok' : 'document-not-checked' ?>">Не проверен</div>

			</div>
			<p class="info"><?php echo $form->labelEx($model,'file1', array('class'=>'')); ?></p>
			<div class="document-delete-wr">
				<button class="document-delete-btn btn-red">Удалить х</button>
			</div>
			
		
		<?	}	?>
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
 
<?php $this->endWidget(); ?>