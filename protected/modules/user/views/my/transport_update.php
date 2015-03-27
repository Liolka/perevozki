<?php 

$title = 'Редактировать транспорт';

$this->renderPartial('_transport_form', array(
	'model'=>$model,
	'title'=>$title,
));

?>
