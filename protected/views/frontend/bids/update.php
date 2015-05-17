<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Заявки на перевозку грузов'=>array('index'),
	$bid_name.' | Изменить',
);

$clientScript = $this->app->clientScript;

$this->pageTitle = "Редактироание | Заявка №".$bid_model->bid_id;
$clientScript->registerMetaTag("Редактироание | Заявка №".$bid_model->bid_id, 'keywords');
$clientScript->registerMetaTag("Редактироание | Заявка №".$bid_model->bid_id, 'description');

$NumberFormatter = $this->app->NumberFormatter;

$cs = $this->app->clientScript;
$cs->coreScriptPosition = CClientScript::POS_END;
//$cs->registerCoreScript('fancybox');
$cs->registerCoreScript('ajax-upload');
$cs->registerScript('bid-update', "
var upload1 = new AjaxUpload('#userfile1', {
		action: '/bids/uploadfoto.html?cargo='+$('#step3Container').find('#cargo-num').val(),
		onSubmit : function(file, extension){
			$('#loading' + $('#step3Container #cargo-num').val() ).show();
			if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))) {
				$('#loading' + $('#step3Container #cargo-num').val() ).hide();
				$('<span class=\"error\">Неправильный тип файла</span>').appendTo('#errormes-'+$('#cargo-num').val());
				return false;
			} else {
				$('#errormes-'+$('#cargo-num').val()).hide();
			}	
			upload1.setData({'file': file});
		},
		onComplete : function(file, response) {
			$('#loading'+$('#step3Container #cargo-num').val()).hide();
			$('.success').css('display', 'block');
			var pItems = $('.iframe'),
				response = $.parseJSON($(pItems[(pItems.length - 1)]).contents().find('body').text());
			if(response.res == 'ok') {
				$('#step3Container').find('#cargo-foto'+$('#step3Container #cargo-num').val()).css('background-image', ('url('+response.msg+')'));
				$('#step3Container').find('#Cargoes_foto'+$('#step3Container #cargo-num').val()).val(response.foto);
			}
			if(response.res == 'err') {
				$('#step3Container .cargo'+$('#step3Container #cargo-num').val()+'-err').html(response.msg);
				$('#step3Container .cargo'+$('#step3Container #cargo-num').val()+'-err').show();
			}
		}
});

");
//echo'<pre>';print_r($cargoModel);echo'</pre>';//die

?>
<div class="pos-rel">
	<h1><?php echo $bid_name; ?> | Редактирование</h1>

	<p class="bid-detail-number narrow-bold-23">Заявка №<?=$bid_model->bid_id;?></p>	
</div>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<div id="step3Container">
<div class="mb-40">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cargo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<div class="form-row clearfix">
		<?php echo CHtml::link('Назад', $this->createUrl('/bids/view', array('id'=>$bid_model->bid_id)), array ('class'=>'btn-blue-52 fLeft')) ?>		
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn-green-52 fRight', 'name' => 'save')); ?>		
	</div>

	<? $model = $cargoModel	?>
	<? //foreach($cargoes as $key=>$model)	{	?>
	<? for ($key=0; $key<$count_cargoes;$key++)	{	?>
	<div id="cargo<?=($key+1)?>" class="step-container pt-25">
		<div class="container ">
		
			<?php echo $form->hiddenField($model,'category_id'); ?>
			
			<? $fld = 'cargo_id'.($key+1)?>
			<?php echo $form->hiddenField($model, $fld); ?>
			
			<div class="row">
				<div class="col-md-5 col-lg-5">
					<div class="row form-row">
						
						<div class="col-md-2 col-lg-2">
							<? $fld = 'category'.($key+1)?>
							<p class="step3-category-ico catn-c<?=$model->$fld?>-b"> </p>
						</div>
						<div class="col-md-10 col-lg-10">
							<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'name'.($key+1), array('class'=>'width100')); ?>
							<?php echo $form->error($model,'name'.($key+1)); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
						<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
						<?php echo $form->textArea($model,'comment'.($key+1),array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
						<?php echo $form->error($model,'comment'.($key+1)); ?>
						</div>
					</div>
					
				</div>
				<div class="col-md-1 col-lg-1"></div>
				<div class="col-md-6 col-lg-6">
					<div class="row form-row">
						<div class="col-md-7 col-lg-7">
							<div class="row">
								<div class="col-md-12 col-lg-12"><?php echo $form->labelEx($model,'weight', array('class'=>'lbl-block')); ?></div>
								<div class="col-md-8 col-lg-8">
										
										<?php echo $form->textField($model,'weight'.($key+1), array('size'=>3, 'class'=>'width100')); ?>
										<?php echo $form->error($model,'weight'.($key+1)); ?>

								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->dropDownList($model, 'unit'.($key+1), $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
										<?php echo $form->error($model,'unit'.($key+1)); ?>

								</div>
							</div>
						</div>
						
						
						<div class="col-md-5 col-lg-5 upload-foto-block pos-rel">
							<? $fld = 'foto'.($key+1)?>
							<? if($model->$fld != '')	{ ?>
								<div id="cargo-foto<?=($key+1)?>" class="form-cargo-foto" style="background-image: url('<?=$this->app->homeUrl.'files/bids/thumb_'.$model->$fld ?>')"> </div>
							<?	}	else	{	?>
								<div id="cargo-foto<?=($key+1)?>" class="form-cargo-foto" style="background-image: url('/images/new-bid-foto.jpg')"> </div>
							<?	}	?>
							
							<div id="loading<?=($key+1)?>" class="hide-block pos-abs upload-foto-block-loading"><img src="/images/loading.gif" alt="Loading" /></div>
							<div id="errormes-<?=($key+1)?>" class="font-12 mt-5 pos-abs upload-foto-block-errormes c_eb4c4c"></div>
							<a href="#" class="btn-grey-33 upload-foto-btn" data-cargo="<?=($key+1)?>">Загрузить фото</a>
							<? if($key == 0)	{	?>
								<input type="file" name="userfile" id="userfile1" class="userfile" style="display:none;" />
								<input type="hidden" name="cargo-num" id="cargo-num" value="1" />
							<?	}	?>
							
							<?php echo $form->hiddenField($model,'foto'.($key+1)); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12"><label class="lbl-block">Грузчики</label></div>
						<div class="col-md-5 col-lg-5">
								<?php echo $form->checkBox($model,'porters'.($key+1), array('class'=>'checkbox')); ?>
								<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
								<?php echo $form->error($model,'porters'.($key+1)); ?>
						</div>
						<div class="col-md-4 col-lg-4">
								<?php echo $form->checkBox($model,'lift_to_floor'.($key+1), array('class'=>'checkbox')); ?>
								<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
								<?php echo $form->error($model,'lift_to_floor'.($key+1)); ?>
						</div>
						<div class="col-md-3 col-lg-3" style="padding-top:4px;">
								<?php echo $form->textField($model,'floor'.($key+1), array('size'=>1)); ?>
								<?php echo $form->labelEx($model,'floor'); ?>
								
								<?php echo $form->error($model,'floor'.($key+1)); ?>
						</div>
					</div>
					<div class="row form-row">
						<div class="col-md-10 col-lg-10">
							<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'length'.($key+1), array('size'=>3)); ?>
							<span class="dimensions-separator">M x </span>
							<?php echo $form->textField($model,'width'.($key+1), array('size'=>3)); ?>
							<span class="dimensions-separator">M x </span>
							<?php echo $form->textField($model,'height'.($key+1), array('size'=>3)); ?>
							<span class="dimensions-separator">M x </span>
							<?php echo $form->textField($model,'volume'.($key+1), array('size'=>3)); ?>
							<span class="dimensions-separator">M<sup>3</sup> </span>
						</div>
						<div class="col-md-2 col-lg-2" style="padding-top:24px;">
							<?php echo $form->checkBox($model,'lift'.($key+1), array('class'=>'checkbox')); ?>
							<?php echo $form->labelEx($model,'lift', array('class'=>'checkbox-lbl')); ?>						
							<?php echo $form->error($model,'lift'.($key+1)); ?>
						</div>
						
					</div>
				</div>
			</div>

		</div>
	</div>
	<?	}	?>
	
	
	<div class="step-container p-20 mb-40">
		<div class="row clearfix">
		<div class="col-lg-6">
		<? $model = $bid_model ?>
					<div class="row form-row"><div class="col-md-12 col-lg-12 step-subheader">Даты, между которыми нужно перевезти груз</div></div>				
					<div class="row form-row" style="position:relative;">
						<div class="col-md-3 col-lg-3">
							<?php echo $form->labelEx($model,'date_transportation', array('class'=>'lbl-block')); ?>
							<?php //echo $form->textField($model,'date_transportation', array('class'=>'width100')); ?>
							<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'model'=>$model,
									'name' => 'Bids[date_transportation]',
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

						<div class="col-md-2 col-lg-2">
							<?php echo $form->labelEx($model,'time_transportation', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'time_transportation', array('class'=>'width100')); ?>
							<?php echo $form->error($model,'time_transportation'); ?>
						</div>
						<div class="col-md-1 col-lg-1 bold p-0 text_c pt-25 font-32">&mdash;</div>
						
						<div class="col-md-3 col-lg-3">
							<?php echo $form->labelEx($model,'date_transportation_to', array('class'=>'lbl-block')); ?>
							<?php //echo $form->textField($model,'date_transportation', array('class'=>'width100')); ?>
							<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'model'=>$model,
									'name' => 'Bids[date_transportation_to]',
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
										  'id'=>'date_transportation_to',
											'class'=>'width100'
									),

									// DONT FORGET TO ADD TRUE this will create the datepicker return
									// as string
								),true);
							?>
							
							<?php echo $form->error($model,'date_transportation'); ?>						
						</div>
						<div class="col-md-2 col-lg-2">
							<?php echo $form->labelEx($model,'time_transportation_to', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'time_transportation_to', array('class'=>'width100')); ?>
							<?php echo $form->error($model,'time_transportation_to'); ?>
						</div>

						<div class="col-md-12 col-lg-12 font-12 pt-10 c_697f9a">(Вы можете указать только 1 дату или вообще не указывать, если это не важно)</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'price', array('class'=>'lbl-block step-subheader')); ?>
							<?php echo $form->textField($model,'price'); ?>  <label class="" for="Bids_price">белорусских рублей</label>
							<?php echo $form->error($model,'price'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12 step-subheader">Погрузка</div>
					</div>

					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'loading_country', array('class'=>'lbl-block')); ?>
							<?php echo $form->dropDownList($model, 'loading_country', $this->app->params['countries'], array('class'=>'width100'));?>
							<?php echo $form->error($model,'loading_country'); ?>
						</div>
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
					
					
					<? for ($key=1; $key<4;$key++)	{	?>
						<?	$fld = 'add_loading_unloading_town_'.$key ?>
						<div id="add-loading-unloading-block-1" class="form-row add-loading-unloading-block clearfix <? if($model->$fld == '') echo 'hide-block'?>">

							<a href="#" class="delete-loading-unloading-block btn-red">Удалить х</a>

							<div class="col-md-12 col-lg-12">

								<div class="row form-row">
									<div class="col-md-12 col-lg-12 step-subheader">Пункт догрузки/выгрузки</div>
								</div>

								<div class="row form-row">
									<div class="col-md-12 col-lg-12">
										<?php echo $form->labelEx($model,'add_loading_unloading_country_'.$key, array('class'=>'lbl-block')); ?>
										<?php echo $form->dropDownList($model, 'add_loading_unloading_country_'.$key, $this->app->params['countries'], array('class'=>'width100'));?>
										<?php echo $form->error($model,'add_loading_unloading_country_'.$key); ?>
									</div>								
								</div>

								<div class="row form-row">							
									<div class="col-md-12 col-lg-12">
										<?php echo $form->labelEx($model,'add_loading_unloading_town_'.$key, array('class'=>'lbl-block')); ?>
										<?php echo $form->textField($model,'add_loading_unloading_town_'.$key,array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
										<?php echo $form->error($model,'add_loading_unloading_town_'.$key); ?>
									</div>
								</div>

								<div class="row form-row">
									<div class="col-md-12 col-lg-12">
										<?php echo $form->labelEx($model,'add_loading_unloading_address_'.$key, array('class'=>'lbl-block')); ?>
										<?php echo $form->textField($model,'add_loading_unloading_address_'.$key,array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
										<?php echo $form->error($model,'add_loading_unloading_address_'.$key); ?>
									</div>
								</div>

							</div>
						</div>
					
					<?	}	?>
					<?/*
					<div id="add-loading-unloading-block-2" class="form-row add-loading-unloading-block clearfix hide-block">
					
						<a href="#" class="delete-loading-unloading-block btn-red">Удалить х</a>
						
						<div class="col-md-12 col-lg-12">
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12 step-subheader">Пункт догрузки/выгрузки</div>
							</div>
						
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->labelEx($model,'add_loading_unloading_country_2', array('class'=>'lbl-block')); ?>
									<?php echo $form->dropDownList($model, 'add_loading_unloading_country_2', $this->app->params['countries'], array('class'=>'width100'));?>
									<?php echo $form->error($model,'add_loading_unloading_country_2'); ?>
								</div>							
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
									<?php echo $form->labelEx($model,'add_loading_unloading_country_3', array('class'=>'lbl-block')); ?>
									<?php echo $form->dropDownList($model, 'add_loading_unloading_country_3', $this->app->params['countries'], array('class'=>'width100'));?>
									<?php echo $form->error($model,'add_loading_unloading_country_3'); ?>
								</div>							
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
					*/?>
					
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
							<?php echo $form->labelEx($model,'unloading_country', array('class'=>'lbl-block')); ?>
							<?php echo $form->dropDownList($model, 'unloading_country', $this->app->params['countries'], array('class'=>'width100'));?>
							<?php echo $form->error($model,'unloading_country'); ?>
						</div>					
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
			</div>
		</div>
	</div>
	
	<div class="form-row clearfix">
		<?php echo CHtml::link('Назад', $this->createUrl('/bids/view', array('id'=>$bid_model->bid_id)), array ('class'=>'btn-blue-52 fLeft')) ?>		
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'btn-green-52 fRight', 'name' => 'save')); ?>		
	</div>
	
<?php $this->endWidget(); ?>	
</div>
</div>