<?php
$this->breadcrumbs=array(
	$model->username,
);

$this->layout='//layouts/column2';


?>
<h1><?php echo $model->username ?></h1>
<p class="bid-detail-number narrow-bold-23">Профиль грузодателя</p>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<div class="clearfix">
	<div class="content column2r pos-rel contact-info-g">
		<? include (dirname(dirname(__FILE__))."/common/gruzodatel-contact-info-container.php")?>
		
		<? if($user_company->file1 != '' && $user_company->file1_checked == 1)	{	?>
			<div class="doc-files-item fLeft doc-files-g-item doc-files-item-ok pos-abs">
				<div class="fileform">
					<div class="selectbutton document-ok">Проверен</div>
				</div>
				<p class="info pos-rel text_c pb-10">
					<label>Пример договора</label>
				</p>
				<p class="info pos-rel text_c">
					<a class="" href="<?=$this->app->homeUrl?>files/users/<?=$model->id?>/docs/<?=$user_company->file1?>">Скачать</a>
				</p>
			</div>		
		<?	}	?>


	</div>

	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/gruzodatel-rating-reviews.php")?>

	</div>
</div>

<div class="profile-requests-block mt-30">
	<p class="narrow-bold-23 mb-30">
		Заказы
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
	
	<?php $this->renderPartial('_reviews_list_type_1', array('dataProvider'=>$lastBidsUser)); ?>
	
	<p class="blue-border-1 mt-20 p-20"><span class="notice bold c_fcb60e font-20">*</span> <span class="italic otziv-lbl">Отзыв перевозчика</span> - это оценка удовлетворенности от сотрудничества, выставленная перевозчиком грузовладельцу.</p>
	
</div>

