<?
$this->breadcrumbs=array(
	$this->app->user->username => array('/user/my'),
	'Информация о компании, контакты',
);

$this->pageTitle = "Информация о компании, контакты";

?>
 

<h1>Информация о компании, контакты</h1>
<div class="my-contact-info-container blue-border-1 pos-rel">
	<div class="my-contact-info-container-wr p-20">
		<p class="narrow-bold-18 mb-25">Контактная информация</p>
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
		<a href="<?=$this->createUrl('/user/my/infoedit')?>" class="btn-blue-33 btn-w250 pos-abs">Редактировать</a>
	</div>
	<div class="my-contact-info-company bg_f4fbfe">
		<div class="my-contact-info-container-wr p-20">
			<p class="narrow-bold-18 mb-25">Информация о компании</p>
			<div class="my-contact-info-company-container row mb-35">
				<ul class="my-contact-info-company-list col-lg-5 col-md-5">
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

				<ul class="my-contact-info-company-list col-lg-7 col-md-7">
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
				<p class="narrow-bold-18 mb-25">Дополнительно</p>
				<p class="my-contact-info-descr"><?=$user_company->description?></p>
			<?	}	?>


		</div>
	</div>
</div>