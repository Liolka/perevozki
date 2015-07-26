<?
$cs = Yii::app()->clientScript;

$cs->registerScript('user-update', "
	$('.checkbox input[type=\"checkbox\"]').bootstrapSwitch({
		onText : 'Да',
		offText : 'Нет',
	});

");


//echo'<pre>';print_r($user_info);echo'</pre>';die;


function print_document_item($attr, &$user_info, &$model, &$form)
{
	$html = '';
	if($user_info->$attr != '')	{
		$html .= CHtml::openTag('div', array('class'=>'col-lg-4 col-md-4', 'style'=>'text-align:center;'));
		$html .= CHtml::openTag('div', array('style'=>'border:1px solid #ddd;'));
		$html .= CHtml::openTag('div', array('style'=>'height:80px;'));
		$html .= CHtml::link($form->labelEx($user_info, $attr), Yii::app()->homeUrl.'files/users/'.$model->id.'/docs/'.$user_info->$attr);
		$html .= CHtml::closeTag('div');
		$html .= $form->checkBoxControlGroup($user_info, $attr.'_passed');
		$html .= $form->checkBoxControlGroup($user_info, $attr.'_checked');
		//$html .= $form->error($user_info, $attr.'_checked');
		$html .= CHtml::closeTag('div');
		$html .= CHtml::closeTag('div');
	}
	return $html;
}

?>		


<div class="form">
<?php $form=$this->beginWidget('bootstrap.widgets.BsActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype'=>'multipart/form-data'),
));
?>

	<p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary(array($model,$profile)); ?>
	
    <ul class="nav nav-tabs" id="myTab">
		<li><a href="#tab1" data-toggle="tab">Основное</a></li>
		<li><a href="#tab2" data-toggle="tab">Информация</a></li>
		<? if($model->user_type == 2)	{	?>
   			<li><a href="#tab3" data-toggle="tab">Документы</a></li>
   		<?	}	?>
    </ul>
    
    <div class="tab-content">
		<div class="tab-pane active" id="tab1">
			<div class="row">
				<?php echo $form->labelEx($model,'username'); ?>
				<?php echo $form->textField($model,'username',array('size'=>20,'maxlength'=>20)); ?>
				<?php echo $form->error($model,'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'password'); ?>
				<?php echo $form->passwordField($model,'password',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'password'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'email'); ?>
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'superuser'); ?>
				<?php echo $form->dropDownList($model,'superuser',User::itemAlias('AdminStatus')); ?>
				<?php echo $form->error($model,'superuser'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'status'); ?>
				<?php echo $form->dropDownList($model,'status',User::itemAlias('UserStatus')); ?>
				<?php echo $form->error($model,'status'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'user_type'); ?>
				<?php echo $form->dropDownList($model, 'user_type', $user_type_dropdown, array('data-placeholder'=>'выберите...', 'options' => $user_type_selected));?>
				<?php echo $form->error($model,'user_type'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model,'user_status'); ?>
				<?php echo $form->dropDownList($model, 'user_status', $user_status_dropdown, array('data-placeholder'=>'выберите...', 'options' => $user_status_selected));?>
				<?php echo $form->error($model,'user_status'); ?>
			</div>

		<?php 
				$profileFields=$profile->getFields();
				if ($profileFields) {
					foreach($profileFields as $field) {
					?>
			<div class="row">
				<?php echo $form->labelEx($profile,$field->varname); ?>
				<?php 
				if ($widgetEdit = $field->widgetEdit($profile)) {
					echo $widgetEdit;
				} elseif ($field->range) {
					echo $form->dropDownList($profile,$field->varname,Profile::range($field->range));
				} elseif ($field->field_type=="TEXT") {
					echo CHtml::activeTextArea($profile,$field->varname,array('rows'=>6, 'cols'=>50));
				} else {
					echo $form->textField($profile,$field->varname,array('size'=>60,'maxlength'=>(($field->field_size)?$field->field_size:255)));
				}
				 ?>
				<?php echo $form->error($profile,$field->varname); ?>
			</div>
					<?php
					}
				}
		?>
		
		</div>
		<div class="tab-pane" id="tab2">
			
			<? 
			include "_user_info.php";
			
			switch($model->user_type) {
				case 2:
					switch($model->user_status)	{
						case 1: 
							$tmpl = "_user_info_2_ur.php";
							break;

						case 2: 
						default: 
							$tmpl = "_user_info_2_fiz.php";
							break;
					}

					break;

				default:
				case 1:
					switch($model->user_status)	{
						case 1: 
							$tmpl = "_user_info_1_ur.php";
							break;

						case 2: 
						default: 
							$tmpl = "_user_info_1_fiz.php";
							break;
					}

					break;
			}

			include ($tmpl);

			?>
			
			<div class="row">
				<?php echo $form->labelEx($user_info,'description'); ?>
				<?php echo $form->textArea($user_info,'description',array('rows'=>6, 'cols'=>50)); ?>
				<?php echo $form->error($user_info,'description'); ?>
			</div>			
		
		</div>
		
		<? if($model->user_type == 2)	{	?>
			<div class="tab-pane" id="tab3">
				<div class="row">
				<?php 
					echo print_document_item('file1', $user_info, $model, $form);
					echo print_document_item('file2', $user_info, $model, $form);
					echo print_document_item('file3', $user_info, $model, $form);
					echo print_document_item('file4', $user_info, $model, $form);
					echo print_document_item('file5', $user_info, $model, $form);
					echo print_document_item('file6', $user_info, $model, $form);
					echo print_document_item('file7', $user_info, $model, $form);
					echo print_document_item('file8', $user_info, $model, $form);
					echo print_document_item('file9', $user_info, $model, $form);
					echo print_document_item('file10', $user_info, $model, $form);
					echo print_document_item('file11', $user_info, $model, $form);
					echo print_document_item('file12', $user_info, $model, $form);
					echo print_document_item('file13', $user_info, $model, $form);
					echo print_document_item('file14', $user_info, $model, $form);
				?>
				</div>
			</div>
		<?	}	?>
	</div>
	

	<div class="row buttons">
		<?php echo BsHtml::submitButton($model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'), array('color' => BsHtml::BUTTON_COLOR_PRIMARY, 'name'=>'save')); ?>
		<?php echo BsHtml::submitButton('Применить', array('color' => BsHtml::BUTTON_COLOR_SUCCESS, 'name'=>'apply')); ?>
		<?php echo BsHtml::submitButton('Отмена', array('name'=>'cancel')); ?>		
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->