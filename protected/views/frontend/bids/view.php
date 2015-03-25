<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Заявки на перевозку грузов'=>array('index'),
	$bid_name,
);

$NumberFormatter = $this->app->NumberFormatter;

//echo'<pre>';print_r($cargoes);echo'</pre>';
?>

<script src="http://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);
        var myMap, 
            myPlacemark,
			place = "<?=$model->loading_town?>";

        function init(){ 
			//var geocoder = new YMaps.Geocoder(place, {results: 1, boundedBy: map.getBounds()});
			
            myMap = new ymaps.Map("map", {
                center: [52.42837651, 31.01077383],
                zoom: 12,
				controls: ["zoomControl", "fullscreenControl"]
            }); 
            /*
            myPlacemark = new ymaps.Placemark([52.42837651, 31.01077383], {
                hintContent: 'Гомель!',
                balloonContent: 'Гомель'
            });
			*/
            
            //myMap.geoObjects.add(myPlacemark);
			
			//ymaps.route(['Гомель, ул.Советская д. 4','Гомель, Кирова 14', 'Минск'],
			ymaps.route([<?=implode(',', $route_arr)?>],
						{mapStateAutoApply: true, // автоматически позиционировать карту  
						}).then(
				function (route) {
					myMap.geoObjects.add(route);
				},
				function (error) {
					alert('Возникла ошибка: ' + error.message);
				}
			);		
			
        }
		
		//http://javascript.ru/forum/server/29796-vyvod-znacheniya-v-peremennuyu-php-yandeks-karty-api.html
		
		//http://www.forum.mista.ru/topic.php?id=510781
		
    </script>

<h1><?php echo $bid_name; ?></h1>

<p class="bid-detail-number">Заявка №<?=$model->bid_id;?></p>


<div class="bid-detail-route-block">
	<ul class="clearfix">
		<li class="route-start ">
			<p class="route-town counry-by"><?=$model->loading_town?></p>
			<p class="route-address"><?=$model->loading_address?></p>			
		</li>
		<? if($model->add_loading_unloading_town_1 != '')	{	?>
			<li class="route-item">
				<div class="route-item-arrow"></div>
				<div class="route-item-wr">
					<p class="route-town counry-by"><?=$model->add_loading_unloading_town_1?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_1?></p>
				</div>
			</li>
		<?	}	?>
		<? if($model->add_loading_unloading_town_2 != '')	{	?>
			<li class="route-item">
				<div class="route-item-arrow"></div>
				<div class="route-item-wr">
					<p class="route-town counry-by"><?=$model->add_loading_unloading_town_2?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_2?></p>
				</div>
			</li>
		<?	}	?>
		<? if($model->add_loading_unloading_town_3 != '')	{	?>
			<li class="route-item">
				<div class="route-item-arrow"></div>
				<div class="route-item-wr">
					<p class="route-town counry-by"><?=$model->add_loading_unloading_town_3?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_3?></p>
				</div>
			</li>
		<?	}	?>
		
		<li class="route-item route-end ">
			<div class="route-item-arrow"></div>
			<div class="route-item-wr">
				<p class="route-town counry-by"><?=$model->unloading_town?></p>
				<p class="route-address"><?=$model->unloading_address?></p>
			</div>		
		</li>
		
	</ul>
</div>

<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div id="map" style="width: 100%; height: 350px"></div>
	</div>
	
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		<div class="bid-detail-date <? if( $model->quickly) echo 'bid-detail-date-quickly'?>">
			<?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $model->created); ?>
			<?php if( $model->quickly)	{	?>
				<span class="bid-detail-date-quickly-val">Срочно</span>
			<?	}	?>
			
		</div>
		<div class="bid-detail-price">
			<span class="bid-detail-price-title">Заказчик предлагает:</span>
			<span class="bid-detail-price-wr">до <? echo $NumberFormatter->formatDecimal($model->price)?>р.</span>
		</div>
		
		<a href="#" id="bid-detail-respond-btn" class="btn-blue-66 bid-detail-respond-btn">Откликнуться</a>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3 bid-detail-cargo-list">
		<ul>
		<? foreach($cargoes as $cargo)	{	?>
			<li class="bid-detail-cargo-listitem bid-detail-cargo-listitem-cat-<?=$model->category_id ?>">
				<div class="bid-detail-cargo-listitem-row">
					<p class="bid-detail-cargo-listitem-cargo-name"><?=$cargo['name']?></p>
					<?
					$info_arr = array();
					if($cargo['weight']) {
						$info_arr[] = "Вес: ".$cargo['weight'].$this->app->params['UnitsListArray'][$cargo['unit']]['name'];
					}
						
					if($cargo['volume']) {
						$info_arr[] = "объем: ".$cargo['volume']."м<sup>3</sup>";
					}
						
					?>
					<p><?=implode(' / ', $info_arr)?></p>
				</div>
				
				<?
				$unit_arr = array();
				$value_arr = array();
				if($cargo['length'] != 0)	{
					$unit_arr[] = 'Д';
					$value_arr[] = $cargo['length'];
				}

				if($cargo['width'] != 0)	{
					$unit_arr[] = 'Ш';
					$value_arr[] = $cargo['width'];
				}

				if($cargo['height'] != 0)	{
					$unit_arr[] = 'В';
					$value_arr[] = $cargo['height'];
				}

				?>
				<? if(count($value_arr))	{	?>
					<p class="bid-detail-cargo-listitem-row"><? echo implode('x', $unit_arr).': '.implode('x', $value_arr).'м'; ?></p>
				<?	}	?>
				
				<? if($cargo['porters'] == 1 || $cargo['lift_to_floor'] == 1 || $cargo['lift'] == 1 || $cargo['floor'] != 0 )	{	?>
					<?
						$value_arr = array();
						if($cargo['porters'] == 1) {
							$value_arr[] = 'Нужна погрузка/выгрузка';
						}																									 
						if($cargo['lift_to_floor'] == 1 && $cargo['floor'] != 0 ) {
							$value_arr[] = 'Нужен подъем на '.$cargo['floor'].'й этаж';
						} elseif($cargo['lift_to_floor'] == 1) {
							$value_arr[] = 'Нужен подъем на этаж';
						}																								 
						if($cargo['lift'] == 1) {
							$value_arr[] = 'Лифт есть';
						} else {
							$value_arr[] = 'Лифта нет';
						}																							 
					
					?>
					<p class="bid-detail-cargo-listitem-row bid-detail-cargo-listitem-porters"><? echo implode('<br>', $value_arr); ?></p>
				<?	}	?>
				
				<? if($cargo['comment'] != '')	{	?>
					<p class="bid-detail-cargo-listitem-comment"><?=$cargo['comment']?></p>
				<?	}	?>
				
			</li>
		<?	}	?>
		</ul>
	</div>

		


<?php /*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'bid_id',
		'user_id',
		'created',
		'published',
		'date_transportation',
		'time_transportation',
		'date_unknown',
		'price',
		'loading_town',
		'loading_address',
		'add_loading_unloading_town_1',
		'add_loading_unloading_address_1',
		'add_loading_unloading_town_2',
		'add_loading_unloading_address_2',
		'add_loading_unloading_town_3',
		'add_loading_unloading_address_3',
		'unloading_town',
		'unloading_address',
	),
));*/ ?>

</div>

<div class="bid-detail-deals-block">
	<p class="narrow-regular-24">Предложения от перевозчиков</p>
	
	<div class="bid-detail-deals">
		<div class="bid-detail-deals-head">
			<p> </p>
			<p>Ставка</p>
			<p>Исполнитель</p>
			<p>Услуги</p>
			<p>Дата перевозки</p>
			<p> </p>
		</div>
		<div class="bid-detail-deals-row">
			<div class="bid-detail-deals-col1">
				<div class="ico-notice-blue">0</div>
			</div>
			<div class="bid-detail-deals-col2">
				<p class="font-17">до 500 000 р.</p>
				<p class="font-12 c_8e95a1">до 500 000 р.</p>
			</div>
			<div class="bid-detail-deals-col3">
				<a href="#" class="profile-link">Перевозчик Man</a>
				<div class="rating-stars"><span class="stars-empty"></span><span class="stars-full-blue" style="width:78%;"></span></div>
			</div>
			<div class="bid-detail-deals-col4">
				
			</div>
			<div class="bid-detail-deals-col5">
				
			</div>
			<div class="bid-detail-deals-col6">
				
			</div>
		</div>
	</div>
</div>
