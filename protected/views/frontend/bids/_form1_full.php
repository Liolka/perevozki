<?php
/* @var $this BidsController */
/* @var $model Bids */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'bids-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>
	<div class="step-container">
		<div class="container ">

			<p class="num-step num-step-green">1</p>
			<p class="step-title">Выберите категорию перевозки</p>

			<div class="row">
				<ul class="clearfix">
				<? foreach($categories_list_level1 as $cat) {	?>
					<li class="col-md-2 col-lg-2 step1-list-item">
						<a href="javascript:void(0)" class="step1-category-item step1-category-item-<?=$cat['id']?>" data-catid="<?=$cat['id'] ?>">
							<span class="span-wr1"><span class="span-wr2"><?=$cat['name']?></span></span>
						</a>
					</li>
				<? } ?>
				</ul>
			</div>

		</div>
	</div>
	<div id="step2Container">
		<div class="step-container">
			<div class="container ">

				<p class="num-step num-step-green">2</p>
				<p class="step-title">Выберите одну или несколько подкатегорий</p>

				<div class="row">
					<ul class="clearfix">
					<? foreach($categories_list_level2 as $cat) {	?>
						<li class="col-md-3 col-lg-3 step2-list-item">
							<p class="step2-category-item">
								<input type="checkbox" name="Cargoes[category1][]" onchange="change_step2_cat(this)" id="step2-category-item-<?=$cat['id']?>" class="checkbox step2-category-item-checkbox" value="<?=$cat['id']?>"><label for="step2-category-item-<?=$cat['id']?>" class="checkbox-lbl"><?=$cat['name']?></label>
							</p>
						</li>
					<? } ?>
					</ul>
				</div>

			</div>
		</div>		
	</div>
	
	<div id="step3Container">
		<? $model = $model_Cargoes;  ?>
			<div class="step-container">
				<div class="container ">


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
									<?php echo $form->textField($model,'name1', array('class'=>'width100')); ?>
									<?php echo $form->error($model,'name1'); ?>
								</div>
							</div>

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
								<?php echo $form->textArea($model,'comment1',array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'comment1'); ?>
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

												<?php echo $form->textField($model,'weight1', array('size'=>3, 'class'=>'width100')); ?>
												<?php echo $form->error($model,'weight1'); ?>

										</div>
										<div class="col-md-4 col-lg-4">
												<?php echo $form->dropDownList($model, 'unit1', $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
												<?php echo $form->error($model,'unit1'); ?>

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
										<?php echo $form->checkBox($model,'porters1', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'porters1'); ?>
								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->checkBox($model,'lift_to_floor1', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift_to_floor1'); ?>
								</div>
								<div class="col-md-4 col-lg-3" style="padding-top:4px;">
										<?php echo $form->textField($model,'floor1', array('size'=>1)); ?>
										<?php echo $form->labelEx($model,'floor'); ?>

										<?php echo $form->error($model,'floor1'); ?>
								</div>
							</div>
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'length1', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'width1', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'height1', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'volume1', array('size'=>5)); ?>
								<span class="dimensions-separator">M<sup>3</sup> </span>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="step-container add-cargo-step-container hide-block">
				<a href="#" class="delete-add-cargo-block btn-red">Удалить х</a>
				<div class="container">


					<div class="row">
						<div class="col-md-5 col-lg-5">

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->dropDownList($model, 'category2', $categories_list, array('data-placeholder'=>'выберите...', 'options' => array(), 'class'=>'width100'));?>
									<?php echo $form->error($model,'category2'); ?>
								</div>
							</div>


							<div class="row form-row">

								<div class="col-md-2 col-lg-2">
									<p class="step3-category-ico catn-c<?=$category_id?>-b"> </p>
								</div>
								<div class="col-md-10 col-lg-10">
									<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'name2', array('class'=>'width100')); ?>
									<?php echo $form->error($model,'name2'); ?>
								</div>
							</div>

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
								<?php echo $form->textArea($model,'comment2',array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'comment2'); ?>
								</div>
							</div>

						</div>
						<div class="col-md-1 col-lg-1"></div>
						<div class="col-md-6 col-lg-6" style="margin-top: 45px;">
							<div class="row form-row">
								<div class="col-md-7 col-lg-7">
									<div class="row">
										<div class="col-md-12 col-lg-12"><?php echo $form->labelEx($model,'weight', array('class'=>'lbl-block')); ?></div>
										<div class="col-md-8 col-lg-8">

												<?php echo $form->textField($model,'weight2', array('size'=>3, 'class'=>'width100')); ?>
												<?php echo $form->error($model,'weight2'); ?>

										</div>
										<div class="col-md-4 col-lg-4">
											<?php echo $form->dropDownList($model, 'unit2', $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
											<?php echo $form->error($model,'unit2'); ?>
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
										<?php echo $form->checkBox($model,'porters2', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'porters2'); ?>
								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->checkBox($model,'lift_to_floor2', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift_to_floor2'); ?>
								</div>
								<div class="col-md-4 col-lg-3" style="padding-top:4px;">
										<?php echo $form->textField($model,'floor2', array('size'=>1)); ?>
										<?php echo $form->labelEx($model,'floor'); ?>

										<?php echo $form->error($model,'floor2'); ?>
								</div>
							</div>
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'length2', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'width2', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'height2', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'volume2', array('size'=>5)); ?>
								<span class="dimensions-separator">M<sup>3</sup> </span>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="step-container add-cargo-step-container hide-block">
				<a href="#" class="delete-add-cargo-block btn-red">Удалить х</a>
				<div class="container">


					<div class="row">
						<div class="col-md-5 col-lg-5">

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->dropDownList($model, 'category3', $categories_list, array('data-placeholder'=>'выберите...', 'options' => array(), 'class'=>'width100'));?>
									<?php echo $form->error($model,'category3'); ?>
								</div>
							</div>


							<div class="row form-row">

								<div class="col-md-2 col-lg-2">
									<p class="step3-category-ico catn-c<?=$category_id?>-b"> </p>
								</div>
								<div class="col-md-10 col-lg-10">
									<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'name3', array('class'=>'width100')); ?>
									<?php echo $form->error($model,'name3'); ?>
								</div>
							</div>

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
								<?php echo $form->textArea($model,'comment3',array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'comment3'); ?>
								</div>
							</div>

						</div>
						<div class="col-md-1 col-lg-1"></div>
						<div class="col-md-6 col-lg-6" style="margin-top: 45px;">
							<div class="row form-row">
								<div class="col-md-7 col-lg-7">
									<div class="row">
										<div class="col-md-12 col-lg-12"><?php echo $form->labelEx($model,'weight', array('class'=>'lbl-block')); ?></div>
										<div class="col-md-8 col-lg-8">

												<?php echo $form->textField($model,'weight3', array('size'=>3, 'class'=>'width100')); ?>
												<?php echo $form->error($model,'weight3'); ?>

										</div>
										<div class="col-md-4 col-lg-4">
											<?php echo $form->dropDownList($model, 'unit3', $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
											<?php echo $form->error($model,'unit3'); ?>
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
										<?php echo $form->checkBox($model,'porters3', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'porters3'); ?>
								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->checkBox($model,'lift_to_floor3', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift_to_floor3'); ?>
								</div>
								<div class="col-md-4 col-lg-3" style="padding-top:4px;">
										<?php echo $form->textField($model,'floor3', array('size'=>1)); ?>
										<?php echo $form->labelEx($model,'floor'); ?>
										<?php echo $form->error($model,'floor3'); ?>
								</div>
							</div>
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'length3', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'width3', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'height3', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'volume3', array('size'=>5)); ?>
								<span class="dimensions-separator">M<sup>3</sup> </span>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="step-container add-cargo-step-container hide-block">
				<a href="#" class="delete-add-cargo-block btn-red">Удалить х</a>
				<div class="container">


					<div class="row">
						<div class="col-md-5 col-lg-5">

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
									<?php echo $form->dropDownList($model, 'category4', $categories_list, array('data-placeholder'=>'выберите...', 'options' => array(), 'class'=>'width100'));?>
									<?php echo $form->error($model,'category4'); ?>
								</div>
							</div>


							<div class="row form-row">

								<div class="col-md-2 col-lg-2">
									<p class="step3-category-ico catn-c<?=$category_id?>-b"> </p>
								</div>
								<div class="col-md-10 col-lg-10">
									<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
									<?php echo $form->textField($model,'name4', array('class'=>'width100')); ?>
									<?php echo $form->error($model,'name4'); ?>
								</div>
							</div>

							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
								<?php echo $form->textArea($model,'comment4',array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'comment4'); ?>
								</div>
							</div>

						</div>
						<div class="col-md-1 col-lg-1"></div>
						<div class="col-md-6 col-lg-6" style="margin-top: 45px;">
							<div class="row form-row">
								<div class="col-md-7 col-lg-7">
									<div class="row">
										<div class="col-md-12 col-lg-12"><?php echo $form->labelEx($model,'weight', array('class'=>'lbl-block')); ?></div>
										<div class="col-md-8 col-lg-8">

												<?php echo $form->textField($model,'weight4', array('size'=>3, 'class'=>'width100')); ?>
												<?php echo $form->error($model,'weight4'); ?>

										</div>
										<div class="col-md-4 col-lg-4">
											<?php echo $form->dropDownList($model, 'unit4', $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
											<?php echo $form->error($model,'unit4'); ?>
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
										<?php echo $form->checkBox($model,'porters4', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'porters4'); ?>
								</div>
								<div class="col-md-4 col-lg-4">
										<?php echo $form->checkBox($model,'lift_to_floor4', array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift_to_floor4'); ?>
								</div>
								<div class="col-md-4 col-lg-3" style="padding-top:4px;">
										<?php echo $form->textField($model,'floor4', array('size'=>1)); ?>
										<?php echo $form->labelEx($model,'floor'); ?>

										<?php echo $form->error($model,'floor4'); ?>
								</div>
							</div>
							<div class="row form-row">
								<div class="col-md-12 col-lg-12">
								<?php echo $form->labelEx($model,'length', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'length4', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'width4', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'height4', array('size'=>5)); ?>
								<span class="dimensions-separator">M x </span>
								<?php echo $form->textField($model,'volume4', array('size'=>5)); ?>
								<span class="dimensions-separator">M<sup>3</sup> </span>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="form-row add-loading-unloading-block clearfix" style="padding-bottom: 15px;">
				<div class="col-md-12 col-lg-12">
					<a href="#" id="add-cargo-block" class="btn-grey-33">+ Добавить еще груз</a>
					<label for="">Можете добавить груз для совместной перевозки по маршруту</label>						
				</div>
			</div>

	</div>
	
	<div id="step-final-btn-wr" class="buttons text-align-center">
		<?php echo CHtml::submitButton('Перейти к финальному шагу', array('class'=>'btn-green-52 step-final-btn', 'name' => 'step3')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div><!-- form -->