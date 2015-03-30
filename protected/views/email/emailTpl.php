<? /** @var dpsEmailController $this */
$this->setSubject( 'Тема письма' ); // указываем тему
$this->setLayout( 'emailLayoutTpl' ); // какой макет
$this->attach( $sFilePath ); // приложим файлик
?>
Привет <?=$sUsername ?>!