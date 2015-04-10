<ul class="contact-info-list col-lg-12 col-md-12">
	<li>
		<p><? echo $user_company->getAttributeLabel('company_name');?>:</p>
		<p><?=$user_company->company_name ? '<span>'.$user_company->company_name.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p><? echo $user_company->getAttributeLabel('unp');?>:</p>
		<p class="contact-info-wide"><?=$user_company->unp ? '<span>'.$user_company->unp.'</span>' : 'Не указано' ?></p>						
	</li>
	<?/*
	<li>
		<p><? echo $user_company->getAttributeLabel('unp');?>:</p>
		<p><?=$user_company->unp ? '<span>'.$user_company->unp.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p></p>
		<p class="contact-info-wide"></p>

	</li>
	*/?>
	<li>
		<p><? echo $user_company->getAttributeLabel('main_office');?>:</p>
		<p><?=$user_company->main_office ? '<span>'.$user_company->main_office.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p><? echo $user_company->getAttributeLabel('filials');?>:</p>
		<p class="contact-info-wide"><?=$user_company->filials ? '<span>'.$user_company->filials.'</span>' : 'Не указано' ?></p>

	</li>
	<?/*
	<li>
		<p><? echo $user_company->getAttributeLabel('filials');?>:</p>
		<p><?=$user_company->filials ? '<span>'.$user_company->filials.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p></p>
		<p class="contact-info-wide"></p>

	</li>
	*/?>
</ul>