<?php 

//$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");
$this->pageTitle = 'Мой транспорт';

$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);

$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Мой транспорт',
);

$cs = $this->app->clientScript;

$cs->registerScript('loading', "
	$('.my-transport-list-item').hover(
        function(){ if(!$(this).hasClass('.add-transport-wr')) { $(this).children('.my-transport-edit').fadeIn(100) }    },
        function(){ if(!$(this).hasClass('.add-transport-wr')) { $(this).children('.my-transport-edit').fadeOut(100) }    }
    );
	
");

    //$cs1 = $this->app->getClientScript();
	$cs->registerCoreScript('ajax-upload');

$counter = 2;

$transport_imageLive = $this->app->homeUrl.'files/users/'.$this->app->user->id.'/transport/'

?>
 

<h1>Мой транспорт <span>(<?=count($dataProvider->data)?> единицы)</span></h1>

<?php if($this->app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success"><?php echo $this->app->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php if($this->app->user->hasFlash('error')): ?>
	<div class="flash-message flash-error"><?php echo $this->app->user->getFlash('error'); ?></div>
<?php endif; ?>


<ul class="my-transport-list clearfix">
    <li class="my-transport-list-item add-transport-wr">
        <div class="add-transport clearfix">
            <a href="<? echo $this->createUrl('/user/my/transportcreate') ?>" id="add-transport-btn" class="add-transport-btn">+</a>
            <p>Добавить транспорт</p>
        </div>
    </li>
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

	?>
    
		<li class="my-transport-list-item <? if($counter == 4) { echo 'clear'; $counter = 1; } ?>">
			
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