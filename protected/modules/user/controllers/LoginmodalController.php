<?php

class LoginmodalController extends Controller
{
	public $defaultAction = 'login';
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (Yii::app()->user->isGuest) {
			$model=new UserLogin;
			// collect user input data
			if(isset($_POST['UserLogin']))
			{
				$model->attributes=$_POST['UserLogin'];
				// validate user input and redirect to previous page if valid
				if($model->validate()) {
					$this->lastViset();
                    echo 'ok';
                    die;
				}
			}
			// display the login form
			$this->renderPartial('/user/login-modal',array('model'=>$model));
		} else {
			Yii::app()->user->setFlash('registration', 'Вы уже вошли в систему');
			$this->renderPartial('/user/already-logged-modal');
			//$this->redirect(Yii::app()->controller->module->returnUrl);
		}
	}
	
	private function lastViset() {
		$lastVisit = User::model()->notsafe()->findByPk(Yii::app()->user->id);
		$lastVisit->lastvisit = time();
		$lastVisit->save();
	}

}