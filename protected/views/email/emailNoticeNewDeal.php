<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Уважаемый <?=$user_name?>, на размещеную Вами заявку <?=CHtml::link($bid_name, $bid_url, array('target'=>'_blank'))?> было сделано предложение пользователем <?=CHtml::link($dealer_name, $dealer_url, array('target'=>'_blank'))?></p>
