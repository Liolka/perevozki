<?php 

$this->pageTitle = $app->user->username . ' - Личный кабинет перевозчика';

/*
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
*/
/*
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);
*/

//echo $app->user->user_type;
?>

<h1><?php echo  $app->user->username; ?></h1>
<p>Личный кабинет перевозчика</p>

<?php if($app->user->hasFlash('profileMessage')): ?>
	<div class="success flash-message flash-success">
		<?php echo $app->user->getFlash('profileMessage'); ?>
	</div>
<?php endif; ?>


<div class="my-menu">
	<ul class="my-menu-list">
		<li class="my-menu-item">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/requests')?>">Заявки</a>
			<span class="my-menu-descr">54 единиц</span>
		</li>
		<li class="my-menu-item">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/transport')?>">Транпорт</a>
			<span class="my-menu-descr">54 единиц</span>
		</li>
		<li class="my-menu-item">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/documents')?>">Мои документы</a>
			<span class="my-menu-descr">6 штук</span>
		</li>
		<li class="my-menu-item">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/documents')?>">Информация о компании, контакты</a>
			<span class="my-menu-descr my-menu-descr-small">Тип компании, количество сотрудников, год основания и т.д.</span>
		</li>
		<li class="my-menu-item">
			<a class="my-menu-url" href="<?=$this->createUrl('/user/my/edit')?>">Регистрационные данные</a>
			<span class="my-menu-descr my-menu-descr-small">Регистрационный email, пароль, регистрационный телефон.</span>
		</li>
	</ul>
</div>


<div class="my-page clearfix">
	<div class="content column2r">
		<img src="/images/my_1.jpg" alt="">
	</div>
	
	<div class="sidebar sideRight">
		<img src="/images/my_2.jpg" alt="">
	</div>
</div>