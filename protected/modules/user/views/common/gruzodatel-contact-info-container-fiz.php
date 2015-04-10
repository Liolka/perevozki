<ul class="contact-info-list col-lg-12 col-md-12">
	<li>
		<p><? echo $user_company->getAttributeLabel('fio');?>:</p>
		<p><?=$user_company->fio ? '<span>'.$user_company->fio.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p><? echo $user_company->getAttributeLabel('birthday');?>:</p>
		<p class="contact-info-wide"><?=$user_company->birthday ? '<span>'.$user_company->birthday.'</span>' : 'Не указано' ?></p>						
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
		<p><? echo $user_company->getAttributeLabel('country');?>:</p>
		<p><?=$user_company->country ? '<span>'.$user_company->country.'</span>' : 'Не указано' ?></p>
		<p class="sep"></p>
		<p><? echo $user_company->getAttributeLabel('town');?>:</p>
		<p class="contact-info-wide"><?=$user_company->town ? '<span>'.$user_company->town.'</span>' : 'Не указано' ?></p>
	</li>
</ul>
