<?php

class BidsController extends Controller
{
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(
					'create',
					'index',
					'view',
					'step2form',
					'step3form',
					'acceptdeal',
					'cancelaccepteddeal',
					'rejectdeal',
					'cancelrejecteddeal',
					'uploadfoto',
					'setcargonum',
					'removebid',
					'updatebid',
					'category',
					'createincat',
				),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		//throw new CHttpException(500,'Неверные параметры запроса');
		
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);
		
		$model = $this->loadModel($id);
		
		$cargoes = BidsCargoes::model()->getCargoresBids($connection, $model->bid_id);
		
		$bid_name_arr = array();
		foreach($cargoes as $cargo) {
			$bid_name_arr[] = $cargo['name'];
		}
		
		$bid_name = implode('. ', $bid_name_arr);
		
		
		$deals = new Deals();
		
		if(isset($_POST['Deals'])) {
			$deals->attributes = $_POST['Deals'];
			$deals->bid_id = $id;
			$deals->user_id = $this->app->user->id;
			if($deals->validate())	{
				$deals->save(false);
				$this->sendNoticeNewDeal($model->user_id, $id, $bid_name, $this->app->user->id, $this->app->user->username );
				$this->app->user->setFlash('success', 'Ваше предложение размещено.');
				$this->redirect(array('bids/view','id'=>$id));
			}
		}
		
		if(isset($_POST['deal-post'])) {
			$deal_post = new DealsPosts();
			$deal_post->user_id = $this->app->user->id;
			$deal_post->deal_id = $_POST['deal-id'];
			$deal_post->text = $_POST['deal-post'];
			if($deal_post->validate())	{
				$deal_post->save();
				if($deal_post->user_id == $model->user_id)	{
					//посылаем сообщение автору предложения в заявке
					$this->sendNoticeNewPostDealAuthor($deal_post->deal_id, $id, $bid_name, $this->app->user->id, $this->app->user->username);
				}	else	{
					//посылаем сообщение автору заявки
					$this->sendNoticeNewPostBidAuthor($model->user_id, $id, $bid_name, $this->app->user->id, $this->app->user->username );
				}
				$this->app->user->setFlash('success', 'Ваше сообщение размещено.');
			}
			$this->redirect(array('bids/view','id'=>$id));
		}
		
		$user_info = User::model()->getUserName($connection, $model->user_id);
		$model->username = $user_info['username'];
		$model->last_activity = $user_info['last_activity'];
		$model->user_rating = $user_info['rating'];
		
		isOnline($this->app, $user_info['last_activity']);
		
		$route_arr = array();
		$this->addRouteItem($model->loading_town, $model->loading_address, $route_arr);
		$this->addRouteItem($model->add_loading_unloading_town_1, $model->add_loading_unloading_address_1, $route_arr);
		$this->addRouteItem($model->add_loading_unloading_town_2, $model->add_loading_unloading_address_2, $route_arr);
		$this->addRouteItem($model->add_loading_unloading_town_3, $model->add_loading_unloading_address_3, $route_arr);
		$this->addRouteItem($model->unloading_town, $model->unloading_address, $route_arr);
		
		if(!$this->app->user->isGuest && $this->app->user->user_type == 2)	{
			$is_perevozchik = true;
			$transport_list = Transport::model()->getUserTransportList($connection, $this->app->user->id);
		}	else	{
			$is_perevozchik = false;
			$transport_list = array();
		}
		
		$deals_list = Deals::model()->getBidDeals($connection, $id);
		
		$deals_ids = array();
		foreach($deals_list as $row) {
			$deals_ids[] = $row['id'];
		}
		
		$deals_posts_list = DealsPosts::model()->getDealsPosts($connection, $deals_ids);
		
		//получаем данные по предлагаемому транспорту
		/*
		$transport_ids = array();
		foreach($deals_list as $deal) {
			$transport_ids[] = $deal['transport_id'];
		}
		$transport_list = Transport::model()->getTransportListFromIds($connection, $transport_ids);
		*/
		
		
		//echo'<pre>';print_r($transport_list);echo'</pre>';
		
		$this->render('view',array(
			'model'=> $model,
			'cargoes'=> $cargoes,
			'bid_name'=> $bid_name,
			'route_arr'=> $route_arr,
			'deals'=> $deals,
			'is_perevozchik'=> $is_perevozchik,
			'transport_list'=> $transport_list,
			'deals_list'=> $deals_list,
			'deals_posts_list'=> $deals_posts_list,
		));
		
	}
	
	//принять заявку
	public function actionAcceptdeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = $this->app->request->getParam('performer_id', 0);
		
		$bid_name = $this->getBidName($id);
		$this->sendNoticeAcceptDeal($deal_id, $id, $bid_name, $this->app->user->id, $this->app->user->username);		
		
		$this->updateBid($id, $deal_id, 'accepted', 1, $performer_id, 'Предложение принято.');
		
	}
	
	//отменить принятую заявку
	public function actionCancelaccepteddeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = 0;
		
		$bid_name = $this->getBidName($id);
		$this->sendNoticeCancelAcceptedDeal($deal_id, $id, $bid_name, $this->app->user->id, $this->app->user->username);
		
		$this->updateBid($id, $deal_id, 'accepted', 0, $performer_id, 'Выбранное предложение отменено.');		
	}

	//отклонить заявку
	public function actionRejectdeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = -1;
		
		$bid_name = $this->getBidName($id);
		$this->sendNoticeRejectDeal($deal_id, $id, $bid_name, $this->app->user->id, $this->app->user->username);
		
		$this->updateBid($id, $deal_id, 'rejected', 1, $performer_id, 'Предложение отклонено.');	
	}

	//отменить отклонение заявки
	public function actionCancelrejecteddeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = -1;
		
		$bid_name = $this->getBidName($id);
		$this->sendNoticeCancelRejectedDeal($deal_id, $id, $bid_name, $this->app->user->id, $this->app->user->username);
		
		$this->updateBid($id, $deal_id, 'rejected', 0, $performer_id, 'Отклоненное предложение восстановлено.');	
	}
	
	//удалить заявку
	public function actionRemovebid($id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$bid_model = $this->loadModel($id);
		
		if($this->app->user->isGuest || $bid_model->user_id != $this->app->user->id)
			throw new CHttpException(500,'Ошибка доступа');
		
		$count_bids = Deals::model()->getBidDealsCount($connection, array($id));
		if(count($count_bids))	{
			//echo'<pre>Только пометить</pre>';
			Bids::model()->UnpublishBid($connection, $id);
			$this->app->user->setFlash('success', 'Ваша заявка успешно отменена');
			$this->redirect(array('/user/my/requests'));
			
		}	else	{
			//echo'<pre>Удалить</pre>';
			// найти все грузы
			$bidsCargoes = $bid_model->bidsCargoes;
			$image_path = Yii::getPathOfAlias('webroot').'/files/bids/';
			// удалить их изображения
			foreach($bidsCargoes as $bidcargo)	{
				$cargo = $bidcargo->cargo;
				if($cargo->foto != '')	{
					if (file_exists($image_path . 'full_'.$cargo->foto)) {
						unlink($image_path . 'full_'.$cargo->foto);
					}
					if (file_exists($image_path . 'thumb_'.$cargo->foto)) {
						unlink($image_path . 'thumb_'.$cargo->foto);
					}					
				}
				$cargo->delete();
			}
			$bid_model->delete();
			$this->app->user->setFlash('success', 'Ваша заявка успешно отменена');
			$this->redirect(array('/user/my/requests'));
		}
		
		//$bidsCargoes = $bid_model->bidsCargoes;
		//echo'<pre>';print_r($bidsCargoes[0]->cargo);echo'</pre>';
		//echo'<pre>';print_r($count_bids);echo'</pre>';
		

		
		$this->app->user->setFlash('bidMessageSuccess', $bidMessageSuccess);
		$this->redirect(array('bids/view','id'=>$id));
		
	}

	//удалить заявку
	public function actionUpdatebid($id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$bid_model = $this->loadModel($id);
		if($bid_model->time_transportation != '00:00:00')	{
			$bid_model->time_transportation = $this->app->dateFormatter->format('HH:mm', $bid_model->time_transportation);
		}	else	{
			$bid_model->time_transportation = '';
		}
		
		if($bid_model->time_transportation_to != '00:00:00')	{
			$bid_model->time_transportation_to = $this->app->dateFormatter->format('HH:mm', $bid_model->time_transportation_to);
		}	else	{
			$bid_model->time_transportation_to = '';
		}
		
		if($this->app->user->isGuest || $bid_model->user_id != $this->app->user->id)
			throw new CHttpException(500,'Ошибка доступа');
		
		$deals_list = Deals::model()->getBidDeals($connection, $id);
		
		
		if(count($deals_list) != 0)	{
			$this->app->user->setFlash('error', 'Для заявки присутствуют предложения. Редактирование невозможно.');
			$this->redirect(array('bids/view','id'=>$id));		
		}
		
		$cargoModel = new Cargoes;
		$cargoModel->DropDownUnitsList = Cargoes::model()->getDropDownUnitsList();
		
		$count_cargoes = count($bid_model->bidsCargoes);
		
		$msg = '';
		
		$bid_name_arr = array();
		
		if(isset($_POST['Cargoes']) && isset($_POST['Bids']))	{
			$bid_model->attributes = $_POST['Bids'];
			$cargoModel->attributes = $_POST['Cargoes'];
			
			for ($key=0; $key<$count_cargoes;$key++)	{
				$field = 'name'.($key+1);
				$bid_name_arr[] = $cargoModel->$field;
			}

			
			if($cargoModel->validate() && $bid_model->validate())	{
				$bid_model->save();
				
				
				
				for ($key=0; $key<$count_cargoes;$key++)	{
					$isOK = false;
					$field = 'cargo_id'.($key+1);
					if($cargoModel->$field)	{
						$cargo_item = Cargoes::model()->findByPk($cargoModel->$field);
						$cargo_item->scenario = Cargoes::SCENARIO_SAVE_CARGO;
						$field = 'name'.($key+1);
						$cargo_item->name = $cargoModel->$field;
						
						$field = 'comment'.($key+1);
						$cargo_item->comment = $cargoModel->$field;
						
						$field = 'unit'.($key+1);
						$cargo_item->unit = $cargoModel->$field;
						
						$field = 'porters'.($key+1);
						$cargo_item->porters = $cargoModel->$field;
						
						$field = 'lift'.($key+1);
						$cargo_item->lift = $cargoModel->$field;
						
						$field = 'floor'.($key+1);
						$cargo_item->floor = $cargoModel->$field;
						
						$field = 'weight'.($key+1);
						$cargo_item->weight = $cargoModel->$field;
						
						$field = 'length'.($key+1);
						$cargo_item->length = $cargoModel->$field;
						
						$field = 'width'.($key+1);
						$cargo_item->width = $cargoModel->$field;
						
						$field = 'height'.($key+1);
						$cargo_item->height = $cargoModel->$field;
						
						$field = 'volume'.($key+1);
						$cargo_item->volume = $cargoModel->$field;
						
						$field = 'foto'.($key+1);
						$cargo_item->foto = $cargoModel->$field;
						
						$field = 'passengers_qty'.($key+1);
						$cargo_item->passengers_qty = $cargoModel->$field;
						
						$field = 'time'.($key+1);
						$cargo_item->time = $cargoModel->$field;
						
						if($cargoModel->validate())	{
							$cargo_item->save();
							$field = 'bid_tmp_foto_'.($key+1);
							unset($this->app->session[$field]);
							$isOK = true;
						}	else	{
							foreach($cargoModel->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}
							break;
						}
					}
				}
				
				unset($this->app->session['bid_cargo_num']);
				
				$this->app->user->setFlash('success', 'Изменения успешно сохранены.');
				$this->redirect(array('/bids/view','id'=>$id));
			}
			//echo'<pre>';print_r($cargoModel);echo'</pre>';die;
			
		}	else	{
			foreach($bid_model->bidsCargoes as $key => $bidsCargoes)	{
				$model = $bidsCargoes->cargo;
				//echo'<pre>';print_r($model->unit);echo'</pre>';die;

				$bid_name_arr[] = $model->name;

				$field = 'category'.($key+1);
				$cargoModel->$field = $model->cargoesCategories[0]->category_id;

				$field = 'name'.($key+1);
				$cargoModel->$field = $model->name;

				$field = 'cargo_id'.($key+1);
				$cargoModel->$field = $model->cargo_id;

				$field = 'comment'.($key+1);
				$cargoModel->$field = $model->comment;

				$field = 'unit'.($key+1);
				$cargoModel->$field = $model->unit;

				$field = 'porters'.($key+1);
				$cargoModel->$field = $model->porters;

				$field = 'lift_to_floor'.($key+1);
				$cargoModel->$field = $model->lift_to_floor;

				$field = 'lift'.($key+1);
				$cargoModel->$field = $model->lift;

				$field = 'floor'.($key+1);
				$cargoModel->$field = $model->floor;

				$field = 'weight'.($key+1);
				$cargoModel->$field = $model->weight;

				$field = 'length'.($key+1);
				$cargoModel->$field = $model->length;

				$field = 'width'.($key+1);
				$cargoModel->$field = $model->width;

				$field = 'height'.($key+1);
				$cargoModel->$field = $model->height;

				$field = 'volume'.($key+1);
				$cargoModel->$field = $model->volume;

				$field = 'foto'.($key+1);
				$cargoModel->$field = $model->foto;

				$field = 'passengers_qty'.($key+1);
				$cargoModel->$field = $model->passengers_qty;

				$field = 'time'.($key+1);
				$cargoModel->$field = $model->time;

				$field = 'selected_unit'.($key+1);
				$cargoModel->$field = array($model->unit => array( 'selected' => 'selected' ));
			}


			
		}
		
		$bid_name = implode('. ', $bid_name_arr);
		
		if($msg != '') {
			$msg = '<ul>'.$msg.'</ul>';
			$this->app->user->setFlash('error', $msg);
		}
		

		
		
		//подготавливаем выпадающий список наличия товара
		
		
		//echo'<pre>';print_r($cargoModel);echo'</pre>';die;
		
		//$this->app->user->setFlash('success', 'Изменения в заявке сохранены.');
		//$this->redirect(array('bids/view','id'=>$id));
		
		$this->render('update',array(
			'bid_model'=> $bid_model,
			'cargoModel'=> $cargoModel,
			'count_cargoes'=> $count_cargoes,
			'bid_name'=> $bid_name,
			//'route_arr'=> $route_arr,
			//'deals'=> $deals,
			//'is_perevozchik'=> $is_perevozchik,
			//'transport_list'=> $transport_list,
			//'deals_list'=> $deals_list,
			//'deals_posts_list'=> $deals_posts_list,
		));
		
		

		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Bids;
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);

		if(isset($_POST['Bids']) && !isset($_POST['ajax'])) {
				//если пришли данные из последнего шага и без аякс-валидации
				$model->attributes = $_POST['Bids'];
				$create_bid = false;
				$msg = '';
				if($model->validate()) {
					//валидация входных данных успешна
					$bidMessageSuccess = 'Ваша заявка успешно размещена.';
					
					if($this->app->user->isGuest) {
						$model->have_account = $_POST['Bids']['have_account'];
						
						if($_POST['Bids']['have_account'] == 1) {
							$model->scenario = Bids::SCENARIO_LOGIN_FORM;
						} else {
							$model->scenario = Bids::SCENARIO_REG_FORM;
						}
						
						if($model->have_account == 1) {
							//если пользователь уже зареген то проверяем введенные им данные и логиним его
							$user_model=new UserLogin;
							$user_model->username = $model->login_email;
							$user_model->password = $model->login_password;
							$user_model->rememberMe = false;
							//var_dump($user_model->validate());die;
							if($user_model->validate()) {
								$lastVisit = User::model()->notsafe()->findByPk($this->app->user->id);
								$lastVisit->lastvisit = time();
								$lastVisit->save();

								$this->app->user->setFlash('bidMessageSuccess', $bidMessageSuccess);
								$model->user_id = $this->app->user->id;
								$create_bid = true;

							} else {
								foreach($user_model->errors as $er) {
									$msg .= '<li>'.$er[0].'</li>';
								}
								$create_bid = false;
							}
						} else {
							//если это новый пользователь - регим его
							header('Content-Type: text/html; charset=utf-8');
							$model_reg = new RegistrationForm;
							$profile = new Profile;
							$profile->regMode = true;

							$model_reg->scenario = RegistrationForm::SCENARIO_REGISTRATION;

							$model_reg->username = $model->bid_name;
							$model_reg->email = $model->bid_email;
							$model_reg->password = $this->createPassword();
							$model_reg->verifyPassword = $model_reg->password;
							$model_reg->accept_rules = 1;
							$model_reg->user_status = $model->user_status;
							
							$profile->attributes = array();
							
							if($model_reg->validate()) {
								$soucePassword = $model_reg->password;
								$model_reg->activkey=UserModule::encrypting(microtime().$model_reg->password);
								$model_reg->password=UserModule::encrypting($model_reg->password);
								$model_reg->verifyPassword=UserModule::encrypting($model_reg->verifyPassword);
								$model_reg->superuser=0;
								//$model_reg->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
								$model_reg->status=User::STATUS_NOACTIVE;

								$model_reg->user_type = 1;
								$model_reg->user_status = $model->user_status;

								if ($model_reg->save()) {
									$profile->user_id=$model_reg->id;
									$profile->save();
									$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model_reg->activkey, "email" => $model_reg->email));
									UserModule::sendMail($model_reg->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)).' 
									Пароль для входа: '.$soucePassword);
									
									Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
									$bidMessageSuccess .= '<br />На Ваш e-mail, указанный при регистрации, отправлено письмо для активации аккаунта. Если письмо отсутствует во входящих сообщениях, проверьте папку "СПАМ"';
								}

								$create_bid = true;

								$model->user_id = $model_reg->id;
							} else {
								$msg = '';
								foreach($model_reg->errors as $er) {
									$msg .= '<li>'.$er[0].'</li>';
								}

								$create_bid = false;
							}
							
							//echo'<pre>';print_r($msg);echo'</pre>';die;
							//echo'<pre>';print_r($model_reg);echo'</pre>';die;
						}						

					} else {
						$model->user_id = $this->app->user->id;
						$create_bid = true;
					}
					
				} else {
					foreach($model->errors as $er) {
						$msg .= '<li>'.$er[0].'</li>';
					}
					$create_bid = false;
				}
				//echo'<pre>';var_dump($create_bid);echo'</pre>';die;
				if($create_bid) {
					$NewBid_Cargoes	= $this->app->session['NewBid.Cargoes'];
					$model->save(false);
					
					$add_categories = array(
						$NewBid_Cargoes['category2'],
						$NewBid_Cargoes['category3'],
						$NewBid_Cargoes['category4'],
					);
					$add_categories_info = Categories::model()->getCategoriesFromIds($connection, $add_categories);
					
					$cargo = new Cargoes;
					$cargo->name = $NewBid_Cargoes['name1'];
					$cargo->comment = $NewBid_Cargoes['comment1'];
					$cargo->weight = isset($NewBid_Cargoes['weight1']) ? $NewBid_Cargoes['weight1'] : 0 ;
					$cargo->unit = isset($NewBid_Cargoes['unit1']) ? $NewBid_Cargoes['unit1'] : 1;
					$cargo->foto = isset($NewBid_Cargoes['foto1']) ? $NewBid_Cargoes['foto1'] : '';
					$cargo->porters = isset($NewBid_Cargoes['porters1']) ? $NewBid_Cargoes['porters1'] : 0;
					$cargo->lift_to_floor = isset($NewBid_Cargoes['lift_to_floor1']) ? $NewBid_Cargoes['lift_to_floor1'] : 0;
					$cargo->lift = isset($NewBid_Cargoes['lift1']) ? $NewBid_Cargoes['lift1'] : 0;
					$cargo->floor = isset($NewBid_Cargoes['floor1']) ? $NewBid_Cargoes['floor1'] : 0;
					$cargo->length = isset($NewBid_Cargoes['length1']) ? $NewBid_Cargoes['length1'] : 0;
					$cargo->width = isset($NewBid_Cargoes['width1']) ? $NewBid_Cargoes['width1'] : 0;
					$cargo->height = isset($NewBid_Cargoes['height1']) ? $NewBid_Cargoes['height1'] : 0;
					$cargo->volume = isset($NewBid_Cargoes['volume1']) ? $NewBid_Cargoes['volume1'] : 0;
					$cargo->passengers_qty = isset($NewBid_Cargoes['passengers_qty1']) ? $NewBid_Cargoes['passengers_qty1'] : '';
					$cargo->time = isset($NewBid_Cargoes['time1']) ? $NewBid_Cargoes['time1'] : '';
					
					if($cargo->validate()) {
						$cargo->save();
						$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
						$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category_id']);
						/*
						foreach($NewBid_Cargoes['category1'] as $category_id) {
							$this->createCargoesCategories($cargo->cargo_id, $category_id);
						}
						*/
						
					} else {
						foreach($model_reg->errors as $er) {
							$msg .= '<li>'.$er[0].'</li>';
						}
					}
					
					unset($this->app->session['bid_tmp_foto_1']);
					
					
					//echo'<pre>';print_r($_POST);echo'</pre>';die;
					
					if($msg == '' && $NewBid_Cargoes['name2'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name2'];
						$cargo->comment = $NewBid_Cargoes['comment2'];
						$cargo->weight = isset($NewBid_Cargoes['weight2']) ? $NewBid_Cargoes['weight2'] : 0 ;
						$cargo->unit = isset($NewBid_Cargoes['unit2']) ? $NewBid_Cargoes['unit2'] : 1;
						$cargo->foto = isset($NewBid_Cargoes['foto2']) ? $NewBid_Cargoes['foto2'] : '';
						$cargo->porters = isset($NewBid_Cargoes['porters2']) ? $NewBid_Cargoes['porters2'] : 0;
						$cargo->lift_to_floor = isset($NewBid_Cargoes['lift_to_floor2']) ? $NewBid_Cargoes['lift_to_floor2'] : 0;
						$cargo->lift = isset($NewBid_Cargoes['lift2']) ? $NewBid_Cargoes['lift2'] : 0;
						$cargo->floor = isset($NewBid_Cargoes['floor2']) ? $NewBid_Cargoes['floor2'] : 0;
						$cargo->length = isset($NewBid_Cargoes['length2']) ? $NewBid_Cargoes['length2'] : 0;
						$cargo->width = isset($NewBid_Cargoes['width2']) ? $NewBid_Cargoes['width2'] : 0;
						$cargo->height = isset($NewBid_Cargoes['height2']) ? $NewBid_Cargoes['height2'] : 0;
						$cargo->volume = isset($NewBid_Cargoes['volume2']) ? $NewBid_Cargoes['volume2'] : 0;
						$cargo->passengers_qty = isset($NewBid_Cargoes['passengers_qty2']) ? $NewBid_Cargoes['passengers_qty2'] : '';
						$cargo->time = isset($NewBid_Cargoes['time2']) ? $NewBid_Cargoes['time2'] : '';

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category2'], $add_categories_info);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}
						}
					}
					
					unset($this->app->session['bid_tmp_foto_2']);
					
					if($msg == '' && $NewBid_Cargoes['name3'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name3'];
						$cargo->comment = $NewBid_Cargoes['comment3'];
						$cargo->weight = isset($NewBid_Cargoes['weight3']) ? $NewBid_Cargoes['weight3'] : 0 ;
						$cargo->unit = isset($NewBid_Cargoes['unit3']) ? $NewBid_Cargoes['unit3'] : 1;
						$cargo->foto = isset($NewBid_Cargoes['foto3']) ? $NewBid_Cargoes['foto3'] : '';
						$cargo->porters = isset($NewBid_Cargoes['porters3']) ? $NewBid_Cargoes['porters3'] : 0;
						$cargo->lift_to_floor = isset($NewBid_Cargoes['lift_to_floor3']) ? $NewBid_Cargoes['lift_to_floor3'] : 0;
						$cargo->lift = isset($NewBid_Cargoes['lift3']) ? $NewBid_Cargoes['lift3'] : 0;
						$cargo->floor = isset($NewBid_Cargoes['floor3']) ? $NewBid_Cargoes['floor3'] : 0;
						$cargo->length = isset($NewBid_Cargoes['length3']) ? $NewBid_Cargoes['length3'] : 0;
						$cargo->width = isset($NewBid_Cargoes['width3']) ? $NewBid_Cargoes['width3'] : 0;
						$cargo->height = isset($NewBid_Cargoes['height3']) ? $NewBid_Cargoes['height3'] : 0;
						$cargo->volume = isset($NewBid_Cargoes['volume3']) ? $NewBid_Cargoes['volume3'] : 0;
						$cargo->passengers_qty = isset($NewBid_Cargoes['passengers_qty3']) ? $NewBid_Cargoes['passengers_qty3'] : '';
						$cargo->time = isset($NewBid_Cargoes['time3']) ? $NewBid_Cargoes['time3'] : '';
						
						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category3'], $add_categories_info);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}
						}
					}
					
					unset($this->app->session['bid_tmp_foto_3']);
					
					if($msg == '' && $NewBid_Cargoes['name4'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name4'];
						$cargo->comment = $NewBid_Cargoes['comment4'];
						
						$cargo->weight = isset($NewBid_Cargoes['weight4']) ? $NewBid_Cargoes['weight4'] : 0 ;
						$cargo->unit = isset($NewBid_Cargoes['unit4']) ? $NewBid_Cargoes['unit4'] : 1;
						$cargo->foto = isset($NewBid_Cargoes['foto4']) ? $NewBid_Cargoes['foto4'] : '';						
						$cargo->porters = isset($NewBid_Cargoes['porters4']) ? $NewBid_Cargoes['porters4'] : 0;
						$cargo->lift_to_floor = isset($NewBid_Cargoes['lift_to_floor4']) ? $NewBid_Cargoes['lift_to_floor4'] : 0;
						$cargo->lift = isset($NewBid_Cargoes['lift4']) ? $NewBid_Cargoes['lift4'] : 0;
						$cargo->floor = isset($NewBid_Cargoes['floor4']) ? $NewBid_Cargoes['floor4'] : 0;
						$cargo->length = isset($NewBid_Cargoes['length4']) ? $NewBid_Cargoes['length4'] : 0;
						$cargo->width = isset($NewBid_Cargoes['width4']) ? $NewBid_Cargoes['width4'] : 0;
						$cargo->height = isset($NewBid_Cargoes['height4']) ? $NewBid_Cargoes['height4'] : 0;
						$cargo->volume = isset($NewBid_Cargoes['volume4']) ? $NewBid_Cargoes['volume4'] : 0;
						$cargo->passengers_qty = isset($NewBid_Cargoes['passengers_qty4']) ? $NewBid_Cargoes['passengers_qty4'] : '';
						$cargo->time = isset($NewBid_Cargoes['time4']) ? $NewBid_Cargoes['time4'] : '';
						
						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category4'], $add_categories_info);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}


						}
					}
					
					unset($this->app->session['bid_tmp_foto_4']);
					unset($this->app->session['bid_cargo_num']);
					
					$this->app->user->setFlash('success', $bidMessageSuccess);
					
					$this->redirect(array('view','id'=>$model->bid_id));
					/*
					$form = '_form';
					$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);

					

					$data = array(
						'category_id'=>'0',
						'model'=>$model,
						'form'=>$form,
						'model_Cargoes'=>null,
						'categories_list_level1'=>$categories_list_level1,
						'categories_list_level2'=>array(),
						'categories_list'=>array(),

					);
					*/
					
				} else {
					
					if($msg != '') {
						$msg = '<ul>'.$msg.'</ul>';
						$this->app->user->setFlash('bidMessageError', $msg);
					}
					
					$form = '_form_f';
					$data = array(
						'category_id'=>'0',
						'model'=>$model,
						'model_Cargoes'=>null,
						'form'=>$form,
						'categories_list_level1'=>array(),
						'categories_list_level2'=>array(),
						'categories_list'=>array(),
					);
					
				}
		} elseif(isset($_POST['Cargoes'])) {
			
			$this->app->session['NewBid.Cargoes'] = $_POST['Cargoes'];
			$model_Cargoes = null;
			
			//$model->category_id = $this->app->request->getParam('Cargoes[category_id]', 1);
			$model->category_id = $_POST['Cargoes']['category_id'];
			
			//$countries = CHtml::listData($this->app->params['countries']);			
			//echo'<pre>';print_r($countries);echo'</pre>';die;
			
			$form = '_form_f';
			$data = array(
				'category_id'=>'0',
				'model'=>$model,
				'model_Cargoes'=>null,
				'form'=>$form,
				'categories_list_level1'=>array(),
				'categories_list_level2'=>array(),
				'categories_list'=>array(),
				
			);
			/*
			$model->attributes=$_POST['Bids'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->bid_id));
			*/
			
		} elseif(isset($_POST['ajax'])) {
			$model->attributes = $_POST['Bids'];
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->bid_id));
			
			$form = '_form_f';
			$data = array(
				'category_id'=>'0',
				'model'=>$model,
				'model_Cargoes'=>null,
				'form'=>$form,
				'categories_list_level1'=>array(),
				'categories_list_level2'=>array(),
				'categories_list'=>array(),
			);

			
		} else {
			$form = '_form';
			$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);
			
			$data = array(
				'category_id'=>'0',
				'model'=>$model,
				'form'=>$form,
				'model_Cargoes'=>null,
				'categories_list_level1'=>$categories_list_level1,
				'categories_list_level2'=>array(),
				'categories_list'=>array(),
				
			);
		}
		
		//echo'<pre>';print_r($data);echo'</pre>';die;
		

		$this->render('create', $data);
	}
	
	public function actionCreateincat($id)
	{
		$model = new Bids;
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);
		
		$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);
		$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $id);
		
		$data = array(
			'category_id'=>$id,
			'model'=>$model,
			'categories_list_level1'=>$categories_list_level1,
			'categories_list_level2'=>$categories_list_level2,
			'categories_list'=>array(),

		);
		//echo'<pre>';print_r($data);echo'</pre>';die;
		
		$this->render('create-in-cat', $data);
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$page_info = Pages::model()->findByPk(11);
		
		UpdateLastActivity($this->app, $connection);
		
		$model = new BidsFilter;
		
		//$rows_pages = Bids::model()->getBids();
		
		//$this->processPageRequest('page');
		processPageRequest('page');
		
		/*
		$clear_bids_filter = $this->app->request->getParam('clear-bids-filter', 0);
		if($clear_bids_filter)	{
			//unset($this->app->session['bidslst.BidsFilter']);
			//unset($this->app->session['bidslst.BidsFilterCategories']);
			$this->redirect(array('index'));
		}
		*/
		
		$type_sort = $this->app->request->getParam('type-sort', '');
		
		if($type_sort != '')	{
			$this->app->session['bidslst.type_sort'] = $type_sort;
			$this->redirect(array('index'));
		}	elseif(isset($this->app->session['bidslst.type_sort'])) {
			$type_sort = $this->app->session['bidslst.type_sort'];
		}	else	{
			$type_sort = 'datepub';
		}
		
		//echo'<pre>';print_r($_POST);echo'</pre>';
		//echo'<pre>';print_r($_GET);echo'</pre>';
		//date_from=2015-05-04&date_to=&town_from=&town_to=&cat%5B%5D=2&cat%5B%5D=11&cat%5B%5D=13
		
		$model->bids_filter_dates_from = $this->app->request->getParam('date_from', '');
		$model->bids_filter_dates_to = $this->app->request->getParam('date_to', '');
		
		$model->town_from = $this->app->request->getParam('town_from', '');
		$model->town_to = $this->app->request->getParam('town_to', '');
		
		$model->town_from = $this->app->request->getParam('town_from', '');
		$model->town_to = $this->app->request->getParam('town_to', '');
		if($model->validate())	{
			$filtering = true;
		}
		
		/*
		$filtering = false;
		if(isset($_GET['BidsFilter']))	{
			$model->attributes = $_GET['BidsFilter'];
			//echo'<pre>';print_r($model->attributes);echo'</pre>';
			if($model->validate())	{
				$this->app->session['bidslst.BidsFilter'] = $_GET['BidsFilter'];
				$filtering = true;
			}	else	{
				
			}
		}	elseif(isset($this->app->session['bidslst.BidsFilter']))	{
			$model->attributes = $this->app->session['bidslst.BidsFilter'];
			$filtering = true;

		}
		*/
		
		$BidsFilterCategories = array();
		/*
		if(isset($_GET['bids-filter-categories']))	{
			$this->app->session['bidslst.BidsFilterCategories'] = $_GET['bids-filter-categories'];
			$BidsFilterCategories = $_GET['bids-filter-categories'];
			$filtering = true;
		} elseif(isset($_GET['BidsFilter']) && !isset($_GET['bids-filter-categories']))	{
			unset($this->app->session['bidslst.BidsFilterCategories']);
			
		} elseif(isset($this->app->session['bidslst.BidsFilterCategories']))	{
			$BidsFilterCategories = $this->app->session['bidslst.BidsFilterCategories'];
			$filtering = true;
		}
		*/
		/*
		if(isset($_GET['bids-filter-categories']))	{
			$BidsFilterCategories = $_GET['bids-filter-categories'];
			$filtering = true;
		}
		*/
		if(isset($_GET['cat']))	{
			$BidsFilterCategories = $_GET['cat'];
			$filtering = true;
		}
		
		$join = array();
		$join[] = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		
		$criteria = new CDbCriteria;		
		$criteria->select = "t.*, u.username, u.last_activity";
		
		switch($type_sort) {
			case 'datepub':
				$criteria->order = 't.created DESC';
				break;
			case 'dateperevoz':
				$criteria->order = 't.date_transportation DESC';
				break;
			default:
				$criteria->order = 't.bid_id DESC';
			break;
		}
		
		//echo'<pre>';print_r($criteria->order);echo'</pre>';
		
		if($filtering === true)	{
			
			$condition_arr = array();

			if($model->bids_filter_dates_from != '')	{
				$condition_arr[] = "t.date_transportation >= '".$model->bids_filter_dates_from."'";
			}

			if($model->bids_filter_dates_to != '')	{
				$condition_arr[] = "t.date_transportation <= '".$model->bids_filter_dates_to."'";
			}
 
//			if($model->country_from != 'all' && $model->country_to != 'all')	{
//				$condition_arr[] = "t.loading_country = '".$model->country_from."' AND t.unloading_country = '".$model->country_to."'";
//			}	elseif($model->country_from != 'all' )	{
//				$condition_arr[] = "t.loading_country = '".$model->country_from."'";
//			}	elseif($model->country_to != 'all')	{
//				$condition_arr[] = "t.unloading_country = '".$model->country_to."'";
//			}
			
			if($model->town_from != '' && $model->town_to != '')	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."' AND t.unloading_town = '".$model->town_to."'";
			}	elseif($model->town_from != '' )	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."'";
			}	elseif($model->town_to != '')	{
				$condition_arr[] = "t.unloading_town = '".$model->town_to."'";
			}
			
			if(count($BidsFilterCategories)) {
				$condition_arr[] = "cc.category_id IN (".implode(', ', $BidsFilterCategories).")";
				
				$join[] = "INNER JOIN {{bids_cargoes}} AS bc USING (`bid_id`)";
				$join[] = "INNER JOIN {{cargoes_categories}} AS cc USING (`cargo_id`)";
			}

			if(count($condition_arr))	{
				$criteria->condition = implode(' AND ', $condition_arr);
			}
		}
		
		//echo'<pre>';print_r($condition_arr);echo'</pre>';die;
		
		$criteria->join = implode(' ', $join);
 
        $dataProvider = new CActiveDataProvider('Bids', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
                //'pageSize'=>5,
				'pageVar' =>'page',
            ),
        ));
		
		//echo'<pre>';print_r($dataProvider->data);echo'</pre>';
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		//echo'<pre>';print_r($bid_ids);echo'</pre>';die;
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		//echo'<pre>';print_r($cargoes_info);echo'</pre>';//die;
		
		$categories_list = Categories::model()->getCategoriesLevel1($connection);
		foreach($categories_list as &$i) {
			$checked = false;
			foreach($BidsFilterCategories as $cat) {
				if($i['id'] == $cat)	{
					$checked = true;
					break;
				}
			}
			if($checked === true)	{
				$i['checked'] = 1;
			}	else	{
				$i['checked'] = 0;
			}
			
		}
		
		//получаем инфу по кол-ву предложений по заявкам
		$deals_count_list = Deals::model()->getBidDealsCount($connection, $bid_ids);
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();
			$porters = false;
			
			$row->total_weight = 0;
			$row->total_volume = 0;
			$row->deals_count = isset($deals_count_list[$row->bid_id]) ? $deals_count_list[$row->bid_id] : 0;
			

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];

					if($cargo['porters'] == 1) {
						$porters = true;
					}
					
					$row->total_weight = $row->total_weight + $cargo['weight'];
					$row->total_unit = $cargo['unit'];
					$row->total_volume = $row->total_volume + $cargo['volume'];
					
					if($cargo['foto'] != '')	{
						$row->bid_foto = $cargo['foto'];
					}
				}
			}
			
			$row->full_name = implode('. ', $cargo_name);
			$row->need_porters = $porters;
			
		}
		
		//echo'<pre>';print_r($cargoes_info);echo'</pre>';
		
		$countries_list = array('all'=>'-- Страна --') + $this->app->params['countries'];

        if ($this->app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
            ));
            $this->app->end();
        } else {
            $this->render('index', array(
				'model' => $model,
				'countries_list' => $countries_list,
				'categories_list' => $categories_list,
                'dataProvider'=>$dataProvider,
                'type_sort'=>$type_sort,
                'page_info'=>$page_info,
            ));
        }		
	}
	
	
	/**
	 * Lists Category.
	 */
	public function actionCategory($id)
	{
		//echo'<pre>';print_r($id);echo'</pre>';
		
		
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		UpdateLastActivity($this->app, $connection);
		
		$model = new BidsFilter;
		
		//$rows_pages = Bids::model()->getBids();
		
		//$this->processPageRequest('page');
		processPageRequest('page');
		
		//$clear_bids_filter = $this->app->request->getParam('clear-bids-filter', 0);
		
		//if($clear_bids_filter)	{
			unset($this->app->session['bidslst.BidsFilter']);
			unset($this->app->session['bidslst.BidsFilterCategories']);
			//$this->redirect(array('index'));
		//}
		
		$type_sort = $this->app->request->getParam('type-sort', '');
		//$type_sort = '';
		
		
		
		if($type_sort != '')	{
			$this->app->session['bidslst.type_sort'] = $type_sort;
			//$this->redirect(array('index'));
		}	elseif(isset($this->app->session['bidslst.type_sort'])) {
			$type_sort = $this->app->session['bidslst.type_sort'];
		}	else	{
			$type_sort = 'datepub';
		}
		
		//echo'<pre>';print_r($_POST);echo'</pre>';
		
		$filtering = false;
		/*
		if(isset($_POST['BidsFilter']))	{
			$model->attributes = $_POST['BidsFilter'];
			//echo'<pre>';print_r($model->attributes);echo'</pre>';
			if($model->validate())	{
				$this->app->session['bidslst.BidsFilter'] = $_POST['BidsFilter'];
				$filtering = true;
			}	else	{
				
			}
		}	elseif(isset($this->app->session['bidslst.BidsFilter']))	{
			$model->attributes = $this->app->session['bidslst.BidsFilter'];
			$filtering = true;

		}
		*/
		
		$BidsFilterCategories = array($id);
		
		/*
		if(isset($_POST['bids-filter-categories']))	{
			$this->app->session['bidslst.BidsFilterCategories'] = $_POST['bids-filter-categories'];
			$BidsFilterCategories = $_POST['bids-filter-categories'];
			$filtering = true;
		} elseif(isset($_POST['BidsFilter']) && !isset($_POST['bids-filter-categories']))	{
			unset($this->app->session['bidslst.BidsFilterCategories']);
			
		} elseif(isset($this->app->session['bidslst.BidsFilterCategories']))	{
			$BidsFilterCategories = $this->app->session['bidslst.BidsFilterCategories'];
			$filtering = true;
		}
		*/
		$join = array();
		$join[] = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		
		$criteria = new CDbCriteria;		
		$criteria->select = "t.*, u.username, u.last_activity";
		
		switch($type_sort) {
			case 'datepub':
				$criteria->order = 't.created DESC';
				break;
			case 'dateperevoz':
				$criteria->order = 't.date_transportation DESC';
				break;
			default:
				$criteria->order = 't.bid_id DESC';
			break;
		}
		
		//echo'<pre>';print_r($criteria->order);echo'</pre>';
		/*
		if($filtering === true)	{
			
			$condition_arr = array();

			if($model->bids_filter_dates_from != '')	{
				$condition_arr[] = "t.date_transportation >= '".$model->bids_filter_dates_from."'";
			}

			if($model->bids_filter_dates_to != '')	{
				$condition_arr[] = "t.date_transportation <= '".$model->bids_filter_dates_to."'";
			}

			if($model->town_from != '' && $model->town_to != '')	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."' AND t.unloading_town = '".$model->town_to."'";
			}	elseif($model->town_from != '' )	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."'";
			}	elseif($model->town_to != '')	{
				$condition_arr[] = "t.unloading_town = '".$model->town_to."'";
			}
			
			if(count($BidsFilterCategories)) {
				$condition_arr[] = "cc.category_id IN (".implode(', ', $BidsFilterCategories).")";
				
				$join[] = "INNER JOIN {{bids_cargoes}} AS bc USING (`bid_id`)";
				$join[] = "INNER JOIN {{cargoes_categories}} AS cc USING (`cargo_id`)";
			}

			if(count($condition_arr))	{
				$criteria->condition = implode(' AND ', $condition_arr);
			}
		}
		*/
		
			if(count($BidsFilterCategories)) {
				$condition_arr[] = "cc.category_id IN (".implode(', ', $BidsFilterCategories).")";
				
				$join[] = "INNER JOIN {{bids_cargoes}} AS bc USING (`bid_id`)";
				$join[] = "INNER JOIN {{cargoes_categories}} AS cc USING (`cargo_id`)";
			}

			if(count($condition_arr))	{
				$criteria->condition = implode(' AND ', $condition_arr);
			}
		
		
		$criteria->join = implode(' ', $join);
 
        $dataProvider = new CActiveDataProvider('Bids', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>20,
				'pageVar' =>'page',
            ),
        ));
		
		//echo'<pre>';print_r($dataProvider->data);echo'</pre>';
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		//echo'<pre>';print_r($bid_ids);echo'</pre>';die;
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		//echo'<pre>';print_r($cargoes_info);echo'</pre>';//die;
		
		$categories_list = Categories::model()->getCategoriesLevel1($connection);
		foreach($categories_list as &$i) {
			$checked = false;
			foreach($BidsFilterCategories as $cat) {
				if($i['id'] == $cat)	{
					$checked = true;
					break;
				}
			}
			if($checked === true)	{
				$i['checked'] = 1;
			}	else	{
				$i['checked'] = 0;
			}
			
		}
		
		$this->getDealsInfo($dataProvider, $cargoes_info, $connection, $bid_ids);
		//echo'<pre>';print_r($id);echo'</pre>';die;
		//echo'<pre>';print_r($cargoes_info);echo'</pre>';

        if ($this->app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', array(
                'dataProvider'=>$dataProvider,
            ));
            $this->app->end();
        } else {
            $this->render('index', array(
				'model' => $model,
				'categories_list' => $categories_list,
                'dataProvider'=>$dataProvider,
                'type_sort'=>$type_sort,
            ));
        }		
	}
	
	
	protected function getDealsInfo(&$dataProvider, $cargoes_info, &$connection, $bid_ids)
	{
		//получаем инфу по кол-ву предложений по заявкам
		//echo'<pre>11111';print_r($bid_ids);echo'</pre>';die;
		$deals_count_list = Deals::model()->getBidDealsCount($connection, $bid_ids);
		
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();
			$porters = false;
			
			$row->total_weight = 0;
			$row->total_volume = 0;
			$row->deals_count = isset($deals_count_list[$row->bid_id]) ? $deals_count_list[$row->bid_id] : 0;
			

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];

					if($cargo['porters'] == 1) {
						$porters = true;
					}
					
					$row->total_weight = $row->total_weight + $cargo['weight'];
					$row->total_unit = $cargo['unit'];
					$row->total_volume = $row->total_volume + $cargo['volume'];
					
					if($cargo['foto'] != '')	{
						$row->bid_foto = $cargo['foto'];
					}
				}
			}
			
			$row->full_name = implode('. ', $cargo_name);
			$row->need_porters = $porters;
			
		}
		
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Bids the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Bids::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Запрашиваемая заявка отсутствует.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Bids $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bids-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function updateBid($bid_id, $deal_id, $field, $value, $performer_id, $message)
	{
		if($deal_id == 0)	{
			throw new CHttpException(500, 'Отсутствует ID предложения');
		}
		
		if($performer_id != -1)	{
			$connection = $this->app->db;
			Bids::model()->updatePerfomer($connection, $bid_id, $performer_id);
		}
		
		
		$deal_model = Deals::model()->findByPk($deal_id);
		
		if($deal_model->bid_id != $bid_id) {
			throw new CHttpException(500, 'Предложение не принаджежит заявке');
		}
		
		$this->app->user->setFlash('success', $message);
		
		$deal_model->deal_time = substr($deal_model->deal_time, 0, -3);
		$deal_model->$field = $value;
		$deal_model->save(false);
		
		$this->redirect(array('bids/view','id'=>$bid_id));
		
	}
	
	public function actionStep2form($category_id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;

		$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $category_id);
		//$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection);

		$this->renderPartial('step2form',array(
			'categories_list_level2'=>$categories_list_level2,
		));
	}
	
	public function actionStep3form($category_id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = new Cargoes;
		
		$model->category_id = $category_id;

		//подготавливаем выпадающий список наличия товара
		$model->DropDownUnitsList = Cargoes::model()->getDropDownUnitsList();
		$model->SelectedUnitsList = array();
		
		$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $category_id);
		//$categories_list = Categories::model()->getDropDownList($categories_list_level2);
		
		$categories_list = Categories::model()->getDropDownlistItemsOptGroup();
		
		//echo'<pre>';print_r($categories_list_level2);echo'</pre>';die;
		
		

		//$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $category_id);
		switch($category_id) {
			case 2:
				$layout = "step3form_2";
				break;
			default:
				$layout = "step3form_2";				
		}
		
		$this->renderPartial($layout, array(
			'model'=>$model,
			//'category_id'=>$category_id,
			'categories_list'=>$categories_list,
		));
	}
	
	public function actionUploadfoto()
	{
		$this->app = Yii::app();
		
		if(isset($this->app->session['bid_cargo_num'])) {
			$cargo_num = $this->app->session['bid_cargo_num'];
		}	else	{
			$cargo_num = 1;
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
		
		//$upload_path = Yii::getPathOfAlias('webroot').'/files/users/'.$this->app->user->id;
		$upload_path = Yii::getPathOfAlias('webroot').'/files/bids/';
		
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
			$json_arr['msg'] = 'Файл слишком велик.';
		}
		
		// Check if we can upload to the specified path, if not DIE and inform the user.
		if(!is_writable($upload_path)) {
			$allOk = false;
			$json_arr['res'] = 'err';
			$json_arr['msg'] = 'Ошибка доступа к каталогу.';
			
		}
		
		if($allOk)	{
			$filename_ = md5(strtotime('now'));
			$new_filename = 'full_'.$filename_.$ext;
			// Move the file if eveything checks out.
			if(move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_path . $new_filename)) {

				if(isset($this->app->session["bid_tmp_foto_$cargo_num"]))	{
					$tmp_name = $this->app->session["bid_tmp_foto_$cargo_num"];
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

				$this->app->session["bid_tmp_foto_$cargo_num"] = $filename_.$ext;
				
				$transport_imageLive = $this->app->homeUrl.'files/bids/';

				$json_arr['res'] = 'ok';
				$json_arr['msg'] = $transport_imageLive.'thumb_'.$filename_.$ext;
				$json_arr['foto'] = $filename_.$ext;
			} else {
				$json_arr['res'] = 'err';
				$json_arr['msg'] = 'Ошибка загрузки.';
			}
		}
		
		echo json_encode($json_arr);
		
		
		$this->app->end();
	}
				   
	
	public function actionSetcargonum($id)
	{
		$this->app = Yii::app();
		$this->app->session['bid_cargo_num'] = $id;
		$this->app->end();
	}
	
	
	public function createBidsCargoes($bid_id, $cargo_id)
	{
		$BidsCargoes = new BidsCargoes;
		$BidsCargoes->bid_id = $bid_id;
		$BidsCargoes->cargo_id = $cargo_id;
		$BidsCargoes->save();
	}
	
	public function createCargoesCategories($cargo_id, $category_id, $add_categories_info = array())
	{
		if(count($add_categories_info))	{
			$cargo_cat_id = $this->getCargoParentId($add_categories_info, $category_id);
			if($cargo_cat_id != 0)	{
				$CargoesCategories = new CargoesCategories;
				$CargoesCategories->cargo_id = $cargo_id;
				$CargoesCategories->category_id = $cargo_cat_id;
				$CargoesCategories->save();
			}
			
		}	else	{
			$CargoesCategories = new CargoesCategories;
			$CargoesCategories->cargo_id = $cargo_id;
			$CargoesCategories->category_id = $category_id;
			$CargoesCategories->save();			
		}
	}
	
	public function createPassword()
	{
		$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 

		// Количество символов в пароле. 

		$max=8; 

		// Определяем количество символов в $chars 

		$size=StrLen($chars)-1; 

		// Определяем пустую переменную, в которую и будем записывать символы. 

		$password=null; 

		// Создаём пароль. 

		while($max--) 
		$password.=$chars[rand(0,$size)];
		
		return $password;
	}
	
	public function addRouteItem($town = '', $address = '', &$route_arr)
	{
		if($town != '' && $address != '') {
			$route_arr[] = "'".$town.", ".$address."'";
		}
		
	}
	
    protected function processPageRequest($param='page')
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST[$param]))
            $_GET[$param] = Yii::app()->request->getPost($param);
    }
	
    //возвращает ИД родительской категории
	protected function getCargoParentId($rows=array(), $id)
    {
		$res = 0;
		if(count($rows))	{
			foreach($rows as $row)	{
				if($row['id'] == $id)	{
					$res = $row['parent_id'];
					break;
				}
			}
		}
		return $res;
    }
	
	/**
	 * Переводим TIMESTAMP в формат вида: 5 дн. назад
	 * или 1 мин. назад и тп.
	 *
	 * @param unknown_type $date_time
	 * @return unknown
	 */
	public function getTimeAgo($date_time)
	{
		$timeAgo = time() - strtotime($date_time);
		$timePer = array(
			'day' 	=> array(3600 * 24, 'дн.'),
			'hour' 	=> array(3600, ''),
			'min' 	=> array(60, 'мин.'),
			'sek' 	=> array(1, 'сек.'),
			);
		foreach ($timePer as $type =>  $tp) {
			$tpn = floor($timeAgo / $tp[0]);
			if ($tpn){
				
				switch ($type) {
					case 'hour':
						if (in_array($tpn, array(1, 21))){
							$tp[1] = 'час';
						}elseif (in_array($tpn, array(2, 3, 4, 22, 23)) ) {
							$tp[1] = 'часа';
						}else {
							$tp[1] = 'часов';
						}
						break;
				}
				return $tpn.' '.$tp[1].' назад';
			}
		}
	}
	
	
	//полует название заявки из названий всех грузов
	public function getBidName($bid_id = 0)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = $this->loadModel($bid_id);
		
		$cargoes = BidsCargoes::model()->getCargoresBids($connection, $model->bid_id);
		
		$bid_name_arr = array();
		foreach($cargoes as $cargo) {
			$bid_name_arr[] = $cargo['name'];
		}
		//echo'$bid_name_arr<pre>';print_r($bid_name_arr);echo'</pre>';die;

		return (implode('. ', $bid_name_arr));
		
	}
	
	public function sendNoticeNewDeal($user_id = 0, $bid_id, $bid_name, $dealer_id, $dealer_name)
	{
		$user_model = User::model()->findByPk($user_id);
		if($user_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки пользователя');
		}
		
		$data = array(
			'bid_url' => $this->createAbsoluteUrl('/bids/view', array('id'=>$bid_id)),
			'bid_name' => $bid_name,
			'user_name' => $user_model->username,
			'dealer_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$dealer_id)),
			'dealer_name' => $dealer_name,
			'subject' => "Новое предложение в Вашей заявке",
		);
		
		$email = $user_model->email;
		sendMail($email, 'emailNoticeNewDeal', $data);
	}
	
	//посылаем сообщение автору заявки
	public function sendNoticeNewPostBidAuthor($user_id = 0, $bid_id, $bid_name, $dealer_id, $dealer_name)
	{
		$user_model = User::model()->findByPk($user_id);
		if($user_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки пользователя');
		}
		
		$data = array(
			'bid_url' => $this->createAbsoluteUrl('/bids/view', array('id'=>$bid_id)),
			'bid_name' => $bid_name,
			'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$user_model->id)),
			'user_name' => $user_model->username,
			'dealer_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$dealer_id)),
			'dealer_name' => $dealer_name,
			'subject' => "Новое сообщение в Вашей заявке",
		);
		
		$email = $user_model->email;
		sendMail($email, 'emailNoticeNewPostBidAuthor', $data);
	}
	
	//посылаем сообщение автору предложения в заявке
	public function sendNoticeNewPostDealAuthor($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name)
	{
		$deal_model = Deals::model()->findByPk($deal_id);
		if($deal_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки предложения');
		}
		
		$dealer_model = User::model()->findByPk($deal_model->user_id);
		if($dealer_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки пользователя');
		}
		
		$data = array(
			'bid_url' => $this->createAbsoluteUrl('/bids/view', array('id'=>$bid_id)),
			'bid_name' => $bid_name,
			'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$user_id)),
			'user_name' => $user_name,
			'dealer_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$dealer_model->id)),
			'dealer_name' => $dealer_model->username,
			'subject' => "Новое сообщение в Вашем предложении",
		);
		
		$email = $dealer_model->email;
		sendMail($email, 'emailNoticeNewPostDealAuthor', $data);
	}
	
	//посылаем сообщение автору предложения при утверждении заявки
	public function sendNoticeAcceptDeal($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name)
	{
		$this->sendNoticeDealer($deal_id, $bid_id, $bid_name, $user_id, $user_name, "Ваше предложение принято", 'emailNoticeAcceptDeal');
	}
	
	//посылаем сообщение автору предложения при отмене утвержденой заявки
	public function sendNoticeCancelAcceptedDeal($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name)
	{
		$this->sendNoticeDealer($deal_id, $bid_id, $bid_name, $user_id, $user_name, "Ваше предложение отменено", 'emailNoticeCancelAcceptedDeal');
	}
	
	//посылаем сообщение автору предложения при отклонении заявки
	public function sendNoticeRejectDeal($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name)
	{
		$this->sendNoticeDealer($deal_id, $bid_id, $bid_name, $user_id, $user_name, "Ваше предложение отклонено", 'emailNoticeRejectDeal');
	}
	
	//посылаем сообщение автору предложения при отмене отклоненной заявки
	public function sendNoticeCancelRejectedDeal($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name)
	{
		$this->sendNoticeDealer($deal_id, $bid_id, $bid_name, $user_id, $user_name, "Ваше отклоненное предложение отменено", 'emailNoticeCancelRejectedDeal');
	}
	
	//посылаем сообщение автору предложения
	public function sendNoticeDealer($deal_id = 0, $bid_id, $bid_name, $user_id, $user_name, $subject, $tmpl)
	{
		$deal_model = Deals::model()->findByPk($deal_id);
		if($deal_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки предложения');
		}
		
		$dealer_model = User::model()->findByPk($deal_model->user_id);
		if($dealer_model === null)	{
			throw new CHttpException(500, 'Ошибка загрузки пользователя');
		}
		
		$data = array(
			'bid_url' => $this->createAbsoluteUrl('/bids/view', array('id'=>$bid_id)),
			'bid_name' => $bid_name,
			'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$user_id)),
			'user_name' => $user_name,
			'dealer_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$dealer_model->id)),
			'dealer_name' => $dealer_model->username,
			'subject' => $subject,
		);		
		$email = $dealer_model->email;
		sendMail($email, $tmpl, $data);
	}
	
}
