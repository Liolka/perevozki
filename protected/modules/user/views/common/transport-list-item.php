<div class="my-transport-wr clearfix">
	<? /*<img src="/images/transport-item.jpg" alt="" class="my-transport-image"> */ ?>
	<? //echo CHtml::image( $row->foto ? $this->app->params->transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg' , $row->name)?>

	<? if($row->foto != '')	{	?>
		<a href="<?=$transport_image_full?>" class="db transport-image-url pos-rel fLeft fancybox" data-fancybox-group="gallery" title="<?=$row->name?>"><span class="db transport-image" style="background-image: url(<?=$transport_image?>)"></span></a>
	<?	}	else	{	?>
		<span class="db transport-image" style="background-image: url(<?=$transport_image?>)"></span>
	<?	}	?>
	<div class="my-transport-info-wr">
		<p class="my-transport-name"><?=$row->name?></p>
		<p class="my-transport-info odd">
			<span class="name"><? echo $row->getAttributeLabel('year') ?>:</span>
			<span><?=$row->year ?></span>
		</p>		
		<p class="my-transport-info even">
			<span class="name"><? echo $row->getAttributeLabel('carrying') ?>:</span>
			<span><?=$row->carrying ?>кг</span>
		</p>
		<p class="my-transport-info odd">
			<span class="name"><? echo implode('x', $unit_arr)?>:</span>
			<span><? echo implode('x', $value_arr) ?>м</span>
		</p>
		<p class="my-transport-info even">
			<span class="name"><? echo $row->getAttributeLabel('volume') ?>:</span>
			<span><?=$row->volume ?> м3</span>
		</p>
		<p class="my-transport-info odd">
			<span class="name"><? echo $row->getAttributeLabel('body_type') ?>:</span>
			<span><?=$row->body_type ? $row->body_type : 'Не указан' ?></span>
		</p>
		<p class="my-transport-info even">
			<span class="name"><? echo $row->getAttributeLabel('loading_type') ?>:</span>
			<span><?=$row->loading_type ? $row->loading_type : 'Не указаны' ?></span>
		</p>
	</div>
	<? if($row->comment) { ?>
		<div class="my-transport-comment"><?=$row->comment ?></div>
	<? } ?>
</div>
