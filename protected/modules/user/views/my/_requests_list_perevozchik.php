<ul class="requests1-list-head clearfix p-20">
	<li class="col1 fLeft c_757575 font-12 text_c">№</li>
	<li class="col2 fLeft c_757575 font-12">Информация о грузе</li>
	<li class="col3 fLeft c_757575 font-12 text_c">Дата</li>
	<li class="col4 fLeft c_757575 font-12">Перевозчик</li>
	<li class="col5 fLeft c_757575 font-12 text_c"><p class="review-perevoz-ttl pos-rel"><span class="bold c_2e3c54 otziv-lbl">Отзыв перевозчика<span class="notice bold c_fcb60e font-20 pos-abs db">*</span></span></p></li>
	<li class="col6 fLeft c_757575 font-12">Заказчик</li>
	<li class="col7 fLeft c_757575 font-12">Отзыв заказчика</li>
</ul>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_requests_perevozchik',
	'ajaxUpdate'=>false,
	'template'=>"{items}\n{pager}",
	'pager'=>array(
		'htmlOptions'=>array(
			'class'=>'paginator'
		)
	),	
	//'itemsCssClass' => 'blue-border-1 p-20 mb-10 bg_f4fbfe_h pos-rel clearfix',
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'listView', 'class'=>'requests1-list-items',),
)); ?>

<?php if ($dataProvider->totalItemCount > $dataProvider->pagination->pageSize): ?>
 
    <p id="loading" class="requests-more-btn text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe" style="display:none">Загрузка...</p>
	<a href="#" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Показать еще</a>    
 
    <script type="text/javascript">
    /*<![CDATA[*/
        (function($)
        {
            // скрываем стандартный навигатор
            $('.pager').hide();
 
            // запоминаем текущую страницу и их максимальное количество
            var page = parseInt('<?php echo (int)Yii::app()->request->getParam('page', 1); ?>');
            var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');
 
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
                            '<?php echo Yii::app()->request->csrfTokenName; ?>': '<?php echo Yii::app()->request->csrfToken; ?>'
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
        })(jQuery);
    /*]]>*/
    </script>
 
<?php endif; ?>

