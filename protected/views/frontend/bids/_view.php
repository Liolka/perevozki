<?php
/* @var $this BidsController */
/* @var $data Bids */
?>

<?php //echo CHtml::link(CHtml::encode($data->bid_id), array('view', 'id'=>$data->bid_id)); 

//echo'<pre>';print_r($cargoes_info);echo'</pre>';
/*


$cargo_name = array();
$porters = false;

foreach($cargoes_info as $cargo) {
	if($cargo['bid_id'] == $data->bid_id) {
		$cargo_name[] = $cargo['name'];
		
		if($cargo['porters'] == 1) {
			$porters = true;
		}
	}
}
*/
?>

<div class="requests-list-item clearfix">

	<div class="requests-list-item_number"><?php echo $data->bid_id; ?></div>
	<div class="requests-list-item_info">
		<a class="requests-list-item-info_url" href="#"><?=$data->full_name?></a>
		<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>3</sup></span>
		<? if($data->need_porters) { ?>
			<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
		<?	}	?>
	</div>
	<div class="requests-list-item_from">
		<span class="requests-list-item_town counry-by"><?php echo $data->loading_town; ?></span>
		<span class="requests-list-item_adress"><?php echo $data->loading_address; ?></span>
		<p class="requests-list-item_author">Добавил 2ч назад <a href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>"><?php echo $data->username; ?></a></p>
	</div>
	<div class="requests-list-item_to">
		<span class="requests-list-item_town counry-by"><?php echo $data->unloading_town; ?></span>
		<span class="requests-list-item_adress"><?php echo $data->unloading_address; ?></span>
	</div>
	<div class="requests-list-item_date">
		<span class="requests-list-item_created"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $data->created); ?></span>
		<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
	</div>
	<div class="requests-list-item_price">
		<span class="requests-list-item-price_price">до <?php echo $data->price; ?> р.</span>
		<a class="btn-blue-33" href="#">Откликнуться</a>
	</div>


</div>