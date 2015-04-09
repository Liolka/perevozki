<?php

class ReviewForm extends CFormModel
{
	public $comment;
	public $rating;
	
	
	public function rules()
	{
		return array(
			array('comment', 'required', 'message'=>'Напишите отзыв'),
			array('rating', 'required', 'message'=>'Поставьте оценку вашему отзыву'),
			array('rating', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>400, 'min' => 3),
		);
	}

	public function attributeLabels()
	{
		return array(
			'rating' => "rating",
			'comment' => "comment",
		);
	}
}
