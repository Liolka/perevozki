<?
$cs = $this->app->getClientScript();
//$cs1 = $this->app->getClientScript();
if(!$this->app->user->isGuest)	{
	if($this->app->user->user_type == 1) {
		$cs->registerCoreScript('rating-g');
	}	else	{
		$cs->registerCoreScript('rating-b');
	}
}	else	{
	$cs->registerCoreScript('rating-g');
}
//$cs->registerCoreScript('rating');
$cs->registerCoreScript('simplyCountable');


$cs->registerScript('rating-init', "
	$('.auto-submit-star').rating({
		callback: function(value, link){
			if(value != undefined) {
				$(this).parent().parent().parent().parent().find('.rating-value').val(value);
			}
		}
	});
	
	$('#listView').on('click', '.show-full-review', function () {
		$(this).parent().parent().parent().parent().find('.requests-full-review').slideToggle();
	});
	
	$('#listView').on('click', '.requests-full-review-hide', function () {
		$(this).parent().parent().parent().find('.requests-full-review').slideToggle();
	});
	
	$('#listView').on('click', '.rating-cancel', function () {
		$(this).parent().parent().parent().parent().find('.rating-value').val('');
	});
	
	$('#listView').on('click', '.btn-send-review', function () {
        var form = $(this).closest('form'),
            err_wrap = $('.error');
        
		err_wrap.hide();
		
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    err_wrap.html(data);
					err_wrap.show();
                }
            }
        );
        return false;
	});
");
?>