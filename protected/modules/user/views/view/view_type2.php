<?php
$this->breadcrumbs=array(
	$model->username,
);

$this->layout='//layouts/column2';

//echo'<pre>';print_r(dirname(dirname(__FILE__)));echo'</pre>';

$transport_imageLive = $this->app->homeUrl.'files/users/'.$model->id.'/transport/';

$this->app->getClientScript()->registerCoreScript('flexcroll');

$cs = $this->app->clientScript;
$cs->coreScriptPosition = CClientScript::POS_END;
$cs->registerCoreScript('fancybox');

$cs->registerScript('transport_list', "

	var max_height = 0,
		enable_sroll = true;
	
	
	
	$('#flexcroll_transport_list').hover(
		function(){ enable_sroll = false; },
		function(){ enable_sroll = true; }
	);
	
	
	$('#flexcroll_transport_list li').each(function(){
		if($(this).height() > max_height) { 
			max_height = $(this).height();
		}
	});
	
	$('#flexcroll_transport_list li').css('height', (max_height+'px'));
	max_height = max_height + 50;
	
	$('#flexcroll_transport_list').css('height', (max_height+'px'));
	
	//fleXenv.fleXcrollMain('flexcroll_transport_list');
	//flexcroll_transport_list.fleXcroll.setScrollPos(0, 0, false, true);
	//flexcroll_transport_list.fleXcroll.scrollContent(0, 0);
	
	//window.onfleXcrollRun=function(){}
	
");

include (dirname(dirname(__FILE__))."/common/rating-init.php");

?>
<script>
</script>

<h1><?php echo $model->username ?></h1>
<p class="bid-detail-number narrow-bold-23">Профиль перевозчика<? include "_user_status.php"; ?></p>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<div class="clearfix">
	<div class="content column2r">
		<? include (dirname(dirname(__FILE__))."/common/perevozchik-contact-info-container.php")?>


	</div>

	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/perevozchik-rating-reviews.php")?>

	</div>
</div>

<div class="blue-border-1 mt-40 mb-40 bg_f4fbfe p-20 ov-hidden pos-rel">
	<p class="narrow-bold-23 mb-30">
		Транспорт перевозчика
		<span class="narrow-regular-18 c_71a72c pl-10">(<? echo count($dataProvider->data).' '.Yii::t('app', 'единица|единицы|единиц', count($dataProvider->data))?>)</span>
	</p>
	
	<ul class="toggle-view-transport pos-abs">
		<li class="toggle-view-transport-item<? if($show_transport == 'scroll') echo '-active';?> fLeft">
			<a href="<?=$this->createUrl('/user/view/', array('id'=>$model->id))?>?show=scroll" class="underline_n_n bb-dotted-4-h">С прокруткой</a>
		</li>
		<li class="toggle-view-transport-item<? if($show_transport == 'all') echo '-active';?> fLeft">
			<a href="<?=$this->createUrl('/user/view/', array('id'=>$model->id))?>?show=all" class="underline_n_n bb-dotted-4-h">Показать всё</a>
		</li>
	</ul>
	
<?
switch($show_transport)	{
	case 'all':
		$transport_tmpl = '_transport_list_all';
	break;
	case 'scroll':
	default:
		$transport_tmpl = '_transport_list_scroll';
}

$this->renderPartial($transport_tmpl, array(
	'dataProvider' => $dataProvider,
	'transport_imageLive' => $transport_imageLive,
));
?>


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
		<a href="<?=$this->createUrl('/user/requests', array('id'=>$model->id))?>" class="pl-10 narrow-regular-18">Смотреть все</a>
	</p>
	
	<?php $this->renderPartial('_reviews_list_type_2', array('dataProvider'=>$lastBidsUser, 'model'=>$model)); ?>
</div>
