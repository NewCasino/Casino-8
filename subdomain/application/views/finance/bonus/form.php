<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){	
	$('.tabs li a').bind('click', function(){ 
		$(this).parents('ul').find('li').removeClass('active');
		$(this).parents('li').addClass('active');
		$('.form').find('.in-bg').addClass('hide');
		$('.form .in-bg[tab='+$(this).parents('li').attr('tab')+']').removeClass('hide');				
	});
	$('form').bind('submit', function(){
		var input = $('.form :input');
		var flag = false;
		for (var i = 0; i < input.length; i++) {
			if ($(input[i]).attr('required') && $(input[i]).val() == '') {				
				$(input[i]).parent().find('span').removeClass('hide').html('Обязательное поле').addClass('up-box3');
				flag = true;				
			}
		}
		if (flag) {
			$('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
			return false;
		}
	});
	$('a[name=add_collection]').bind('click',function(e){
		$('div.collection').css({'position' : 'absolute'});
		$('div.collection').css('left', e.pageX+20);
		$('div.collection').css('top', e.pageY);
		$('div.collection').fadeIn(350);
	});
	$('div.collection input.cancel').bind('click', function(){
		$('div.collection').fadeOut(350);
	})
	$('div.collection input.submit').bind('click', function(){
		$.ajax({
			type: "POST",
   			url: "/finance/bonus/save_collection",
   			data: "title="+$('div.collection input[name=title]').val(),
   			success: function(id){
     			$('select[name=collection_id]').append('<option value="'+id+'">'+$('div.collection input[name=title]').val()+'</option>');
   			}
 		});
		$('div.collection').fadeOut(350);
	})
	$('.button2 input[name=cancel]').bind('click', function(){
		$('.form').fadeOut();		
	});
});
/* ]]> */
</script>
<div class="collection" style="display: none;">
<form action="/finance/pincode/save_collection" method="post"> 
	<br class="clearfloat" />
	<div class="bg">
	<div class="in-bg" tab="main">
		<table cellpadding="0" cellspacing="25" class="t1">
			<tr valign="top">
				<td>
					<p> Название <br />
						<input type="text" class="f06" required="true" name="title" value="" />                                                       
						<span class="hide"></span><br />
						<font class="description">Название коллекции</font>
					</p><br />                    
				</td>                   
			</tr>
		</table>
		<div class="button2"> 
			<input type="button" class="submit" value="Сохранить" /> <input type="button" class="cancel" value="Отменить" />
			<br /><span class="hide"></span>
		</div>
	</div>    
	</div> 
</form>
</div>
<form action="/finance/bonus/save" method="post"> 
<h2>Создание бонусов</h2>
<div class="tabs">
	<ul>
		<li class="active" tab="main"><a href="javascript:;" title="Главное">Главное</a></li>        
	</ul>
	<br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
	<div class="in-bg" tab="main">
		<table cellpadding="0" cellspacing="0" class="t1">
			<tr valign="top">
				<td class="w02">
					<p> Сумма <br />
						<input type="text" class="f24" required="true" name="amount" value="" />                                                       
						<span class="hide"></span><br />
						<font class="description">Целое число</font>
					</p><br />                    
					<p> Количество <br />
						<input type="text" class="f23" required="true" name="count" value="" />                                                       
						<span class="hide"></span><br />
						<font class="description">Количество щтук<br />для создания</font>
					</p><br />
					<p> Коллекция <br />
						<select name="collection_id">
							<option value="0"></option>
						<?php foreach ($data->list_collection as $row1): ?>							                    		
							<option value="<?php echo $row1->id ?>" ><?php echo $row1->title ?></option>							                    		
						<?php endforeach ?>								                        
						</select>
						<a href="javascript:;" name="add_collection">+</a>
					</p><br />
				</td>                   
				<!--<td class="w01"></td>-->
			</tr>
		</table>
		<div class="button2"> 
			<input type="submit" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
			<br /><span class="hide"></span>
		</div>
	</div>    
</div> 
</form>							