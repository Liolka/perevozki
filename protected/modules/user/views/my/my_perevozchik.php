<?php 

$this->pageTitle = $this->app->user->username . ' - Личный кабинет перевозчика';

include (dirname(dirname(__FILE__))."/common/rating-init.php");
?>

<h1>Личный кабинет перевозчика <span class="db narrow-bold-24 c_2e3c54"><?php echo  $this->app->user->username; ?></span></h1>
<? /* <p class="my-username"><?php echo  $this->app->user->username; ?></p>*/ ?>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<?/*
<div class="bg_697f9a">
	<ul class="clearfix">
		<li class="fLeft for_sprite my-menu-item my-menu-item-zayavki">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/requests')?>">Заявки</a>
			<span class="db font-12 c_d0daea"><?=$totalBids.' '. Yii::t('app', 'штука|штуки|штук', $totalBids) ?></span>
		</li>
		<li class="fLeft for_sprite my-menu-item my-menu-item-transport">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/transport')?>">Транпорт</a>
			<span class="db font-12 c_d0daea"><?=$transport_count.' '. Yii::t('app', 'единица|единицы|единиц', $transport_count) ?></span>
		</li>
		<li class="fLeft for_sprite my-menu-item my-menu-item-documents">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/documents')?>">Мои документы</a>
			<span class="db font-12 c_d0daea"><?=$documents_count.' '. Yii::t('app', 'единица|единицы|единиц', $documents_count) ?></span>
		</li>
		<li class="fLeft for_sprite my-menu-item my-menu-item-info">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/info')?>">Основные данные</a>
		</li>
		<li class="fLeft for_sprite my-menu-item my-menu-item-profile my-menu-item-br-none">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/edit')?>">Регистрационные данные</a>
		</li>
	</ul>
</div>
*/?>

<div class="my-page clearfix">
	<div class="content column2r">
		<div class="profile-requests-block">
			<p class="my-last-requests-title">Заявки в которых вы отписывались <span>(5 последних)</span> <a href="/my-last/">Смотреть все</a> </p>
			
			<?php $this->renderPartial('_requests_list_perevozchik_my', array('dataProvider'=>$lastBidsUser)); ?>

			<a href="<?=$this->createUrl('/user/my/requests')?>" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Смотреть все</a>			
		
		</div>
	</div>
	
	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/perevozchik-rating-reviews.php")?>
	</div>
</div>