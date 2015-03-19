<?php
/* @var $this BidsController */
/* @var $model Bids */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('form_f', "
if($('#Bids_have_account').is(':checked')) {
	$('#step-reg-form').hide();
	$('#step-login-form').show();
}

");

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bids-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	//'enableAjaxValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
	
)); ?>

	<?php if($this->app->user->hasFlash('bidMessageError')): ?>
		<div class="error flash-message flash-error">
			<?php echo $this->app->user->getFlash('bidMessageError'); ?>
		</div>
	<?php endif; ?>

	<?php echo $form->errorSummary($model); ?>
	<div class="step-container">
		<div class="container ">

			<p class="num-step num-step-green">4</p>
			<p class="step-title">Пункты погрузки и выгрузки<span>Завершающий этап</span> </p>

			<div class="row">
				<div class="col-md-6 col-lg-6">
					<div class="row form-row" style="position:relative;">
						<div class="col-md-4 col-lg-4">
							<?php echo $form->labelEx($model,'date_transportation', array('class'=>'lbl-block')); ?>
							<?php //echo $form->textField($model,'date_transportation', array('class'=>'width100')); ?>
							<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'model'=>$model,
									'name' => 'date_transportation',
									'language' => 'ru',
									'value' => $model->date_transportation,
									'options'=>array(
										'showAnim'=>'fold',
										'dateFormat'=>'yy-mm-dd',
										'defaultDate' => '+1w',
										'changeMonth' => 'true',
										'changeYear'=>'true',
										'constrainInput' => 'false',
										'onSelect' => "js:function( selectedDate ) {
										jQuery('#lastdate').datepicker('option', 'minDate', selectedDate)
									}"
									),
									'htmlOptions'=>array(
										  //'style'=>'height:20px;',
										  'id'=>'date_transportation',
											'class'=>'width100'
									),

									// DONT FORGET TO ADD TRUE this will create the datepicker return
									// as string
								),true);
							?>
							
							<?php echo $form->error($model,'date_transportation'); ?>						
						</div>
						<div class="col-md-4 col-lg-4">
							<?php echo $form->labelEx($model,'time_transportation', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'time_transportation'); ?>
							<?php echo $form->error($model,'time_transportation'); ?>
						</div>
						<div class="col-md-4 col-lg-4 date-unknown-block">
							<?php echo $form->checkBox($model,'date_unknown', array('class'=>'checkbox')); ?>
							<?php echo $form->labelEx($model,'date_unknown', array('class'=>'checkbox-lbl')); ?>						
							<?php echo $form->error($model,'date_unknown'); ?>
						</div>
					</div>
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'price', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'price'); ?>  <label class="" for="Bids_price">белорусских рублей</label>
							<?php echo $form->error($model,'price'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12 step-subheader">Погрузка</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'loading_town', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'loading_town',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
							<?php echo $form->error($model,'loading_town'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'loading_address', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'loading_address',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
							<?php echo $form->error($model,'loading_address'); ?>
						</div>
					</div>
					
					<div id="add-loading-unloading-block-1" class="form-row add-loading-unloading-block clearfix hide-block">
					
						<a href="#" class="delete-loading-unloading-block btn-red">Удалить х</a>
						
						<div class="col-md-12 col-lg-12">
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12 step-subheader">Пункт догрузки/выгрузки</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_town_1', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_town_1',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_town_1'); ?>
								</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_address_1', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_address_1',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_address_1'); ?>
								</div>
							</div>
						
						</div>
					</div>
					
					<div id="add-loading-unloading-block-2" class="form-row add-loading-unloading-block clearfix hide-block">
					
						<a href="#" class="delete-loading-unloading-block btn-red">Удалить х</a>
						
						<div class="col-md-12 col-lg-12">
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12 step-subheader">Пункт догрузки/выгрузки</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_town_2', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_town_2',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_town_2'); ?>
								</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_address_2', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_address_2',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_address_2'); ?>
								</div>
							</div>
						
						</div>
					</div>
					
					<div id="add-loading-unloading-block-3" class="form-row add-loading-unloading-block clearfix hide-block">
					
						<a href="#" class="delete-loading-unloading-block btn-red">Удалить х</a>
						
						<div class="col-md-12 col-lg-12">
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12 step-subheader">Пункт догрузки/выгрузки</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_town_3', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_town_3',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_town_3'); ?>
								</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_address_3', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'add_loading_unloading_address_3',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
									<?php echo $form->error($model,'add_loading_unloading_address_3'); ?>
								</div>
							</div>
						
						</div>
					</div>
					
					<div class="form-row add-loading-unloading-block clearfix" style="padding-bottom: 15px;">
						<div class="col-md-12 col-lg-12">
							<a href="#" id="add-loading-unloading-block" class="btn-grey-33">+ Добавить пункт догрузки/выгрузки</a>
							<label for="">Можно добавить два в сумме</label>						
						</div>
					</div>
					
					
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12 step-subheader">Выгрузка</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'unloading_town', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'unloading_town',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
							<?php echo $form->error($model,'unloading_town'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'unloading_address', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'unloading_address',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
							<?php echo $form->error($model,'unloading_address'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-5 col-lg-5">
							<?php echo CHtml::submitButton('Назад', array('class'=>'btn-blue-52 width100')); ?>				
						</div>

						<div class="col-md-7 col-lg-7">
							<?php echo CHtml::submitButton('Подтвердить размещение', array('class'=>'btn-green-52 width100', 'name'=>'send-new-bid')); ?>				
						</div>				
					</div>			
					
				</div>
				<div class="col-md-6 col-lg-6 step-login-block">
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->checkBox($model,'have_account', array('class'=>'checkbox')); ?>
							<?php echo $form->labelEx($model,'have_account', array('class'=>'checkbox-lbl')); ?>						
							<?php echo $form->error($model,'have_account'); ?>
						</div>
					
					</div>
					
					<div id="step-reg-form">
						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'bid_email', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'bid_email',array('size'=>60,'maxlength'=>255, 'class'=>'width100', 'placeholder'=>'например: email@email.com')); ?>
								<?php echo $form->error($model,'bid_email'); ?>
							</div>
						</div>

						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'bid_phone', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'bid_phone',array('size'=>60,'maxlength'=>255, 'class'=>'width100', 'placeholder'=>'Например: +375 33 333 33 33')); ?>
								<?php echo $form->error($model,'bid_phone'); ?>
							</div>
						</div>

						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'bid_name', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'bid_name',array('size'=>60,'maxlength'=>255, 'class'=>'width100', 'placeholder'=>'например: Сергей Сергеенко')); ?>
								<?php echo $form->error($model,'bid_name'); ?>
							</div>
						</div>
					</div>
					
					<div id="step-login-form" class="hide-block">
						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'login_email', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'login_email',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'login_email'); ?>
							</div>
						</div>
						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'login_password', array('class'=>'lbl-block')); ?>
								<?php echo $form->passwordField($model,'login_password',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'login_password'); ?>
							</div>
						</div>
					</div>
				
				</div>
			</div>
			

		</div>
	</div>
<?php $this->endWidget(); ?>

</div><!-- form -->