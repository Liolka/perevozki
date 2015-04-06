<?php

class ReviewForm extends CFormModel
{
	public $comment;
	public $mark;
	
	
	public function rules()
	{
		return array(
			array('mark', 'numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>400, 'min' => 3),
		);
	}

	public function attributeLabels()
	{
		return array(
			'mark' => "mark",
			'comment' => "comment",
		);
	}
}
