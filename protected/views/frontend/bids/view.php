<?php
/* @var $this BidsController */
/* @var $model Bids */

$this->breadcrumbs=array(
	'Заявки на перевозку грузов'=>array('index'),
	$bid_name,
);

$clientScript = $this->app->clientScript;

$this->pageTitle = "Заявка №".$model->bid_id;
$clientScript->registerMetaTag("Заявка №".$model->bid_id, 'keywords');
$clientScript->registerMetaTag("Заявка №".$model->bid_id, 'description');

$NumberFormatter = $this->app->NumberFormatter;

$cs = $this->app->clientScript;
$cs->coreScriptPosition=CClientScript::POS_END;
$cs->registerCoreScript('fancybox');

$accepted_deal = 0;
foreach($deals_list as $row) {
	if($row['accepted'] == 1)	{
		$accepted_deal = $row['id'];
		break;
	}
}

$show_deal_frm = true;
foreach($deals_list as $row) {
	//if(!$this->app->user->isGuest && $row['user_id'] == $this->app->user->id)	{
	if(!$this->app->user->isGuest && ($row['user_id'] == $this->app->user->id || $row['accepted'] == 1) )	{

		$show_deal_frm = false;
	}
}

//echo'<pre>';print_r($deals_list);echo'</pre>';
//echo'<pre>';print_r($model);echo'</pre>';

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
<div class="pos-rel">
	<h1><?php echo $bid_name; ?></h1>

	<p class="bid-detail-number narrow-bold-23">Заявка №<?=$model->bid_id;?></p>
	
	<? if(!$this->app->user->isGuest && $this->app->user->id == $model->user_id)	{	?>
		<a href="#" class="db pos-abs underline_n_n narrow-regular-24 c_96a5b8 bb-dotted-3-h cancel-bid" title="Отменить заявку">Отменить заявку ×</a>
	<?	}	?>
</div>

<?php if($this->app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success">
		<?php echo $this->app->user->getFlash('success'); ?>
	</div>
<?php endif; ?>


<div class="bid-detail-route-block mb-30">
	<div class="bid-view-created fRight clearfix">
		<span class="db font-12 c_aab1ba mb-5"><?=getTimeAgo($model->created).' добавил'?></span>
		<span class="db p-0-20 text_r mb-5"><a class="profile-link c_71a72c" target="_blank" href="<?=$this->createUrl('/user/view', array('id'=>$model->user_id))?>"><?=$model->username?></a></p></span>
		<? /*<a href="#" class="db ico-question fRight"></a>*/ ?>
		<div class="m-0-5 rating-stars bid-view-rating fRight">
			<span class="stars-empty"></span><span class="stars-full" style="width:<?=($model->user_rating * 10)?>%;"></span>
		</div>
	</div>


	<ul class="bid-detail-route-list clearfix">
		<li class="route-start fLeft">
			<p class="route-town counry-by mb-5 bold for_sprite pl-20 ml-20"><?=$model->loading_town?></p>
			<p class="route-address"><?=$model->loading_address?></p>			
		</li>
		<? if($model->add_loading_unloading_town_1 != '')	{	?>
			<li class="route-item fLeft ml-40 table-row">
				<div class="route-item-arrow table-cell"></div>
				<div class="route-item-wr table-cell for_sprite">
					<p class="route-town counry-by mb-5 bold for_sprite pl-20 ml-20"><?=$model->add_loading_unloading_town_1?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_1?></p>
				</div>
			</li>
		<?	}	?>
		<? if($model->add_loading_unloading_town_2 != '')	{	?>
			<li class="route-item fLeft ml-40 table-row">
				<div class="route-item-arrow table-cell for_sprite"></div>
				<div class="route-item-wr table-cell">
					<p class="route-town counry-by mb-5 bold for_sprite pl-20 ml-20"><?=$model->add_loading_unloading_town_2?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_2?></p>
				</div>
			</li>
		<?	}	?>
		<? if($model->add_loading_unloading_town_3 != '')	{	?>
			<li class="route-item fLeft ml-40 table-row">
				<div class="route-item-arrow table-cell for_sprite"></div>
				<div class="route-item-wr table-cell">
					<p class="route-town counry-by mb-5 bold for_sprite pl-20 ml-20"><?=$model->add_loading_unloading_town_3?></p>
					<p class="route-address"><?=$model->add_loading_unloading_address_3?></p>
				</div>
			</li>
		<?	}	?>
		
		<li class="route-item route-end fLeft ml-40 table-row">
			<div class="route-item-arrow table-cell for_sprite"></div>
			<div class="route-item-wr table-cell">
				<p class="route-town counry-by mb-5 bold for_sprite pl-20 ml-20"><?=$model->unloading_town?></p>
				<p class="route-address"><?=$model->unloading_address?></p>
			</div>		
		</li>
	</ul>
	
	
	
</div>

<div class="row mb-40">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		<div id="map" style="width: 100%; height: 350px"></div>
	</div>
	
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3">
		<div class="bid-detail-date <? if(isQuickly($model->date_transportation)) echo 'bid-detail-date-quickly'?>">
			<p class="clearfix" style="margin-left:-5px;margin-right:-5px;">
				<? if($model->date_transportation != '0000-00-00')	{	?>
					<span class="db fLeft p-0-5">
						<?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $model->date_transportation); ?>
						<? if($model->time_transportation != '00:00:00')	{	?>
							<span class="db font-14 normal pt-5"><?php echo $model->time_transportation; ?></span>
						<?	}	?>
					</span>
				<?	}	?>
				<? if($model->date_transportation != '0000-00-00' && $model->date_transportation_to != '0000-00-00')	{	?>
					<span class="db fLeft p-0-5">&mdash;</span>
				<?	}	?>
				<? if($model->date_transportation_to != '0000-00-00')	{	?>
					<span class="db fLeft p-0-5">
						<?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $model->date_transportation_to); ?>
						<? if($model->time_transportation_to != '00:00:00')	{	?>
							<span class="db font-14 normal pt-5"><?php echo $model->time_transportation_to; ?></span>
						<?	}	?>
					</span>
				<?	}	?>
			</p>
			
			<?php if( isQuickly($model->date_transportation))	{	?>
				<span class="bid-detail-date-quickly-val">Срочно</span>
			<?	}	?>
		</div>
		<div class="bid-detail-price">
			<span class="bid-detail-price-title">Заказчик предлагает:</span>
			<span class="bid-detail-price-wr">до <? echo $NumberFormatter->formatDecimal($model->price)?>р.</span>
		</div>
		<? if($is_perevozchik && $show_deal_frm)	{	?>
			<a href="#new-deal" id="bid-detail-respond-btn" class="btn-blue-66 bid-detail-respond-btn">Откликнуться</a>
		<?	}	elseif($this->app->user->isGuest)	{	?>
			<a href="<?=$this->createUrl('/user/login')?>" id="bid-detail-respond-btn" class="login-btn btn-blue-66 bid-detail-respond-btn">Откликнуться</a>
		<?	}	?>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-3 bid-detail-cargo-list">
		<ul>
		<? foreach($cargoes as $cargo)	{	?>
			<? if($cargo['foto'])	{	?>
				<li class="bid-detail-cargo-listitem pos-rel">
					<a href="/files/bids/full_<?=$cargo['foto']?>" class="fancybox" data-fancybox-group="gallery" title="<?=$cargo['name']?>">
						<span class="cargo_foto_detail db pos-abs" style="background-image: url('/files/bids/thumb_<?=$cargo['foto']?>')"></span>
					</a>
					
			<?	}	else	{	?>
				<li class="bid-detail-cargo-listitem for_sprite requests-list-item_number-cat-<?=$cargo['category_id'] ?>">
			<?	}	?>
			
				<div class="mb-20">
					<p class="bold mb-5"><?=$cargo['parent_name']?></p>
					<p class="mb-5"><?=$cargo['name']?></p>
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
					<p class="bid-detail-cargo-listitem-comment lh-18 font-12">
					<?
						$intro_text = getIntroText(150, $cargo['comment']);
						if($intro_text != $cargo['comment'])	{
							$intro_text .= ' <a href="javascript:void(0)" class="introtext-toggle bb-dotted-4-h underline_n_n">Подробнее</a>';
							$full_text = $cargo['comment'].' <a href="javascript:void(0)" class="introtext-toggle bb-dotted-4-h underline_n_n">Скрыть</a>';
							?>
							<span class="bid-detail-cargo-introtext"><?=$intro_text?></span><span class="bid-detail-cargo-fulltext hide-block"><?=$full_text?></span>
							<?
						}	else	{
							echo $cargo['comment'];
						}
					?>
					</p>
				<?	}	?>
				
			</li>
		<?	}	?>
		</ul>
	</div>
</div>

<div class="bid-detail-deals-block">
	<? if(count($deals_list))	{	?>
		<p class="narrow-regular-24 mb-20 bid-detail-deals-title">Предложения от перевозчиков</p>

		<div class="bid-detail-deals">
			<div class="bid-detail-deals-head clearfix width100">
				<p class="font-12 c_757575 bid-detail-deals-col1 fLeft"> </p>
				<p class="font-12 c_757575 bid-detail-deals-col2 fLeft">Ставка</p>
				<p class="font-12 c_757575 bid-detail-deals-col3 fLeft">Исполнитель</p>
				<p class="font-12 c_757575 bid-detail-deals-col4 fLeft">Услуги</p>
				<p class="font-12 c_757575 bid-detail-deals-col5 fLeft">Дата перевозки</p>
				<p class="font-12 c_757575 bid-detail-deals-col6 fLeft"> </p>
			</div>

			<? foreach($deals_list as $row) {	?>
				<?
	
				$deal_posts = array();
				foreach($deals_posts_list as $post)	{
					if($post['deal_id'] == $row['id'])	{
						$deal_posts[] = $post;
					}
				}
				?>

				<div class="bid-detail-deals-row width100 mb-10 <? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	echo ' bid-detail-deals-row-inactive'	?>">
					<div class="bid-detail-deals-row-wr clearfix">
						<div class="bid-detail-deals-col1 fLeft pos-rel p-15">
							<? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	{	?>
								<div class="deals-inactive-cell pos-abs width100"> </div>
							<?	}	?>
						
							<div class="ico-notice-blue bid-detail-notice-blue text_c"><?=count($deal_posts)?></div>
							<span class="show-deals-comments hide-block">▼</span>
						</div>
						
						<div class="bid-detail-deals-col2 fLeft pos-rel p-15">
							<? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	{	?>
								<div class="deals-inactive-cell pos-abs width100"> </div>
							<?	}	?>
						
							<p class="font-17 bold mb-10">до <?php echo $NumberFormatter->formatDecimal($row['price'])?> р.</p>
							<p class="font-12 c_8e95a1">Доб. <?php echo $this->app->dateFormatter->format('dd.MM.yyyy / HH:mm', $row['created']); ?></p>
						</div>
						
						<div class="bid-detail-deals-col3 fLeft pos-rel p-15">
							<? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	{	?>
								<div class="deals-inactive-cell pos-abs width100"> </div>
							<?	}	?>
							<div class="bid-detail-deals-perevozhik">
								<a href="<?=$this->createUrl('/user/view', array('id'=>$row['user_id']))?>" class="profile-link bid-detail-deals-profile-link pl-20" target="_blank">Перевозчик <?php echo $row['username'] ?></a>
								<div class="bid-detail-deals-rating-block mt-5">
									<div class="rating-stars dib"><span class="stars-empty"></span><span class="stars-full-blue" style="width:<?=($row['rating'])?>%;"></span></div>
									<p class="rewiews-count font-12 c_8e95a1 dib">(<?=$row['reviews_count']?> <?php echo Yii::t('app', 'отзыв|отзыва|отзывов|отзыва', $row['reviews_count']); ?>)</p>
								</div>
							</div>
						</div>
						
						<div class="bid-detail-deals-col4 fLeft pos-rel p-15">
							<? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	{	?>
								<div class="deals-inactive-cell pos-abs width100"> </div>
							<?	}	?>
						
							<? if($row['porters'])	{	?>
								<p class="services font-13 bold mb-5">Перевозка + грузчик/и</p>
							<?	}	?>
							<? if($row['comment'])	{	?>
								<p class="font-13"><?=$row['comment']?></p>
							<?	}	?>
						</div>
						
						<div class="bid-detail-deals-col5 fLeft pos-rel p-15">
							<? if($accepted_deal > 0 && $row['id'] != $accepted_deal || $row['rejected'] == 1)	{	?>
								<div class="deals-inactive-cell pos-abs width100"> </div>
							<?	}	?>
						
							<p class="deal-date font-13 bold mb-5"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy', $row['deal_date']); ?></p>
							<p class="deal-time font-13 c_8e95a1"><?php echo $this->app->dateFormatter->format('HH:mm', $row['deal_time']); ?></p>

						</div>
						
						<div class="bid-detail-deals-col6 fLeft p-15">
							<? if($accepted_deal > 0 && $row['id'] == $accepted_deal)	{	?>							
								<p class="btn-green-33 deal-btn text_r pos-rel">
									
									<? if($this->app->user->id == $model->user_id)	{	?>
										<span class="name pos-abs p-0-15 bg_85bf32 text_c">Перевозчик выбран</span>
										<a href="<?=$this->createUrl('/bids/cancelaccepteddeal', array('id'=>$model->bid_id, 'deal_id'=>$row['id']))?>" class="ico tahoma font-24 normal c_fff underline_n_n" title="Отменить принятую заявку">×</a>
									<?	}	else	{	?>
										<span class="name pos-abs width100 p-0-15 bg_85bf32 border-box text_c">Перевозчик выбран</span>
									<?	}	?>
								</p>
								<?	}	elseif($row['rejected'] == 1)	{	?>
									<p class="btn-red-33 deal-btn text_r pos-rel">
										<? if($this->app->user->id == $model->user_id)	{	?>
											<span class="name pos-abs p-0-15 bg_de5151 text_c">Отклонена</span>
											<a href="<?=$this->createUrl('/bids/cancelrejecteddeal', array('id'=>$model->bid_id, 'deal_id'=>$row['id']))?>" class="ico tahoma font-24 normal c_fff underline_n_n" title="Отменить отклонение заявки">×</a>
										<?	}	else	{	?>
											<span class="name pos-abs width100 p-0-15 bg_de5151 border-box text_c">Отклонена</span>
										<?	}	?>
									</p>
								<?	}	else	{	?>
									<? if($this->app->user->id == $model->user_id && !($accepted_deal > 0 && $row['id'] != $accepted_deal))	{	?>
										<a href="<?=$this->createUrl('/bids/acceptdeal', array('id'=>$model->bid_id, 'deal_id'=>$row['id'], 'performer_id'=>$row['user_id']))?>" class="btn-grey-33 accept-deal-btn" title="Принять заявку">Принять</a>
										<a href="<?=$this->createUrl('/bids/rejectdeal', array('id'=>$model->bid_id, 'deal_id'=>$row['id'], 'performer_id'=>$row['user_id']))?>" class="ico-close-blue reject-deal-btn" title="Отклонить заявку">x</a>
									<?	}	?>
							<?	}	?>
							
							
						</div>
					</div>

					<? if(($accepted_deal > 0 && $row['id'] == $accepted_deal) || $accepted_deal == 0)	{	?>
					<div class="bid-detail-deals-row-answer-block-reviews clear hide-block">
						<? if(count($deal_posts))	{	?>
							<div class="bid-detail-deals-row-answer-block-reviews-wr">

							<? foreach($deal_posts as $post)	{	?>
								<? if($post['deal_id'] == $row['id'])	{	?>
									<? 
										if($post['user_type'] == 2)	{
											$user_type_str = "(перевозчик)";
										}	else	{
											$user_type_str = "(грузодатель)";
										}
									?>
									<div class="bid-detail-deals-row-answer-block-reviews-row clearfix">
										<div class="bid-detail-deals-row-answer-block-reviews-cell1 fLeft font-12 c_8e95a1 p-15"><?php echo $this->app->dateFormatter->format('dd.MM.yyyy / HH:mm', $post['created']); ?></div>
										<div class="bid-detail-deals-row-answer-block-reviews-cell2 fLeft p-15">
											<p class="font-12 mb-5"><a href="<?=$this->createUrl('/user/view', array('id'=>$post['user_id']))?>" class="c_1e91da" target="_blank"><?=$post['username']?></a> <span class="c_8e95a1"><?=$user_type_str?></span></p>
											<p class="font-12"><?=$post['text']?></p>
										</div>
									</div>

								<?	}	?>
							<?	}	?>
							</div>
						
						<?	}	?>

						<? if($row['user_id'] == $this->app->user->id || $model->user_id == $this->app->user->id)	{	?>
						<div class="bid-detail-deals-row-answer-block-comment pos-rel bg_daf0fa clearfix">
							<form action="" method="post">
								<textarea name="deal-post" id="deal-post" class="width100 mb-20" cols="30" rows="10"></textarea>
								<?php echo CHtml::hiddenField('deal-id', $row['id']); ?>
								<?php echo CHtml::submitButton('Написать', array('id'=>'create-deal-post', 'class'=>'btn-green-33 bid-detail-send-comment-btn fRight', 'name'=>'create-deal-post')); ?>
							</form>
						</div>
						<?	}	?>

					</div>
					<?	}	?>

				</div>		
			<?	}	?>
		</div>	
	<?	}	?>


	
	<? 
		if($is_perevozchik && $show_deal_frm)	{
			$this->renderPartial('_add-new-deal', array(
				'deals'=>$deals,
				'transport_list'=>$transport_list,
			));
		}
	?>
	
</div>
