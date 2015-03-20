<?php
/* @var $this BidsController */
/* @var $data Bids */
?>

<?php //echo CHtml::link(CHtml::encode($data->bid_id), array('view', 'id'=>$data->bid_id)); ?>

<div class="requests-list-item clearfix">
	<div class="requests-list-item_number"><?php echo $data->bid_id; ?></div>
	<div class="requests-list-item_info">
		<a class="requests-list-item-info_url" href="#">Мебель и бытовая техника</a>
		<span class="requests-list-item-info_descr">Вес ~60кг / Объем 6м<sup>2</sup></span>
		<span class="requests-list-item-info_gruzchiki">Нужны грузчики</span>
	</div>
	<div class="requests-list-item_from">
		<span class="requests-list-item_town counry-by">Гомель</span>
		<span class="requests-list-item_adress">ул. Малайчука, 12</span>
		<p class="requests-list-item_author">Добавил 2ч назад <a href="#"><?php echo $data->username; ?></a></p>
	</div>
	<div class="requests-list-item_to">
		<span class="requests-list-item_town counry-by">Брест</span>
		<span class="requests-list-item_adress">ул. Малайчука, 27</span>
	</div>
	<div class="requests-list-item_date">
		<span class="requests-list-item_created">11.06.2015</span>
		<p class="requests-list-item_suggestions"><span class="suggestion-green">199</span>предложений</p>
	</div>
	<div class="requests-list-item_price">
		<span class="requests-list-item-price_price">до <?php echo $data->price; ?> р.</span>
		<a class="btn-blue-33" href="#">Откликнуться</a>
	</div>


</div>