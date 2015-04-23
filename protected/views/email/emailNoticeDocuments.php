<? /** @var dpsEmailController $this */
$this->setSubject( $subject ); // указываем тему
//$this->setLayout( 'emailLayoutTpl' ); // какой макет
//$this->attach( $sFilePath ); // приложим файлик
?>
<p>Уважаемый <?=$user_name?>, администрация сайта <?=CHtml::link(Yii::app()->params['siteName'], Yii::app()->homeUrl, array('target'=>'_blank'))?> проверила, загруженные Вами, документы:<br /> 
<?=implode(';<br>', $document_names)?></p>