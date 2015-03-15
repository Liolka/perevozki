	<div class="step-container">
		<div class="container ">
		
			<?php $form=$this->beginWidget('CActiveForm', array(
				'id'=>'cargo-form',
				'enableAjaxValidation'=>false,
			)); ?>
			<?php echo $form->errorSummary($model); ?>
			
			<p class="num-step num-step-light-blue">3</p>
			
			<p class="step-title">Заполните необходимую информацию<span>Внесите как можно больше информации, чтобы получить больше предложений</span></p>

			<div class="row">
				<div class="col-md-5 col-lg-5">
					<div class="row form-row">
						
						<div class="col-md-2 col-lg-2">
							<p class="step3-category-ico catn-c<?=$category_id?>-b"> </p>
						</div>
						<div class="col-md-10 col-lg-10">
							<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
							<?php echo $form->textField($model,'name', array('class'=>'width100')); ?>
							<?php echo $form->error($model,'name'); ?>
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
						<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
						<?php echo $form->textArea($model,'comment',array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
						<?php echo $form->error($model,'comment'); ?>
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
										
										<?php echo $form->textField($model,'weight', array('size'=>3, 'class'=>'width100')); ?>
										<?php echo $form->error($model,'weight'); ?>

								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->dropDownList($model, 'unit', $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
										<?php echo $form->error($model,'unit'); ?>

								</div>
							</div>
						</div>
						
						
						<div class="col-md-5 col-lg-5 upload-foto-block">
							<img src="/images/new-bid-foto.jpg" alt="" class="upload-foto-tmb">
							<a href="#" class="btn-grey-33 upload-foto-btn">Загрузить фото</a>
							
						</div>
					</div>
					
					<div class="row form-row">
						<div class="col-md-12 col-lg-12"><label class="lbl-block">Грузчики</label></div>
						<div class="col-md-4 col-lg-5">
								<?php echo $form->checkBox($model,'porters', array('class'=>'checkbox')); ?>
								<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
								<?php echo $form->error($model,'porters'); ?>
						</div>
						<div class="col-md-4 col-lg-4">
								<?php echo $form->checkBox($model,'lift_to_floor', array('class'=>'checkbox')); ?>
								<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
								<?php echo $form->error($model,'lift_to_floor'); ?>
						</div>
						<div class="col-md-4 col-lg-3" style="padding-top:4px;">
								<?php echo $form->textField($model,'floor', array('size'=>1)); ?>
								<?php echo $form->labelEx($model,'floor'); ?>
								
								<?php echo $form->error($model,'floor'); ?>
						</div>
					</div>
					<div class="row form-row">
						<div class="col-md-12 col-lg-12">
						<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
						<?php echo $form->textField($model,'length', array('size'=>5)); ?>
						<span class="dimensions-separator">M x </span>
						<?php echo $form->textField($model,'width', array('size'=>5)); ?>
						<span class="dimensions-separator">M x </span>
						<?php echo $form->textField($model,'height', array('size'=>5)); ?>
						<span class="dimensions-separator">M x </span>
						<?php echo $form->textField($model,'volume', array('size'=>5)); ?>
						<span class="dimensions-separator">M<sup>3</sup> </span>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	
<?php $this->endWidget(); ?>