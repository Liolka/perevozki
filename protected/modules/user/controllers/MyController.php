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
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			
		
		$this->checkIsLoggedUser();

		$model = $this->loadUser();
		
		
		$data = array(
			'model'=>$model,
		);
		
		$filter = 'actual';
		$orderBy = "t.`created` DESC";		
		
		switch($this->app->user->user_type) {
			case 2:
				$template = 'my_perevozchik';
			
				//$data['reviewsStat'] = ReviewsPerformers::model()->getUserReviewsStatistic($connection, $this->app->user->id);
				$data['reviewsStat'] = Bids::model()->getUserReviewsStatistic($connection, 'performer', $this->app->user->id);
			
				$lastBidsUser = Bids::model()->getBidsPerevozchik($connection, $this->app->user->id, $model, 5, $orderBy, $filter);
			
				$add_info = $model->perevozchik;
				if($add_info === null) {
					$add_info = new UsersPerevozchik;
				}
			
				$documents_count = 0;
			
				if($add_info->file1 != '') {
					$documents_count++;
				}
				
				if($add_info->file2 != '') {
					$documents_count++;
				}
				
				$data['documents_count'] = $documents_count;
				$data['transport_count'] = count(Transport::model()->getUserTransportList($connection, $this->app->user->id));
				$data['lastBidsUser'] = $lastBidsUser;
				$data['totalBids'] = Bids::model()->getTotalBidsPerevozchik($connection, $this->app->user->id);
				break;
			
			case 1:
			default:
				$template = 'my_gruzodatel';
			
				//$lastBidsUser = Bids::model()->getBidsUser($connection, $this->app->user->id, $model, 'user_id');
				$lastBidsUser = Bids::model()->getBidsGruzodatel($connection, $this->app->user->id, $model, 'user_id', 5, $orderBy, $filter);
				
				$add_info = $model->gruzodatel;
				if($add_info === null) {
					$add_info = new UsersGruzodatel;
				}
			
			
				$documents_count = 0;
				if($add_info->file1 != '') {
					$documents_count++;
				}
				
				if($add_info->file2 != '') {
					$documents_count++;
				}
				
				$data['documents_count'] = $documents_count;
			
				//echo'<pre>';print_r($lastBidsUser,0);echo'</pre>';
			
				$user_company = $model->gruzodatel;
				if($user_company === null) {
					$user_company = new UsersGruzodatel;
				}
			
				$data['user_company'] = $user_company;
				$data['lastBidsUser'] = $lastBidsUser;
				$data['totalBids'] = Bids::model()->getTotalBidsGruzodatel($connection, $this->app->user->id);
				break;
		}
		
		if($this->app->user->id == 1) {
			$this->layout='//layouts/column2r';
			$template = 'my_admin';
		}
		
	    $this->render($template, $data);
	}

	public function actionRequests()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);
		
		processPageRequest('page');
		
		$order_ = $this->app->request->getParam('order', '');
		if($order_ != '')	{
			$this->app->session['myrequests.order'] = $order_;
			$this->redirect(array('requests'));
		}
				
		if(isset($this->app->session['myrequests.order'])) {
			$order = $this->app->session['myrequests.order'];
		}	else	{
			$order = 'date';
		}
		
		switch($order) {
			case 'reviews' :
				$orderBy = "review DESC, t.`created` DESC";
				//$orderBy = "t.`created` DESC";
				break;
			case 'date' :
			default:
				$orderBy = "t.`created` DESC";
				break;
		}
		
		$filter_ = $this->app->request->getParam('filter', '');
		if($filter_ != '')	{
			$this->app->session['myrequests.filter'] = $filter_;
			$this->redirect(array('requests'));
		}
		
		if(isset($this->app->session['myrequests.filter'])) {
			$filter = $this->app->session['myrequests.filter'];
		}	else	{
			$filter = 'actual';
		}
		
		//echo'<pre>';print_r($orderBy,0);echo'</pre>';
		
		$this->checkIsLoggedUser();
		
		$model = $this->loadUser();
		
		$data = array(
			'model'=>$model,
			'order'=>$order,
			'filter'=>$filter,
		);
		
		switch($this->app->user->user_type) {
			case 2:
				$dataProvider = Bids::model()->getBidsPerevozchik($connection, $this->app->user->id, $model, 5, $orderBy, $filter);
				$data['dataProvider'] = $dataProvider;
				//echo'<pre>';print_r($dataProvider->data,0);echo'</pre>';
			
				if ($this->app->request->isAjaxRequest){
					$template = '_requests_list_perevozchik_ajax';
				}	else	{
					$totalBids = Bids::model()->getTotalBidsPerevozchik($connection, $this->app->user->id);
					$data['totalBids'] = $totalBids;

					$user_company = $model->perevozchik;
					if($user_company === null) {
						$user_company = new UsersPerevozchik;
					} 

					$data['user_company'] = $user_company;
					
					$template = 'requests_perevozchik';
				}
				break;
			
			case 1:
			default:
				$dataProvider = Bids::model()->getBidsGruzodatel($connection, $this->app->user->id, $model, 'user_id', 5, $orderBy, $filter);
				$data['dataProvider'] = $dataProvider;
			
				//echo'<pre>';print_r($lastBidsUser,0);echo'</pre>';
				if ($this->app->request->isAjaxRequest)	{
					$template = '_requests_list_gruzodatel_ajax';
				}	else	{
					$totalBids = Bids::model()->getTotalBidsGruzodatel($connection, $this->app->user->id);
					$data['totalBids'] = $totalBids;
					
					$user_company = $model->gruzodatel;
					if($user_company === null) {
						$user_company = new UsersGruzodatel;
					}

					$data['user_company'] = $user_company;
					
					$template = 'requests_gruzodatel';
				}
				break;
		}

		if ($this->app->request->isAjaxRequest) {
			$this->renderPartial($template, $data);
		}	else	{
			$this->render($template, $data);
		}
	    
	}

	public function actionTransport()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			

		
		$this->checkIsLoggedUser();
		$this->checkPerevozchik();
		
		$model = new Transport;
		
		$criteria = new CDbCriteria;
		$criteria->select = "transport_id, name, year, foto, carrying, length, width, height, volume, body_type, loading_type, comment";
		$criteria->condition = '`user_id` = '.$this->app->user->id;
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
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}
		
		if(isset($_POST['Transport'])) {
			
			$criteria = new CDbCriteria;
			$criteria->select = "transport_id, name, year, foto, carrying, length, width, height, volume, body_type, loading_type, comment";
			$criteria->condition = '`user_id` = '.$this->app->user->id;
			$criteria->order = 'transport_id DESC';
			
			//получаем кол-во транспорта перед сохранением
			$dataProvider_old = new CActiveDataProvider('Transport', array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>50,
					'pageVar' =>'page',
				),
			));
			$count_old = count($dataProvider_old->data);
			
			//echo'<pre>';print_r($count_old,0);echo'</pre>';//die;
			$model->attributes = $_POST['Transport'];
			$model->user_id = $this->app->user->id;
			
			if($model->validate()) {
				$model->save(false);
				//получаем кол-во транспорта после сохранения
				$dataProvider_new = new CActiveDataProvider('Transport', array(
					'criteria'=>$criteria,
					'pagination'=>array(
						'pageSize'=>50,
						'pageVar' =>'page',
					),
				));
				$count_new = count($dataProvider_new->data);

				//если необходимо - корректируем показатель надежности
				if($count_old == 0 && $count_new > 0)	{
					$user = $this->loadUser();
					$user->reliability = $user->reliability + 15;
					$user->save(false);
				}	elseif($count_old > 0 && $count_new == 0) {
					$user = $this->loadUser();
					$user->reliability = $user->reliability - 15;
					$user->save(false);
				}
				
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
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}
		
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
		$this->app = Yii::app();
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}
		
		$model = Transport::model()->findByPk($id);
		
		if($model !== null) {
			$this->app->session['transport_tmp_foto'] = $model->foto;
		}
		
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
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}
		
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
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}		
		
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
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			

		
		$this->checkIsLoggedUser();
		
		$model = new MyDocuments;
		
		$user = $this->loadUser();
		
		switch($user->user_type) {
			case 2:
				$add_info = $user->perevozchik;
			
				if($add_info === null) {
					$add_info = new UsersPerevozchik;
					$add_info->user_id = $user->id;
				}
			
				break;
			default:
			case 1:
				$add_info = $user->gruzodatel;
			
				if($add_info === null) {
					$add_info = new UsersGruzodatel;
					$add_info->user_id = $user->id;
				}
			
				break;
			
		}
		//echo'<pre>';print_r($add_info,0);echo'</pre>';
		//die;
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
						$add_info->$attr = $filename;
						$add_info->save(false);
						
						$this->sendNoticeDocumentModerator($attr, $user, $add_info);
						
						$this->app->user->setFlash('success', "Файл успешно загружен");
						$this->redirect(array("documents"));
					}
				}
			}
			
		}	else	{
			if($add_info->file1)
				$model->file1 = $add_info->file1;

			if($add_info->file2)
				$model->file2 = $add_info->file2;
		}
				
	    $this->render('documents', array(
	    	'user'=>$user,
	    	'model'=>$model,
	    	'add_info'=>$add_info,
	    ));
	}
	
	//удаление документа
	//в id передается имя атрибута, в котором франится файл.
	public function actionDocumentdelete($id)
	{
		$this->app = Yii::app();
		
		if($this->app->user->isGuest) {
			throw new CHttpException(500,'Ошибка доступа');
		}

		$user = $this->loadUser();
		$add_info = $user->perevozchik;
		
		if($id)	{
			$checked_attr = $id.'_checked';
			$file_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id.'/docs/'.$add_info->$id;
			if(file_exists($file_path)) unlink($file_path);
			$add_info->$id = '';
			$add_info->$checked_attr = 0;
			$add_info->save(false);
			$this->app->user->setFlash('success', "Файл успешно удален");
		}
		$this->redirect(array("documents"));
	}
	
	public function actionInfo()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			

		
		$user = $this->loadUser();
		
		$data = array(
			'user'=>$user,
			'show_edit_btn'=>true,
			'user_status' => $this->app->user->user_status,
		);
		
		switch($user->user_type) {
			case 2:
				$tmpl = 'info-perevozchik';
			
				$user_company = $user->perevozchik;
			
				if($user_company === null) {
					$user_company = new UsersPerevozchik();
				}
			
				$data['user_company'] = $user_company;
				break;
			default:
			case 1:
				$tmpl = 'info-gruzodatel';
				$add_info = $user->gruzodatel;
			
				if($add_info === null) {
					$add_info = new UsersGruzodatel();
				}
				
				$data['user_company'] = $add_info;
				break;
			
		}
		
		$this->render($tmpl, $data );
		/*
	    $this->render('info-perevozchik', array(
	    	'user'=>$user,
	    	'user_company'=>$user_company,
	    	'show_edit_btn'=>true,
		
	    ));
		*/
	}

	public function actionInfoedit()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			
		
		$user = $this->loadUser();
	
		switch($user->user_type) {
			case 2:
				$tmpl = 'info-edit-perevozchik';
			
				$user_company = $user->perevozchik;
			
				if($user_company === null) {
					$user_company = new UsersPerevozchik();
				}
				break;
			default:
			case 1:
				$tmpl = 'info-edit-gruzodatel';
				$user_company = $user->gruzodatel;
			
				if($user_company === null) {
					$user_company = new UsersGruzodatel();
				}
				break;
		}
		
		
		
		if(isset($_POST['UsersPerevozchik']))	{
			foreach($_POST['UsersPerevozchik'] as &$attr)	{
				$attr = strip_tags($attr);
			}
			
			$user_company_prev = $user_company->attributes;
			$filled_phones_prev = 0;
			if($user_company_prev['phone1'] != '') $filled_phones_prev++;
			if($user_company_prev['phone2'] != '') $filled_phones_prev++;
			if($user_company_prev['phone3'] != '') $filled_phones_prev++;
			if($user_company_prev['phone4'] != '') $filled_phones_prev++;
			//echo'<pre>';print_r($user_company_prev,0);echo'</pre>';die;
			
			$user_company->attributes = $_POST['UsersPerevozchik'];
			if(!$user_company->user_id)	{
				$user_company->user_id = $this->app->user->id;
			}
			if($user_company->save()) {
				
				$filled_phones = 0;
				if($user_company->phone1 != '') $filled_phones++;
				if($user_company->phone2 != '') $filled_phones++;
				if($user_company->phone3 != '') $filled_phones++;
				if($user_company->phone4 != '') $filled_phones++;
				
				if($filled_phones > 1 && $filled_phones_prev <=1)	{
					$user->reliability = $user->reliability + 5;
				}	elseif($filled_phones_prev > 1 && $filled_phones <=1)	{
					$user->reliability = $user->reliability - 5;
				}
				
				//Для частных лиц
				if($user_company_prev['town'] == '' && $user_company->town != '')	{
					$user->reliability = $user->reliability + 3;
				}	elseif($user_company_prev['town'] != '' && $user_company->town == '')	{
					$user->reliability = $user->reliability - 3;
				}
				
				if($user_company_prev['experience'] == '' && $user_company->experience != '')	{
					$user->reliability = $user->reliability + 4;
				}	elseif($user_company_prev['experience'] != '' && $user_company->experience == '')	{
					$user->reliability = $user->reliability - 4;
				}
				
				if($user_company_prev['birthday'] == '' && $user_company->birthday != '')	{
					$user->reliability = $user->reliability + 3;
				}	elseif($user_company_prev['birthday'] != '' && $user_company->birthday == '')	{
					$user->reliability = $user->reliability - 3;
				}
				
				// Для компаний
				if($user_company_prev['main_office'] == '' && $user_company->main_office != '')	{
					$user->reliability = $user->reliability + 3;
				}	elseif($user_company_prev['main_office'] != '' && $user_company->main_office == '')	{
					$user->reliability = $user->reliability - 3;
				}
				
				if($user_company_prev['filials'] == '' && $user_company->filials != '')	{
					$user->reliability = $user->reliability + 3;
				}	elseif($user_company_prev['filials'] != '' && $user_company->filials == '')	{
					$user->reliability = $user->reliability - 3;
				}
				
				if($user_company_prev['unp'] == '' && $user_company->unp != '')	{
					$user->reliability = $user->reliability + 4;
				}	elseif($user_company_prev['unp'] != '' && $user_company->unp == '')	{
					$user->reliability = $user->reliability - 4;
				}
				
				$user->save(false);
				
				$this->redirect(array("info"));
			}
		} elseif(isset($_POST['UsersGruzodatel']))	{
			foreach($_POST['UsersGruzodatel'] as &$attr)	{
				$attr = strip_tags($attr);
			}
			
			$user_company->attributes = $_POST['UsersGruzodatel'];
			if(!$user_company->user_id)	{
				$user_company->user_id = $this->app->user->id;
			}
			if($user_company->save()) {
				$this->redirect(array("info"));
			}
		}	else	{
		}
				
	    $this->render($tmpl, array(
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
		
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);			

		$this->checkIsLoggedUser();
		//echo'<pre>';print_r($_POST);echo'</pre>';die;
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
			
			if(isset($_POST['UserChangeEmail'])) {
				$model_ChangeEmail->attributes = $_POST['UserChangeEmail'];
				if($model_ChangeEmail->validate())	{
					
					$data = array(
						'new_email' => $model_ChangeEmail->newEmail,
						'user_name' => $app->user->username,
						'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$app->user->id)),
						'subject' => 'Запрос на смену пароля',
					);
					$email = $app->user->email;
					$tmpl = 'emaiChangelNotice';
					sendMail($email, $tmpl, $data);
					
					$this->redirect(array("edit"));
				}
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
						Yii::app()->user->setFlash('success',UserModule::t("New password is saved."));
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
	
	/**
	* Проверяет, залогинен ли пользователь
	*/
	public function checkIsLoggedUser()
	{
		if($this->app->user->isGuest) {
			$this->redirect(Yii::app()->controller->module->loginUrl);
		}
	}
	
	/**
	* Проверяет, перевозчик ли пользователь
	*/
	public function checkPerevozchik()
	{
		if($this->app->user->user_type != 2)	{
			throw new CHttpException(500, 'Данная страница доступна только перевозчикам.');
		}		
	}
	
	
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
	//посылаем сообщение модератору о загрузке документов
	public function sendNoticeDocumentModerator($attr, $user, $add_info)
	{
		$document_name = $add_info->getAttributeLabel($attr);
		
		$data = array(
			'document_name' => $document_name,
			'user_name' => $user->username,
			'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$user->id)),
			'subject' => 'Загружен новый документ',
		);
		$email = $this->app->params['adminEmail'];
		$tmpl = 'emailNoticeDocumentModerator';
		sendMail($email, $tmpl, $data);

	}
	
	
	
}