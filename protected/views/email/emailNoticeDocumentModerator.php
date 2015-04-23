<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Пользователь <?=CHtml::link($user_name, $user_url, array('target'=>'_blank'))?> загрузил в личном кабинете документ "<?=$document_name?>".</p>