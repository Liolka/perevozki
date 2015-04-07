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

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

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
		<? if($user_company->file1 != '' && $user_company->file1_checked == 1)	{	?>
			<li class="doc-files-item fLeft pos-rel doc-files-item-ok">
				<div class="fileform">
					<div class="selectbutton document-ok">Проверен</div>
				</div>
				<p class="info pos-rel text_c pb-10">
					<label>Пример договора</label>
				</p>
				<p class="info pos-rel text_c">
					<a class="" href="<?=$this->app->homeUrl?>files/users/<?=$model->id?>/docs/<?=$user_company->file1?>">Скачать</a>
				</p>
			</li>		
		<?	}	?>
		
		<? if($user_company->file2 != '' && $user_company->file2_checked == 1)	{	?>
			<li class="doc-files-item fLeft pos-rel doc-files-item-ok">
				<div class="fileform">
					<div class="selectbutton document-ok">Проверен</div>
				</div>
				<p class="info pos-rel text_c">
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
		<li class="col5 fLeft c_757575 font-12 text_c"><p class="review-perevoz-ttl pos-rel"><span class="bold c_2e3c54 otziv-lbl">Отзыв перевозчика<span class="notice bold c_fcb60e font-20 pos-abs db">*</span></span></p></li>
		<li class="col6 fLeft c_757575 font-12">Заказчик</li>
		<li class="col7 fLeft c_757575 font-12">Отзыв заказчика</li>
	</ul>
	
	<?php $this->renderPartial('_reviews_list_type_2', array('dataProvider'=>$lastBidsUser)); ?>
	
	<p class="blue-border-1 mt-20 p-20"><span class="notice bold c_fcb60e font-20">*</span> <span class="italic otziv-lbl">Отзыв перевозчика</span> - это оценка удовлетворенности от сотрудничества, выставленная перевозчиком грузовладельцу.</p>
	
</div>
