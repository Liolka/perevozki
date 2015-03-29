<?php
/* @var $this BidsController */

$this->breadcrumbs=array(
	'Заявки на перевозку грузов',
);

$bids_filter_dates_from = $bids_filter_dates_to = '';


?>

<h1>Заявки на перевозку грузов</h1>

<div class="my-page clearfix">

	<div class="sidebar sideLeft">
		<div class="bids-filter">
		
			<?php $form = $this->beginWidget('CActiveForm', array(
				'id'=>'bids-filter-form',
				// Please note: When you enable ajax validation, make sure the corresponding
				// controller action is handling ajax validation correctly.
				// There is a call to performAjaxValidation() commented in generated controller code.
				// See class documentation of CActiveForm for details on this.
				//'enableAjaxValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				),

			)); ?>
			
			<?php echo $form->errorSummary($model); ?>
			
			<div class="bids-filter-block bids-filter-topbtns">
				<input type="hidden" name="clear-bids-filter" id="clear-bids-filter" value="0" />
				<p class="bids-filter-clear-wr"><a href="#" id="bids-filter-clear" class="bids-filter-clear">Сбросить фильтры</a></p>
				<a href="#" id="bids-filter-filterig" class="btn-blue-33 bids-filter-filterig">Отфильтровать</a>
			</div>
			<div class="bids-filter-block bids-filter-dates">
				<span class="bids-filter-title">Дата перевозки</span>
				<p class="dates clearfix">
					
					<span class="dates-txt">С</span>
					
					<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'name' => 'BidsFilter[bids_filter_dates_from]',
							'language' => 'ru',
							'value' => $model->bids_filter_dates_from,
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
								'id'=>'bids-filter-dates-from',
								'class'=>'bids-filter-dates-from width100',
							),

							// DONT FORGET TO ADD TRUE this will create the datepicker return
							// as string
						),true);
					?>
					<span class="calendar-icon calendar-icon1"> </span>
				</p>
				<p class="dates clearfix">
					
					<span class="dates-txt">По</span>
					<?php echo $this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model,
							'name' => 'BidsFilter[bids_filter_dates_to]',
							'language' => 'ru',
							'value' => $model->bids_filter_dates_to,
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
								'id'=>'bids-filter-dates-to',
								'class'=>'bids-filter-dates-to width100',
							),

							// DONT FORGET TO ADD TRUE this will create the datepicker return
							// as string
						),true);
					?>
					<span class="calendar-icon calendar-icon2"> </span>
				</p>
				
			</div>
			<div class="bids-filter-block bids-filter-towns">
				<span class="bids-filter-title">Маршрут</span>
				<p>
					<?php echo $form->labelEx($model,'town_from', array('class'=>'lbl-block')); ?>
					<?php echo $form->textField($model,'town_from', array('size'=>60,'maxlength'=>128, 'class'=>'width100')); ?>
				</p>
				
				<p>
					<?php echo $form->labelEx($model,'town_to', array('class'=>'lbl-block')); ?>
					<?php echo $form->textField($model,'town_to', array('size'=>60,'maxlength'=>128, 'class'=>'width100')); ?>
				</p>
				
			</div>
			<div id="bids-filter-categories" class="bids-filter-block bids-filter-categories">
				<span class="bids-filter-title">Тип груза</span>
				<p class="bids-filter-categories-btns">
					<a href="#" id="bids-filter-categories-check" class="bids-filter-categories-check">Выбрать все категории</a>
					<a href="#" id="bids-filter-categories-uncheck" class="bids-filter-categories-uncheck">Сбросить</a>
				</p>
				
				<ul>
				<? foreach($categories_list as $cat) {	?>
					<li class="bids-filter-categories-list-item">
						<p class="bids-filter-categories-item">
							<input type="checkbox" name="bids-filter-categories[]" id="bids-filter-categories-item-<?=$cat['id']?>" class="checkbox bids-filter-categories-item-checkbox" value="<?=$cat['id']?>" <?=$cat['checked']? 'checked="checked"' : '' ?></input><label for="bids-filter-categories-item-<?=$cat['id']?>" class="checkbox-lbl"><?=$cat['name']?></label>
						</p>
					</li>
				<? } ?>
				</ul>
			</div>
			
			
			
			<?php $this->endWidget(); ?>
		</div>
		

	</div>


	<div class="content column2l">
		<div class="bids-sorting-block">
			<form action="" method="post" id="sort-bids-form">
				<input type="hidden" id="type-sort" name="type-sort" value="" />
			</form>
			<ul id="bids-sorting-block-list" class="bids-sorting-block-list clearfix">
				<li class="bids-sorting-block-title">Сортировка:</li>
				<li class="bids-sorting-block-btn <? if($type_sort == 'datepub') echo 'active' ?>"><a href="#" data-sort="datepub" rel="nofollow">По дате публикации</a></li>
				<li class="bids-sorting-block-btn <? if($type_sort == 'dateperevoz') echo 'active' ?>"><a href="#" data-sort="dateperevoz" rel="nofollow">По дате перевозки</a></li>
			</ul>
		</div>
	
		<div class="requests-list-container">
			<ul class="requests-list-head clearfix mb-15">
				<li class="numb c_757575 font-12 fLeft">№</li>
				<li class="info c_757575 font-12 fLeft">Информация о грузе</li>
				<li class="addr from c_757575 font-12 fLeft">Откуда</li>
				<li class="addr to c_757575 font-12 fLeft">Куда</li>
				<li class="date c_757575 font-12 fLeft">Дата выезда / Предложения</li>
				<li class="price c_757575 font-12 fLeft">Предложенная стоимость</li>
			</ul>
			<? /*
			<ul class="requests-list-items">
				<li class="requests-list-item clearfix">
					<div class="requests-list-item_number">8523963</div>
					<div class="requests-list-item_info">
						<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
						<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
						<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
					</div>
					<div class="requests-list-item_from">
						<span class="requests-list-item_town counry-by">Гомель</span>
						<span class="requests-list-item_adress">ул. Малайчука, 12</span>
						<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр (*15)</a></p>
					</div>
					<div class="requests-list-item_to">
						<span class="requests-list-item_town counry-by">Брест</span>
						<span class="requests-list-item_adress">ул. Малайчука, 27</span>
					</div>
					<div class="requests-list-item_date">
						<span class="requests-list-item_created">11.06.2015</span>
						<p class="requests-list-item_suggestions"><span class="suggestion-green">0</span>предложений</p>
					</div>
					<div class="requests-list-item_price">
						<span class="requests-list-item-price_price">до 8 500 000 р.</span>
						<a class="btn-blue-33" href="#">Откликнуться</a>
					</div>
				</li>

				<li class="requests-list-item clearfix">
					<div class="requests-list-item_number">8523963</div>
					<div class="requests-list-item_info">
						<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
						<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
						<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
					</div>
					<div class="requests-list-item_from">
						<span class="requests-list-item_town counry-by">Гомель</span>
						<span class="requests-list-item_adress">ул. Малайчука, 12</span>
						<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр (*15)</a></p>
					</div>
					<div class="requests-list-item_to">
						<span class="requests-list-item_town counry-by">Брест</span>
						<span class="requests-list-item_adress">ул. Малайчука, 27</span>
					</div>
					<div class="requests-list-item_date">
						<span class="requests-list-item_created">11.06.2015</span>
						<p class="requests-list-item_suggestions"><span class="suggestion-orange">99</span>предложений</p>
					</div>
					<div class="requests-list-item_price">
						<span class="requests-list-item-price_price">до 500 000 р.</span>
						<a class="btn-blue-33" href="#">Откликнуться</a>
					</div>
				</li>

				<li class="requests-list-item clearfix">
					<div class="requests-list-item_number">8523963</div>
					<div class="requests-list-item_info">
						<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
						<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
						<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
					</div>
					<div class="requests-list-item_from">
						<span class="requests-list-item_town counry-by">Гомель</span>
						<span class="requests-list-item_adress">ул. Малайчука, 12</span>
						<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр Михайлович (*15)</a></p>
					</div>
					<div class="requests-list-item_to">
						<span class="requests-list-item_town counry-by">Брест</span>
						<span class="requests-list-item_adress">ул. Малайчука, 27</span>
					</div>
					<div class="requests-list-item_date">
						<span class="requests-list-item_created">11.06.2015</span>
						<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
					</div>
					<div class="requests-list-item_price">
						<span class="requests-list-item-price_price">до 10 500 000 р.</span>
						<a class="btn-blue-33" href="#">Откликнуться</a>
					</div>
				</li>

				<li class="requests-list-item clearfix">
					<div class="requests-list-item_number">8523963</div>
					<div class="requests-list-item_info">
						<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
						<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
						<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
					</div>
					<div class="requests-list-item_from">
						<span class="requests-list-item_town counry-by">Гомель</span>
						<span class="requests-list-item_adress">ул. Малайчука, 12</span>
						<p class="requests-list-item_author">Добавил 2ч назад <a href="#">Александр Михайлович (*15)</a></p>
					</div>
					<div class="requests-list-item_to">
						<span class="requests-list-item_town counry-by">Брест</span>
						<span class="requests-list-item_adress">ул. Малайчука, 27</span>
					</div>
					<div class="requests-list-item_date">
						<span class="requests-list-item_created">11.06.2015</span>
						<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
					</div>
					<div class="requests-list-item_price">
						<span class="requests-list-item-price_price">до 10 500 000 р.</span>
						<a class="btn-blue-33" href="#">Откликнуться</a>
					</div>
				</li>

			</ul>
			*/ ?>
			
			
			<?php $this->renderPartial('_loop', array('dataProvider'=>$dataProvider)); ?>
			
			
			
				
		</div>	
	</div>
	
</div>
