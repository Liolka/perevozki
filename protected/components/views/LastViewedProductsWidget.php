<?
$images_live_url = Yii::app()->params->images_live_url;
$webroot = Yii::getPathOfAlias('webroot');
$product_classes = "";
$isWidget = true;
?>

<div class="last-viewed-block">
	<div class="header-wr">
		<h3 class="uppercase">Вы недавно просматривали</h3>
	</div>
	<ul class="last-viewed-list">
		<?	foreach($rows as $key=>$row) {	?>
			<? 
				if($isWidget)	{
					$product_url = $this->controller->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}	else	{
					$product_url = $this->createUrl('shopproducts/detail', array('product'=> $row->product_id)); 
				}
			?>

			<li class="last-viewed-item <?=$product_classes?>">
				<div class="last-viewed-item-wr" style="background-image: url(<?=$images_live_url.$row->file_url_thumb ?>)">
					<a href="<?=$product_url?>" class="product-title"><?=$row->product_name?></a>

					<div class="status status-available"><?=$row->in_stock?></div>

					<div class="last-viewed-item-prices">
						<?if($row->product_override_price != 0) {	?>
							<div class="price"><?=number_format($row->product_override_price, 0, '.', ' ')?> у.е.</div>
							<div class="price-discount"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</div>
						<?	}	else	{	?>
							<div class="price"><?=number_format($row->product_price, 0, '.', ' ')?> у.е.</div>
						<?	}	?>
					</div>
				</div>


			</li>

		<?	}	?>





	</ul>
	<a href="#" class="all-items">Что еще смотрели?</a>
</div>