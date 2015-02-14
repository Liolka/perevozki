<?php 

$this->pageTitle = $app->user->username . ' - Личный кабинет грузодателя';

$this->breadcrumbs=array(
	UserModule::t("Profile"),
);
$this->menu=array(
	((UserModule::isAdmin())
		?array('label'=>UserModule::t('Manage Users'), 'url'=>array('/user/admin'))
		:array()),
    array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
    array('label'=>UserModule::t('Edit'), 'url'=>array('edit')),
    array('label'=>UserModule::t('Change password'), 'url'=>array('changepassword')),
    array('label'=>UserModule::t('Logout'), 'url'=>array('/user/logout')),
);

//echo $app->user->user_type;
?>

<h1><?php echo UserModule::t('Your profile'); ?></h1>
<p>Личный кабинет грузодателя</p>

<?php if($app->user->hasFlash('profileMessage')): ?>
	<div class="success flash-message flash-success">
		<?php echo $app->user->getFlash('profileMessage'); ?>
	</div>
<?php endif; ?>
