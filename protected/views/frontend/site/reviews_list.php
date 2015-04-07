<ul class="radnom-reviews-items">
	<? foreach($rows as $row)	{	?>
		<li class="radnom-reviews-item">
			<a href="<?=$this->createUrl('bids/view', array('id'=> $row['bid_id']))?>" class="radnom-reviews-item-url">заказ №<?=$row['bid_id']?></a>
			<p class="radnom-reviews-item-text"><?=getIntroText(250, $row['text'])?><span class="double-arrow-right"> </span></p>
		</li>		
	<?	}	?>
</ul>		
