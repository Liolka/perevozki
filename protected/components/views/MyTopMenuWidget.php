<div class="my-top-menu">
	<?php
		switch($this->user->user_type) {
			case 2:
				$items = array(
					array('label'=>'Заявки', 'url'=>array('/user/my/requests'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-zayavki')),
					array('label'=>'Транспорт', 'url'=>array('/user/my/transport'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-transport')),
					array('label'=>'Мои документы', 'url'=>array('/user/my/documents'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-documents')),
					array('label'=>'Основные данные', 'url'=>array('/user/my/info'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-info')),
					array('label'=>'Регистрационные данные', 'url'=>array('/user/my/edit'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-profile')),
				);
				break;
			
			case 1:
			default:
				$items = array(
					array('label'=>'Заявки', 'url'=>array('/user/my/requests'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-zayavki')),
					//array('label'=>'Мои документы', 'url'=>array('/user/my/documents'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-documents')),
					array('label'=>'Основные данные', 'url'=>array('/user/my/info'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-info')),
					array('label'=>'Регистрационные данные', 'url'=>array('/user/my/edit'), 'itemOptions'=>array('class'=>'my-top-menu-item my-top-menu-profile')),
				);
				break;
		}
		
		$this->widget('zii.widgets.CMenu',array(
			'items' => $items,
			'htmlOptions' => array('class'=>'my-top-menu-list width-wrap clearfix', 'id'=>'my-top-menu-list')
		)); 
	?>
					
</div>