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
$cargo_info = array();
if($data->total_weight)	{
	$cargo_info[] = "Вес ". $data->total_weight.$this->app->params['UnitsListArray'][$data->total_unit]['name'];
}

if($data->total_volume)	{
	$cargo_info[] = "Объем ". $data->total_volume."м3";
}

isQuickly($data->date_transportation);
?>

<div class="requests-list-item p-25 mb-10 blue-border-1 clearfix">

	<? if($data->bid_foto != '')	{	?>
		<div class="requests-list-item_number fLeft font-12 c_2e3c54 pos-rel">
			<a href="/files/bids/full_<?=$data->bid_foto?>" class="fancybox" data-fancybox-group="gallery_<?php echo $data->bid_id; ?>" title="<?=$data->full_name?>">
				<span class="cargo_foto db pos-abs" style="background-image: url('/files/bids/thumb_<?=$data->bid_foto?>')"></span>
			</a>
			<?php echo $data->bid_id; ?>
		</div>
	<?	}	else	{	?>
		<div class="requests-list-item_number for_sprite cat-b-<?php echo $data->category_id; ?> rl-cat-<?php echo $data->category_id; ?> fLeft font-12 c_2e3c54"><?php echo $data->bid_id; ?></div>
	<?	}	?>
	
	<div class="requests-list-item_info fLeft">
		<a class="requests-list-item-info_url db font-12 c_1e91da pb-5 lh-18" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>"><?=$data->full_name?></a>
		<span class="requests-list-item-info_descr db font-12 c_8e95a1"><?=implode(" / ", $cargo_info)?></span>
		<? if($data->need_porters) { ?>
			<span class="requests-list-item-info_gruzchiki c_2e3c54 font-12">Нужны грузчики</span>
		<?	}	?>
	</div>
	<div class="requests-list-item_from fLeft pos-rel">
		<span class="requests-list-item_town counry-by db pb-5 c_2e3c54 font-13 bold"><?php echo $data->loading_town; ?></span>
		<span class="requests-list-item_adress db c_8e95a1 font-12"><?php echo $data->loading_address; ?></span>
		<p class="requests-list-item_author font-11 c_8e95a1 pos-abs">
			Добавил <?=$this->getTimeAgo($data->created)?> 
			<a href="<?=$this->createUrl('/user/view', array('id'=>$data->user_id))?>" class="di font-11 c_8e95a1 pr-5" target="_blank"><?php echo $data->username; ?></a>
			<? if(isOnline($this->app, $data->last_activity))	{	?>
				<span class="user-online c_fff bg_33a72c font-10 p-0-5 arial">Online</span>
			<?	}	else	{	?>
				<span class="user-ofline c_fff bg_abbbcf font-10 p-0-5 arial">Offline</span>
			<?	}	?>				
			
		</p>
	</div>
	<div class="requests-list-item_to fLeft">
		<span class="requests-list-item_town counry-by db pb-5 c_2e3c54 font-13 bold"><?php echo $data->unloading_town; ?></span>
		<span class="requests-list-item_adress db c_8e95a1 font-12"><?php echo $data->unloading_address; ?></span>
	</div>
	<div class="requests-list-item_date fLeft">
		<? 
			$date = array();
			if($data->date_transportation != '0000-00-00') $date[] = $this->app->dateFormatter->format('dd.MM.yyyy', $data->date_transportation);
			if($data->date_transportation != '0000-00-00' && $data->date_transportation_to != '0000-00-00') $date[] = '-';
			if($data->date_transportation_to != '0000-00-00') $date[] = $this->app->dateFormatter->format('dd.MM.yyyy', $data->date_transportation_to);
		?>
		<span class="requests-list-item_created c_8e95a1 font-13"><?php echo implode(' ', $date); ?></span>
		<p class="requests-list-item_suggestions c_8e95a1 font-13"><span class="<? if(isQuickly($data->date_transportation)) { echo 'suggestion-orange'; } else { echo 'suggestion-green'; }?> c_fff dib"><?=$data->deals_count?></span><?php echo Yii::t('app', 'предложение|предложения|предложений|предложения', $data->deals_count); ?></p>
	</div>
	<div class="requests-list-item_price fRight ">
	<?/*
		<span class="requests-list-item-price_price db mb-15 bold font-17 c_2e3c54">до <?php echo $this->app->NumberFormatter->formatDecimal($data->price)?> р.</span>
		<a class="btn-blue-33 db p-0-20" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>#new-deal">Откликнуться</a>
	*/?>
		<span class="requests-list-item-price_price db mb-15 bold font-17 c_2e3c54">до <?php echo $this->app->NumberFormatter->formatDecimal($data->price)?> р.</span>
		
		<? if ($this->app->user->isGuest)	{	?>
			<a class="btn-blue-33 db p-0-20 login-btn" href="<?=$this->createUrl('/user/login')?>" target="_blank">Откликнуться</a>
		<? }	elseif ($this->app->user->user_type == 2)	{	?>
			<a class="btn-blue-33 db p-0-20" href="<?=$this->createUrl('/bids/view', array('id'=>$data->bid_id))?>#new-deal" target="_blank">Откликнуться</a>
		<?	}	else	{	?>
			<? /* <a class="btn-blue-33 db p-0-20 login-btn" href="<?=$this->createUrl('/user/login')?>">Откликнуться</a> */ ?>
		<?	}	?>
		
	</div>


</div>