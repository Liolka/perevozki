<?php

class ViewController extends Controller
{
	
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	
	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}	

	/**
	 * Displays a particular model.
	 */
	public function actionIndex()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		$model = $this->loadModel();
		//echo'<pre>';print_r($model,0);echo'</pre>';
		$user_id = $this->app->request->getParam('id', 0);
		/*
		$review_text = $this->app->request->getParam('review-text', '');
		$review_value = $this->app->request->getParam('review-value', 0);
		$bid_id = $this->app->request->getParam('bid-id', 0);
		$performer_id = $this->app->request->getParam('performer-id', 0);
		
		if($review_text != '' && $review_value != 0 && $bid_id != 0 && $performer_id != 0 && $user_id == $this->app->user->id)	{
			$reviewForm = new ReviewForm;
			$reviewForm->comment = $review_text;
			if($reviewForm->validate())	{
				$reviews_performers = new ReviewsPerformers;
				$reviews_performers->bid_id = $bid_id;
				$reviews_performers->performer_id = $performer_id;
				$reviews_performers->author_id = $this->app->user->id;
				$reviews_performers->text = $review_text;
				$reviews_performers->review_value = $review_value;
				$reviews_performers->save(false);
				$this->app->user->setFlash('success', "Ваш отзыв успешно размещен.");
				$this->redirect(array('index','id'=>$user_id));
			}
		}
		*/	
		
		$filter = 'actual';
		$orderBy = "t.`created` DESC";
		
		//echo'<pre>';var_dump($user_company,0);echo'</pre>';
		//die;
		$data = array(
			'model'=>$model,
			//'user_company'=>$user_company,
			'show_edit_btn'=>false,
			'user_status' => $model->user_status,
		);
		switch($model->user_type) {
			case 2:
				$user_company = $model->perevozchik;
				if($user_company === null) {
					$user_company = new UsersPerevozchik;
				} 
			
				$dataProvider = $this->getTansportUser($user_id);
				//$lastBidsUser = Bids::model()->getBidsUser($connection, $user_id, $model, 'performer_id');
				$lastBidsUser = Bids::model()->getBidsPerevozchik($connection, $user_id, $model, 5, $orderBy, $filter);
				
				$data['dataProvider'] = $dataProvider;
				$data['lastBidsUser'] = $lastBidsUser;
				$data['user_company'] = $user_company;
				$data['reviewsStat'] = ReviewsPerformers::model()->getUserReviewsStatistic($connection, $user_id);
			
				$tmpl = 'view_type2';
				break;
			
			default:
			case 1:	
				$tmpl = 'view_type1';
			
				//$lastBidsUser = Bids::model()->getBidsUser($connection, $user_id, $model, 'user_id');
				$lastBidsUser = Bids::model()->getBidsGruzodatel($connection, $user_id, $model, 'user_id', 5, $orderBy, $filter);
				
				//echo'<pre>';print_r($lastBidsUser,0);echo'</pre>';
			
				$user_company = $model->gruzodatel;
				if($user_company === null) {
					$user_company = new UsersGruzodatel;
				}
			
				$data['user_company'] = $user_company;
				$data['lastBidsUser'] = $lastBidsUser;
			
				break;
			
		}
		$this->render($tmpl, $data );
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
				$this->_model=User::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the primary key value. Defaults to null, meaning using the 'id' GET variable
	 */
	public function loadUser($id=null)
	{
		if($this->_model===null)
		{
			if($id!==null || isset($_GET['id']))
				$this->_model=User::model()->findbyPk($id!==null ? $id : $_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}
	
	
	public function getTansportUser($user_id)
	{
		$criteria = new CDbCriteria;
		$criteria->select = "transport_id, name, foto, carrying, length, width, height, volume, body_type, loading_type, comment";
		$criteria->order = 'transport_id DESC';
		$criteria->condition = "user_id = $user_id";

		$dataProvider = new CActiveDataProvider('Transport', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>50,
				'pageVar' =>'page',
			),
		));
		return $dataProvider;
		
	}
	
}
