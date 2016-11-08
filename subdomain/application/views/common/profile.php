<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
    $('.q16 a[name=get_profile]').bind('click', function(){
    	$.getJSON('/profile/edit/id/' + <?php echo Auth::instance()->get_user()->id ?>, function(result){
			$('input[name=profile[username]]').val(result.username);
			$('input[name=profile[email]]').val(result.email);
			$('input[name=profile[name]]').val(result.name);
			$('input[name=profile[phone]]').val(result.phone);
			if (result.sex == 1)
			{ 
				$('input[name=profile[sex]][value=1]').attr('checked', 'checked');
			}
			else
			{
				$('input[name=profile[sex]][value=0]').attr('checked', 'checked');
			}
			$('.profile, .layer').fadeIn(350);
		});       
    });
    $('form input[name=submit]').bind('click', function(){
    	$(this).parents('form').find('span').addClass('hide');
		var input = $(this).parents('form').find(':input');
		var flag = false;
		for (var i = 0; i < input.length; i++) {
			if ($(input[i]).attr('required') && $(input[i]).val() == '') {				
				$(input[i]).parent().find('span').removeClass('hide').html('Обязательное поле').addClass('up-box3');
				flag = true;				
			}
		}
		if (flag) {
			$(this).parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
			return false;
		}
		else
		{
			if ($(this).parents('form').attr('action') == '/profile/save')
			{
				var filter_email = /([a-z0-9._-]+@[a-z0-9._-]+\.[a-z]{2,3}$)/;
	    		var string_email = $('input[name=profile[email]]').val().toLowerCase();
	    		if (!filter_email.test(string_email))
	    		{
					$('input[name=profile[email]]').parent().find('span').removeClass('hide').html('Неправильный формат').addClass('up-box2');
					$(this).parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
					return false;
				}
				$.ajax({
                	type: 'POST',
                	url: '/profile/count_username/username/'+$(this).parents('form').find('input[name=profile[username]]').val(),
             	   	success: function(result){
						if (result > 0)
						{
							$('input[name=profile[username]]').parent().find('span').removeClass('hide').html('Пользователь с таким логином уже существует').addClass('up-box3');
            				$('input[name=profile[username]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
						}
						else
						{
							$.ajax({
    	            			type: 'POST',
        	        			url: '/profile/count_email/email/'+$('input[name=profile[email]]').val(),
            	 	   			success: function(result){
									if (result > 0)
            						{
            							$('input[name=profile[email]]').parent().find('span').removeClass('hide').html('Пользователь с таким email уже существует').addClass('up-box3');
            							$('input[name=profile[email]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
            						}
            						else
            						{
										var data = '';
        								$('form[name=profile]').find('input[type=text]').each(function(i, item) {
		        							data = data + item.name+'='+item.value+'&';
        								});
        								data = data + 'profile[sex]='+$('form[name=profile]').find('input[name=profile[sex]]:checked').val();
										$.ajax({
		                					type: 'POST',
                							url: '/profile/save',
                							data: data,         
             	   							success: function(result){
		             	   						//$('.profile, .layer').fadeOut(100);
                    							$('input[name=profile[email]]').parents('form').find('.button2 span').html(result).removeClass('hide').addClass('up-box');
                							}
            							});
									}
                				}
            				});
						}
	               	}
            	});
			}
			if ($(this).parents('form').attr('action') == '/profile/save_password')
			{
				if ($(this).parents('form').find('input[name=profile[new_password]]').val() != $(this).parents('form').find('input[name=profile[confirm_new_password]]').val())
				{
					$(this).parents('form').find('input[name=profile[new_password]]').parent().find('span').removeClass('hide').html('Пароли не совпадают').addClass('up-box3');
					$(this).parents('form').find('input[name=profile[confirm_new_password]]').parent().find('span').removeClass('hide').html('Пароли не совпадают').addClass('up-box3');
					$(this).parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
				}
				else
				{
					$.ajax({
		                type: 'POST',
                		url: '/profile/compare_password/password/'+$(this).parents('form').find('input[name=profile[old_password]]').val(),
             	   		success: function(result){
							if (result == 1)
							{
								$('input[name=profile[old_password]]').parent().find('span').removeClass('hide').html('Неверный пароль').addClass('up-box3');
								$('input[name=profile[old_password]]').parents('form').find('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
							}
							else
							{
								$.ajax({
		                			type: 'POST',
                					url: '/profile/save_password/password/'+$('input[name=profile[new_password]]').val(),
             	   					success: function(result){
		             	   				//$('.profile, .layer').fadeOut(100);
		             	   				$('input[name=profile[old_password]]').parents('form').find('.button2 span').html(result).removeClass('hide').addClass('up-box');
                					}
            					});
							}
                		}
            		});
				}
			}
		}
	});
    $('.tabs li a').bind('click', function(){ 
		$(this).parents('ul').find('li').removeClass('active');
		$(this).parents('li').addClass('active');
		$(this).parents('.profile').find('.in-bg').addClass('hide');
		$(this).parents('.profile').find('.in-bg[tab='+$(this).parents('li').attr('tab')+']').removeClass('hide');				
	});
	$('.button2 input[name=cancel]').bind('click', function(){
		$('.profile, .layer').fadeOut(100);		
	});
});
/* ]]> */
</script>
<div class="profile">
<div class="tabs">
    <ul>
        <li class="active" tab="main"><a href="javascript:;" title="Главное"><?php echo Auth::instance()->get_user()->username; ?></a></li>								        
        <!--<li class="last" tab="password"><a href="javascript:;" title="Настройки"><?php echo Kohana::lang('profile.password') ?></a></li>-->
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
    <div class="in-bg" tab="main">
    	<form action="/profile/save" method="post" name="profile">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
		         	<p> <?php echo Kohana::lang('profile.username') ?> <br />
                        <input type="text" class="f06" required="true" name="profile[username]" value="" />	
                        <span class="hide"></span><br />							                        
                    </p><br />
                    <p> <?php echo Kohana::lang('profile.name') ?> <br />
                        <input type="text" class="f06" name="profile[name]" value="" />	
                        <span class="hide"></span><br />							                        
                    </p><br />
                    <p> <?php echo Kohana::lang('profile.email') ?> <br />
                        <input type="text" class="f06" required="true" name="profile[email]" value="" />	
                        <span class="hide"></span><br />							                        
                    </p><br />
                    <p> <?php echo Kohana::lang('profile.phone') ?> <br />
                        <input type="text" class="f06" name="profile[phone]" value="" />	
                        <span class="hide"></span><br />							                        
                    </p><br />
                </td>
                <td class="w01">
                	<p> <?php echo Kohana::lang('profile.sex') ?> <br />
                        <input type="radio" name="profile[sex]" value="0" />&nbsp;<b>Мужской</b>&nbsp;&nbsp;
                        <input type="radio" name="profile[sex]" value="1" />&nbsp;<b>Женский</b>	
                        <span class="hide"></span><br />								                        
                    </p><br />
                </td>                   
            </tr>
        </table>
        <div class="button2"> 
        	<!-- <div class="button2"> <a href="javascript:;" title="#"><img src="/media/images/button7.png" alt="#" /></a><a href="javascript:;" title="#"><img src="/media/images/button12.png" alt="#" /></a> </div> -->
	    	<input type="button" name="submit" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
	    	<br /><span class="hide"></span>
	    </div>
	    </form>
    	<form action="/profile/save_password" method="post">
        <table cellpadding="0" cellspacing="0" class="t1">
        	<tr valign="top">
                <td class="w02">
                	<p> <h2>Изменение пароля</h2> </p><br />
                    <p> <?php echo Kohana::lang('profile.old_password') ?> <br />
                        <input type="text" class="f08" required="true" name="profile[old_password]" value="" />		
                        <span class="hide"></span><br />						                        
                    </p><br />
                    <p> <?php echo Kohana::lang('profile.new_password') ?> <br />
                        <input type="text" class="f08" required="true" name="profile[new_password]" value="" />		
                        <span class="hide"></span><br />						                        
                    </p><br />
                    <p> <?php echo Kohana::lang('profile.confirm_new_password') ?> <br />
                        <input type="text" class="f08" required="true" name="profile[confirm_new_password]" value="" />	
                        <span class="hide"></span><br />							                        
                    </p><br />
                </td>   
			</tr>
        </table>
        <div class="button2"> 
	    	<input type="button" name="submit" value="Сохранить" />
	    	<br /><span class="hide"></span>
	    </div>
	    </form>
    </div>
</div> 
</div>