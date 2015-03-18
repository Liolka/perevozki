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
		$model=new Bids;
		$this->app = Yii::app();
		$connection = $this->app->db;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		
		//echo'<pre>';print_r($categories_list_level1);echo'</pre>';

		//if(isset($_POST['Bids']))
		if(isset($_POST['Cargoes'])) {
			
			//echo'<pre>';print_r($_POST);echo'</pre>';die;
			
			$form = '_form_f';
			$data = array(
				'model'=>$model,
				'form'=>$form,
				'categories_list_level1'=>array(),
				
			);
			/*
			$model->attributes=$_POST['Bids'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->bid_id));
			*/
		} else {
			$form = '_form';
			$categories_list_level1 = Categories::model()->getCategoriesLevel1($connection);
			$data = array(
				'model'=>$model,
				'form'=>$form,
				'categories_list_level1'=>$categories_list_level1,				
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
	
}
