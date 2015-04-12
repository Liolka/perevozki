<?
$counter = 1;
?>
<ul class="my-transport-list clearfix">
    <? foreach($dataProvider->data as $row) { ?>
    
	<?
	$unit_arr = array();
	$value_arr = array();
	if($row->length != '')	{
		$unit_arr[] = 'Д';
		$value_arr[] = $row->length;
	}

	if($row->width != 0)	{
		$unit_arr[] = 'Ш';
		$value_arr[] = $row->width;
	}

	if($row->height != 0)	{
		$unit_arr[] = 'В';
		$value_arr[] = $row->height;
	}
											 
	//$transport_image = $row->foto ? $this->app->params->transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg';
	$transport_image = $row->foto ? $transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg';
	$transport_image_full = $row->foto ? $transport_imageLive.'full_'.$row->foto : '/images/transport-no-foto.jpg';

	?>
    
		<li class="profile-transport-list-item width33 pos-rel fLeft <? if($counter == 4) { echo 'clear'; $counter = 1; } ?>">
			<? include (dirname(dirname(__FILE__))."/common/transport-list-item.php")?>			
		</li>
    	<? $counter++ ?>
    <? } ?>
    
</ul>