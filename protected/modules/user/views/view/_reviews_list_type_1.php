<?
$cs = $this->app->getClientScript();

$cs->registerScript('loading', "
	$('.auto-submit-star').rating({
		callback: function(value1, link){
			if(value != undefined) {
				$.ajax({
					type: 'post',
					url: '/bids/step2form',
					data: {rating_data : value},
					dataType: 'html',
					beforeSend: function () {
					},
					success: function (msg) {
						//$('#step2Container').html(msg);
						//$('#step2Container .checkbox').styler();
					}
				});
			} else {
			}
			
		}
	});
	
	$('.rate-this-btn').on('click', function(e){
		e.preventDefault();
		$(this).hide();
		$(this).parent().children('.stars-wr').show();
	});
	
	$('.comment-this-btn').on('click', function(e){
		e.preventDefault();
		$(this).parent().parent().parent().parent().find('.profile-requests-comment-frm').slideToggle();
	});
");

//$cs1 = $this->app->getClientScript();
$cs->registerCoreScript('rating');
$cs->registerCoreScript('simplyCountable');

?>

	
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view_reviews_item_type_1',
	'ajaxUpdate'=>false,
	'template'=>"{items}",
	'itemsCssClass' => 'mb-10',
	'htmlOptions' => array('id'=>'listView', 'class'=>'requests1-list-items'),
)); ?>

<? if(count($dataProvider->data))	{	?>
	<a href="<?=$this->createUrl('/user/requests', array('id'=>$model->id))?>" id="showMore" class="requests-more-btn db text_c c_1e91da narrow-regular-20 blue-border-1 bg_f4fbfe">Смотреть все</a>
<?	}	?>
