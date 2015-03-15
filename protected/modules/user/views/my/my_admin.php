<?php 

$this->pageTitle = $app->user->username . ' - Личный кабинет администратора';

/*
$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
*/

$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
    array('label'=>'Категории', 'url'=>array('/categories/admin')),
);


//echo $app->user->user_type;
?>

<h1>Личный кабинет администратора</h1>
