<div class="cartBlock floatRight">
	<div class="CartModule <? if($count_products == 0) { echo 'empty-cart'; }?>" id="CartModule">
		<div id="total-products" class="total-products"><? echo $count_products ? $count_products : '0';	?></div>
		<a class="to-cart" href="/showcart.html">Корзина</a>
	</div>
</div>