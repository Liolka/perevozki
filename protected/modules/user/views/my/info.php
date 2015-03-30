<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Информация о компании, контакты',
);

?>
 

<h1>Информация о компании, контакты</h1>
<div class="my-contact-info-container">
	<div class="my-contact-info-container-wr">
		<p class="my-contact-info-header">Контактная информация</p>
		<ul class="my-contact-info-list">
			<li>
				<? if($user_company->phone1 != '')	{	?>
					<p class="phone"><?=$user_company->phone1?></p>
				<?	}	?>
				
				<? if($user_company->phone2 != '')	{	?>
					<p class="phone"><?=$user_company->phone2?></p>
				<?	}	?>
				
				<? if($user_company->phone3 != '')	{	?>
					<p class="phone"><?=$user_company->phone3?></p>
				<?	}	?>
				
				<? if($user_company->phone4 != '')	{	?>
					<p class="phone"><?=$user_company->phone4?></p>
				<?	}	?>
				

			</li>
			<li><p class="email"><?=$user_company->email?></p></li>
			<li><p class="skype"><?=$user_company->skype?></p></li>
			<li><p class="website"><?=$user_company->site?></p></li>
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
						<p><?=$user_company->type ? '<span>'.$user_company->type.'</span>' : 'Не указано' ?></p>
					</li>
					<li>
						<p>Год основания:</p>
						<p><?=$user_company->year ? '<span>'.$user_company->year.'</span>' : 'Не указано' ?></p>
					</li>
					<li>
						<p>Кол-во авто:</p>
						<p><?=$user_company->count_auto ? '<span>'.$user_company->count_auto.'</span>' : 'Не указано' ?></p>
					</li>
					<li>
						<p>Количество сотрудников:</p>
						<p><?=$user_company->count_staff ? '<span>'.$user_company->count_staff.'</span>' : 'Не указано' ?></p>
					</li>
				</ul>

				<ul class="my-contact-info-company-list">
					<li>
						<p></p>
						<p></p>
					</li>
					<li>
						<p>Головной офис:</p>
						<p><?=$user_company->main_office ? '<span>'.$user_company->main_office.'</span>' : 'Не указано' ?></p>
					</li>
					<li>
						<p>Филиалы:</p>
						<p><?=$user_company->filials ? '<span>'.$user_company->filials.'</span>' : 'Не указано' ?></p>
					</li>
					<li>
						<p>Склады и терминалы:</p>
						<p><?=$user_company->terminals ? '<span>'.$user_company->terminals.'</span>' : 'Не указано' ?></p>
					</li>
				</ul>
			</div>
			
			<? if($user_company->description != '')	{	?>
				<p class="my-contact-info-header">Дополнительно</p>
				<p class="my-contact-info-descr"><?=$user_company->description?></p>
			<?	}	?>


		</div>
	</div>
</div>