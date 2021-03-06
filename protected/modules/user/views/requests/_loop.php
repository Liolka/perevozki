<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>$itemView,
	'ajaxUpdate'=>false,
	'template'=>"{items}\n{pager}",
	'pager'=>array(
		'htmlOptions'=>array(
			'class'=>'paginator'
		)
	),	
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'listView', 'class'=>'requests1-list-items',),
)); ?>



<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize)	{	?>
 
    <? /*<p id="loading" style="display:none"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/loading.gif" alt="" /></p> */ ?>
    <p id="loading" class="requests-more-btn text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe" style="display:none">Загрузка...</p>
    <? /* <p id="showMore">Показать ещё</p> */ ?>
    <? /*<a href="#" class="requests-more-btn">Показать еще</a> */?>
	<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>
    <? /*<p id="showMore" class="requests-more-btn">Показать еще</p> */ ?>
	<?
	$this->app->clientScript->registerScript('bids-index', "
// скрываем стандартный навигатор
$('.pager').hide();

// запоминаем текущую страницу и их максимальное количество
var page = parseInt('".(int)$this->app->request->getParam('page', 1)."');
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
				'".$this->app->request->csrfTokenName."': '".$this->app->request->csrfToken."'
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
			}
		});
	}
	return false;
})
");

?>
 
<?php	}	?>