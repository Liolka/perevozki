<?	foreach($rows as $key=>$row) {	?>
	<li class="product-item <?=$product_classes?>">
		<div class="product-item-wr">
			<? 
				if($key == 1 || $key == 3) {
					echo '<span class="product-label new-product">Новинка</span>';
				}
				if($isWidget)	{
					//$product_url = $this->controller->createUrl('shopproducts/detail', array('path'=> 'product/'.$row->product_id)); 
					$product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}	else	{
					//$product_url = $this->createUrl('shopproducts/detail', array('path'=> 'product/'.$row->product_id)); 
					$product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}
			?>
			<a href="<?=$product_url?>" class="product-title font-size-14 full-black"><?=$row->product_name?></a>
			<div class="product-image" style="background-image: url(<?=$images_live_url.$row->file_url_thumb ?>)"></div>
			<div class="small">пр-во: <span><?=$row->manuf?></span><br />код: <span><?=$row->code?></span></div>
			<div class="status status-available"><?=$row->in_stock?></div>
			<div class="product-bottom clearfix">
				<div class="product-prices">
					<?if($row->product_override_price != 0) {	?>
						<div class="price"><?=number_format($row->product_override_price, 0, '.', ' ')?> у.е.</div>
						<div class="price-discount"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</div>
					<?	}	else	{	?>
						<div class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</div>
					<?	}	?>
				</div>
				<a href="<?=$product_url?>" class="button product-detail">Подробнее</a>
			</div>

		</div>
	</li>
						
<?	}	?>



