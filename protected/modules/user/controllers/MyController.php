<?php

class MyController extends Controller
{
	public $defaultAction = 'my';
	public $layout='//layouts/column1';
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	public function actionMy()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
		
		
		switch($app->user->user_type) {
			case 1:
				$template = 'my_grizodatel';
				break;
			case 2:
				$template = 'my_perevozchik';
				break;
			default:
				$template = 'my_grizodatel';
				break;
		}
	    $this->render($template, array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionRequests()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
				
	    $this->render('requests', array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionTransport()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
				
	    $this->render('transport', array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionDocuments()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
				
	    $this->render('documents', array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionInfo()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
				
	    $this->render('info', array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}

	public function actionInfoedit()
	{
		$model = $this->loadUser();
		
		$app = Yii::app();
				
	    $this->render('info_edit', array(
	    	'app'=>$app,
	    	'model'=>$model,
			'profile'=>$model->profile,
	    ));
	}


	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionEdit()
	{
		$model = $this->loadUser();
		$profile=$model->profile;
		$app = Yii::app();
		
		// ajax validator
		if(isset($_POST['ajax']) && $_POST['ajax']==='profile-form')
		{
			echo UActiveForm::validate(array($model,$profile));
			Yii::app()->end();
		}
		
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$profile->attributes=$_POST['Profile'];
			
			if($model->validate()&&$profile->validate()) {
				$model->save();
				$profile->save();
                Yii::app()->user->updateSession();
				Yii::app()->user->setFlash('profileMessage',UserModule::t("Changes is saved."));
				$this->redirect(array('/user/profile'));
			} else $profile->validate();
		}

		$this->render('edit',array(
			'app'=>$app,
			'model'=>$model,
			'profile'=>$profile,
		));
	}
	
	/**
	 * Change password
	 */
	public function actionChangepassword() {
		$model = new UserChangePassword;
		if (Yii::app()->user->id) {
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model->attributes=$_POST['UserChangePassword'];
					if($model->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model->password);
						$new_password->save();
						Yii::app()->user->setFlash('profileMessage',UserModule::t("New password is saved."));
						$this->redirect(array("profile"));
					}
			}
			$this->render('changepassword',array('model'=>$model));
	    }
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser()
	{
		if($this->_model===null)
		{
			if(Yii::app()->user->id)
				$this->_model=Yii::app()->controller->module->user();
			if($this->_model===null)
				$this->redirect(Yii::app()->controller->module->loginUrl);
		}
		return $this->_model;
	}
}