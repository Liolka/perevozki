<?php

class AdminController extends Controller
{
	public $defaultAction = 'admin';
	public $layout='//layouts/column2';
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	
	
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return CMap::mergeArray(parent::filters(),array(
			'accessControl', // perform access control for CRUD operations
		));
	}
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','view'),
				'users'=>UserModule::getAdmins(),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('index',array(
            'model'=>$model,
        ));
		/*$dataProvider=new CActiveDataProvider('User', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->controller->module->user_page_size,
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));//*/
	}


	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$model = $this->loadModel();
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		//если нажали "Отмена" возврат на список компаний
		if(isset($_POST['cancel']))	
			$this->redirect(array('admin'));
				
		$model=new User;
		$profile=new Profile;
		$this->performAjaxValidation(array($model,$profile));
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
			$profile->attributes=$_POST['Profile'];
			$profile->user_id=0;
			if($model->validate()&&$profile->validate()) {
				$model->password=Yii::app()->controller->module->encrypting($model->password);
				if($model->save()) {
					$profile->user_id=$model->id;
					$profile->save();
				}
				if(isset($_POST['save']))	{
					$this->redirect(array('admin'));
				}	else	{
					$this->redirect(array('update','id'=>$model->id));
				}
			} else $profile->validate();
		}

		$this->render('create',array(
			'model'=>$model,
			'profile'=>$profile,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		//если нажали "Отмена" возврат на список компаний
		if(isset($_POST['cancel']))	
			$this->redirect(array('admin'));
		
		$model=$this->loadModel();
		$profile=$model->profile;
		$allOk = true;
		$this->performAjaxValidation(array($model,$profile));
		//echo'1212<pre>';print_r($_POST,0);echo'</pre>';die;
		if(isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if(isset($_POST['Profile']))	{
				$profile->attributes = $_POST['Profile'];
			}	else	{
				$profile->attributes = array();
			}
			
			
			if($model->validate()&&$profile->validate()) {
				$old_password = User::model()->notsafe()->findByPk($model->id);
				if ($old_password->password!=$model->password) {
					$model->password=Yii::app()->controller->module->encrypting($model->password);
					$model->activkey=Yii::app()->controller->module->encrypting(microtime().$model->password);
				}
				$model->save();
				$profile->save();
				
				if(isset($_POST['UsersPerevozchik'])) {
					$user_info = $model->perevozchik;
					
					$user_info_prev = $user_info->attributes;
					
					$checked_files_arr = array(
						1 => $user_info->file1_checked,
						2 => $user_info->file2_checked,
						3 => $user_info->file3_checked,
						4 => $user_info->file4_checked,
						5 => $user_info->file5_checked,
						6 => $user_info->file6_checked,
						7 => $user_info->file7_checked,
						8 => $user_info->file8_checked,
						9 => $user_info->file9_checked,
						10 => $user_info->file10_checked,
						11 => $user_info->file11_checked,
						12 => $user_info->file12_checked,
						13 => $user_info->file13_checked,
						14 => $user_info->file14_checked,
					);
					
					$user_info->attributes = $_POST['UsersPerevozchik'];
					
					if($user_info->validate())	{
						$checked_documents = array();
						foreach($checked_files_arr as $key=>$file)	{
							$fld = 'file'.$key.'_checked';
							if($file == 0 && $user_info->$fld == 1)	{
								$checked_documents[] = $key;
							}
						}
						
						
						//Для ИП и юр. лиц
						if($user_info_prev->file2_checked == 0 && $user_info->file2_checked == 1)	{
							$model->reliability = $model->reliability + 17;
						}	elseif($user_info_prev->file2_checked == 1 && $user_info->file2_checked == 0)	{
							$model->reliability = $model->reliability - 17;
						}
						
						if($user_info_prev->file3_checked == 0 && $user_info->file3_checked == 1)	{
							$model->reliability = $model->reliability + 18;
						}	elseif($user_info_prev->file3_checked == 1 && $user_info->file3_checked == 0)	{
							$model->reliability = $model->reliability - 18;
						}
						
						//Для физических лиц
						if($user_info_prev->file6_checked == 0 && $user_info->file6_checked == 1)	{
							$model->reliability = $model->reliability + 6;
						}	elseif($user_info_prev->file6_checked == 1 && $user_info->file6_checked == 0)	{
							$model->reliability = $model->reliability - 6;
						}
						
						if($user_info_prev->file8_checked == 0 && $user_info->file8_checked == 1)	{
							$model->reliability = $model->reliability + 6;
						}	elseif($user_info_prev->file8_checked == 1 && $user_info->file8_checked == 0)	{
							$model->reliability = $model->reliability - 6;
						}
						
						if($user_info_prev->file9_checked == 0 && $user_info->file9_checked == 1)	{
							$model->reliability = $model->reliability + 6;
						}	elseif($user_info_prev->file9_checked == 1 && $user_info->file9_checked == 0)	{
							$model->reliability = $model->reliability - 6;
						}
						
						$model->save();
						
						$user_info->save();

						$this->sendNoticeDocuments($checked_documents, $model, $user_info);
						//echo'$checked_files_arr<pre>';print_r($checked_files_arr,0);echo'</pre>';//die;
						//echo'$checked_documents<pre>';print_r($checked_documents,0);echo'</pre>';die;
					}	else	{
						$allOk = false;
					}
				}

				if(isset($_POST['UsersGruzodatel'])) {
					$user_info = $model->gruzodatel;
					
					$user_info->attributes = $_POST['UsersGruzodatel'];
					if($user_info->validate())	{
						$user_info->save();
					}	else	{
						$allOk = false;
					}
				}
				
				if($allOk)	{
					if(isset($_POST['save']))	{
						$this->redirect(array('admin'));
					}	else	{
						$this->redirect(array('update','id'=>$model->id));
					}
				}
				
			} else $profile->validate();
		}
		
		$user_type_list = array(
			1 => array('id' => 1, 'name' => 'Грузодатель'),
			2 => array('id' => 2, 'name' => 'Перевозчик'),
		);		
		
		$user_type_dropdown = CHtml::listData($user_type_list, 'id', 'name');
		$user_type_selected[$model->user_type] = array('selected' => 'selected');

		$user_status_list = array(
			1 => array('id' => 1, 'name' => 'Юр. лицо'),
			2 => array('id' => 2, 'name' => 'Физ. лицо'),
		);		
		
		$user_status_dropdown = CHtml::listData($user_status_list, 'id', 'name');
		$user_status_selected[$model->user_status] = array('selected' => 'selected');
		
		switch($model->user_type) {
			case 2:
				$user_info = $model->perevozchik;
				if($user_info === null) {
					$user_info = new UsersPerevozchik();
				}
				break;
			
			default:
			case 1:
				$user_info = $model->gruzodatel;
				if($user_info === null) {
					$user_info = new UsersGruzodatel();
				}
				break;
		}		

		$this->render('update',array(
			'model'=>$model,
			'profile'=>$profile,
			'user_type_dropdown'=>$user_type_dropdown,
			'user_type_selected'=>$user_type_selected,
			'user_status_dropdown'=>$user_status_dropdown,
			'user_status_selected'=>$user_status_selected,
			'user_info'=>$user_info,
		));
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$profile = Profile::model()->findByPk($model->id);
			$profile->delete();
			$model->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('/user/admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($validate)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($validate);
            Yii::app()->end();
        }
    }
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=User::model()->notsafe()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	//посылаем сообщение пользователю, что его документ проверен
	public function sendNoticeDocuments($checked_documents, $user, $user_info)
	{
		$document_names = array();
		if(count($checked_documents))	{
			foreach($checked_documents as $doc)	{
				$document_names[] = $user_info->getAttributeLabel('file'.$doc);
			}

			$data = array(
				'document_names' => $document_names,
				'user_name' => $user->username,
				'subject' => 'Верификация документов',
			);		
			$email = $user->email;
			$tmpl = 'emailNoticeDocuments';
			sendMail($email, $tmpl, $data);
		}
	}
}