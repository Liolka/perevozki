<?php

class BidsFilter extends CFormModel
{
	public $bids_filter_dates_from;
	public $bids_filter_dates_to;
	
	public $town_from;
	public $town_to;
	
	public function rules()
	{
		return array(
			array('bids_filter_dates_from, bids_filter_dates_to', 'date', 'format' => 'yyyy-MM-dd'),
			array('town_from, town_to', 'length', 'max'=>128, 'min' => 3),
		);
	}

	public function attributeLabels()
	{
		return array(
			'bids_filter_dates_from' => "С",
			'bids_filter_dates_to' => "По",
			'town_from' => "Откуда",
			'town_to' => "Куда",
		);
	}
}
