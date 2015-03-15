var cargo_name = '',
	loading_unloading_block = 0;

$(document).ready(function () {
	'use strict';
	
    $('#login-btn, #register-btn').click(function () {
        
        var url = $(this).attr('href'),
            modal = $('.modal');
        
        $.get(url, function (data) {
            modal.html(data).modal('show');
        });

        return false;
    });
    
    $('.modal').on('click', '.loginButton', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    //$('.modal').html(data);
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                    
                }
                
                //$('.modal').modal('hide');
            }
        );
        return false;
    });
    
    $('.modal').on('click', '#lostPassword, #loginBtn, #regBtn', function () {
        var url = $(this).attr('href'),
            modal = $('.modal');
        
        $.get(url, function (data) {
            modal.children('.modal-dialog').remove();
            modal.append(data);
            
        });

        return false;
    });
    
    $('.modal').on('click', '#restoreButton', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                //console.log(data);
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    //$('.modal').html(data);
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                    
                }
                
                //$('.modal').modal('hide');
            }
        );
        return false;
    });
    
    $('.modal').on('click', '.select-user-type', function () {
        
        var form = $(this).closest('form'),
            modal = $('.modal');
        
        $('#user_type').val($(this).data('type'));
        
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    //$('.modal').html(data);
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                    
                }
                
                //$('.modal').modal('hide');
            }
        );
        return false;
    });
    
    $('.modal').on('click', '#registerButton', function () {
        
        var form = $(this).closest('form'),
            modal = $('.modal');
        
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    $('.modal').children('.modal-dialog').remove();
                    $('.modal').append(data);
                    
                }
                
                //$('.modal').modal('hide');
            }
        );
        return false;
    });
	
	
    $('.step1-category-item').on('click', function () {
		$('.step1-category-item').removeClass('active');
		$(this).addClass('active');
		
		$.ajax({
			type: 'get',
			url: '/index.php?r=bids/step2form',
			data: {category_id : $(this).data('catid')},
			dataType: 'html',
			beforeSend: function () {
			},
			success: function (msg) {
				$('#step2Container').html(msg);
				$('#step2Container .checkbox').styler();
			}
		});
		
	});
    
    //$('#step2Container').on('change', '.step2-category-item-checkbox', function () {
    $('#Bids_have_account').change(function () {
		console.log($(this).is(':checked'));
		
		
		if($(this).is(':checked')) {
			$('#step-reg-form').hide();
			$('#step-login-form').show();
			
		} else {
			$('#step-reg-form').show();
			$('#step-login-form').hide();
			
		}
		
		//console.log('1121');
		/*
		$('.step1-category-item').removeClass('active');
		$(this).addClass('active');
		console.log($(this).data('catid'));
		
		$.ajax({
			type: 'get',
			url: '/index.php?r=bids/step2form',
			data: {category_id : $(this).data('catid')},
			dataType: 'html',
			beforeSend: function () {
			},
			success: function (msg) {
				$('#step2Container').html(msg);
				$('#step2Container .checkbox').styler();
			}
		});
		*/
		
	});
	
    	$('#add-loading-unloading-block').on('click', function (e) {
			loading_unloading_block++;
			
			$('.add-loading-unloading-block').each(function () {
				if($(this).is(':hidden')) {
					$(this).slideDown(50);
					return false;
				} else {
					
				}
			});
			
			e.preventDefault();
			return false;
		});
	
    	$('.delete-loading-unloading-block').on('click', function (e) {
			
			$(this).parent().find('input[type="text"]').each(function () {
				$(this).val('');
			});
			
			$(this).parent().slideUp(50);
			
			e.preventDefault();
			return false;
		});
	
    
    
    
});

function change_step2_cat(el) {
	var get_step3form = false,
		count = 0;
	
	cargo_name = '';
	
	$('.step2-category-item-checkbox').each(function(){
		if($(this).is(':checked')) {
			get_step3form = true;
			if(cargo_name != '') {
				cargo_name = cargo_name + ', ';
			}
			cargo_name = cargo_name + $('label[for="'+$(this).attr('id')+'"]').text();
			count++;
			//console.log($(this).val());
		}
	});
	
	if(count > 1) {
		get_step3form = false;
	}
	
	
	
	if(get_step3form) {
		$.ajax({
			type: 'get',
			url: '/index.php?r=bids/step3form',
			data: {category_id : $('.step1-category-item.active').data('catid')},
			dataType: 'html',
			beforeSend: function () {
			},
			success: function (msg) {
				$('#step3Container').html(msg);
				$('#step3Container .checkbox, #step3Container select').styler();
				$('#Cargoes_name').val(cargo_name);
				$('#step-final-btn-wr').show();
			}
		});
		
	} else {
		$('#Cargoes_name').val(cargo_name);
	}
	
	//console.log($(el).val());
}

