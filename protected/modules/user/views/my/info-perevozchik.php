<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Информация о компании, контакты',
);

$this->pageTitle = "Информация о компании, контакты";

?>
 

<h1>Информация о компании, контакты</h1>

<? include (dirname(dirname(__FILE__))."/common/perevozchik-contact-info-container.php"); ?>