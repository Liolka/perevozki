<?php

class RatingForm extends CFormModel
{
	public $rating;
	
	
	public function rules()
	{
		return array(
			array('mark', 'numerical', 'integerOnly'=>true),
		);
	}

	public function attributeLabels()
	{
		return array(
			'rating' => "rating",
		);
	}
}
