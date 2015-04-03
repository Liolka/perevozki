<div class="contact-info-container blue-border-1 pos-rel">
	<div class="p-20">
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
			
			<? if($user_company->email != '')	{	?>
				<li><p class="email"><?=$user_company->email?></p></li>
			<?	}	?>
			
			<? if($user_company->skype != '')	{	?>
				<li><p class="skype"><?=$user_company->skype?></p></li>
			<?	}	?>
			
			<? if($user_company->site != '')	{	?>
				<li><p class="website"><?=$user_company->site?></p></li>
			<?	}	?>
		</ul>
		<? if($show_edit_btn) { ?>
			<a href="<?=$this->createUrl('/user/my/infoedit')?>" class="btn-blue-33 btn-w250 pos-abs">Редактировать</a>
		<?	}	?>
	</div>
	<div class="my-contact-info-company bg_f4fbfe">
		<div class="my-contact-info-container-wr p-20">
			<p class="narrow-bold-18 mb-25">Информация о компании</p>
			<div class="row mb-35">
				<ul class="contact-info-list col-lg-12 col-md-12">
					<li>
						<p>Тип компании:</p>
						<p><?=$user_company->type ? '<span>'.$user_company->type.'</span>' : 'Не указано' ?></p>
						<p class="sep"></p>
						<p></p>
						<p class="contact-info-wide"></p>						
					</li>
					<li>
						<p>Год основания:</p>
						<p><?=$user_company->year ? '<span>'.$user_company->year.'</span>' : 'Не указано' ?></p>
						<p class="sep"></p>
						<p>Головной офис:</p>
						<p class="contact-info-wide"><?=$user_company->main_office ? '<span>'.$user_company->main_office.'</span>' : 'Не указано' ?></p>
						
					</li>
					<li>
						<p>Кол-во авто:</p>
						<p><?=$user_company->count_auto ? '<span>'.$user_company->count_auto.'</span>' : 'Не указано' ?></p>
						<p class="sep"></p>
						<p>Филиалы:</p>
						<p class="contact-info-wide"><?=$user_company->filials ? '<span>'.$user_company->filials.'</span>' : 'Не указано' ?></p>
						
					</li>
					<li>
						<p>Количество сотрудников:</p>
						<p><?=$user_company->count_staff ? '<span>'.$user_company->count_staff.'</span>' : 'Не указано' ?></p>
						<p class="sep"></p>
						<p>Склады и терминалы:</p>
						<p class="contact-info-wide"><?=$user_company->terminals ? '<span>'.$user_company->terminals.'</span>' : 'Не указано' ?></p>
						
					</li>
				</ul>
			</div>
			
			<? if($user_company->description != '')	{	?>
				<p class="narrow-bold-18 mb-25">Дополнительно</p>
				<p class="contact-info-descr"><?=$user_company->description?></p>
			<?	}	?>


		</div>
	</div>
</div>