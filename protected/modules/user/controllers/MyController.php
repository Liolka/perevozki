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

	/*
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
	*/

	public function actionTransport()
	{
		$this->app = Yii::app();
		
		$model = new Transport;
		
		$criteria = new CDbCriteria;
		
		$criteria->select = "transport_id, name, foto, carrying, length, width, height, volume, body_type, loading_type, comment";
		
		$criteria->order = 'transport_id DESC';		
		
        $dataProvider = new CActiveDataProvider('Transport', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>50,
				'pageVar' =>'page',
            ),
        ));
		
				
	    $this->render('transport', array(
	    	'model'=>$model,
			'dataProvider'=>$dataProvider,
	    ));
	}

	public function actionTransportcreate()
	{
		$model = new Transport();
		
		$this->app = Yii::app();
		
		if(isset($_POST['Transport'])) {
			
			$model->attributes = $_POST['Transport'];
			$model->user_id = $this->app->user->id;
			
			if($model->validate()) {
				$model->save(false);
				unset($this->app->session['transport_tmp_foto']);
				
				$this->app->user->setFlash('success', "Добавлено");
				
				echo 'ok';
				$this->app->end();
			}
		}
		
	    $this->renderPartial('transport_create', array(
	    	'model'=>$model,
	    ));
	}
	
	public function actionTransportdelete($id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = Transport::model()->findByPk($id);
		
		if($model === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}	else	{
			//$check = ;
			if(Deals::model()->checkTransportInDeals($connection, $id))	{
				//$upload_path = Yii::getPathOfAlias($this->app->params->transport_imagePath) . DIRECTORY_SEPARATOR;
				$upload_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id.'/transport/';

				if (file_exists($upload_path . 'full_'.$model->foto)) {
					unlink($upload_path . 'full_'.$model->foto);
				}

				if (file_exists($upload_path . 'thumb_'.$model->foto)) {
					unlink($upload_path . 'thumb_'.$model->foto);
				}

				$model->delete();
				$this->app->user->setFlash('success', "Удалено");
				
			}	else	{
				$this->app->user->setFlash('error', "Данная единица транспорта присутствует в предложениях. В удалении отказано.");
			}
		}

		$this->redirect(array('/user/my/transport'));
	}
	
	public function actionTransportupdate($id)
	{
		$model = Transport::model()->findByPk($id);
		if($model !== null) {
			$this->app->session['transport_tmp_foto'] = $model->foto;
		}
		
		$this->app = Yii::app();
		
		if(isset($_POST['Transport'])) {
			
			$model->attributes = $_POST['Transport'];
			
			if($model->validate()) {
				$model->save(false);
				unset($this->app->session['transport_tmp_foto']);
				$this->app->user->setFlash('success', "Сохранено");
				
				echo 'ok';
				$this->app->end();
			}
		}
		
	    $this->renderPartial('transport_update', array(
	    	'model'=>$model,
	    ));
	}
	

	public function actionUploadfoto()
	{
		$this->app = Yii::app();
		
		$model = new UploadTransportFoto();
		
		$allOk = true;
		
		$max_filesize = (2 * 1024 * 1024); // Maximum filesize in BYTES.
		$allowed_filetypes = array('.jpg','.jpeg','.gif','.png'); // These will be the types of file that will pass the validation.
		$filename = $_FILES['userfile']['name']; // Get the name of the file (including file extension).
		$ext = substr($filename, strpos($filename,'.'), strlen($filename)-1); // Get the extension from the filename.
		$file_strip = str_replace(" ","_",$filename); //Strip out spaces in filename
		//$upload_path = '/path/to/uploads/'; //Set upload path
		//$upload_path = '/home/gfclubne/public_html/perevozki/images/transport/'; //Set upload path
		//$upload_path = Yii::getPathOfAlias($this->app->params->transport_imagePath) . DIRECTORY_SEPARATOR;
		
		$upload_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id;
		if(!file_exists($upload_path)) mkdir($upload_path, 0777, true);
		$upload_path .= '/transport';
		if(!file_exists($upload_path)) mkdir($upload_path, 0777, true);
		$upload_path .= '/';
		
		
		$json_arr = array();

		// Check if the filetype is allowed, if not DIE and inform the user.
		if(!in_array($ext,$allowed_filetypes)) {
			$allOk = false;
			$json_arr['res'] = 'err';
			$json_arr['msg'] = 'Неверный тип файла.';
		}
		
		// Now check the filesize, if it is too large then DIE and inform the user.
		if(filesize($_FILES['userfile']['tmp_name']) > $max_filesize) {
			$allOk = false;
			$json_arr['res'] = 'err';
			$json_arr['msg'] = 'Загружаемый файл слишком велик.';
		}
		
		// Check if we can upload to the specified path, if not DIE and inform the user.
		if(!is_writable($upload_path)) {
			$allOk = false;
			$json_arr['res'] = 'err';
			$json_arr['msg'] = 'Ошибка прав доступа к каталогу.';
			
		}
		
		if($allOk)	{
			$filename_ = md5(strtotime('now'));
			$new_filename = 'full_'.$filename_.$ext;
			// Move the file if eveything checks out.
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path . $new_filename)) {

				if(isset($this->app->session['transport_tmp_foto']))	{
					$tmp_name = $this->app->session['transport_tmp_foto'];
					if (file_exists($upload_path . 'full_'.$tmp_name)) {
						unlink($upload_path . 'full_'.$tmp_name);
					}
					if (file_exists($upload_path . 'thumb_'.$tmp_name)) {
						unlink($upload_path . 'thumb_'.$tmp_name);
					}
				}

				$file_path = $upload_path . DIRECTORY_SEPARATOR . $new_filename;

				$Image = $this->app->image->load($file_path);

				$img_width_config = $this->app->params->transport_tmb_params['width'];
				$img_height_config = $this->app->params->transport_tmb_params['height'];


				if(($Image->width/$Image->height) >= ($img_width_config/$img_height_config)){
					$Image -> resize($img_width_config, $img_height_config, Image::HEIGHT);
				}	else	{
					$Image -> resize($img_width_config, $img_height_config, Image::WIDTH);
				}
				//$Image->crop($img_width_config, $img_height_config, 'top', 'center')->quality(75);
				//$Image->resize($img_width_config, $img_height_config)->quality(75);
				//echo'<pre>';print_r($app->params->product_tmb_params,0);echo'</pre>';die;
				$Image->save($upload_path . DIRECTORY_SEPARATOR . 'thumb_'.$filename_.$ext);

				$this->app->session['transport_tmp_foto'] = $filename_.$ext;
				
				$transport_imageLive = $this->app->homeUrl.'files/users/'.$this->app->user->id.'/transport/';

				$json_arr['res'] = 'ok';
				//$json_arr['msg'] = $this->app->params->transport_imageLive.'thumb_'.$filename_.$ext;
				$json_arr['msg'] = $transport_imageLive.'thumb_'.$filename_.$ext;
				$json_arr['foto'] = $filename_.$ext;
				//echo '<div class="success">'. $file_strip .' uploaded successfully</div>'; // It worked.
			} else {
				$json_arr['res'] = 'err';
				$json_arr['msg'] = 'Ошибка загрузки. Попробуйте еще раз.';
			}
			
		}
		
		echo json_encode($json_arr);
		
		
		$this->app->end();
		
	}

	// метод удаляет загружееное фото транспорта если нажали
	// закрыть в модальном окне
	public function actionCleartransportfoto()
	{
		$this->app = Yii::app();
		
		if(isset($this->app->session['transport_tmp_foto']))	{
			$upload_path = Yii::getPathOfAlias($this->app->params->transport_imagePath) . DIRECTORY_SEPARATOR;
			$tmp_name = $this->app->session['transport_tmp_foto'];
			
			if(isset($this->app->session['transport_tmp_foto']))	{
				$tmp_name = $this->app->session['transport_tmp_foto'];
				if (file_exists($upload_path . 'full_'.$tmp_name)) {
					unlink($upload_path . 'full_'.$tmp_name);
				}
				if (file_exists($upload_path . 'thumb_'.$tmp_name)) {
					unlink($upload_path . 'thumb_'.$tmp_name);
				}
			}
			
			unset($this->app->session['transport_tmp_foto']);
		}
	}

	public function actionDocuments()
	{
		$this->app = Yii::app();
		
		$model = new MyDocuments;
		
		$user = $this->loadUser();
		
		
		//$user = User::model()->findByPk(Yii::app()->user->id);
//		echo'<pre>';print_r($_POST,0);echo'</pre>';
//		echo'<pre>';print_r($_FILES,0);echo'</pre>';
//		die;
		if(isset($_FILES['MyDocuments']))	{
			foreach($_FILES['MyDocuments']['name'] as $attr=>$name)	{
//				echo'<pre>';print_r($name,0);echo'</pre>';
				if($name != '')	{
					$model->file = CUploadedFile::getInstance($model, $attr);
					if($model->validate())	{
						$filename = md5(strtotime('now')).$this->getExtentionFromFileName($model->file->getName());
						
						//подготавливаем путь для сохранения файла
						$file_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id;
						if(!file_exists($file_path)) mkdir($file_path, 0777, true);
						$file_path .= '/docs';
						if(!file_exists($file_path)) mkdir($file_path, 0777, true);
						$file_path .= '/';
						
						$path = $file_path.$filename;
						$model->file->saveAs($path);
						$user->$attr = $filename;
						$user->save(false);
						
						$this->app->user->setFlash('success', "Файл успешно загружен");
						$this->redirect(array("documents"));
					}
				}
			}
			
		}	else	{
			if($user->file1)
				$model->file1 = $user->file1;

			if($user->file2)
				$model->file2 = $user->file2;
			
		}
		
		
				
	    $this->render('documents', array(
	    	'user'=>$user,
	    	'model'=>$model,
	    ));
	}
	
	//удаление документа
	//в id передается имя атрибута, в котором франится файл.
	public function actionDocumentdelete($id)
	{
		$this->app = Yii::app();
		//echo'<pre>';print_r($id,0);echo'</pre>';
		$user = $this->loadUser();
		if($id)	{
			$checked_attr = $id.'_checked';
			$file_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id.'/docs/'.$user->$id;
			if(file_exists($file_path)) unlink($file_path);
			$user->$id = '';
			$user->$checked_attr = 0;
			$user->save(false);
			$this->app->user->setFlash('success', "Файл успешно удален");
		}
		$this->redirect(array("documents"));
	}
	
	/*
	public function actionDownload($id)
	{
		$user = User::model()->findByPk($id);
		$attr = $_GET['attr'];
		//echo'<pre>';print_r($user,0);echo'</pre>';
		if($user->$attr != '')	{
			$file_path = Yii::getPathOfAlias('webroot').'/files/users/'.$id.'/docs/'.$user->$attr;
			echo'<pre>';print_r($file_path,0);echo'</pre>';
			
//			header("Content-Type: application/force-download");
//			header("Content-Type: application/octet-stream");
//			header("Content-Type: application/download");
//			header("Content-Disposition: attachment; filename=" . $user->$attr);
//			header("Content-Transfer-Encoding: binary ");  
//
//			readfile($file_path);			
		}
	}
	*/

	public function actionInfo()
	{
		$this->app = Yii::app();
		
		$user = $this->loadUser();
		$user_company = $user->company;
		if($user_company === null) {
			$user_company = new UsersCompanies();
		}
		
	    $this->render('info', array(
	    	'user'=>$user,
	    	'user_company'=>$user_company,
	    	'show_edit_btn'=>true,
		
	    ));
	}

	public function actionInfoedit()
	{
		$this->app = Yii::app();
		
		$user = $this->loadUser();
		
		$user_company = $user->company;
		if($user_company === null) {
			$user_company = new UsersCompanies();
		}
		
		
		if(isset($_POST['UsersCompanies']))	{
			foreach($_POST['UsersCompanies'] as &$attr)	{
				$attr = strip_tags($attr);
			}
			
			//$user_company = new UsersCompanies();
			$user_company->attributes = $_POST['UsersCompanies'];
			if(!$user_company->user_id)	{
				$user_company->user_id = $this->app->user->id;
			}
			if($user_company->save()) {
				$this->redirect(array("info"));
			}
			
		}	else	{
			//echo'<pre>';var_dump($model->company);echo'</pre>';die;
			
		}
		
		
		
				
	    $this->render('info_edit', array(
	    	//'app'=>$app,
	    	'user'=>$user,
	    	'user_company'=>$user_company,
			//'profile'=>$model->profile,
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
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
}