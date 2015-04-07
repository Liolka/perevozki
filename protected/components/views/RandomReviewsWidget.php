<div class="radnom-reviews">
	<p class="header">Случайные отзывы <a href="#" id="next-random-reviews" rel="nofollow">Показать ещё</a><img src="/images/loading.gif" alt="loading" id="random-reviews-loading" class="ml-5 hide-block"></p>
	<div id="random-reviews-wr">
		<ul class="radnom-reviews-items">
			<? foreach($rows as $row)	{	?>
				<li class="radnom-reviews-item">
					<a href="<?=$this->controller->createUrl('bids/view', array('id'=> $row['bid_id']))?>" class="radnom-reviews-item-url">заказ №<?=$row['bid_id']?></a>
					<p class="radnom-reviews-item-text"><?=getIntroText(250, $row['text'])?><span class="double-arrow-right"> </span></p>
				</li>		
			<?	}	?>
		</ul>		
	</div>
</div>