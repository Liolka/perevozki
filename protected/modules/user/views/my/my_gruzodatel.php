<?php 

$this->pageTitle = $this->app->user->username . ' - Личный кабинет грузодателя';

include (dirname(dirname(__FILE__))."/common/rating-init.php");
?>

<h1>Личный кабинет грузодателя</h1>
<p class="my-username"><?php echo  $this->app->user->username; ?></p>

<? include(Yii::getPathOfAlias('application')."/views/common/_flash-messages.php"); ?>

<div class="my-menu">
	<ul class="my-menu-list clearfix">
		
		<li class="my-menu-item my-menu-item-zayavki">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/requests')?>">Заявки</a>
			<span class="my-menu-descr"><?=$totalBids.' '. Yii::t('app', 'штука|штуки|штук', $totalBids) ?></span>
		</li>
		<?/*
		<li class="my-menu-item my-menu-item-transport">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/transport')?>">Транпорт</a>
			<span class="my-menu-descr">54 единиц</span>
		</li>
		
		<li class="my-menu-item my-menu-item-documents">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/documents')?>">Мои документы</a>
			<span class="my-menu-descr"><?=$documents_count.' '. Yii::t('app', 'единица|единицы|единиц', $documents_count) ?></span>
		</li>
		*/?>
		<li class="my-menu-item my-menu-item-info">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/info')?>">Информация, контакты</a>
			<? /*<span class="my-menu-descr my-menu-descr-small">Тип компании, количество сотрудников, год основания и т.д.</span> */ ?>
		</li>
		<li class="my-menu-item my-menu-item-profile">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/edit')?>">Регистрационные данные</a>
			<span class="my-menu-descr my-menu-descr-small">Регистрационный email, пароль, регистрационный телефон.</span>
		</li>
	</ul>
</div>

<div class="my-page clearfix">
	<div class="content column2r">
		<div class="profile-requests-block">
			<p class="my-last-requests-title">Мои заявки <span>(5 последних)</span> <a href="<?=$this->createUrl('/user/my/requests')?>">Смотреть все</a></p>

			<?php $this->renderPartial('_requests_list_gruzodatel_my', array('dataProvider'=>$lastBidsUser)); ?>
			
			<a href="<?=$this->createUrl('/user/my/requests')?>" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Смотреть все</a>			
		</div>
	</div>
	
	<div class="sidebar sideRight">
		<? include (dirname(dirname(__FILE__))."/common/gruzodatel-rating-reviews.php")?>
	</div>
</div>