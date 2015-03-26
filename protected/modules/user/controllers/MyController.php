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
		
		if($app->user->id == 1) {
			$this->layout='//layouts/column2r';
			$template = 'my_admin';
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

	public function actionTransportcreate()
	{
		$model = new Transport();
		
		$this->app = Yii::app();
		
		/*
		if(isset($_POST['ajax']) && $_POST['ajax']==='transport-form')
		{
			echo CActiveForm::validate($model);
			$app->end();
		}
		*/
		
	    $this->renderPartial('transport_create', array(
	    	'model'=>$model,
	    ));
	}

	public function actionUploadfoto()
	{
		$this->app = Yii::app();
		$max_filesize = 2097152; // Maximum filesize in BYTES.
		$allowed_filetypes = array('.jpg','.jpeg','.gif','.png'); // These will be the types of file that will pass the validation.
		$filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
		$file_strip = str_replace(" ","_",$filename); //Strip out spaces in filename
		//$upload_path = '/path/to/uploads/'; //Set upload path
		$upload_path = '/home/gfclubne/public_html/perevozki/images/transport/'; //Set upload path

		// Check if the filetype is allowed, if not DIE and inform the user.
		if(!in_array($ext,$allowed_filetypes)) {
			die('<div class="error">The file you attempted to upload is not allowed.</div>');
		}
		
		// Now check the filesize, if it is too large then DIE and inform the user.
		if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) {
			die('<div class="error">The file you attempted to upload is too large.</div>');
		}
		
		// Check if we can upload to the specified path, if not DIE and inform the user.
		if(!is_writable($upload_path)) {
			die('<div class="error">You cannot upload to the '.$upload_path.' folder. The permissions must be changed.</div>');
		}
		
		$new_filename = md5(time()).$ext;
		// Move the file if eveything checks out.
		if(move_uploaded_file($_FILES['userfile']['tmp_name'],$upload_path . $new_filename)) {
			echo '<div class="success">'. $file_strip .' uploaded successfully</div>'; // It worked.
		} else {
			echo '<div class="error">'. $file_strip .' was not uploaded.  Please try again.</div>'; // It failed :(.
		}
		
		$this->app->end();
		
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
		$app = Yii::app();
		if ($app->user->id) {
			$model_ChangePassword = new UserChangePassword;
			$model_ChangeEmail = new UserChangeEmail;
			
			//если нажали "Отмена"  - возврат
			if(isset($_POST['cancel']))	{
				$this->redirect(array('my'));
			}
			
		
			
			// ajax validator
			if(isset($_POST['ajax']) && $_POST['ajax']==='changepassword-form')
			{
				echo UActiveForm::validate($model_ChangePassword);
				Yii::app()->end();
			}
			
			if(isset($_POST['ajax']) && $_POST['ajax']==='changeemail-form')
			{
				echo UActiveForm::validate($model_ChangeEmail);
				Yii::app()->end();
			}
			
			if(isset($_POST['UserChangePassword'])) {
					$model_ChangePassword->attributes=$_POST['UserChangePassword'];
					if($model_ChangePassword->validate()) {
						$new_password = User::model()->notsafe()->findbyPk(Yii::app()->user->id);
						$new_password->password = UserModule::encrypting($model_ChangePassword->password);
						$new_password->activkey=UserModule::encrypting(microtime().$model_ChangePassword->password);
						$new_password->save();
						Yii::app()->user->setFlash('success',UserModule::t("New password is saved."));
						$this->redirect(array("edit"));
					}
			}
			
			$this->render('changeemailpassword',array(
				'model_ChangePassword'=>$model_ChangePassword,
				'model_ChangeEmail'=>$model_ChangeEmail,
				'app'=>$app,
			));
	    }
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