<?php 

$this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Profile");

$this->breadcrumbs=array(
	UserModule::t("Profile")=>array('profile'),
	UserModule::t("Edit"),
);

$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Мой транспорт',
);

$cs = $app->clientScript;

$cs->registerScript('loading', "
	$('.my-transport-list-item').hover(
        function(){ if(!$(this).hasClass('.add-transport-wr')) { $(this).children('.my-transport-edit').fadeIn(100) }    },
        function(){ if(!$(this).hasClass('.add-transport-wr')) { $(this).children('.my-transport-edit').fadeOut(100) }    }
    );
	
");
?>
 

<h1>Мой транспорт <span>(54 единицы)</span></h1>

<ul class="my-transport-list clearfix">
    <li class="my-transport-list-item add-transport-wr">
        <div class="add-transport clearfix">
            <a href="#" class="add-transport-btn">+</a>
            <p>Добавить транспорт</p>
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
    
    
</ul>