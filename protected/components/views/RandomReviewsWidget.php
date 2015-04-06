<div class="radnom-reviews">
	<p class="header">Случайные отзывы <a href="#">Показать все</a></p>	
	<ul class="radnom-reviews-items">
		<? foreach($rows as $row)	{	?>
		
		<?
			$maxchar = 250;
			$text_intro = '';
			if(strlen($row['text']) > $maxchar)	{
				$words = explode(' ', $row['text']);
				foreach ($words as $word)	{
					if (strlen($text_intro . ' ' . $word) < $maxchar)	{
						$text_intro .= ' '.$word; 
					} else	{
						$text_intro .= '';
						break;
					}
				}
				$text_intro .= '...';
			}	else	{
				$text_intro = $row['text'];
			}
		
		?>		
			<li class="radnom-reviews-item">
				<a href="<?=$this->controller->createUrl('bids/view', array('id'=> $row['bid_id']))?>" class="radnom-reviews-item-url">заказ №<?=$row['bid_id']?></a>
				<p class="radnom-reviews-item-text"><?=$text_intro?><span class="double-arrow-right"> </span></p>
			</li>		
		<?	}	?>
		<?/*
		<li class="radnom-reviews-item">
			<a href="#" class="radnom-reviews-item-url">заказ №987645</a>
			<p class="radnom-reviews-item-text">Приехал вовремя. Загрузили и разобрали шкафы-купе. Мастерски владеет фургоном в узких дворах! Быстро грузят и разгружают. Приехал с помощником Михаилом. Переехали 2-х комнатной квартирой.<span class="double-arrow-right"> </span></p>
		</li>
		<li class="radnom-reviews-item">
			<a href="#" class="radnom-reviews-item-url">заказ №987645</a>
			<p class="radnom-reviews-item-text">Приехал вовремя. Загрузили и разобрали шкафы-купе. Мастерски владеет фургоном в узких дворах! Быстро грузят и разгружают. Приехал с помощником Михаилом. Переехали 2-х комнатной квартирой за 8 часов.<span class="double-arrow-right"> </span></p>
		</li>
		<li class="radnom-reviews-item">
			<a href="#" class="radnom-reviews-item-url">заказ №987645</a>
			<p class="radnom-reviews-item-text">Приехал вовремя. Загрузили и разобрали шкафы-купе. Мастерски владеет фургоном в узких дворах! Быстро грузят и разгружают. Приехал с помощником Михаилом. Переехали 2-х комнатной квартирой за 8 часов. Рекомендую!<span class="double-arrow-right"> </span></p>
		</li>
		*/ ?>
	</ul>
</div>