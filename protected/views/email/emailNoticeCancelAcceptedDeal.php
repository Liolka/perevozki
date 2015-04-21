<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Уважаемый <?=$dealer_name?>, пользователь <?=CHtml::link($user_name, $user_url, array('target'=>'_blank'))?> отменил, принятое ранее, Ваше предложение в заявке "<?=CHtml::link($bid_name, $bid_url, array('target'=>'_blank'))?>"</p>