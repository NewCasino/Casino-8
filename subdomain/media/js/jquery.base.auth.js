// JavaScript Document
$(document).ready(function(){
	var timer = null;
	
	$('input[type=button]').bind('click', function() {
		
		var flag, fields = false;
		
		if (timer) {
			clearTimeout(timer);
		}
		
		var input = $('.f01');
		for (var i = 0; i < $(input).size(); i++) {
			$(input[i]).parents('p').find('span').removeClass('up-box3').html('');
			
			// filter
			if ($(input[i]).attr('filter')) {
				switch ($(input[i]).attr('filter')) 
				{
					case 'email':
						var filter = /([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,3}$)/;
						break;
					case 'username': 
					case 'password': 
					default:
						var filter = /([a-zA-Z0-9._-]{4,32}$)/;
						break;
				}
				
				if (filter.test($(input[i]).val())) {
					$(input[i]).parents('p').find('span').hide().removeClass('up-box2').html('');
				} else {
					flag = true;
					$(input[i]).parents('p').find('span').show().addClass('up-box2').html('Format');
				}
			}
			
			// empty
			if ( ! $(input[i]).val()) {
				flag = true;
				$(input[i]).parents('p').find('span').show().addClass('up-box3').html('Required');
			}
			
			// assign ajax data fields
			if (fields) {
				fields += '&'+$(input[i]).attr('name')+'='+$(input[i]).val();
			} else {
				fields = $(input[i]).attr('name')+'='+$(input[i]).val();
			}
		}
		
		if (flag) {
			timer = setTimeout(function() {
				$('.auth span').fadeOut(1000);
			}, 5000);
		} else {
			$.ajax({
				type: "POST",
				url: $('form').attr('action'),
				data: fields,
				success: function(result){
					if ($.trim(result).length) {
						$('.notice').html(result);
					} else {
						document.location.href = '/home';
					}					
				}	   
			});
		}
	});
});

/**
 * Javascript Compressor Version 3.0
 * Algorithm author Dean Edwards
 * http://javascriptcompressor.com/
 */
 
/*
 $(document).ready(function(){var timer=null;$('input[type=button]').bind('click',function(){if(timer){clearTimeout(timer)}var input=$('.f01');for(var i=0;i<$(input).size();i++){$(input[i]).parents('p').find('span').removeClass('up-box3').html('');if($(input[i]).attr('filter')){switch($(input[i]).attr('filter')){case'email':var filter=/([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,3}$)/;break;case'username':case'password':default:var filter=/([a-zA-Z0-9._-]{4,32}$)/;break}if(!filter.test($(input[i]).val())){$(input[i]).parents('p').find('span').show().addClass('up-box2').html('�� ���������� ������')}else{$(input[i]).parents('p').find('span').hide().removeClass('up-box2').html('')}}if(!$(input[i]).val()){$(input[i]).parents('p').find('span').show().addClass('up-box3').html('������������ ����')}}timer=setTimeout(function(){$('.auth span').fadeOut(1000)},5000)})});
 */