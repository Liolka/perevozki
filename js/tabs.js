$(function(){
	//$('#myTab a[href=\"#tab1\"]').tab('show'); // Выбор вкладки по имени
	/*
    $('#myTab a[href="'+$('#current-tab').val()+'"]').tab('show'); // Выбор вкладки по имени
    $('#myTab a').click(function(e) {
		e.preventDefault();
    	$(this).tab('show');
		$('#current-tab').val($(this).attr('href'));
    });
    */
    
    $('#nav-tabs a').on('click', function(){
        $('.tab-pane').fadeOut();
        $('.tab-pane').removeClass('active');
        $($(this).attr('href')).fadeIn();
    });
});