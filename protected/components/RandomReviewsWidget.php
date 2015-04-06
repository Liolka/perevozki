<?php
class RandomReviewsWidget extends CWidget {
	public $current_controller = '';
	public $current_action = '';
	public $user = '';
	
    public function run() {
		$rows = ReviewsPerformers::model()->getRandomReviews(Yii::app()->db);
		$this->render('RandomReviewsWidget', array('rows' => $rows));
    }
}
?>