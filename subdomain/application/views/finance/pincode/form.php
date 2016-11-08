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
<form action="/manage/games/save" method="post"> 
<h2>Редактирование игры</h2>
<div class="tabs">
    <ul>
        <li class="active" tab="main"><a href="javascript:;" title="Главное">Главное</a></li>                                       
        <li class="last" tab="setting"><a href="javascript:;" title="Настройки">Настройки</a></li>
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
    <div class="in-bg" tab="main">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                    <input type="hidden" name="games[id]" value="<?php if (isset($data->item_games->id)) echo $data->item_games->id ?>" />                  
                    <p> Название <br />
                        <input type="text" class="f03" required="true" name="games[title]" value="<?php if (isset($data->item_games->title)) echo $data->item_games->title ?>" />                                                       
                        <span class="hide"></span><br />
                        <font class="description">Оригинальное название игры латинскими буквами</font>
                    </p><br />
                    <p> Сортировать <br />
                        <input type="text" class="f21" name="games[sort]" value="<?php if (isset($data->item_games->title)) echo $data->item_games->sort ?>" />                                                     
                        <span class="hide"></span><br />
                        <font class="description">Сортировка, цифра,<br />по возрастанию</font> 
                    </p><br />
                </td>                   
                <td class="w01">
                    <p> Категория <br />
                        <select name="games[categories_id]">
                        <?php foreach ($data->list_categories as $row): ?>
                            <option <?php if ($row->id === $data->item_games->categories_id) echo 'selected="selected"' ?> value="<?php echo $row->id ?>"><?php echo $row->title ?></option>                        
                        <?php endforeach ?>
                        </select><br />
                        <span class="hide"></span><br />
                        <font class="description">Кнопки категорий игр</font>
                    </p><br />
                </td>
            </tr>
        </table>
        <div class="button2"> 
            <input type="submit" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
            <br /><span class="hide"></span>
        </div>
    </div>
    <div class="in-bg hide" tab="setting">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                    <?php foreach ($data->list_games_setting as $row): ?>
                        <?php if ($row->name): ?>
                        <p><?php echo Kohana::lang('games.setting.'.$row->name.'.title') ?><br />
                            <input type="text" class="f21" filter="number" required="true" name="setting[<?php echo $row->name ?>]" value="<?php echo $row->value ?>" />&nbsp;<?php echo Kohana::lang('games.setting.'.$row->name.'.postfix') ?>
                            <span class="hide"></span><br />
                            <font class="description"><?php echo Kohana::lang('games.setting.'.$row->name.'.description') ?></font>                                                          
                        </p><br />
                        <?php endif ?>
                    <?php endforeach ?>
                </td>                   
                <td class="w01">
                    <?php foreach ($data->list_games_banking as $row): ?>
                    <p><?php echo Kohana::lang('games.banking.'.$row->type.'.title') ?><br />
                        <select name="banking[<?php echo $row->type ?>][banking_id]">
                        <?php foreach ($data->list_banking as $row1): ?>
                            <?php if ($row->type === $row1->type): ?>
                            <option <?php if ($row->banking_id === $row1->id) echo 'selected="selected"' ?> value="<?php echo $row1->id ?>"><?php echo $row1->title ?> - <?php echo $row1->balance ?></option>
                            <?php endif ?>
                        <?php endforeach ?>
                        </select>
                        <?php if ($row->type !== 'game'): ?>
                        <input type="text" class="f22" name="banking[<?php echo $row->type ?>][percent]" value="<?php echo $row->percent ?>" />
                        <?php endif ?>
                        &nbsp;<?php echo Kohana::lang('games.banking.'.$row->type.'.postfix') ?>
                        <span class="hide"></span><br />
                        <font class="description "><?php echo Kohana::lang('games.banking.'.$row->type.'.description') ?></font>
                    </p><br />
                    <?php endforeach ?>
                </td>
            </tr>
        </table>
        <div class="button2"> 
            <input type="submit" value="Сохранить" /> <input type="button" name="cancel" value="Отменить" />
            <span class="hide"></span>
        </div>
    </div>
</div> 
</form>                             