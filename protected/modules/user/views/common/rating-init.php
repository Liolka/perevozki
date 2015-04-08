<?
$cs = $this->app->getClientScript();

$cs->registerScript('rating-init', "
	$('.auto-submit-star').rating({
		callback: function(value, link){
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
			
				console.log(value);
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