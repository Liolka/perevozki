<?
if($deals->transport_id && count($transport_list)) {
	foreach($transport_list as $row )	{
		if($row['transport_id'] == $deals->transport_id ) {
			$transport_name = $row['name'];
		}
	}
}	else	{
	$transport_name = '';
}

?>
		<div id="new-deal" class="add-new-deal-block blue-border-1 bg_daf0fa p-20">
		
		<p class="narrow-regular-24 bold mb-20">Добавление моего предложения</p>
		<div class="add-new-deal-form">
			<? //$model = $deals; ?>
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'bids-form',
				// Please note: When you enable ajax validation, make sure the corresponding
				// controller action is handling ajax validation correctly.
				// There is a call to performAjaxValidation() commented in generated controller code.
				// See class documentation of CActiveForm for details on this.
				'enableAjaxValidation'=>true,
				//'clientOptions'=>array(
					//'validateOnSubmit'=>true,
				//),

			)); ?>
			
			<?php echo $form->errorSummary($deals); ?>
			
			<div class="row pos-rel mb-20">
				<div class="col-md-4 col-lg-4">
					<?php echo $form->labelEx($deals,'price', array('class'=>'lbl-block')); ?>
					<?php echo $form->textField($deals,'price',array('size'=>60,'maxlength'=>255, 'class'=>'deals_price')); ?> рублей
					<?php //echo $form->error($deals,'price'); ?>
				</div>

				<div class="col-md-3 col-lg-3">
					<div class="row">
						<div class="col-md-6 col-lg-6">
							<?php echo $form->labelEx($deals,'deal_date', array('class'=>'lbl-block')); ?>
							<?php //echo $form->textField($deals,'deal_date',array('size'=>60,'maxlength'=>255, 'class'=>'width100')); ?>
							
							<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
									'model'=>$deals,
									'name' => 'Deals[deal_date]',
									'language' => 'ru',
									'value' => $deals->deal_date,
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
										  'id'=>'deal_date',
											'class'=>'width100'
									),

									// DONT FORGET TO ADD TRUE this will create the datepicker return
									// as string
								),true);
							?>
							
							<?php //echo $form->error($deals,'deal_date'); ?>
						
						</div>
						
						<div class="col-md-6 col-lg-6">
							<?php echo $form->labelEx($deals,'deal_time', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($deals,'deal_time',array('size'=>60,'maxlength'=>255, 'class'=>'width100', 'placeholder'=>'ЧЧ:ММ')); ?>
							<?php //echo $form->error($deals,'deal_time'); ?>
						
						</div>
					</div>
				</div>
				
				<div class="col-md-3 col-lg-3 deal-porters-wr">
					<?php echo $form->hiddenField($deals,'transport_id',array('id'=>'deal-transport-id')); ?>
					<button id="deal-set-transport" class="deal-set-transport btn-grey-33 p-0-10">Указать транспорт</button>
					<button id="deal-transport-item" class="deal-transport-item btn-green-33 <?=$transport_name ? '' : 'hide-block' ?>">
						<span class="name"><?=$transport_name?></span> <span class="ico">×</span>
					</button>
					
					
						<div id="deals-form-transport-list" class="deals-form-transport-list pos-abs p-20 hide-block">
							<ul class="row">
								<? if(count($transport_list))	{	?>
									<? foreach($transport_list as $row)	{	?>
										<li class="col-md-4 col-lg-4 pt-10 pb-10">
											<a href="#" data-transport="<?=$row['transport_id']?>" class="deals-form-transport-list-item narrow-regular-16 c_fff underline_n_y"><?=$row['name']?></a>
										</li>
									<?	}	?>
								<?	}	else	{	?>
									<li class="col-md-4 col-lg-4 pt-10 pb-10">
										<a href="#" class="deals-form-transport-list-item narrow-regular-16 c_fff underline_n_y">Транспорт не добавлен...</a>
									</li>
								<?	}	?>
								
							</ul>
						</div>
					
				</div>
				
				<div class="col-md-2 col-lg-2 deal-porters-checkbox">
					<?php echo $form->checkBox($deals,'porters', array('class'=>'checkbox')); ?>
					<?php echo $form->labelEx($deals,'porters', array('class'=>'checkbox-lbl')); ?>						
					<?php //echo $form->error($deals,'porters'); ?>
				</div>
			</div>
			<div class="row mb-20">
				<div class="col-md-12 col-lg-12">
					<?php echo $form->labelEx($deals,'comment', array('class' => 'lbl-block')); ?>
					<?php echo $form->textArea($deals,'comment',array('rows'=>6, 'cols'=>30, 'class'=>'width100' )); ?>
					<?php //echo $form->error($deals,'comment'); ?>
				</div>
			</div>
			
			<?php echo CHtml::submitButton('Разместить предложение', array('id'=>'createDealbtn', 'class'=>'createDealbtn btn-blue-52', 'name'=>'createDealbtn')); ?>			
			
			<?php $this->endWidget(); ?>
		</div>
		
	</div>