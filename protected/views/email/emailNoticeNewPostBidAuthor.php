<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Уважаемый <?=$user_name?>, пользователь <?=CHtml::link($dealer_name, $dealer_url, array('target'=>'_blank'))?> оставил комментарий в своём предложении на Вашу заявку "<?=CHtml::link($bid_name, $bid_url, array('target'=>'_blank'))?>".</p>