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
		
		UpdateLastActivity($this->app, $connection);			
		
		//$model = $this->loadModel();
		//echo'<pre>';print_r($model,0);echo'</pre>';
		$user_id = $this->app->request->getParam('id', 0);
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->layout = '//layouts/column2r';
		//echo'<pre>';print_r($user_id,0);echo'</pre>';
		//echo'<pre>----------------------------</pre>';
		
		$user_model = User::model()->findbyPk($user_id);
		
		$data = array(
			'user_model' => $user_model
		);
		if($user_model === null)
				throw new CHttpException(404, 'Пользователь с данным ID отсутствует');
		
		processPageRequest('page');
		
		$filter = 'all';
		$orderBy = "t.`created` DESC";		
		
		switch($user_model->user_type) {
			case 2:
				$tmpl = 'requests_type2';
			
				$dataProvider = Bids::model()->getBidsPerevozchik($connection, $user_id, $user_model, 5, $orderBy, $filter);				
				$data['dataProvider'] = $dataProvider;
				$data['itemView'] = '_view_type2';
				
				break;
			default:
			case 1:	
				$tmpl = 'requests_type1';
			
				$dataProvider = Bids::model()->getBidsGruzodatel($connection, $user_id, $user_model, 'user_id', 5, $orderBy, $filter);
				$data['dataProvider'] = $dataProvider;
				$data['itemView'] = '_view_type1';
				break;
			
		}
		//$this->render($tmpl, $data );
		//echo'<pre>';print_r($data,0);echo'</pre>';die;
        if ($this->app->request->isAjaxRequest){
            $this->renderPartial('_loopAjax', $data);
            $this->app->end();
        } else {
			$this->render($tmpl, $data );
        }		
		
	}
	
}