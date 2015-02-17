<?
$this->breadcrumbs=array(
	$app->user->username => array('/user/my'),
	'Информация о компании, контакты',
);

?>
 

<h1>Информация о компании, контакты</h1>
<div class="my-contact-info-container">
	<div class="my-contact-info-container-wr">
		<p class="my-contact-info-header">Контактная информация</p>
		<ul class="my-contact-info-list">
			<li>
				<p class="phone">+ 375 (46) 567 81 82</p>
				<p class="phone">+ 375 (46) 567 81 82</p>
			</li>
			<li><p class="email">vanya125@mail.ru</p></li>
			<li><p class="skype">vanya125</p></li>
			<li><p class="website">vanya125.ru</p></li>
		</ul>
		<a href="<?=$this->createUrl('/user/my/infoedit')?>" class="btn-blue-33 btn-w250">Редактировать</a>
	</div>
	<div class="my-contact-info-company">
		<div class="my-contact-info-container-wr">
			<p class="my-contact-info-header">Контактная информация</p>
			<div class="my-contact-info-company-container clearfix">
				<ul class="my-contact-info-company-list">
					<li>
						<p>Тип компании:</p>
						<p><span>ООО</span></p>
					</li>
					<li>
						<p>Год основания:</p>
						<p><span>2004</span></p>
					</li>
					<li>
						<p>Кол-во авто:</p>
						<p><span>54</span></p>
					</li>
					<li>
						<p>Количество сотрудников:</p>
						<p>Не указано</p>
					</li>
				</ul>

				<ul class="my-contact-info-company-list">
					<li>
						<p></p>
						<p></p>
					</li>
					<li>
						<p>Головной офис:</p>
						<p><span>Россия, Москва, ул.Лукинская</span></p>
					</li>
					<li>
						<p>Филиалы:</p>
						<p>Не указано</p>
					</li>
					<li>
						<p>Склады и терминалы:</p>
						<p>Не указано</p>
					</li>
				</ul>
			</div>

			<p class="my-contact-info-header">Дополнительно</p>
			<p class="my-contact-info-descr">Перевозка автомобилей конструктивно предусмотренными, многоместными прицепными системами – автовозами. Собственный парк автовозов европейского производства, в безупречном техническом состоянии, оборудованных всем необходимым для транспортировки автомобилей любых типов и размеров.</p>

		</div>
	</div>
</div>