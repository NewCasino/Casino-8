<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){   
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
<form action="/finance/cashout/save" method="post"> 
<h2>Редактирование запроса на выплату</h2>
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
                    <input type="hidden" name="cashout[id]" value="<?php echo $data->item_cashout->cashout_id ?>" />                  
                    <p> Пользователь <br />
                        <strong><?php echo $data->item_cashout->username ?></strong>                                                       
                        <span class="hide"></span><br />
                        <font class="description">Пользователь, который заказал выплату</font>
                    </p><br />
                    <p> Сумма <br />
                        <strong><?php echo number_format($data->item_cashout->amount, 2, '.', '') ?></strong>                                                       
                        <span class="hide"></span><br />
                        <font class="description">Сумма выплаты</font>
                    </p><br />
                    <p> Дата <br />
                        <strong><?php echo date('d M Y g:i a', $data->item_cashout->created) ?></strong>                                                       
                        <span class="hide"></span><br />
                        <font class="description">Дата заказа выплаты</font>
                    </p><br />
                </td>                   
                <td class="w01">
                    <p> Статус <br />
                        <select name="cashout[status]">
							<option <?php if ($data->item_cashout->status == '2') echo 'selected="selected"' ?> value="2"><?php echo Kohana::lang('cash.status.2'); ?></option>
	                		<option <?php if ($data->item_cashout->status == '3') echo 'selected="selected"' ?> value="3"><?php echo Kohana::lang('cash.status.3'); ?></option>
	                		<option <?php if ($data->item_cashout->status == '4') echo 'selected="selected"' ?> value="4"><?php echo Kohana::lang('cash.status.4'); ?></option>                        
                        </select>
                        <span class="hide"></span><br />
                        <font class="description">Статус заказа на выплату</font>
                    </p><br />
                    <p>Информация <br />
                        <strong><?php echo $data->item_cashout->payment_info ?></strong>                                                       
                        <span class="hide"></span><br />
                        <font class="description">Платежная информация для выплаты</font>
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