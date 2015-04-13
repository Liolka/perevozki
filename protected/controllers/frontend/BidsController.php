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
		
		$deals = new Deals();
		
		if(isset($_POST['Deals'])) {
			$deals->attributes = $_POST['Deals'];
			$deals->bid_id = $id;
			$deals->user_id = $this->app->user->id;
			if($deals->validate())	{
				$deals->save(false);
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
				$this->app->user->setFlash('success', 'Ваше сообщение размещено.');
			}
			$this->redirect(array('bids/view','id'=>$id));
		}
		
		
		$model = $this->loadModel($id);
		$user_info = User::model()->getUserName($connection, $model->user_id);
		$model->username = $user_info['username'];
		$model->user_rating = $user_info['rating'];
		$cargoes = BidsCargoes::model()->getCargoresBids($connection, $model->bid_id);
		
		$bid_name_arr = array();
		foreach($cargoes as $cargo) {
			$bid_name_arr[] = $cargo['name'];
		}
		
		$bid_name = implode('. ', $bid_name_arr);
		
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
		
		$this->updateBid($id, $deal_id, 'accepted', 1, $performer_id, 'Предложение принято.');
	}
	
	//отменить принятую заявку
	public function actionCancelaccepteddeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = 0;
		
		$this->updateBid($id, $deal_id, 'accepted', 0, $performer_id, 'Выбранное предложение отменено.');		
	}

	//отклонить заявку
	public function actionRejectdeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = -1;
		
		$this->updateBid($id, $deal_id, 'rejected', 1, $performer_id, 'Предложение отклонено.');	
	}

	//отменить отклонение заявки
	public function actionCancelrejecteddeal($id)
	{
		$this->app = Yii::app();
		$deal_id = $this->app->request->getParam('deal_id', 0);
		$performer_id = -1;
		
		$this->updateBid($id, $deal_id, 'rejected', 0, $performer_id, 'Отклоненное предложение восстановлено.');	
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

		if(isset($_POST['Bids']) && !isset($_POST['ajax'])) {
				//если пришли данные из последнего шага и без аякс-валидации
				$model->attributes = $_POST['Bids'];
				$create_bid = false;
				$msg = '';
				if($model->validate()) {
					//валидация входных данных успешна
					$bidMessageSuccess = 'Ваша заявка успешно размещена';
					
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

							//$model_reg->attributes=$_POST['RegistrationForm'];
							$model_reg->username = $model->bid_name;
							$model_reg->email = $model->bid_email;
							$model_reg->password = $this->createPassword();
							$model_reg->verifyPassword = $model_reg->password;
							$model_reg->accept_rules = 1;
							//echo'<pre>';print_r($model->attributes);echo'</pre>';die;
							$profile->attributes = array();
							//var_dump($model_reg->validate());//die;
							//echo'<pre>';print_r($model->bid_name);echo'</pre>';die;
							//echo'<pre>';print_r($model_reg);echo'</pre>';die;
							if($model_reg->validate()) {
								$soucePassword = $model_reg->password;
								$model_reg->activkey=UserModule::encrypting(microtime().$model_reg->password);
								$model_reg->password=UserModule::encrypting($model_reg->password);
								$model_reg->verifyPassword=UserModule::encrypting($model_reg->verifyPassword);
								$model_reg->superuser=0;
								//$model_reg->status=((Yii::app()->controller->module->activeAfterRegister)?User::STATUS_ACTIVE:User::STATUS_NOACTIVE);
								$model_reg->status=User::STATUS_NOACTIVE;

								$model_reg->user_type = 1;
								$model_reg->user_status = 1;

								if ($model_reg->save()) {
									$profile->user_id=$model_reg->id;
									$profile->save();
									//if (Yii::app()->controller->module->sendActivationMail) {
										$activation_url = $this->createAbsoluteUrl('/user/activation/activation',array("activkey" => $model_reg->activkey, "email" => $model_reg->email));
										UserModule::sendMail($model_reg->email,UserModule::t("You registered from {site_name}",array('{site_name}'=>Yii::app()->name)),UserModule::t("Please activate you account go to {activation_url}",array('{activation_url}'=>$activation_url)).' 
										Пароль для входа: '.$soucePassword);
									//}

									/*

									if ((Yii::app()->controller->module->loginNotActiv||(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false))&&Yii::app()->controller->module->autoLogin) {
											$identity=new UserIdentity($model_reg->username,$soucePassword);
											$identity->authenticate();
											Yii::app()->user->login($identity,0);
											$this->redirect(Yii::app()->controller->module->returnUrl);
									} else {
									*/

										/*
										if (!Yii::app()->controller->module->activeAfterRegister&&!Yii::app()->controller->module->sendActivationMail) {
											Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Contact Admin to activate your account."));
										} elseif(Yii::app()->controller->module->activeAfterRegister&&Yii::app()->controller->module->sendActivationMail==false) {
											Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please {{login}}.",array('{{login}}'=>CHtml::link(UserModule::t('Login'),Yii::app()->controller->module->loginUrl))));
										} elseif(Yii::app()->controller->module->loginNotActiv) {
											Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
										} else {
											Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email."));
										}
										*/
										Yii::app()->user->setFlash('registration',UserModule::t("Thank you for your registration. Please check your email or login."));
										//$this->refresh();
										//$this->renderPartial($layout, array('model'=>$model,'profile'=>$profile));die;
									//}
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
			
				if($create_bid) {
					$NewBid_Cargoes	= $this->app->session['NewBid.Cargoes'];
					$model->save(false);
					
					$cargo = new Cargoes;
					$cargo->name = $NewBid_Cargoes['name1'];
					$cargo->comment = $NewBid_Cargoes['comment1'];
					$cargo->weight = $NewBid_Cargoes['weight1'];
					$cargo->unit = $NewBid_Cargoes['unit1'];
					$cargo->foto = $NewBid_Cargoes['foto1'];
					$cargo->porters = $NewBid_Cargoes['porters1'];
					$cargo->foto = $NewBid_Cargoes['foto1'];
					$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor1'];
					$cargo->lift = $NewBid_Cargoes['lift1'];
					$cargo->floor = $NewBid_Cargoes['floor1'];
					$cargo->length = $NewBid_Cargoes['length1'];
					$cargo->width = $NewBid_Cargoes['width1'];
					$cargo->height = $NewBid_Cargoes['height1'];
					$cargo->volume = $NewBid_Cargoes['volume1'];
					
					if($cargo->validate()) {
						$cargo->save();
						$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
						foreach($NewBid_Cargoes['category1'] as $category_id) {
							$this->createCargoesCategories($cargo->cargo_id, $category_id);
						}
						
					} else {
						foreach($model_reg->errors as $er) {
							$msg .= '<li>'.$er[0].'</li>';
						}
					}
					
					unset($this->app->session['bid_tmp_foto_1']);
					
					if($msg == '' && $NewBid_Cargoes['name2'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name2'];
						$cargo->comment = $NewBid_Cargoes['comment2'];
						$cargo->weight = $NewBid_Cargoes['weight2'];
						$cargo->unit = $NewBid_Cargoes['unit2'];
						$cargo->foto = $NewBid_Cargoes['foto2'];
						$cargo->porters = $NewBid_Cargoes['porters2'];
						$cargo->foto = $NewBid_Cargoes['foto2'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor2'];
						$cargo->lift = $NewBid_Cargoes['lift2'];
						$cargo->floor = $NewBid_Cargoes['floor2'];
						$cargo->length = $NewBid_Cargoes['length2'];
						$cargo->width = $NewBid_Cargoes['width2'];
						$cargo->height = $NewBid_Cargoes['height2'];
						$cargo->volume = $NewBid_Cargoes['volume2'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							//$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category2']);
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
						$cargo->weight = $NewBid_Cargoes['weight3'];
						$cargo->unit = $NewBid_Cargoes['unit3'];
						$cargo->foto = $NewBid_Cargoes['foto3'];
						$cargo->porters = $NewBid_Cargoes['porters3'];
						$cargo->foto = $NewBid_Cargoes['foto3'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor3'];
						$cargo->lift = $NewBid_Cargoes['lift3'];
						$cargo->floor = $NewBid_Cargoes['floor3'];
						$cargo->length = $NewBid_Cargoes['length3'];
						$cargo->width = $NewBid_Cargoes['width3'];
						$cargo->height = $NewBid_Cargoes['height3'];
						$cargo->volume = $NewBid_Cargoes['volume3'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							//$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category3']);
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
						$cargo->weight = $NewBid_Cargoes['weight4'];
						$cargo->unit = $NewBid_Cargoes['unit4'];
						$cargo->foto = $NewBid_Cargoes['foto4'];
						$cargo->porters = $NewBid_Cargoes['porters4'];
						$cargo->foto = $NewBid_Cargoes['foto4'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor4'];
						$cargo->lift = $NewBid_Cargoes['lift4'];
						$cargo->floor = $NewBid_Cargoes['floor4'];
						$cargo->length = $NewBid_Cargoes['length4'];
						$cargo->width = $NewBid_Cargoes['width4'];
						$cargo->height = $NewBid_Cargoes['height4'];
						$cargo->volume = $NewBid_Cargoes['volume4'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							//$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category4']);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}


						}
					}
					
					unset($this->app->session['bid_tmp_foto_4']);
					unset($this->app->session['bid_cargo_num']);
					
					$form = '_form';
					$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);

					$this->app->user->setFlash('bidMessageSuccess', $bidMessageSuccess);

					$data = array(
						'category_id'=>'0',
						'model'=>$model,
						'form'=>$form,
						'model_Cargoes'=>null,
						'categories_list_level1'=>$categories_list_level1,
						'categories_list_level2'=>array(),
						'categories_list'=>array(),

					);
					
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
			
			//echo'<pre>';print_r($_POST);echo'</pre>';die;
			
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	/*
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bids']))
		{
			$model->attributes=$_POST['Bids'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->bid_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	*/
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	/*
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	*/
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = new BidsFilter;
		
		//$rows_pages = Bids::model()->getBids();
		
		//$this->processPageRequest('page');
		processPageRequest('page');
		
		$clear_bids_filter = $this->app->request->getParam('clear-bids-filter', 0);
		if($clear_bids_filter)	{
			unset($this->app->session['bidslst.BidsFilter']);
			unset($this->app->session['bidslst.BidsFilterCategories']);
			$this->redirect(array('index'));
		}
		
		$type_sort = $this->app->request->getParam('type-sort', '');
		
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
		
		$BidsFilterCategories = array();
		
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
		
		
		$criteria = new CDbCriteria;
		
		$criteria->select = "t.*, u.username";
		
		$criteria->join = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		
		
		
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

			if($model->town_from != '' && $model->town_to != '')	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."' AND t.unloading_town = '".$model->town_to."'";
			}	elseif($model->town_from != '' )	{
				$condition_arr[] = "t.loading_town = '".$model->town_from."'";
			}	elseif($model->town_to != '')	{
				$condition_arr[] = "t.unloading_town = '".$model->town_to."'";
			}
			
			if(count($BidsFilterCategories)) {
				$condition_arr[] = "t.category_id IN (".implode(', ', $BidsFilterCategories).")";
			}

			if(count($condition_arr))	{
				$criteria->condition = implode(' AND ', $condition_arr);
			}
		}
		
		
		
 
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

	/**
	 * Manages all models.
	 */
	/*
	public function actionAdmin()
	{
		$model=new Bids('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bids']))
			$model->attributes=$_GET['Bids'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	*/

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
			throw new CHttpException(404,'The requested page does not exist.');
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
			/*
			$bid_model = $this->loadModel($bid_id);
			//echo'<pre>';print_r($bid_model);echo'</pre>';die;
			$bid_model->performer_id = $performer_id;
			$bid_model->time_transportation = substr($bid_model->time_transportation, 0, -3);
			$bid_model->save();
			*/
		}
		
		
		$deal_model = Deals::model()->findByPk($deal_id);
		
		if($deal_model->bid_id != $bid_id) {
			throw new CHttpException(500, 'Предложение не принаджежит заявке');
		}
		
		$this->app->user->setFlash('success', $message);
		
		$deal_model->deal_time = substr($deal_model->deal_time, 0, -3);
		$deal_model->$field = $value;
		$deal_model->save();
		
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
	
	public function createCargoesCategories($cargo_id, $category_id)
	{
		$CargoesCategories = new CargoesCategories;
		$CargoesCategories->cargo_id = $cargo_id;
		$CargoesCategories->category_id = $category_id;
		$CargoesCategories->save();
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
							$tp[1] = 'часa';
						}else {
							$tp[1] = 'часов';
						}
						break;
				}
				return $tpn.' '.$tp[1].' назад';
			}
		}
	}	
}
