<?php
class RequestsController extends Controller
{
	
	public $defaultAction = 'index';
	public $current_controller = '';
	public $current_action = '';
	public $theme_baseUrl = '';
	public $request_baseUrl = '';
	public $app = null;
	
	public function actionIndex()
	{
		$this->app = Yii::app();
		$connection = $this->app->db;
		
		//$model = $this->loadModel();
		//echo'<pre>';print_r($model,0);echo'</pre>';
		$user_id = $this->app->request->getParam('id', 0);
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->layout = '//layouts/column2r';
		echo'<pre>';print_r($user_id,0);echo'</pre>';
		echo'<pre>----------------------------</pre>';
		//throw new CHttpException(500, 'Ошибка доступа');
		//$this->render('index');
	}
	
}