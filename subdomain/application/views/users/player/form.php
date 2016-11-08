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
	    var string_email = $('input[name=player[email]]').val().toLowerCase();
	    if (!filter_email.test(string_email))
	    {
			$('input[name=player[email]]').parent().find('span').removeClass('hide').html('Неправильный формат').addClass('up-box2');
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
                url: '/users/player/count_username/username/'+$('input[name=player[username]]').val()+'/id/'+$('input[name=player[id]]').val(),
             	success: function(result){
					if (result > 0)
					{
						$('input[name=player[username]]').parent().find('span').removeClass('hide').html('Пользователь с таким логином уже существует').addClass('up-box3');
            			$('input[name=player[username]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
            			return false;
					}
					else
					{
						$.ajax({
    	            		type: 'POST',
        	        		url: '/users/player/count_email/email/'+$('input[name=player[email]]').val()+'/id/'+$('input[name=player[id]]').val(),
            	 			success: function(result){
								if (result > 0)
            					{
            						$('input[name=player[email]]').parent().find('span').removeClass('hide').html('Пользователь с таким email уже существует').addClass('up-box3');
            						$('input[name=player[email]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
            						return false;
            					}
            					else
            					{
									document.forms.player_save.submit();
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
<form action="/users/player/save" name="player_save" method="post"> 
<h2>Редактирование игрока</h2>
<div class="tabs">
    <ul>
        <li class="active" tab="main"><a href="javascript:;" title="Главное">Главное</a></li>								        
        <li class="last" tab="setting"><a href="javascript:;" title="Настройки">Персональные данные</a></li>
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
    <div class="in-bg" tab="main">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                	<input type="hidden" name="player[id]" value="<?php if (isset($data->item_player->id)) echo $data->item_player->id ?>" />                	
                	<p> Логин <br />
                        <input type="text" class="f03" required="true" name="player[username]" value="<?php if (isset($data->item_player->username)) echo $data->item_player->username ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Логин игрока латинскими буквами</font>
                    </p><br />
                    <p> Емаил <br />
                        <input type="text" class="f03" required="true" name="player[email]" value="<?php if (isset($data->item_player->email)) echo $data->item_player->email ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Адрес электронной почты</font> 
                    </p><br />
                    <?php if (!isset($data->item_player->id))
                    {
                    ?>
                    <p> Пароль <br />
                        <input type="text" class="f03" required="true" name="player[password]" value="" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Пароль игрока</font> 
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
                        <input type="text" class="f06" name="player_info[name]" value="<?php if (isset($data->item_player->name)) echo $data->item_player->name ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Имя игрока</font>
                    </p><br />
                    <p> Страна <br />
                    	<select name="player_info[country_id]">
                    	<?php foreach (Kohana::lang('country') as $key => $value): ?>
                    		<option <?php if (isset($data->item_player->country_id) && $key == $data->item_player->country_id) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $value ?></option>
                    	<?php endforeach ?>
                    	</select>
						<span class="hide"></span><br />
                        <font class="description">Страна игрока</font> 
                    </p><br />
                    <p> Город <br />
                        <input type="text" class="f06" name="player_info[city]" value="<?php if (isset($data->item_player->city)) echo $data->item_player->city ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Город игрока</font> 
                    </p><br />
                    <p> Телефон <br />
                        <input type="text" class="f06" name="player_info[phone]" value="<?php if (isset($data->item_player->phone)) echo $data->item_player->phone ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description">Телефон игрока</font> 
                    </p><br />
                </td>   
                <td class="w01">
                    <p> Пол <br />
                        <input type="radio" name="player_info[sex]" value="0" <?php if ((isset($data->item_player->sex) && $data->item_player->sex == '0') || !isset($data->item_player->sex)) echo 'checked="checked"' ?>" />&nbsp;<b>Мужской</b>&nbsp;&nbsp;
                        <input type="radio" name="player_info[sex]" value="1" <?php if (isset($data->item_player->sex) && $data->item_player->sex == '1') echo 'checked="checked"' ?>" />&nbsp;<b>Женский</b>								                        
                        <span class="hide"></span><br />
                        <font class="description">Пол игрока</font> 
                    </p><br />
                    <p> <br />
                        <input type="checkbox" name="player_info[mailing]" value="1" <?php if ((isset($data->item_player->mailing) && $data->item_player->mailing == 1)) echo 'checked="checked"' ?>" /><b>&nbsp;&nbsp;Получать рассылку</b>
						<span class="hide"></span><br />
                        <font class="description">Будет ли игрок получать рассылку</font> 
                    </p><br />
                </td>                
            </tr>
        </table>
        <div class="button2"> 
	    	<input type="button" name="submit1" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
	    	<span class="hide"></span>
	    </div>
    </div>
</div> 
</form>								