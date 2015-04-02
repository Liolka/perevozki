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
		
		$user_company = $model->company;
		//echo'<pre>';var_dump($user_company,0);echo'</pre>';
		if($user_company === null) {
			
			$user_company = new UsersCompanies;
			/*
			$user_company->phone1 = '';
			$user_company->phone2 = '';
			$user_company->phone3 = '';
			$user_company->phone4 = '';
			$user_company->email = '';
			$user_company->skype = '';
			$user_company->site = '';
			$user_company->type = '';
			$user_company->year = '';
			$user_company->count_auto = '';
			$user_company->count_staff = '';
			$user_company->terminals = '';
			*/
		} 
			
		
		//echo'<pre>';var_dump($user_company,0);echo'</pre>';
		//die;
		$data = array(
			'model'=>$model,
			'user_company'=>$user_company,
			'show_edit_btn'=>false,
		);
		switch($model->user_type) {
			case 2:
				$dataProvider = $this->getTansportUser($user_id);
				$lastBidsUser = $this->getLastBidsUser($connection, $user_id, $model);
			
				$data['dataProvider'] = $dataProvider;
				$data['lastBidsUser'] = $lastBidsUser;
			
				$tmpl = 'view_type2';
			
			
				break;
			default:
			case 1:
				$tmpl = 'view_type1';
				break;
			
		}
		$this->render($tmpl, $data );
//		$this->render('view',array(
//			'model'=>$model,
//		));
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
	
	public function getLastBidsUser(&$connection, $user_id, $model)
	{
		$criteria = new CDbCriteria;

		$criteria->select = "t.*, u.username";		
		$criteria->join = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";


		$criteria->join = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		$criteria->order = 't.bid_id DESC';
		$criteria->condition = "performer_id = $user_id";

		$dataProvider = new CActiveDataProvider('Bids', array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>5,
				'pageVar' =>'page',
			),
		));
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		//echo'<pre>';print_r($bid_ids);echo'</pre>';die;
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		
		$performer_reviews = ReviewsPerformers::model()->getPerfomerReviews($connection, $user_id);
		
		
		foreach($dataProvider->data as $row) {			
			$cargo_name = array();
			/*
			$porters = false;
			
			$row->total_weight = 0;
			$row->total_volume = 0;
			$row->deals_count = isset($deals_count_list[$row->bid_id]) ? $deals_count_list[$row->bid_id] : 0;
			*/

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];
					/*

					if($cargo['porters'] == 1) {
						$porters = true;
					}
					
					$row->total_weight = $row->total_weight + $cargo['weight'];
					$row->total_unit = $cargo['unit'];
					$row->total_volume = $row->total_volume + $cargo['volume'];
					*/
				}
			}
			
			if(isset($performer_reviews[$row->bid_id]))	{
				$row->review_text = $performer_reviews[$row->bid_id]['text'];
				$row->rating = $performer_reviews[$row->bid_id]['rating'];
				$row->good = $performer_reviews[$row->bid_id]['good'];
				$row->bad = $performer_reviews[$row->bid_id]['bad'];
			}	else	{
				$row->review_text = '';
				$row->rating = '';
				$row->good = '';
				$row->bad = '';
			}
			
			$row->full_name = implode('. ', $cargo_name);
			$row->performer_name = $model->username;
			//$row->need_porters = $porters;
			
		}
		
		
		return $dataProvider;
		
	}
}
