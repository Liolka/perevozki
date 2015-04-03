<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Информация, контакты',
);

$this->pageTitle = "Информация, контакты";

?>
 

<h1>Информация, контакты</h1>

<? include (dirname(dirname(__FILE__))."/common/gruzodatel-contact-info-container.php")?>