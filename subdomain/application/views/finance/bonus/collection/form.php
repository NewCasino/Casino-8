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
	$('.button2 input[name=cancel]').bind('click', function(){
		$('.form').fadeOut();		
	});
});
/* ]]> */
</script>
<form action="/finance/bonus/collection/save" method="post"> 
<h2>Редактирование коллекции</h2>
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
                	<input type="hidden" name="collection[id]" value="<?php if (isset($data->item_collection->id)) echo $data->item_collection->id ?>" />                	
                	<p> Название <br />
                        <input type="text" class="f03" required="true" name="collection[title]" value="<?php if (isset($data->item_collection->title)) echo $data->item_collection->title ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Назвние коллекции</font>
                    </p><br />
				</td>                   
            </tr>
        </table>
        <div class="button2"> 
	    	<input type="submit" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
	    	<br /><span class="hide"></span>
	    </div>
    </div>
</div> 
</form>								