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
	$('input[name=submit1]').bind('click', function() {
		$(this).parents('form').find('span').addClass('hide');
		var input = $('.form :input');
		var flag = false;
		for (var i = 0; i < input.length; i++) {
			if ($(input[i]).attr('required') && $(input[i]).val() == '') {				
				$(input[i]).parent().find('span').removeClass('hide').html('Обязательное поле').addClass('up-box3');
				flag = true;				
			}
		}
		var filter_email = /([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,3}$)/;
	    var string_email = $('input[name=admin[email]]').val().toLowerCase();
	    if (!filter_email.test(string_email))
	    {
			$('input[name=admin[email]]').parent().find('span').removeClass('hide').html('Неправильный формат').addClass('up-box2');
			flag = true;
		}
		if (flag) {
			$('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
			return false;
		}
		else
		{
			$.ajax({
                type: 'POST',
                url: '/users/admin/count_username/username/'+$('input[name=admin[username]]').val()+'/id/'+$('input[name=admin[id]]').val(),
             	success: function(result){
					if (result > 0)
					{
						$('input[name=admin[username]]').parent().find('span').removeClass('hide').html('Пользователь с таким логином уже существует').addClass('up-box3');
            			$('input[name=admin[username]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
            			return false;
					}
					else
					{
						$.ajax({
    	            		type: 'POST',
        	        		url: '/users/admin/count_email/email/'+$('input[name=admin[email]]').val()+'/id/'+$('input[name=admin[id]]').val(),
            	 			success: function(result){
								if (result > 0)
            					{
            						$('input[name=admin[email]]').parent().find('span').removeClass('hide').html('Пользователь с таким email уже существует').addClass('up-box3');
            						$('input[name=admin[email]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
            						return false;
            					}
            					else
            					{
									document.forms.admin_save.submit();
            					}
                			}
            			});
					}
				}
            });
		}
	});
	$('.button2 input[name=cancel]').bind('click', function(){
		$('.form').fadeOut();		
	});
});
/* ]]> */
</script>
<form action="/users/admin/save" name="admin_save" method="post"> 
<h2>Редактирование администратора</h2>
<div class="tabs">
    <ul>
        <li class="active" tab="main"><a href="javascript:;" title="Главное">Главное</a></li>								        
        <li class="last" tab="setting"><a href="javascript:;" title="Настройки">Дополнительно</a></li>
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
    <div class="in-bg" tab="main">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                	<input type="hidden" name="admin[id]" value="<?php if (isset($data->item_admin->id)) echo $data->item_admin->id ?>" />                	
                	<p> Логин <br />
                        <input type="text" class="f03" required="true" name="admin[username]" value="<?php if (isset($data->item_admin->username)) echo $data->item_admin->username ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Логин администратора латинскими буквами</font>
                    </p><br />
                    <p> Емаил <br />
                        <input type="text" class="f03" required="true" name="admin[email]" value="<?php if (isset($data->item_admin->email)) echo $data->item_admin->email ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Адрес электронной почты</font> 
                    </p><br />
                    <?php if (!isset($data->item_admin->id))
                    {
                    ?>
                    <p> Пароль <br />
                        <input type="text" class="f03" required="true" name="admin[password]" value="" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Пароль администратора</font> 
                    </p><br />
                    <?php
                    }
                    ?>
                </td>                   
            </tr>
        </table>
        <div class="button2"> 
	    	<input type="button" name="submit1" value="Добавить" /> <input type="button" name="cancel" value="Отменить" />
	    	<br /><span class="hide"></span>
	    </div>
    </div>
    <div class="in-bg hide" tab="setting">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                    <p> Имя <br />
                        <input type="text" class="f06" name="admin_info[name]" value="<?php if (isset($data->item_admin->name)) echo $data->item_admin->name ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Имя администратора</font>
                    </p><br />
                    <p> Телефон <br />
                        <input type="text" class="f06" name="admin_info[phone]" value="<?php if (isset($data->item_admin->phone)) echo $data->item_admin->phone ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Телефон администратора</font> 
                    </p><br />
                </td>   
                <td class="w01">
                    <p> Пол <br />
                        <input type="radio" name="admin_info[sex]" value="0" <?php if ((isset($data->item_admin->sex) && $data->item_admin->sex == '0') || !isset($data->item_admin->sex)) echo 'checked="checked"' ?>" />&nbsp;<b>Мужской</b>&nbsp;&nbsp;
                        <input type="radio" name="admin_info[sex]" value="1" <?php if (isset($data->item_admin->sex) && $data->item_admin->sex == '1') echo 'checked="checked"' ?>" />&nbsp;<b>Женский</b>									                        
                        <span class="hide"></span><br />
                        <font class="description">Пол администратора</font> 
                    </p><br />
                </td>                
            </tr>
        </table>
        <div class="button2"> 
	    	<input type="button" name="submit1" value="Сохранить" /><input type="button" name="cancel" value="Отменить" />
	    	<span class="hide"></span>
	    </div>
    </div>
</div> 
</form>								