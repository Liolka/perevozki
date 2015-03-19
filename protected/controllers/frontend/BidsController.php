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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		//echo'<pre>';print_r($categories_list_level1);echo'</pre>';
		
		//echo'<pre>';print_r($_POST);echo'</pre>';die;

		if(isset($_POST['Bids']) && !isset($_POST['ajax'])) {
				//если пришли данные из последнего шага и без аякс-валидации
				
				//echo'<pre>';print_r($_POST['Bids']);echo'</pre>';die;
			
				$model->attributes = $_POST['Bids'];
			
				$create_bid = false;
			
				$msg = '';
			
				//echo'<pre>';print_r($model->scenario);echo'</pre>';die;
			
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
					
					//echo'<pre>';print_r($NewBid_Cargoes);echo'</pre>';die;
					
					$model->save(false);
					
					$cargo = new Cargoes;
					$cargo->name = $NewBid_Cargoes['name1'];
					$cargo->comment = $NewBid_Cargoes['comment1'];
					$cargo->weight = $NewBid_Cargoes['weight1'];
					$cargo->unit = $NewBid_Cargoes['unit1'];
					$cargo->porters = $NewBid_Cargoes['porters1'];
					//$cargo->foto = $NewBid_Cargoes['foto1'];
					$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor1'];
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
					
					if($msg == '' && $NewBid_Cargoes['name2'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name2'];
						$cargo->comment = $NewBid_Cargoes['comment2'];
						$cargo->weight = $NewBid_Cargoes['weight2'];
						$cargo->unit = $NewBid_Cargoes['unit2'];
						$cargo->porters = $NewBid_Cargoes['porters2'];
						//$cargo->foto = $NewBid_Cargoes['foto2'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor2'];
						$cargo->floor = $NewBid_Cargoes['floor2'];
						$cargo->length = $NewBid_Cargoes['length2'];
						$cargo->width = $NewBid_Cargoes['width2'];
						$cargo->height = $NewBid_Cargoes['height2'];
						$cargo->volume = $NewBid_Cargoes['volume2'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category2']);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}
						}
					}
					
					if($msg == '' && $NewBid_Cargoes['name3'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name3'];
						$cargo->comment = $NewBid_Cargoes['comment3'];
						$cargo->weight = $NewBid_Cargoes['weight3'];
						$cargo->unit = $NewBid_Cargoes['unit3'];
						$cargo->porters = $NewBid_Cargoes['porters3'];
						//$cargo->foto = $NewBid_Cargoes['foto3'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor3'];
						$cargo->floor = $NewBid_Cargoes['floor3'];
						$cargo->length = $NewBid_Cargoes['length3'];
						$cargo->width = $NewBid_Cargoes['width3'];
						$cargo->height = $NewBid_Cargoes['height3'];
						$cargo->volume = $NewBid_Cargoes['volume3'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category3']);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}
						}
					}
					
					if($msg == '' && $NewBid_Cargoes['name4'] != '') {
						$cargo = new Cargoes;
						$cargo->name = $NewBid_Cargoes['name4'];
						$cargo->comment = $NewBid_Cargoes['comment4'];
						$cargo->weight = $NewBid_Cargoes['weight4'];
						$cargo->unit = $NewBid_Cargoes['unit4'];
						$cargo->porters = $NewBid_Cargoes['porters4'];
						//$cargo->foto = $NewBid_Cargoes['foto4'];
						$cargo->lift_to_floor = $NewBid_Cargoes['lift_to_floor4'];
						$cargo->floor = $NewBid_Cargoes['floor4'];
						$cargo->length = $NewBid_Cargoes['length4'];
						$cargo->width = $NewBid_Cargoes['width4'];
						$cargo->height = $NewBid_Cargoes['height4'];
						$cargo->volume = $NewBid_Cargoes['volume4'];

						if($cargo->validate()) {
							$cargo->save();
							$this->createBidsCargoes($model->bid_id, $cargo->cargo_id);
							$this->createCargoesCategories($cargo->cargo_id, $NewBid_Cargoes['category4']);
						} else {
							foreach($model_reg->errors as $er) {
								$msg .= '<li>'.$er[0].'</li>';
							}


						}
					}
					
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
				/*
				$NewBid_Cargoes	= $this->app->session['NewBid.Cargoes'];
			
				$model_Cargoes = new Cargoes;
				
				$model_Cargoes->category1 = $this->app->session['NewBid.Cargoes']['category1'];
				$model_Cargoes->name1 = $this->app->session['NewBid.Cargoes']['name1'];
				$model_Cargoes->comment1 = $this->app->session['NewBid.Cargoes']['comment1'];
				$model_Cargoes->weight1 = $this->app->session['NewBid.Cargoes']['weight1'];
				$model_Cargoes->unit1 = $this->app->session['NewBid.Cargoes']['unit1'];
				$model_Cargoes->porters1 = $this->app->session['NewBid.Cargoes']['porters1'];
				$model_Cargoes->lift_to_floor1 = $this->app->session['NewBid.Cargoes']['lift_to_floor1'];
				$model_Cargoes->floor1 = $this->app->session['NewBid.Cargoes']['floor1'];
				$model_Cargoes->length1 = $this->app->session['NewBid.Cargoes']['length1'];
				$model_Cargoes->width1 = $this->app->session['NewBid.Cargoes']['width1'];
				$model_Cargoes->height1 = $this->app->session['NewBid.Cargoes']['height1'];
				$model_Cargoes->volume1 = $this->app->session['NewBid.Cargoes']['volume1'];
				
				$model_Cargoes->category2 = $this->app->session['NewBid.Cargoes']['category2'];
				$model_Cargoes->name2 = $this->app->session['NewBid.Cargoes']['name2'];
				$model_Cargoes->comment2 = $this->app->session['NewBid.Cargoes']['comment2'];
				$model_Cargoes->weight2 = $this->app->session['NewBid.Cargoes']['weight2'];
				$model_Cargoes->unit2 = $this->app->session['NewBid.Cargoes']['unit2'];
				$model_Cargoes->porters2 = $this->app->session['NewBid.Cargoes']['porters2'];
				$model_Cargoes->lift_to_floor2 = $this->app->session['NewBid.Cargoes']['lift_to_floor2'];
				$model_Cargoes->floor2 = $this->app->session['NewBid.Cargoes']['floor2'];
				$model_Cargoes->length2 = $this->app->session['NewBid.Cargoes']['length2'];
				$model_Cargoes->width2 = $this->app->session['NewBid.Cargoes']['width2'];
				$model_Cargoes->height2 = $this->app->session['NewBid.Cargoes']['height2'];
				$model_Cargoes->volume2 = $this->app->session['NewBid.Cargoes']['volume2'];
				
				$model_Cargoes->category3 = $this->app->session['NewBid.Cargoes']['category3'];
				$model_Cargoes->name3 = $this->app->session['NewBid.Cargoes']['name3'];
				$model_Cargoes->comment3 = $this->app->session['NewBid.Cargoes']['comment3'];
				$model_Cargoes->weight3 = $this->app->session['NewBid.Cargoes']['weight3'];
				$model_Cargoes->unit3 = $this->app->session['NewBid.Cargoes']['unit3'];
				$model_Cargoes->porters3 = $this->app->session['NewBid.Cargoes']['porters3'];
				$model_Cargoes->lift_to_floor3 = $this->app->session['NewBid.Cargoes']['lift_to_floor3'];
				$model_Cargoes->floor3 = $this->app->session['NewBid.Cargoes']['floor3'];
				$model_Cargoes->length3 = $this->app->session['NewBid.Cargoes']['length3'];
				$model_Cargoes->width3 = $this->app->session['NewBid.Cargoes']['width3'];
				$model_Cargoes->height3 = $this->app->session['NewBid.Cargoes']['height3'];
				$model_Cargoes->volume3 = $this->app->session['NewBid.Cargoes']['volume3'];
				
				$model_Cargoes->category4 = $this->app->session['NewBid.Cargoes']['category4'];
				$model_Cargoes->name4 = $this->app->session['NewBid.Cargoes']['name4'];
				$model_Cargoes->comment4 = $this->app->session['NewBid.Cargoes']['comment4'];
				$model_Cargoes->weight4 = $this->app->session['NewBid.Cargoes']['weight4'];
				$model_Cargoes->unit4 = $this->app->session['NewBid.Cargoes']['unit4'];
				$model_Cargoes->porters4 = $this->app->session['NewBid.Cargoes']['porters4'];
				$model_Cargoes->lift_to_floor4 = $this->app->session['NewBid.Cargoes']['lift_to_floor4'];
				$model_Cargoes->floor4 = $this->app->session['NewBid.Cargoes']['floor4'];
				$model_Cargoes->length4 = $this->app->session['NewBid.Cargoes']['length4'];
				$model_Cargoes->width4 = $this->app->session['NewBid.Cargoes']['width4'];
				$model_Cargoes->height4 = $this->app->session['NewBid.Cargoes']['height4'];
				$model_Cargoes->volume4 = $this->app->session['NewBid.Cargoes']['volume4'];
				*/
			
			
		} elseif(isset($_POST['Cargoes'])) {
			
			$this->app->session['NewBid.Cargoes'] = $_POST['Cargoes'];
			$model_Cargoes = null;
			
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
			
			/*
		} elseif(isset($this->app->session['NewBid.Cargoes'])) {
			
				$model_Cargoes = new Cargoes;
				
				$model_Cargoes->category1 = $this->app->session['NewBid.Cargoes']['category1'];
				$model_Cargoes->name1 = $this->app->session['NewBid.Cargoes']['name1'];
				$model_Cargoes->comment1 = $this->app->session['NewBid.Cargoes']['comment1'];
				$model_Cargoes->weight1 = $this->app->session['NewBid.Cargoes']['weight1'];
				$model_Cargoes->unit1 = $this->app->session['NewBid.Cargoes']['unit1'];
				$model_Cargoes->porters1 = $this->app->session['NewBid.Cargoes']['porters1'];
				$model_Cargoes->lift_to_floor1 = $this->app->session['NewBid.Cargoes']['lift_to_floor1'];
				$model_Cargoes->floor1 = $this->app->session['NewBid.Cargoes']['floor1'];
				$model_Cargoes->length1 = $this->app->session['NewBid.Cargoes']['length1'];
				$model_Cargoes->width1 = $this->app->session['NewBid.Cargoes']['width1'];
				$model_Cargoes->height1 = $this->app->session['NewBid.Cargoes']['height1'];
				$model_Cargoes->volume1 = $this->app->session['NewBid.Cargoes']['volume1'];
				
				$model_Cargoes->category2 = $this->app->session['NewBid.Cargoes']['category2'];
				$model_Cargoes->name2 = $this->app->session['NewBid.Cargoes']['name2'];
				$model_Cargoes->comment2 = $this->app->session['NewBid.Cargoes']['comment2'];
				$model_Cargoes->weight2 = $this->app->session['NewBid.Cargoes']['weight2'];
				$model_Cargoes->unit2 = $this->app->session['NewBid.Cargoes']['unit2'];
				$model_Cargoes->porters2 = $this->app->session['NewBid.Cargoes']['porters2'];
				$model_Cargoes->lift_to_floor2 = $this->app->session['NewBid.Cargoes']['lift_to_floor2'];
				$model_Cargoes->floor2 = $this->app->session['NewBid.Cargoes']['floor2'];
				$model_Cargoes->length2 = $this->app->session['NewBid.Cargoes']['length2'];
				$model_Cargoes->width2 = $this->app->session['NewBid.Cargoes']['width2'];
				$model_Cargoes->height2 = $this->app->session['NewBid.Cargoes']['height2'];
				$model_Cargoes->volume2 = $this->app->session['NewBid.Cargoes']['volume2'];
				
				$model_Cargoes->category3 = $this->app->session['NewBid.Cargoes']['category3'];
				$model_Cargoes->name3 = $this->app->session['NewBid.Cargoes']['name3'];
				$model_Cargoes->comment3 = $this->app->session['NewBid.Cargoes']['comment3'];
				$model_Cargoes->weight3 = $this->app->session['NewBid.Cargoes']['weight3'];
				$model_Cargoes->unit3 = $this->app->session['NewBid.Cargoes']['unit3'];
				$model_Cargoes->porters3 = $this->app->session['NewBid.Cargoes']['porters3'];
				$model_Cargoes->lift_to_floor3 = $this->app->session['NewBid.Cargoes']['lift_to_floor3'];
				$model_Cargoes->floor3 = $this->app->session['NewBid.Cargoes']['floor3'];
				$model_Cargoes->length3 = $this->app->session['NewBid.Cargoes']['length3'];
				$model_Cargoes->width3 = $this->app->session['NewBid.Cargoes']['width3'];
				$model_Cargoes->height3 = $this->app->session['NewBid.Cargoes']['height3'];
				$model_Cargoes->volume3 = $this->app->session['NewBid.Cargoes']['volume3'];
				
				$model_Cargoes->category4 = $this->app->session['NewBid.Cargoes']['category4'];
				$model_Cargoes->name4 = $this->app->session['NewBid.Cargoes']['name4'];
				$model_Cargoes->comment4 = $this->app->session['NewBid.Cargoes']['comment4'];
				$model_Cargoes->weight4 = $this->app->session['NewBid.Cargoes']['weight4'];
				$model_Cargoes->unit4 = $this->app->session['NewBid.Cargoes']['unit4'];
				$model_Cargoes->porters4 = $this->app->session['NewBid.Cargoes']['porters4'];
				$model_Cargoes->lift_to_floor4 = $this->app->session['NewBid.Cargoes']['lift_to_floor4'];
				$model_Cargoes->floor4 = $this->app->session['NewBid.Cargoes']['floor4'];
				$model_Cargoes->length4 = $this->app->session['NewBid.Cargoes']['length4'];
				$model_Cargoes->width4 = $this->app->session['NewBid.Cargoes']['width4'];
				$model_Cargoes->height4 = $this->app->session['NewBid.Cargoes']['height4'];
				$model_Cargoes->volume4 = $this->app->session['NewBid.Cargoes']['volume4'];
			
				$model_Cargoes->DropDownUnitsList = Cargoes::model()->getDropDownUnitsList();
				$model_Cargoes->SelectedUnitsList = array();
			
				
			
				
				
				//echo'<pre>';print_r($categories_list);echo'</pre>';//die;
				//echo'<pre>';print_r($this->app->session['NewBid.Cargoes']);echo'</pre>';die;
				//echo'<pre>';print_r($model_Cargoes->attributes);echo'</pre>';die;
			
				$form = '_form1_full';
				$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);
				$categories_list_level2 = Categories::model()->getCategoriesFromIds($connection, $model_Cargoes->category1);
				$categories_list = Categories::model()->getDropDownList($categories_list_level2);
				$data = array(
					'category_id'=>$this->app->session['NewBid.Cargoes']['category_id'],
					'model'=>$model,
					'form'=>$form,
					'model_Cargoes'=>$model_Cargoes,
					'categories_list_level1'=>$categories_list_level1,				
					'categories_list_level2'=>$categories_list_level2,				
					'categories_list'=>$categories_list,			
				);
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

		$this->render('create', $data);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Bids');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
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
	
	public function actionStep2form($category_id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;

		$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $category_id);

		$this->renderPartial('step2form',array(
			'categories_list_level2'=>$categories_list_level2,
		));
	}
	
	public function actionStep3form($category_id)
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = new Cargoes;
		
		//подготавливаем выпадающий список наличия товара
		$model->DropDownUnitsList = Cargoes::model()->getDropDownUnitsList();
		$model->SelectedUnitsList = array();
		
		$categories_list_level2 = Categories::model()->getCategoriesLevel2($connection, $category_id);
		$categories_list = Categories::model()->getDropDownList($categories_list_level2);
		
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
			'category_id'=>$category_id,
			'categories_list'=>$categories_list,
		));
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
	
	
	
}
