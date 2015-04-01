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
		$model = $this->loadModel();
		//echo'<pre>';print_r($model,0);echo'</pre>';
		
		$data = array(
			'model'=>$model,			
		);
		switch($model->user_type) {
			case 2:
				//$model = new Transport;

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
			
			
				$data['user_company'] = $model->company;
				$data['show_edit_btn'] = false;
				$data['dataProvider'] = $dataProvider;
			
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
}
