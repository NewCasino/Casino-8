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
<form action="/setting/banking/save" method="post"> 
<h2>Редактирование банка</h2>
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
                    <input type="hidden" name="banking[id]" value="<?php if (isset($data->item_banking->id)) echo $data->item_banking->id ?>" />                  
                    <p> Название <br />
                        <input type="text" class="f03" required="true" name="banking[title]" value="<?php if (isset($data->item_banking->title)) echo $data->item_banking->title ?>" />                                                       
                        <span class="hide"></span><br />
                        <font class="description">Название банка</font>
                    </p><br />
                    <p> Сумма <br />
						<input type="text" class="f24" required="true" name="banking[balance]" value="<?php if (isset($data->item_banking->balance)) echo number_format($data->item_banking->balance, 2, '.', '') ?>" />                                                       
						<span class="hide"></span><br />
						<font class="description">Баланс банка</font>
					</p><br />
                </td>                   
                <td class="w01">
                    <p> Тип банка <br />
                        <select name="banking[type]">
                        <?php foreach (Kohana::config('const.setting.banking.type') as $key => $value): ?>
                            <option <?php if (isset($data->item_banking->type) && $key === $data->item_banking->type) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $value ?></option>                        
                        <?php endforeach ?>
                        </select>
                        <span class="hide"></span><br />
                        <font class="description">Тип банка</font>
                    </p><br />
                    <p> <br />
                        <input type="radio" name="banking[is_default]" value="1" <?php if ((isset($data->item_banking->is_default) && $data->item_banking->is_default == 1)) echo 'checked="checked"' ?>" /><b>&nbsp;Банк по умолчанию</b>
						<span class="hide"></span><br />
                        <font class="description">Устанавливается банк по умолчанию</font> 
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