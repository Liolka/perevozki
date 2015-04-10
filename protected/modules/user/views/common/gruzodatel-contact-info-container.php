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
				<?
				switch($user_status)	{
					case 1: 
					$tmpl = "gruzodatel-contact-info-container-ur.php";
					break;

					case 2: 
					default: 
					$tmpl = "gruzodatel-contact-info-container-fiz.php";
					break;
				}

				include ($tmpl);	
				?>			
			</div>
			
			<? if($user_company->description != '')	{	?>
				<p class="narrow-bold-18 mb-25"><?php echo CHtml::encode($user_company->getAttributeLabel('description')); ?></p>
				<p class="contact-info-descr"><?=$user_company->description?></p>
			<?	}	?>
		</div>
	</div>
</div>