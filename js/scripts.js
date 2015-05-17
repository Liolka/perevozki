var cargo_name = '',
	loading_unloading_block = 0,
	add_cargo_block = 0;

$(document).ready(function () {
	'use strict';
	
    $('.login-btn, .register-btn').click(function () {
        var url = $(this).attr('href')+"?modal=1",
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
	
    $('.form-login').on('click', '#lostPassword, #loginBtn, #regBtn', function () {
        var url = $(this).attr('href')+"?modal=1",
            modal = $('.modal');
        $.get(url, function (data) {
            modal.html(data).modal('show');
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
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                }
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
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                }
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
            }
        );
        return false;
    });
	
	
    $('.step1-category-item').on('click', function () {
		$('.step1-category-item').removeClass('active');
		$(this).addClass('active');
		$('#category_id').val($(this).data('catid'));
		
		$.ajax({
			type: 'get',
			url: '/bids/step2form',
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
    
    $('#Bids_have_account').change(function () {
		if($(this).is(':checked')) {
			$('#step-reg-form').hide();
			$('#step-login-form').show();
		} else {
			$('#step-reg-form').show();
			$('#step-login-form').hide();
		}
	});
	
	$('#add-loading-unloading-block').on('click', function (e) {
		loading_unloading_block++;
		e.preventDefault();
		$('.add-loading-unloading-block').each(function () {
			if($(this).is(':hidden')) {
				$(this).slideDown(50);
				return false;
			} else {

			}
		});
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
	
	$('#step3Container').on('click', '#add-cargo-block', function (e) {
		add_cargo_block++;
		e.preventDefault();
		$('.add-cargo-step-container').each(function () {
			if($(this).is(':hidden')) {
				$(this).slideDown(50);
				return false;
			}
		});
		return false;
	});

	$('#step3Container').on('click', '.delete-add-cargo-block', function (e) {
		e.preventDefault();
		$(this).parent().find('input[type="text"]').each(function () {
			$(this).val('');
		});
		$(this).parent().slideUp(50);
		return false;
	});
	
	//выбираем из выпадающего списка категорию для дополнительного груза
	$('#step3Container').on('change', '#Cargoes_category2', function () {
		$('#Cargoes_name2').val($(this).children().children(':selected').text());
	});
	
	//выбираем из выпадающего списка категорию для дополнительного груза
	$('#step3Container').on('change', '#Cargoes_category3', function () {
		$('#Cargoes_name3').val($(this).children().children(':selected').text())
	});
	
	//выбираем из выпадающего списка категорию для дополнительного груза
	$('#step3Container').on('change', '#Cargoes_category4', function () {
		$('#Cargoes_name4').val($(this).children().children(':selected').text())
	});
	
	$('#bids-filter-categories-check').on('click', function (e) {
		//e.preventDefault();
		console.log($('#bids-filter-categories input[type="checkbox"]').length);
		
		$('#bids-filter-categories input[type="checkbox"]').each(function(){
			
		$(this).attr('checked', 'checked').trigger('refresh');
		//$(this).trigger('refresh');  
			/*
		setTimeout(function() {  
		  
		}, 2);
			*/
		});
		return false;
	});

	$('#bids-filter-categories-uncheck').on('click', function (e) {
		//e.preventDefault();
		$('#bids-filter-categories input[type="checkbox"]').each(function(){
			$(this).removeAttr('checked').trigger('refresh');
			//$(this).trigger('refresh');  
			/*
				setTimeout(function() {  

			}, 2);*/
		});
		return false;
	});

	$('#bids-sorting-block-list a').on('click', function (e) {
		e.preventDefault();
		$('#type-sort').val($(this).data('sort'));
		$('#sort-bids-form').submit();
		return false;
	});
	
	/*
	$('.bids-filter-filterig').on('click', function (e) {
		e.preventDefault();
		$('#bids-filter-form').submit();
		return false;
	});
	*/

	$('#bids-filter-clear').on('click', function (e) {
		e.preventDefault();
		$('#clear-bids-filter').val(1);
		$('#bids-filter-form').submit();
		return false;
	});

	$('.bid-detail-deals-row .show-deals-comments').on('click', function () {
		var deals_block = $(this).parent().parent().parent();
		deals_block.children('.bid-detail-deals-row-answer-block-reviews').slideToggle(100);
		deals_block.toggleClass('active');
		deals_block.find('.accept-deal-btn').toggleClass('btn-grey-33');
		deals_block.find('.accept-deal-btn').toggleClass('btn-green-33');
		deals_block.find('.reject-deal-btn').toggleClass('ico-close-blue');
		deals_block.find('.reject-deal-btn').toggleClass('ico-close-red');
	});
	
    //отображение модального окна для добавления / редактирования транспорта
	$('#add-transport-btn, .my-transport-edit-btn').click(function () {
        var url = $(this).attr('href'),
            modal = $('.modal');
        
        $.get(url, function (data) {
            modal.html(data).modal('show');
			
			var upload = new AjaxUpload('#userfile', {
				action: '/user/my/uploadfoto.html',
				onSubmit : function(file, extension){
					$("#loading").show();
					if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))) {
						$("#loading").hide();
						$("<span class='error'>Неправильный тип файла</span>").appendTo("#file_holder #errormes");
						return false;
					} else {
						$('.error').hide();
					}	

					upload.setData({'file': file});
				},
				onComplete : function(file, response) {

					$("#loading").hide();

					$(".success").css("display", "block");

					var pItems = $(".iframe"),
						response = $.parseJSON($(pItems[(pItems.length - 1)]).contents().find('body').text());

					if(response.res == 'ok') {
						$('.modal').find('#my-transport-image').css('background-image', ('url('+response.msg+')'));
						$('.modal').find('#Transport_foto').val(response.foto);
					}
				}
			});
			
        });
        return false;
    });

	//обработка клика по кнопке "Загрузить фото транспорта"
	$('.modal').on('click', '#upload-transport-foto', function () {
		var pItems = $('input[name="userfile"]');
		$(pItems[1]).click();
        return false;
    });
	
    //обработка клика по кнопке сохранить с модальном окне редактирования транпорта
	$('.modal').on('click', '#saveTransportButton', function () {
        var form = $(this).closest('form'),
            modal = $('.modal');
        
        $.post(
            form.attr('action'),
            form.serialize(),
            function (data) {
                if (data == 'ok') {
                    window.location.reload();
                } else {
                    modal.children('.modal-dialog').remove();
                    modal.append(data);
                }
            }
        );
        return false;
    });
	
	$('#deal-set-transport').on('click', function () {
		$('#deals-form-transport-list').slideToggle(200);
        return false;
    });
	
	$('.deals-form-transport-list-item').on('click', function (e) {
		e.preventDefault();
		$('#deal-transport-item .name').text($(this).text());
		$('#deal-transport-id').val($(this).data('transport'));
		$('#deal-transport-item').show();
		$('#deals-form-transport-list').slideToggle(200);
        return false;
    });
	
	$('#deal-transport-item .ico').on('click', function (e) {
		e.preventDefault();
		$('#deal-transport-id').val('');
		$('#deal-transport-item').hide();
        return false;
    });
	
	$('.review-text-switch-on').on('click', function (e) {
		e.preventDefault();
		$(this).parent().parent().parent().children('.profile-requests-comment-frm').slideToggle();
        return false;
    });
	
	$('.review-text-switch-off').on('click', function (e) {
		e.preventDefault();
		$(this).parent().parent().slideToggle();
        return false;
    });
	
    $('#next-random-reviews').on('click', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'get',
			url: '/site/getrandomreviews.html',
			data: {},
			dataType: 'html',
			beforeSend: function () {
				$("#random-reviews-loading").show();
			},
			success: function (msg) {
				$("#random-reviews-loading").hide();
				$('#random-reviews-wr').html(msg);
			}
		});
		return false;
		
	});
	
	
	$('#step3Container').on('click', '.upload-foto-btn', function () {
		var pItems = $('input[name="userfile"]');
		
		$("#step3Container #cargo-num").val($(this).data('cargo'));
		
		$.ajax({
			type: 'get',
			url: '/bids/setcargonum/'+$(this).data('cargo'),
			dataType: 'html',
			beforeSend: function () {
			},
			success: function (msg) {
				//console.log(msg);
			}
		});
		
		$(pItems[1]).click();
		
        return false;
    });
	
    $('.introtext-toggle').on('click', function (e) {
		e.preventDefault();
		$(this).parent().parent().find('.bid-detail-cargo-introtext').toggle();
		$(this).parent().parent().find('.bid-detail-cargo-fulltext').toggle();
		return false;
		
	});
	
	$('#listView').on('click', '.show-full-review', function () {
		$(this).parent().parent().parent().parent().parent().parent().find('.requests-full-review').slideToggle();
	});
	
	$('#listView').on('click', '.requests-full-review-hide', function () {
		$(this).parent().parent().parent().find('.requests-full-review').slideToggle();
	});
	
	
    
});

function cancel_changes() {
	$.ajax({
		type: 'get',
		url: '/user/my/cleartransportfoto.html',
		beforeSend: function () {
		},
		success: function (msg) {
		}
	});
}

function close_popup() {
	$('button.close').click();
}

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
		}
	});
	
	if(count > 1) {
		get_step3form = false;
	}
	
	if(get_step3form) {
		$.ajax({
			type: 'get',
			url: '/bids/step3form',
			data: {category_id : $('.step1-category-item.active').data('catid')},
			dataType: 'html',
			beforeSend: function () {
			},
			success: function (msg) {
				$('#step3Container').html(msg);
				$('#step3Container .checkbox, #step3Container select').styler();
				$('#Cargoes_name1').val(cargo_name);
				$('#step-final-btn-wr').show();
				
				var upload1 = new AjaxUpload('#userfile1', {
						action: '/bids/uploadfoto.html?cargo='+$("#step3Container").find("#cargo-num").val(),
						onSubmit : function(file, extension){
							$("#loading" + $("#step3Container #cargo-num").val() ).show();
							if (! (extension && /^(jpg|png|jpeg|gif)$/.test(extension))) {
								$("#loading" + $("#step3Container #cargo-num").val() ).hide();
								$("<span class='error'>Неправильный тип файла</span>").appendTo("#step3Container .cargo"+$("#step3Container #cargo-num").val()+"-err");
								return false;
							} else {
								$('.cargo'+$("#step3Container #cargo-num").val()+'-err').hide();
							}	
							upload1.setData({'file': file});
						},
						onComplete : function(file, response) {
							$("#loading"+$("#step3Container #cargo-num").val()).hide();
							$(".success").css("display", "block");
							var pItems = $(".iframe"),
								response = $.parseJSON($(pItems[(pItems.length - 1)]).contents().find('body').text());
							if(response.res == 'ok') {
								$('#step3Container').find('#cargo-foto'+$("#step3Container #cargo-num").val()).css('background-image', ('url('+response.msg+')'));
								$('#step3Container').find('#Cargoes_foto'+$("#step3Container #cargo-num").val()).val(response.foto);
							}
							if(response.res == 'err') {
								$("#step3Container .cargo"+$("#step3Container #cargo-num").val()+"-err").html(response.msg);
								$("#step3Container .cargo"+$("#step3Container #cargo-num").val()+"-err").show();
							}
						}
				});
				
			}
		});
		
	} else {
		$('#Cargoes_name1').val(cargo_name);
	}
}

