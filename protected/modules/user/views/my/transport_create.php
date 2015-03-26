<?php 
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
		)); ?>

        <div class="modal-header bg_425770 clearfix">
           <span class="narrow-regular-18 lh-34 c_fff transport-form-title">Добавить транспорт</span>
            <button type="button" class="close bg_697f9a" data-dismiss="modal">
                <span aria-hidden="true">х</span><span class="sr-only">х</span>
            </button>           
        </div> 

        <div class="modal-body">
			<div class="row">
				<div class="col-md-4 col-lg-4">
					<div class="upload-transport-image">
						<img src="/images/transport-no-foto.jpg" alt="" class="my-transport-image">
						<button id="upload-transport-foto" class="btn-grey-33">Загузить фото</button>
						<input type="file" name="userfile" id="userfile" class="userfile" />
						<div id="loading" class="hide-block"><img src="/images/ajax-loader.gif" alt="Loading" /> Loading, please wait...</div>
						<div id="errormes"></div>
						
					</div>
					
				</div>
				<div class="col-md-8 col-lg-8">
					<div class="form-row mb-5">
						<?php echo $form->labelEx($model,'name'); ?>
						<?php echo $form->textField($model,'name',array('size'=>3,'maxlength'=>255, 'class'=>'Transport_name')); ?>
						<?php echo $form->error($model,'name'); ?>
					</div>
					<div class="table">
						<div class="table-row">
							<p class="table-cell"><?php echo $form->labelEx($model,'carrying', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'carrying',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold">&nbsp;кг</p>
						</div>
						<div class="table-row">
							<p class="table-cell"><?php echo $form->labelEx($model,'length', array('class'=>'font-12 normal')); ?></p>
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
							<p class="table-cell"><?php echo $form->labelEx($model,'volume', array('class'=>'font-12 normal')); ?></p>
							<p class="table-cell"><?php echo $form->textField($model,'volume',array('size'=>3,'maxlength'=>255, 'class'=>'width100')); ?></p>
							<p class="table-cell bold">&nbsp;м3</p>
						</div>
						
					</div>
					
				</div>
			</div>


        </div>

        <div class="modal-footer">
           <?php echo CHtml::submitButton('Сохранить', array('class'=>'loginButton btn-grey-33', 'name'=>'saveButton')); ?>
            <button type="button" class="close btn-grey-33" data-dismiss="modal">
                <span aria-hidden="true">Отменить</span><span class="sr-only">Отменить</span>
            </button>           

        </div>

        
    </div>
	
	<?php $this->endWidget(); ?>

</div>