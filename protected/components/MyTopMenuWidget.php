<?php
class MyTopMenuWidget extends CWidget {
	
	public $current_controller = '';
	public $current_action = '';
	public $user = '';
	
    public function run() {
		//echo'<pre>';print_r($this->user->user_type,0);echo'</pre>';
		if($this->current_controller == 'my' && $this->current_action != 'my' && !$this->user->isGuest)	{
			$this->render('MyTopMenuWidget', array());
		}
    }
}
?>