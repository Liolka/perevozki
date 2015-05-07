<?php
/*
виджет выводит быстрые ссылки на главную страницу
*/
class QuickLinksWidget extends CWidget {
	
	public $current_controller = '';
	public $current_action = '';
	public $user = '';
	public $connection;
	
    public function run() {
		if($this->current_controller == 'site' && $this->current_action == 'index')	{
			if($this->user->isGuest || $this->user->user_type == 1)	{
				$user_type = 1;
			}	else	{
				$user_type = 2;
			}
		}	else	{
			return;
		}
		
		$categories_list_level1 = Categories::model()->getCategoriesLevel1($this->connection);
		
		$this->render('QuickLinksWidget', array(
			'categories_list_level1'=>$categories_list_level1,
			'user_type'=>$user_type,
		));
		
		//echo'<pre>';print_r($this->user->user_type,0);echo'</pre>';
    }
}
?>