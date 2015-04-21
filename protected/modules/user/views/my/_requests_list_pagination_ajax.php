<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize): ?>
 
    <p id="loading" class="requests-more-btn text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe" style="display:none">Загрузка...</p>
	<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>    
<?

$cs = $this->app->getClientScript();

$cs->registerCoreScript('rating');
$cs->registerCoreScript('simplyCountable');


$cs->registerScript('requests', "
	// скрываем стандартный навигатор
	$('.pager').hide();

	// запоминаем текущую страницу и их максимальное количество
	var page = parseInt('".(int)Yii::app()->request->getParam('page', 1)."');
	var pageCount = parseInt('".(int)$dataProvider->pagination->pageCount."');

	var loadingFlag = false;

	$('#showMore').click(function()
	{
		// защита от повторных нажатий
		if (!loadingFlag)
		{
			// выставляем блокировку
			loadingFlag = true;

			// отображаем анимацию загрузки
			$('#loading').show();
			$('#showMore').hide();

			$.ajax({
				type: 'post',
				url: window.location.href,
				data: {
					// передаём номер нужной страницы методом POST
					'page': page + 1,
					'".Yii::app()->request->csrfTokenName."': '".Yii::app()->request->csrfToken."'
				},
				success: function(data)
				{
					// увеличиваем номер текущей страницы и снимаем блокировку
					page++;                            
					loadingFlag = false;                            

					// прячем анимацию загрузки
					$('#loading').hide();
					$('#showMore').show();

					// вставляем полученные записи после имеющихся в наш блок
					$('#listView').append(data);

					// если достигли максимальной страницы, то прячем кнопку
					if (page >= pageCount)
						$('#showMore').hide();

					$('.auto-submit-star').rating({
						callback: function(value, link){
							if(value != undefined) {
								$(this).parent().parent().parent().parent().find('.rating-value').val(value);
							}
						}
					});

				}
			});
		}
		return false;
	})
");
					
?>
<?php endif; ?>