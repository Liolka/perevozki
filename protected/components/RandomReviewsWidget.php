<?php
class RandomReviewsWidget extends CWidget {
	public $current_controller = '';
	public $current_action = '';
	public $user = '';
	
    public function run() {
		$rows = Bids::model()->getRandomReviews(Yii::app()->db);
		$fields_arr = array('user_review', 'performer_review');
		foreach($rows as &$row)	{
			$rand_field = array_rand($fields_arr, 1);
			if($fields_arr[$rand_field] == 'user_review')	{
				$row['text'] = $row['user_review'] ? $row['user_review'] : $row['performer_review'];
			}	else	{
				$row['text'] = $row['performer_review'] ? $row['performer_review'] : $row['user_review'];
			}
		}
		$this->render('RandomReviewsWidget', array('rows' => $rows));
    }
}
?>