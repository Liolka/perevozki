<?
$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Редактировать Информация о компании, контакты',
);

?>

<h1>Информация о компании, контакты</h1>

<div class="my-contact-info-company my-contact-info-company-edit">
	<div class="my-contact-info-container-wr">
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header">Контактная информация</p>
			<div class="row">
				<ul class="phones">
					<li class="field-title">Телефонные номера:</li>
					<li>1) <input type="text" value="+375 (46) 567 81 82" /></li>
					<li>2) <input type="text" value="+375 (46) 567 81 82" /></li>
					<li>3) <input type="text" value="+375 (46) 567 81 82" /></li>
					<li>4) <input type="text" value="+375 (46) 567 81 82" /></li>
				</ul>
			</div>
			<div class="row">
				<ul class="contacts">
					<li class="email"><span class="field-title">E-mail:</span> <input type="text" value="vanya125@mail.ru" /></li>
					<li class="skype"><span class="field-title">Skype:</span> <input type="text" value="vanya125" /></li>
					<li class="website"><span class="field-title">Веб-сайт:</span> <input type="text" value="vanya125.ru" /></li>
				</ul>
			</div>
		</div>
		
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header">Информация о компании</p>
			<div class="my-contact-info-company-container clearfix">
				<ul class="my-contact-info-company-list">
					<li>
						<p>Тип компании:</p>
						<p><input type="text" value="ООО" /></p>
					</li>
					<li>
						<p>Год основания:</p>
						<p><input type="text" value="2004" /></p>
					</li>
					<li>
						<p>Кол-во авто:</p>
						<p><input type="text" value="54" /></p>
					</li>
					<li>
						<p>Количество сотрудников:</p>
						<p><input type="text" value="" /></p>
					</li>
				</ul>

				<ul class="my-contact-info-company-list">
					<li>
						<p>Головной офис:</p>
						<p><input type="text" class="wide" value="Россия, Москва, ул.Лукинская" /><span></span></p>
					</li>
					<li>
						<p>Филиалы:</p>
						<p><input type="text" class="wide" value="" /></p>
					</li>
					<li>
						<p>Склады и терминалы:</p>
						<p><input type="text" class="wide" value="" /></p>
					</li>
				</ul>
			</div>
		</div>
		<div class="my-contact-info-company-container clearfix">
			<p class="my-contact-info-header">Дополнительно:</p>
			<div class="my-contact-info-company-container clearfix">
				<textarea>Перевозка автомобилей конструктивно предусмотренными, многоместными прицепными системами – автовозами. Собственный парк автовозов европейского производства, в безупречном техническом состоянии, оборудованных всем необходимым для транспортировки автомобилей любых типов и размеров.</textarea>
			</div>
		</div>
		
		<a href="<?=$this->createUrl('/site/index')?>" class="btn-blue-33">Сохранить</a>
		<a href="<?=$this->createUrl('/user/my/info')?>" class="btn-green-33">Отменить</a>
	</div>
</div>

