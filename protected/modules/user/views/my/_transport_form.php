<?
$transport_image = $model->foto ? $this->app->params->transport_imageLive.'thumb_'.$model->foto : '/images/transport-no-foto.jpg';
?>
 <div class="form modal-dialog">
   <div class="modal-content form">
	   <?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'transport-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
			'htmlOptions'=>array('enctype'=>'multipart/form-data'),
		)); ?>

        <div class="modal-header bg_425770 clearfix">
           <span class="narrow-regular-18 lh-34 c_fff transport-form-title"><?=$title?></span>
            <button type="button" class="close bg_697f9a" data-dismiss="modal" onclick="cancel_changes()">
                <span aria-hidden="true">х</span><span class="sr-only">х</span>
            </button>           
        </div> 

        <div class="modal-body">
			<div class="row">
				<div class="col-md-3 col-lg-3">
					<div id="file_holder" class="upload-transport-image">
						<? /*<img src="/images/transport-no-foto.jpg" alt="" class="my-transport-image"> */ ?>
						<div id="my-transport-image" class="my-transport-image" style="background-image: url(<?=$transport_image?>)"> </div>
						<button id="upload-transport-foto" class="btn-grey-33">Загрузить фото</button>
						<input type="file" name="userfile" id="userfile" class="userfile" style="display:none;" />
						<div id="loading" class="hide-block font-12"><img src="/images/ajax-loader.gif" alt="Loading" /> Загрузка...</div>
						<div id="errormes" class="font-12 mt-5"></div>
						
					</div>
					
				</div>
				<div class="col-md-9 col-lg-9">
					<div class="form-row mb-5">
						<?php echo $form->labelEx($model,'name'); ?>
						<?php echo $form->textField($model,'name',array('size'=>3,'maxlength'=>255, 'class'=>'Transport_name')); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
					<div class="table">
						<div class="table-row">
							<p class="table-cell transport-form-col1"><?php echo $form->labelEx($model,'carrying', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'carrying',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold">&nbsp;кг</p>
						</div>
						<div class="table-row">
							<p class="table-cell transport-form-col1"><?php echo $form->labelEx($model,'length', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell dimentions">
								<?php echo $form->textField($model,'length', array('size'=>3,'maxlength'=>255, 'class'=>'inputbox')); ?>
								<span class="dimensions-separator">x</span>
								<?php echo $form->textField($model,'width',array('size'=>3,'maxlength'=>255, 'class'=>'inputbox')); ?>
								<span class="dimensions-separator">x</span>
								<?php echo $form->textField($model,'height',array('size'=>3,'maxlength'=>255, 'class'=>'inputbox')); ?>
							</p>
							<p class="table-cell bold">&nbsp;м</p>
						</div>
						<div class="table-row">
							<p class="table-cell transport-form-col1"><?php echo $form->labelEx($model,'volume', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'volume',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold">&nbsp;м3</p>
						</div>
						
						<div class="table-row">
							<p class="table-cell transport-form-col1"><?php echo $form->labelEx($model,'body_type', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'body_type',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold"></p>
						</div>
						
						<div class="table-row">
							<p class="table-cell transport-form-col1"><?php echo $form->labelEx($model,'loading_type', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'loading_type',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold"></p>
						</div>
						
					</div>
					
					<div class="form-row mb-5">
						<?php echo $form->labelEx($model,'comment', array('class' => 'italic')); ?>
						<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>30, 'class'=>'Transport_comment italic' )); ?>
						<?php echo $form->error($model,'comment'); ?>
					</div>
					
					
				</div>
			</div>


        </div>

        <div class="modal-footer">
			<?php echo $form->hiddenField($model,'foto'); ?>
			<?php echo CHtml::submitButton('Сохранить', array('id'=>'saveTransportButton', 'class'=>'saveTransportButton btn-blue-33', 'name'=>'saveButton')); ?>
			<button class="fRight btn-grey-33" onclick="cancel_changes();close_popup();return false;">Отменить</button>           

        </div>

        
    </div>
	
	<?php $this->endWidget(); ?>

</div>