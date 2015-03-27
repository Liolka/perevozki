<?php 

$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

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

?>
 

<h1>Мой транспорт <span>(<?=count($dataProvider->data)?> единицы)</span></h1>

<?php if($this->app->user->hasFlash('success')): ?>
	<div class="flash-message flash-success">
		<?php echo $this->app->user->getFlash('success'); ?>
	</div>
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
											 
	$transport_image = $row->foto ? $this->app->params->transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg';

	?>
    
		<li class="my-transport-list-item <? if($counter == 4) { echo 'clear'; $counter = 1; } ?>">
			<div class="my-transport-wr clearfix">
				<? /*<img src="/images/transport-item.jpg" alt="" class="my-transport-image"> */ ?>
				<? //echo CHtml::image( $row->foto ? $this->app->params->transport_imageLive.'thumb_'.$row->foto : '/images/transport-no-foto.jpg' , $row->name)?>
				
				<div class="my-transport-image" style="background-image: url(<?=$transport_image?>)"> </div>
				<div class="my-transport-info-wr">
					<p class="my-transport-name"><?=$row->name?></p>
					<p class="my-transport-info odd">
						<span class="name">Грузоподъемность:</span>
						<span><?=$row->carrying ?>кг</span>
					</p>
					<p class="my-transport-info even">
						<span class="name"><? echo implode('x', $unit_arr)?>:</span>
						<span><? echo implode('x', $value_arr) ?>м</span>
					</p>
					<p class="my-transport-info odd">
						<span class="name">Объем кузова:</span>
						<span><?=$row->volume ?> м3</span>
					</p>
					<p class="my-transport-info even">
						<span class="name">Тип кузова:</span>
						<span><?=$row->body_type ? $row->body_type : 'Не указан' ?></span>
					</p>
					<p class="my-transport-info odd">
						<span class="name">Способы погрузки:</span>
						<span><?=$row->loading_type ? $row->volume : 'Не указаны' ?></span>
					</p>
				</div>
				<? if($row->comment) { ?>
					<div class="my-transport-comment"><?=$row->comment ?></div>
				<? } ?>
			</div>

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
    
    <?/*
    <li class="my-transport-list-item">
        <div class="my-transport-wr clearfix">
            <img src="/images/transport-item.jpg" alt="" class="my-transport-image">
            <div class="my-transport-info-wr">
                <p class="my-transport-name">DAF XF 105/510</p>
                <p class="my-transport-info odd">
                    <span class="name">Грузоподъемность:</span>
                    <span>200кг</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Д; Ш; В:</span>
                    <span>Не указаны</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Объем кузова:</span>
                    <span>100 м3</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Тип кузова:</span>
                    <span>Не указан</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Способы погрузки:</span>
                    <span>Верхняя, Задняя</span>
                </p>
            </div>
            <div class="my-transport-comment">Комментарий: Перевозим практически любые автомобили</div>
        </div>
        
        <div class="my-transport-edit">
            <div class="my-transport-edit-top">
                <a href="#" class="my-transport-edit-btn btn-blue1">Редактировать</a>
                <a href="#" class="my-transport-delete-btn btn-red">Удалить х</a>
            </div>
            <a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a>            
        </div>
    </li>
    
    <li class="my-transport-list-item">
        <div class="my-transport-wr clearfix">
            <img src="/images/transport-item.jpg" alt="" class="my-transport-image">
            <div class="my-transport-info-wr">
                <p class="my-transport-name">DAF XF 105/510</p>
                <p class="my-transport-info odd">
                    <span class="name">Грузоподъемность:</span>
                    <span>200кг</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Д; Ш; В:</span>
                    <span>Не указаны</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Объем кузова:</span>
                    <span>100 м3</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Тип кузова:</span>
                    <span>Не указан</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Способы погрузки:</span>
                    <span>Верхняя, Задняя</span>
                </p>
            </div>
            <div class="my-transport-comment">Комментарий: Перевозим практически любые автомобили</div>
        </div>
        <div class="my-transport-edit">
            <div class="my-transport-edit-top">
                <a href="#" class="my-transport-edit-btn btn-blue1">Редактировать</a>
                <a href="#" class="my-transport-delete-btn btn-red">Удалить х</a>
            </div>
            <a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a>            
        </div>
        
    </li>
    
    <li class="my-transport-list-item">
        <div class="my-transport-wr clearfix">
            <img src="/images/transport-item.jpg" alt="" class="my-transport-image">
            <div class="my-transport-info-wr">
                <p class="my-transport-name">DAF XF 105/510</p>
                <p class="my-transport-info odd">
                    <span class="name">Грузоподъемность:</span>
                    <span>200кг</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Д; Ш; В:</span>
                    <span>Не указаны</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Объем кузова:</span>
                    <span>100 м3</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Тип кузова:</span>
                    <span>Не указан</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Способы погрузки:</span>
                    <span>Верхняя, Задняя</span>
                </p>
            </div>
            <div class="my-transport-comment">Комментарий: Перевозим практически любые автомобили</div>
        </div>
        <div class="my-transport-edit">
            <div class="my-transport-edit-top">
                <a href="#" class="my-transport-edit-btn btn-blue1">Редактировать</a>
                <a href="#" class="my-transport-delete-btn btn-red">Удалить х</a>
            </div>
            <a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a>            
        </div>
        
    </li>
    
    <li class="my-transport-list-item">
        <div class="my-transport-wr clearfix">
            <img src="/images/transport-item.jpg" alt="" class="my-transport-image">
            <div class="my-transport-info-wr">
                <p class="my-transport-name">DAF XF 105/510</p>
                <p class="my-transport-info odd">
                    <span class="name">Грузоподъемность:</span>
                    <span>200кг</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Д; Ш; В:</span>
                    <span>Не указаны</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Объем кузова:</span>
                    <span>100 м3</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Тип кузова:</span>
                    <span>Не указан</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Способы погрузки:</span>
                    <span>Верхняя, Задняя</span>
                </p>
            </div>
            <div class="my-transport-comment">Комментарий: Перевозим практически любые автомобили</div>
        </div>
        <div class="my-transport-edit">
            <div class="my-transport-edit-top">
                <a href="#" class="my-transport-edit-btn btn-blue1">Редактировать</a>
                <a href="#" class="my-transport-delete-btn btn-red">Удалить х</a>
            </div>
            <a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a>            
        </div>
        
    </li>
    
    <li class="my-transport-list-item">
        <div class="my-transport-wr clearfix">
            <img src="/images/transport-no-foto.jpg" alt="" class="my-transport-image">
            <div class="my-transport-info-wr">
                <p class="my-transport-name">DAF XF 105/510</p>
                <p class="my-transport-info odd">
                    <span class="name">Грузоподъемность:</span>
                    <span>200кг</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Д; Ш; В:</span>
                    <span>Не указаны</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Объем кузова:</span>
                    <span>100 м3</span>
                </p>
                <p class="my-transport-info even">
                    <span class="name">Тип кузова:</span>
                    <span>Не указан</span>
                </p>
                <p class="my-transport-info odd">
                    <span class="name">Способы погрузки:</span>
                    <span>Верхняя, Задняя</span>
                </p>
            </div>
            <div class="my-transport-comment">Комментарий: Перевозим практически любые автомобили</div>
        </div>
        <div class="my-transport-edit">
            <div class="my-transport-edit-top">
                <a href="#" class="my-transport-edit-btn btn-blue1">Редактировать</a>
                <a href="#" class="my-transport-delete-btn btn-red">Удалить х</a>
            </div>
            <a href="#" class="my-transport-upload-btn btn-blue1">Загрузить фото</a>            
        </div>
        
    </li>
	*/ ?>
    
    
</ul>