<?
$counter = 1;
?>
<div id="flexcroll_transport_list" class="flexcroll flexcroll-transport-list">
	<ul class="transport-list transport-list-in-row clearfix pos-rel" style="width:<?=(405 * count($dataProvider->data))?>px">
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

			<li class="pofile-transport-list-item fLeft bg_fff <? //if($counter == 4) { echo 'clear'; $counter = 1; } ?>">

				<? include (dirname(dirname(__FILE__))."/common/transport-list-item.php")?>

				<div class="my-transport-edit">
					<div class="my-transport-edit-top">
						<a href="<?=$this->createUrl('/user/my/transportupdate', array('id'=>$row->transport_id))?>" class="my-transport-edit-btn btn-blue1">Редактировать</a>
						<a href="<?=$this->createUrl('/user/my/transportdelete', array('id'=>$row->transport_id))?>" class="my-transport-delete-btn btn-red" onclick="if(!confirm('Действительно удалить?')) return false;">Удалить х</a>
					</div>
					<? /*<a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a> */ ?>
				</div>
			</li>
			<? $counter++ ?>
		<? } ?>

	</ul>
</div>
