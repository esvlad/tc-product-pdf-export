/**/

function log(data){
	console.log(data);
}

(function($) {
	$('#all_category').change(function(){
		$('.categorychecklist.categoryes_list').find('input[type="checkbox"]').trigger('click');
	});

	$('.categoryes_show_box').click(function(){
		var categoryes_show_box = $(this);
		if(!categoryes_show_box.hasClass('active')){
			categoryes_show_box.addClass('active');
			categoryes_show_box.next().slideDown(400);
		} else {
			categoryes_show_box.removeClass('active');
			categoryes_show_box.next().slideUp(400);
		}
	});

	$('#form_export_pdf').submit(function(e){
		e = event || e;
		e.preventDefault();

		var form = $(this);
		var form_data = {};

		var categories_ids = [];
		$('.categoryes_list input[type="checkbox"]:checked').each(function(){
			categories_ids.push(parseInt($(this).val()));
		});

		if(categories_ids.length == 0){
			categories_ids = 'all';
		}

		var bestseller = $('#bestseller:checked').val();
		if(bestseller == undefined){
			bestseller = 0;
		}

		form_data.category = categories_ids;
		form_data.bestseller = bestseller;

		$.ajax({
			type: 'post',
			url: ajax_url,
			data: {action: 'export', data: form_data},
			dataType: 'json',
			beforeSend: function(){
				if($('.export_pdf_result').css('display') == 'block'){
					$('.export_pdf_result').fadeOut(300);
					$('.cssload-loader').delay(300).fadeIn(300);
				} else {
					$('.cssload-loader').fadeIn(300);
				}
			},
			success: function(json){
				log(json);
				$('.export_download_file').attr('href',json.file_export_url);
				$('.cssload-loader').fadeOut(300);
				$('.export_pdf_result').delay(300).fadeIn(300);
			},
			error: function(jqXHR, textStatus, errorThrown){
				log(jqXHR);
				log(textStatus);
				log(errorThrown);
			}
		});
	});
})(jQuery);


