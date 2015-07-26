<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
?>

<p>Пользователь <?=CHtml::link($user_name, $user_url, array('target'=>'_blank'))?> запросил смену email-а на "<?=$new_email?>".</p>