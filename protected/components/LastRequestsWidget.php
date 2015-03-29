<?php
class LastRequestsWidget extends CWidget {
	public $app = null;
	
    public function run() {
		
		$this->app = Yii::app();
		$connection =$this->app->db;
		
		$criteria = new CDbCriteria;
		
		$criteria->select = "t.*, u.username";
		
		$criteria->join = "INNER JOIN {{users}} AS u ON t.`user_id` = u.`id`";
		$criteria->order = 't.created DESC';
		
        $dataProvider = new CActiveDataProvider('Bids', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>4,
				'pageVar' =>'page',
            ),
        ));
		
		$bid_ids = array();
		foreach($dataProvider->data as $row) {
			$bid_ids[] = $row->bid_id;
		}
		
		$cargoes_info = Cargoes::model()->getCargoresInfo($connection, $bid_ids);
		
		//получаем инфу по кол-ву предложений по заявкам
		$deals_count_list = Deals::model()->getBidDealsCount($connection, $bid_ids);
		
		foreach($dataProvider->data as $row) {
			$cargo_name = array();
			$porters = false;
			
			$row->total_weight = 0;
			$row->total_volume = 0;
			$row->deals_count = isset($deals_count_list[$row->bid_id]) ? $deals_count_list[$row->bid_id] : 0;
			

			foreach($cargoes_info as $cargo) {
				if($cargo['bid_id'] == $row->bid_id) {
					$cargo_name[] = $cargo['name'];

					if($cargo['porters'] == 1) {
						$porters = true;
					}
					
					$row->total_weight = $row->total_weight + $cargo['weight'];
					$row->total_unit = $cargo['unit'];
					$row->total_volume = $row->total_volume + $cargo['volume'];
					
				}
			}
			
			$row->full_name = implode('. ', $cargo_name);
			$row->need_porters = $porters;
			
		}
		
		$this->render('LastRequestsWidget', array(
			//'model' => $model,
			//'categories_list' => $categories_list,
			'dataProvider'=>$dataProvider,
			//'type_sort'=>$type_sort,
		));
		
		
		//$this->render('LastRequestsWidget', array());
		
    }
	
	public function getTimeAgo($date_time)
	{
		$timeAgo = time() - strtotime($date_time);
		$timePer = array(
			'day' 	=> array(3600 * 24, 'дн.'),
			'hour' 	=> array(3600, ''),
			'min' 	=> array(60, 'мин.'),
			'sek' 	=> array(1, 'сек.'),
			);
		foreach ($timePer as $type =>  $tp) {
			$tpn = floor($timeAgo / $tp[0]);
			if ($tpn){
				
				switch ($type) {
					case 'hour':
						if (in_array($tpn, array(1, 21))){
							$tp[1] = 'час';
						}elseif (in_array($tpn, array(2, 3, 4, 22, 23)) ) {
							$tp[1] = 'часa';
						}else {
							$tp[1] = 'часов';
						}
						break;
				}
				return $tpn.' '.$tp[1].' назад';
			}
		}
	}	
	
}
?>