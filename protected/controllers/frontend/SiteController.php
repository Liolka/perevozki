<?php
class SiteController extends Controller
{
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	public $layout='//layouts/column2';
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->layout = '//layouts/column2r';
		$this->render('index');
	}
	
	public function actionPerevezu()
	{
		$this->render('perevezy');
	}
	
	public function actionZakazhu()
	{
		$this->render('zakazhu');
	}
	
	public function actionEmptypage()
	{
		$this->render('empty-page');
	}
	
	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		//echo'<pre>';print_r(Yii::app()->dpsMailer);echo'</pre>';die;
		/*
		Yii::app()->dpsMailer->sendByView(
			//array( 'aldegtyarev@yandex.ru' => 'получатель' ), // определяем кому отправляется письмо
			array( 'aldegtyarev@yandex.ru'), // определяем кому отправляется письмо
			'emailTpl', // view шаблона письма
			array(
				'sUsername' => 'Участник',
				//'sLogoPicPath' => '/path/to/logo.gif',
				//'sFilePath' => '/path/to/attachment.txt',
			)
		);
		*/
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";
				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		
 		
		
		$this->render('contact',array('model'=>$model));
	}
	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	
	public function actionGetrandomreviews()
	{
		$rows = Bids::model()->getRandomReviews(Yii::app()->db);
		$fields_arr = array('user_review', 'performer_review');
		foreach($rows as &$row)	{
			$rand_field = array_rand($fields_arr, 1);
			if($fields_arr[$rand_field] == 'user_review')	{
				$row['text'] = $row['user_review'] ? $row['user_review'] : $row['performer_review'];
			}	else	{
				$row['text'] = $row['performer_review'] ? $row['performer_review'] : $row['user_review'];
			}
		}

		$this->renderPartial('reviews_list',array('rows'=>$rows));
	}
	
	//аякс запрос на добавление отзыва
	public function actionAddnewreview()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$u_id = $this->app->request->getParam('u-id', '');
		
		if($u_id == $this->app->user->id)	{
			$review_text = $this->app->request->getParam('review-text', '');
			$rating_value = $this->app->request->getParam('rating-value', '');
			$bid_id = $this->app->request->getParam('bid-id', 0);
			$field = $this->app->request->getParam('fld', '');

			$form = new ReviewForm;
			$form->rating = $rating_value;
			$form->comment = strip_tags($review_text);			
			if($form->validate())	{
				$review = $field.'_review';
				$rating = $field.'_rating';
				$model = Bids::model()->findByPk($bid_id);
				
				$count_reviews_prev = Bids::model()->getCountReviews($connection, 'user', $model->performer_id);
				//$count_reviews_prev = array(20, 1);
				
				if($model->$rating == 0 && $model->$review == '')	{
					$model->$rating = $form->rating;
					$model->$review = $form->comment;
					$model->save(false);
					
					if($field == 'user')	{
						$user_id = 'performer_id';
						$author_id = 'user_id';
					}	else	{
						$user_id = 'user_id';
						$author_id = 'performer_id';
					}
					
					$user_model = User::model()->findByPk($model->$user_id);

					$cargoes = BidsCargoes::model()->getCargoresBids($connection, $model->bid_id);

					$bid_name_arr = array();
					foreach($cargoes as $cargo) {
						$bid_name_arr[] = $cargo['name'];
					}
					$bid_name = implode('. ', $bid_name_arr);
					
					if($user_model != null)	{
						
						if($user_model->rating == 0 )	{
							$user_model->rating = $form->rating;
						}	else	{
							$user_model->rating = ($user_model->rating + $form->rating) / 2;
							$user_model->done_carriage++;
						}
						if($user_model->done_carriage == 10) 
							$user->reliability = $user->reliability + 15;
						
						$count_reviews = Bids::model()->getCountReviews($connection, 'user', $model->performer_id);
						//$count_reviews = array(19, 1);
						
						if(($count_reviews_prev[0] / $count_reviews_prev[1] < 20) && ($count_reviews[0] / $count_reviews[1] >= 20))	{
							$user_model->reliability = $user_model->reliability + 20;
						}	elseif(($count_reviews_prev[0] / $count_reviews_prev[1] >= 20) && ($count_reviews[0] / $count_reviews[1] < 20))	{
							$user_model->reliability = $user_model->reliability - 20;
						}
						//echo'<pre>';print_r($count_reviews_prev,0);echo'</pre>';
						//echo'<pre>';print_r($count_reviews,0);echo'</pre>';
						//die;
						//echo'<pre>';print_r($model->performer_id,0);echo'</pre>';
						//echo'<pre>';print_r($count_reviews,0);echo'</pre>';die;
						
						$user_model->save(false);
					}
					
					$author_model = User::model()->findByPk($model->$author_id);
					
					$this->sendNoticeReview($bid_id, $bid_name, $user_model->username, $user_model->id, $user_model->email, $author_model->username, $author_model->id, $author_model->email);
					
					$this->app->user->setFlash('success', 'Ваш отзыв успешно размещён.');
					echo 'ok';
				}	else	{
					echo 'Ошибка';
				}

			}	else	{
				$err = array();
				foreach($form->errors as $msg)	{
					$err[] = $msg[0];
				}
				echo implode(' ', $err);
			}
		}	else	{
			throw new CHttpException(500, 'Ошибка доступа');
		}
	}
	
	//посылаем сообщение автору предложения
	public function sendNoticeReview($bid_id, $bid_name, $user_name, $user_id, $user_email, $author_name, $author_id, $author_email)
	{
		
		$data = array(
			'bid_url' => $this->createAbsoluteUrl('/bids/view', array('id'=>$bid_id)),
			'bid_name' => $bid_name,
			'user_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$user_id)),
			'user_name' => $user_name,
			'author_url' => $this->createAbsoluteUrl('/user/view', array('id'=>$author_id)),
			'author_name' => $author_name,
			'my_url' => $this->createAbsoluteUrl('/user/my'),
			'subject' =>'Публикация нового отзыва',
		);		
		$email = $user_email;
		$tmpl = 'emailNoticeReview';
		sendMail($email, $tmpl, $data);
	}
	
	
	
}