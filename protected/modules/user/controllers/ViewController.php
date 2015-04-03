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
		
		
		
		//echo'<pre>';var_dump($user_company,0);echo'</pre>';
		//die;
		$data = array(
			'model'=>$model,
			//'user_company'=>$user_company,
			'show_edit_btn'=>false,
		);
		switch($model->user_type) {
			case 2:
				$user_company = $model->perevozchik;
				if($user_company === null) {
					$user_company = new UsersPerevozchik;
				} 
			
				$dataProvider = $this->getTansportUser($user_id);
				$lastBidsUser = $this->getLastBidsUser($connection, $user_id, $model, 'performer_id');
				
				$data['dataProvider'] = $dataProvider;
				$data['lastBidsUser'] = $lastBidsUser;
				$data['user_company'] = $user_company;
			
				$tmpl = 'view_type2';
			
			
				break;
			default:
			case 1:			
				$tmpl = 'view_type1';
			
				$lastBidsUser = $this->getLastBidsUser($connection, $user_id, $model, 'user_id');
			
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
	
	public function getLastBidsUser(&$connection, $user_id, $model, $where_field = 'user_id')
	{
		if($where_field == 'performer_id')	{
			$join = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		}	else	{
			$join = "INNER JOIN {{users}} AS u ON t.`performer_id` = u.`id`";
		}
		$criteria = new CDbCriteria;

		$criteria->select = "t.*, u.`username`";		
		$criteria->join = $join;
		$criteria->order = 't.bid_id DESC';
		$criteria->condition = "`$where_field` = $user_id";

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
		
		//echo'<pre>';print_r($dataProvider->data);echo'</pre>';die;
		
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
			if($where_field == 'performer_id')	{
				$row->performer_name = $model->username;
			}	else	{
				$row->performer_name = $row->username;
				$row->username = $model->username;
			}
			//$row->need_porters = $porters;
			
		}
		
		
		return $dataProvider;
		
	}
}
