	<? for ($key=1; $key<=4; $key++)	{	?>
		<div id="cargo<?=$key?>" class="step-container <? if($key > 1) echo 'add-cargo-step-container hide-block'?>">
			<? if($key > 1)	{	?>
				<a href="#" class="delete-add-cargo-block btn-red">Удалить х</a>
			<?	}	?>
			
			<div class="container ">
				<? if($key == 1)	{	?>
					<p class="num-step num-step-light-blue">3</p>
					<p class="step-title">Заполните необходимую информацию<span>Внесите как можно больше информации, чтобы получить больше предложений</span></p>
				<?	}	?>

				<div class="row">
					<div class="col-md-5 col-lg-5">
						<? if($key > 1)	{	?>
						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
								<?php echo $form->dropDownList($model, 'category'.$key, $categories_list, array('data-placeholder'=>'выберите...', 'options' => array(), 'class'=>'width100'));?>
								<?php echo $form->error($model,'category'.$key); ?>
							</div>
						</div>
						<?	}	?>
					
						<div class="row form-row">

							<div class="col-md-2 col-lg-2">
								<p class="step3-category-ico catn-c<?=$model->category_id?>-b"> </p>
							</div>
							<div class="col-md-10 col-lg-10"> 
								<?php echo $form->labelEx($model,'name', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'name'.$key, array('class'=>'width100')); ?>
								<?php echo $form->error($model,'name'.$key); ?>
							</div>
						</div>

						<div class="row form-row">
							<div class="col-md-12 col-lg-12">
							<?php echo $form->labelEx($model,'comment', array('class'=>'lbl-block')); ?>
							<?php echo $form->textArea($model,'comment'.$key,array('rows'=>7, 'cols'=>50, 'class'=>'width100')); ?>
							<?php echo $form->error($model,'comment'.$key); ?>
							</div>
						</div>

					</div>
					 
					<div class="col-md-7 col-lg-7" <? if($key > 1) echo 'style="margin-top: 45px;"'?>>
						<div class="row form-row">
						
							<? if($model->category_id != 4)	{	?>
							<div class="col-md-7 col-lg-7">
								<div class="row">
									<div class="col-md-12 col-lg-12"><?php echo $form->labelEx($model,'weight', array('class'=>'lbl-block')); ?></div>
									<div class="col-md-8 col-lg-8">

											<?php echo $form->textField($model,'weight'.$key, array('size'=>3, 'class'=>'width100')); ?>
											<?php echo $form->error($model,'weight'.$key); ?>

									</div>
									<div class="col-md-4 col-lg-4">
											<?php echo $form->dropDownList($model, 'unit'.$key, $model->DropDownUnitsList, array('data-placeholder'=>'выберите...', 'options' => $model->SelectedUnitsList));?>
											<?php echo $form->error($model,'unit'.$key); ?>

									</div>
								</div>
							</div>


							<div class="col-md-5 col-lg-5 upload-foto-block pos-rel">
								<? $fld = 'foto'.$key ?>
								<? if($model->$fld != '')	{ ?>
									<div id="cargo-foto<?=$key?>" class="form-cargo-foto" style="background-image: url('<?=$this->app->homeUrl.'files/bids/thumb_'.$model->$fld ?>')"> </div>
								<?	}	else	{	?>
									<div id="cargo-foto<?=$key?>" class="form-cargo-foto" style="background-image: url('/images/new-bid-foto.jpg')"> </div>
								<?	}	?>
							
								<?php /*<div id="cargo-foto<?=$key?>" class="form-cargo-foto" style="background-image: url('/images/new-bid-foto.jpg')"> </div>*/?>
								
								<div id="loading<?=$key?>" class="hide-block pos-abs upload-foto-block-loading"><img src="/images/loading.gif" alt="Loading" /></div>
								<div id="errormes<?=$key?>" class="font-12 mt-5 pos-abs upload-foto-block-errormes c_eb4c4c cargo<?=$key?>-err"></div>
								<a href="#" class="btn-grey-33 upload-foto-btn" data-cargo="<?=$key?>">Загрузить фото</a>
								
								<? if($key == 1)	{	?>
									<input type="file" name="userfile" id="userfile1" class="userfile" style="display:none;" />
								<?	}	?>
								<input type="hidden" name="cargo-num" id="cargo-num" value="" />
								<?php echo $form->hiddenField($model,'foto'.$key); ?>
								
								
							</div>
							
							<?	}	else	{	?>
							
								<? if($key == 1)	{	// необходимо чтобы не было в скрипте ошибки?>
									<input type="file" name="userfile" id="userfile1" class="userfile" style="display:none;" />
								<?	}	?>
							
							<div class="col-md-6 col-lg-6">
								<?php echo $form->labelEx($model,'passengers_qty', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'passengers_qty'.$key, array('size'=>3, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'passengers_qty'.$key); ?>
							</div>
							
							<div class="col-md-6 col-lg-6">
								<?php echo $form->labelEx($model,'time', array('class'=>'lbl-block')); ?>
								<?php echo $form->textField($model,'time'.$key, array('size'=>3, 'class'=>'width100')); ?>
								<?php echo $form->error($model,'time'.$key); ?>
							</div>
							
							<?	}	?>
						</div>
						<? if($model->category_id != 13 && $model->category_id != 4)	{	?>
							<? if($model->category_id != 9)	{	?>
								<div class="row form-row">
									<div class="col-md-12 col-lg-12"><label class="lbl-block">Грузчики</label></div>
									<div class="col-md-5 col-lg-5">
										<?php echo $form->checkBox($model,'porters'.$key, array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'porters', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'porters'.$key); ?>
									</div>
									<div class="col-md-4 col-lg-4">
										<?php echo $form->checkBox($model,'lift_to_floor'.$key, array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift_to_floor', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift_to_floor'.$key); ?>
									</div>
									<div class="col-md-3 col-lg-3" style="padding-top:4px;">
										<?php echo $form->textField($model,'floor'.$key, array('size'=>1)); ?>
										<?php echo $form->labelEx($model,'floor'); ?>
										<?php echo $form->error($model,'floor'.$key); ?>
									</div>
								</div>
							<?	}	?>
							
							<div class="row form-row">
								<div class="col-md-10 col-lg-10">
									<div class="row">
										<div class="col-lg-3 col-md-3">
											<label class="lbl-block" for="Cargoes_length<?=$key?>">Длинна</label>
											<?php echo $form->textField($model,'length'.$key, array('size'=>3)); ?>
											<span class="dimensions-separator">M x </span>
										</div>
										<div class="col-lg-3 col-md-3">
											<label class="lbl-block" for="Cargoes_width<?=$key?>">Ширина</label>
											<?php echo $form->textField($model,'width'.$key, array('size'=>3)); ?>
											<span class="dimensions-separator">M x </span>									
										</div>
										<div class="col-lg-3 col-md-3">
											<label class="lbl-block" for="Cargoes_height<?=$key?>">Высота</label>
											<?php echo $form->textField($model,'height'.$key, array('size'=>3)); ?>
											<span class="dimensions-separator">M x </span>

										</div>
										<div class="col-lg-3 col-md-3">
											<label class="lbl-block" for="Cargoes_volume<?=$key?>">Объём</label>
											<?php echo $form->textField($model,'volume'.$key, array('size'=>3)); ?>
											<span class="dimensions-separator">M<sup>3</sup> </span>									
										</div>
									</div>
								</div>
								
								<? if($model->category_id != 9)	{	?>
									<div class="col-md-2 col-lg-2" style="padding-top:24px;">
										<?php echo $form->checkBox($model,'lift'.$key, array('class'=>'checkbox')); ?>
										<?php echo $form->labelEx($model,'lift', array('class'=>'checkbox-lbl')); ?>						
										<?php echo $form->error($model,'lift'.$key); ?>
									</div>
								<?	}	?>
							</div>
						<?	}	?>
					</div>
				</div>

			</div>
		</div>	
	<?	}	?>
	