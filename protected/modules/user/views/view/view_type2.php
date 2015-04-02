<?php
$this->breadcrumbs=array(
	$model->username,
);

$this->layout='//layouts/column2';

//echo'<pre>';print_r(dirname(dirname(__FILE__)));echo'</pre>';

$transport_imageLive = $this->app->homeUrl.'files/users/'.$model->id.'/transport/';

$counter = 1;

$this->app->getClientScript()->registerCoreScript('flexcroll');

$cs = $this->app->clientScript;

$cs->registerScript('loading', "

	var max_height = 0;
	
	$('#flexcroll-transport-list li').each(function(){
		if($(this).height() > max_height) { 
			max_height = $(this).height();
		}
	});
	$('#flexcroll-transport-list li').css('height', (max_height+'px'));
	max_height = max_height + 50;
	$('#flexcroll-transport-list').css('height', (max_height+'px'));
	fleXenv.fleXcrollMain('flexcroll-transport-list');
	
	
");



?>
<h1><?php echo $model->username ?></h1>
<p class="bid-detail-number narrow-bold-23">Профиль перевозчика</p>

<div class="clearfix">
	<div class="content column2r">
		<? include (dirname(dirname(__FILE__))."/common/perevozchik-contact-info-container.php")?>


	</div>

	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/perevozchik-rating-reviews.php")?>

	</div>
</div>

<div class="blue-border-1 mt-40 mb-40 bg_f4fbfe p-20 ov-hidden">
	<p class="narrow-bold-23 mb-30">
		Транспорт перевозчика
		<span class="narrow-regular-18 c_71a72c pl-10">(<? echo count($dataProvider->data).' '.Yii::t('app', 'единица|единицы|единиц', count($dataProvider->data))?>)</span>
	</p>


	<div id="flexcroll-transport-list" class="flexcroll77 flexcroll-transport-list">
		<ul class="transport-list transport-list-in-row clearfix pos-rel" style="width:<?=(405 * count($dataProvider->data))?>px">
			<? foreach($dataProvider->data as $row) { ?>

			<?
			$unit_arr = array();
			$value_arr = array();
			if($row->length != '')	{
				$unit_arr[] = 'Д';
				$value_arr[] = $row->length;
			}

			if($row->width != 0)	{
				$unit_arr[] = 'Ш';
				$value_arr[] = $row->width;
			}

			if($row->height != 0)	{
				$unit_arr[] = 'В';
				$value_arr[] = $row->height;
			}

			//$transport_image = $row->foto ? $this->app->params->transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg';
			$transport_image = $row->foto ? $transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg';

			?>

				<li class="pofile-transport-list-item fLeft bg_fff <? //if($counter == 4) { echo 'clear'; $counter = 1; } ?>">

					<? include (dirname(dirname(__FILE__))."/common/transport-list-item.php")?>

					<div class="my-transport-edit">
						<div class="my-transport-edit-top">
							<a href="<?=$this->createUrl('/user/my/transportupdate', array('id'=>$row->transport_id))?>" class="my-transport-edit-btn btn-blue1">Редактировать</a>
							<a href="<?=$this->createUrl('/user/my/transportdelete', array('id'=>$row->transport_id))?>" class="my-transport-delete-btn btn-red" onclick="if(!confirm('Действительно удалить?')) return false;">Удалить х</a>
						</div>
						<? /*<a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a> */ ?>
					</div>
				</li>
				<? $counter++ ?>
			<? } ?>

		</ul>
	</div>
</div>


<div class="profile-documents">
	<p class="narrow-bold-23 mb-30">Документы перевозчика</p>
	
	<ul class="clearfix">
		<? if($model->file1 != '' && $model->file1_checked == 1)	{	?>
			<li class="my-docs-files-item my-docs-files-item-ok">
				<div class="fileform">
					<div class="selectbutton document-ok">Проверен</div>
				</div>
				<p class="info pb-10">
					<label>Пример договора</label>
				</p>
				<p class="info">
					<a class="" href="http://skorohod.by/files/users/9/docs/bcbc599c434c37696fc8d08a2daf6a63.zip">Скачать</a>
				</p>
			</li>		
		<?	}	?>
		
		<? if($model->file2 != '' && $model->file2_checked == 1)	{	?>
			<li class="my-docs-files-item my-docs-files-item-ok">
				<div class="fileform">
					<div class="selectbutton document-ok">Проверен</div>
				</div>
				<p class="info">
					<label>Свидетельство о постановке на налоговый учет (ИНН)</label>
				</p>
			</li>		
		<?	}	?>
	</ul>
	
</div>


<div class="profile-requests-block">
	<p class="narrow-bold-23 mb-30">
		Перевозки
		<a href="#" class="pl-10 narrow-regular-18">Смотреть все</a>
	</p>
	<ul class="requests1-list-head clearfix p-20">
		<li class="col1 fLeft c_757575 font-12 text_c">№</li>
		<li class="col2 fLeft c_757575 font-12">Информация о грузе</li>
		<li class="col3 fLeft c_757575 font-12 text_c">Дата</li>
		<li class="col4 fLeft c_757575 font-12">Перевозчик</li>
		<li class="col5 fLeft c_757575 font-12 text_c"><span class="db review-perevoz-ttl">Отзыв перевозчика</span></li>
		<li class="col6 fLeft c_757575 font-12">Заказчик</li>
		<li class="col7 fLeft c_757575 font-12">Отзыв заказчика</li>
	</ul>

	<ul class="requests1-list-items">
		<li class="blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix">
			<div class="col1 fLeft font-12 text_c">9876544</div>
			<div class="col2 fLeft font-12"><a href="/">Личные вещи, Коробки, Холодильник</a></div>
			<div class="col3 fLeft font-13 text_c c_aab1ba">11.06.2015</div>
			<div class="col4 fLeft font-12"><a href="#" class="profile-link">Вася Man</a></div>
			<div class="col5 fLeft"> <div class="rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:78%;"></span></div> </div>
			<div class="col6 fLeft font-12"><a href="#" class="profile-link">Иван Игнатенко</a></div>
			<div class="col7 fLeft font-12 border-box requests1-list-item-review requests1-list-item-review-good"><span>Невероятные умницы и молодцы...</span></div>
		</li>
		<li class="blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix">
			<div class="col1 fLeft font-12 text_c">9876544</div>
			<div class="col2 fLeft font-12"><a href="/">Личные вещи, Коробки, Холодильник</a></div>
			<div class="col3 fLeft font-13 text_c c_aab1ba">11.06.2015</div>
			<div class="col4 fLeft font-12"><a href="#" class="profile-link">Вася Man</a></div>
			<div class="col5 fLeft"> <div class="rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:78%;"></span></div> </div>
			<div class="col6 fLeft font-12"><a href="#" class="profile-link">Иван Игнатенко</a></div>
			<div class="col7 fLeft font-12 border-box requests1-list-item-review requests1-list-item-review-bad"><span>Невероятные умницы и молодцы...</span></div>
		</li>
		<li class="blue-border-1 p-20 mb-10 bg_f4fbfe_h clearfix">
			<div class="col1 fLeft font-12 text_c">9876544</div>
			<div class="col2 fLeft font-12"><a href="/">Личные вещи, Коробки, Холодильник</a></div>
			<div class="col3 fLeft font-13 text_c c_aab1ba">11.06.2015</div>
			<div class="col4 fLeft font-12"><a href="#" class="profile-link">Вася Man</a></div>
			<div class="col5 fLeft"> <div class="rating-stars"><span class="stars-empty"></span><span class="stars-full" style="width:78%;"></span></div> </div>
			<div class="col6 fLeft font-12"><a href="#" class="profile-link">Иван Игнатенко</a></div>
			<div class="col7 fLeft font-12 border-box requests1-list-item-review requests1-list-item-review-good"><span>Невероятные умницы и молодцы...</span></div>
		</li>
	</ul>
	<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>
	
</div>
