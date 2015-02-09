<?
	$images_live_url = Yii::app()->params->images_live_url;
	$webroot = Yii::getPathOfAlias('webroot');
	$product_classes = "floatLeft";
	$isWidget = true;
/*		
foreach($rows as $row) {
	echo'<pre>';print_r($row->product_id.' | '.$row->product_name, 0);echo'</pre>';
}
*/



?>



<div class="new-positions news-block">
	<div class="header-wr">
		<h3 class="uppercase">Новые поступления</h3>
		<a href="#" class="all-items">Все новые товары</a>
	</div>
	<div class="jcarousel-wrapper">
		<div class="jcarousel jcarousel-new-positions">
			<ul class="jcarousel products-list">
				<? include("$webroot/protected/views/frontend/common/product-list.php");	?>
			</ul>
		</div>
		<a href="#" class="jcarousel-control-prev jcarousel-new-positions-control-prev">‹</a> <a href="#" class="jcarousel-control-next jcarousel-new-positions-control-next">›</a>
	</div>
	
</div>