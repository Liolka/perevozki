<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Уважаемый <?=$user_name?>, пользователь <?=CHtml::link($author_name, $author_url, array('target'=>'_blank'))?> разметил отзыв о Вас в заявке "<?=CHtml::link($bid_name, $bid_url, array('target'=>'_blank'))?>". Просмотреть данный отзыв Вы можете в своём <?=CHtml::link("Личном кабинете", $my_url, array('target'=>'_blank'))?></p>