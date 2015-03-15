<?
	$this->app = Yii::app();

	$this->current_action = $this->app->getController()->getAction()->getId();
	$this->current_controller =  $this->app->getController()->getId();

	$cs = $this->app->clientScript;

	$this->theme_baseUrl = $this->app->theme->baseUrl;
	$this->request_baseUrl = $this->app->request->baseUrl;


?>