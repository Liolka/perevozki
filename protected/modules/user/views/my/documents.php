<?php

$cs = $this->app->clientScript;

//$cs->registerCssFile('/css/chosen.css', 'screen');
//$cs->registerScriptFile('/js/chosen.jquery.min.js', CClientScript::POS_END);

$cs->registerScript('loading', "
	$('.doc-files-item-ok').hover(
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

function document_item($attr, $attr_checked, &$model, &$form, &$user, $popup = '')
{
	$html = '';
	$class = 'doc-files-item fLeft pos-rel'.($user->$attr ? ' doc-files-item-ok' : '');
	$html .= CHtml::openTag('li', array('class'=>$class));
	if($user->$attr == '')	{
		$html .= CHtml::openTag('div', array('class'=>'fileform'));
		
			$html .= CHtml::openTag('div', array('class'=>'selectbutton document-add'));
			$html .= "Обзор";
			$html .= CHtml::closeTag('div');
		
			$html .= $form->fileField($model, $attr, array('class'=>'document-file'));
		$html .= CHtml::closeTag('div');
		
		$html .= CHtml::openTag('p', array('class'=>'info text_c'));
			$html .= $form->labelEx($model, $attr, array('class'=>''));		
		$html .= CHtml::closeTag('p');
		
		if($popup != '')	{
			$html .= CHtml::openTag('div', array('class'=>'popup-info p-10 mt-20 c_fff text_c pos_abs lh-18'));
				$html .= $popup;
			$html .= CHtml::closeTag('div');
		}
	}	else	{
		$html .= CHtml::openTag('div', array('class'=>'fileform'));
			$class = 'selectbutton'.($user->$attr_checked ? ' document-ok' : ' document-not-checked');
			$html .= CHtml::openTag('div', array('class'=>$class));
				$html .= $user->$attr_checked ? 'Проверен' : 'Не проверен';
			$html .= CHtml::closeTag('div');
		$html .= CHtml::closeTag('div');
		
		$html .= CHtml::openTag('p', array('class'=>'info pos-rel text_c', 'style'=>'z-index:1;'));
			//$html .= CHtml::link($form->labelEx($model, $attr), array('/user/my/download', 'id'=>Yii::app()->user->id, 'attr'=>$attr), array('class'=>''));
			$html .= CHtml::link($form->labelEx($model, $attr), Yii::app()->homeUrl.'files/users/'.$user->id.'/docs/'.$user->$attr, array('class'=>''));
			//$html .= $form->labelEx($model, $attr);	
		$html .= CHtml::closeTag('p');
		
		$html .= CHtml::openTag('div', array('class'=>'document-delete-wr pos-abs hide-block'));
			$html .= CHtml::link('Удалить х', array('/user/my/documentdelete', 'id'=>$attr), array('class'=>'document-delete-btn btn-red pos-abs', 'onclick'=>"if(!confirm('Действительно удалить?')) return false;"));
			/*
			$html .= CHtml::openTag('button', array('class'=>'document-delete-btn btn-red'));
				$html .= "Удалить х";
			$html .= CHtml::closeTag('button');
			*/
		$html .= CHtml::closeTag('div');
		
	}
	
	$html .= CHtml::closeTag('li');
	return $html;
	
	/*
	<li class="doc-files-item <? if($user->file1 != '') echo 'doc-files-item-ok'; ?>">
       <? if($user->file1 == '')	{	?>
        <div class="fileform">
            <div class="selectbutton document-add">Обзор</div>
			<?php echo $form->fileField($model,'file1', array('class'=>'document-file')); ?>            
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
	*/
	
}

?>


<h1>Мои документы</h1>

<div class="doc-notice blue-border-1 mb-15 lh-18">Ваши документы <b>не будут</b> доступны для просмотра и скачивания перевозчикам и грузодателям <b>(Кроме примера договора)</b>. После проверки документа модератором его наличие будет отображено в вашем профиле.</div>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'documents-form',
	'htmlOptions'=>array('enctype'=>'multipart/form-data'),
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


<ul class="doc-files-list">
	<?  echo document_item('file1', 'file1_checked', $model, $form, $add_info, 'Данный файл будет доступен для скачивания всем пользователями портала после его публикации модератором.'); ?>
	<?  echo document_item('file2', 'file2_checked', $model, $form, $add_info); ?>		
</ul>
 
<?php $this->endWidget(); ?>