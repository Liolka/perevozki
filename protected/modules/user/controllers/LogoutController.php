<?php

class LogoutController extends Controller
{
	public $defaultAction = 'logout';
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	
	
	/**
	 * Logout the current user and redirect to returnLogoutUrl.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		//$this->redirect(Yii::app()->controller->module->returnLogoutUrl);
		$this->redirect(Yii::app()->homeUrl);
	}

}