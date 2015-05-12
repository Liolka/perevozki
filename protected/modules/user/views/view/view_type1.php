<?php
$this->breadcrumbs=array(
	$model->username,
);

$this->layout='//layouts/column2';

include (dirname(dirname(__FILE__))."/common/rating-init.php");

//echo'last_activity<pre>';print_r($model,0);echo'</pre>';//die;
?>

<h1><?php echo $model->username ?></h1>
<p class="bid-detail-number narrow-bold-23 pos-rel">Профиль грузодателя<? include "_user_status.php"; ?></p>

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
		<? if(count($lastBidsUser->data))	{	?>
			<a href="<?=$this->createUrl('/user/requests', array('id'=>$model->id))?>" class="pl-10 narrow-regular-18">Смотреть все</a>
		<?	}	?>
	</p>
	
	<?php $this->renderPartial('_reviews_list_type_1', array('dataProvider'=>$lastBidsUser, 'model'=>$model)); ?>
</div>

