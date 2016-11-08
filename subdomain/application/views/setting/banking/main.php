<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<?php echo $template->meta ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
    $(':checkbox').attr({checked: false});
    $('.pad a[name=edit]').bind('click', function(){        
        if ($(this).find('img').attr('disabled') == 'disabled') {           
            $('.notice').html('Выберите одну запись для редактирования...').fadeIn(150);
            setTimeout(function(){
                $('.notice').fadeOut(250);
            }, 2500);
        } else {
            $('.loading').fadeIn(150);
            $.ajax({
                type: 'POST',
                url: '/setting/banking/edit/id/'+$('.t6 tr.items input[type=checkbox]:checked').val(),         
                success: function(result){
                    $('.form').html(result);
                    $('.form').fadeIn(500);
                    $('.loading').html('').fadeOut(50);
                }
            });
        }
    });
    $('.pad a[name=delete]').bind('click', function(){        
        if ($(this).find('img').attr('disabled') == 'disabled') {           
            $('.notice').html('Выберите хотя бы одну запись для удаления...').fadeIn(150);
            setTimeout(function(){
                $('.notice').fadeOut(250);
            }, 2500);
        } else {
        	if(confirm('Вы действительно хотите удалить выбранные записи?'))
        	{
        		$('.loading').fadeIn(150);
        		var data = '';
        		$('.t6 tr.items input[type=checkbox]:checked').each(function(i, item) {
        			data = data + 'id[]='+item.value+'&';
        		});
       			$.ajax({
               		type: 'POST',
               		url: '/setting/banking/delete',
               		data: data,        
               		success: function(result){
               			window.location.reload();
             		}
           		});
        	}
        }
    });
    $('.pad a[name=add]').bind('click', function(){        
		$('.loading').fadeIn(150);
		$('.form').load('/setting/banking/add');
		$('.form').fadeIn(500);
		$('.loading').html('').fadeOut(50);
	});
    $('.main input[type=checkbox]').bind('click', function(){
    	setTimeout(function(){
            if ($('.t6 tr.items input[type=checkbox]:checked').length == 1) {
                $('.pad a[name=edit] img').attr({src: '/media/images/button1.png', disabled: ''});
            } else if ($('.t6 tr.items input[type=checkbox]:checked').length < 1 || $('.t6 tr.items input[type=checkbox]:checked').length > 1) {
                $('.pad a[name=edit] img').attr({src: '/media/images/button1h.png', disabled: 'disabled'});
            }       
        }, 100);
    });
    $('.main input[type=checkbox]').bind('click', function(){
        setTimeout(function(){
            if ($('.t6 tr.items input[type=checkbox]:checked').length > 0) {
                $('.pad a[name=delete] img').attr({src: '/media/images/button3.png', disabled: ''});
            } else {
                $('.pad a[name=delete] img').attr({src: '/media/images/button3h.png', disabled: 'disabled'});
            }       
        }, 100);
    });
    $('.t6 tr.items input[type=checkbox]').bind('click', function(){
        if ($(this).attr('checked')) {
            $(this).parents('tr').addClass('active');
        } else {
            $(this).parents('tr').removeClass('active');
        }       
    });
    $('.t6 tr.items').hover(function(){
        $(this).addClass('hover');      
    }, function(){
        $(this).removeClass('hover');
    });
    $('.t6 th input[type=checkbox]').bind('click', function(){
        if ($(this).attr('checked')) {          
            $('.t6 tr.items').find('input[type=checkbox]').parent('td').parent('tr').addClass('active');
            $('.t6 tr.items').find('input[type=checkbox]').attr({checked: true});
        } else {
            $('.t6 tr.items').find('input[type=checkbox]').parent('td').parent('tr').removeClass('active');
            $('.t6 tr.items').find('input[type=checkbox]').attr({checked: false});
        }
    });
    $('.t6 tr.items a').bind('click', function(){
        $('.loading').fadeIn(150);
        $.ajax({
            type: 'POST',
            url: '/setting/banking/edit/id/' + $(this).attr('rel'),
            success: function(result){
                $('.form').html(result);
                $('.form').fadeIn(500);
                $('.loading').fadeOut(50);
            }
        });
    });
    $('.filter input[type=button]').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/filter\/([0-9a-z]+)/', '', url::current()) ?>/filter/'+$(this).parent().find('select').val();
    });
    $('.sort a').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/sort\/([a-z_]+,[a-z_]+)/', '', url::current()) ?>/sort/'+$(this).attr('rel');
    });
});
/* ]]> */
</script>
<?php echo $template->header ?>
<?php echo $template->layer ?>
<?php echo $template->profile ?>
<div class="center">
    <div class="head">
	    <?php echo $template->logo ?>
	    <?php echo $template->top ?>
	    <?php echo $template->logout ?>
	    <?php echo $template->atack ?>
	</div>
    <div class="block">
        <div class="block-l">
            <div class="block-r">
                <?php echo $template->panel ?>
                <?php echo $template->quick ?>
            </div>
        </div>
    </div>
    <?php echo $template->switch ?>
    <div class="wrapper">
        <div class="wrapper-t">
            <div class="wrapper-b-l">
                <div class="wrapper-b-r">
                    <div class="container">
                        <div class="content">
                            <div class="main">
                                <?php echo $template->breadcrumps ?>
								<!-- BEGIN FORM -->                                
								<div class="desc">
								    <h2>Управление игровыми банками</h2>
								    <p>В этом модуле вы сможете упровлять игровыми банками. </p>
								</div>
								<div class="pad">
								    <div class="button">
								        <div class="button-r"> <a href="javascript:;" title="Добавить" name="add"><img src="/media/images/button2.png" alt="Добавить" /></a><a href="javascript:;" title="Редактировать" name="edit"><img src="/media/images/button1h.png" disabled="disabled" alt="Редактировать" /></a><a href="javascript:;" title="Удалить" name="delete"><img src="/media/images/button3h.png" disabled="disabled" alt="Удалить" /></a> </div>								        
								    </div>
								    <div class="loading">Загрузка...</div>
								    <div class="notice"></div>
								    <br class="clearfloat" />								    
								</div> 								
								<div class="form hide"></div>
								<!-- END FORM -->
                                <h2>Список банков</h2>
								<div class="bg">
								    <div class="in-bg">
								        <table border="0" cellpadding="0" cellspacing="0" class="t6">
								        	<tr class="sort">
								                <th width="29">&nbsp;&nbsp; <input type="checkbox" /></th>
								                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,title">Название&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,title">Название&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,title">Название</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,type'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,type">Тип банка&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,type'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,type">Тип банка&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,type">Тип банка</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th> 
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,balance'))
                                                	{
                                                	?>
                                                		<nobr><a href="javascript:;" rel="down,balance">Сумма&nbsp;<img src="/media/images/up.gif" alt="#"></a></nobr>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,balance'))
                                                	{
                                                	?>
                                                		<nobr><a href="javascript:;" rel="up,balance">Сумма&nbsp;<img src="/media/images/down.gif" alt="#"></a></nobr>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,balance">Сумма</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>               
								            </tr>								            
								            <tr class="filter">
								                <td></td>
								                <td></td>
								                <td>
								                	<nobr><select>
								                		<option value="0"></option>
								                	<?php foreach (Kohana::config('const.setting.banking.type') as $key => $value): ?>							                    		
							                    		<option <?php if (uri::segment('filter') === $key) echo 'selected="selected"' ?> value="<?php echo $key ?>"><?php echo $value ?></option>							                    		
							                    	<?php endforeach ?>								                        
								                    </select>
								                    <input type="button" value="Фильтр" /></nobr>
								                </td>	
								                <td></td>							                
								            </tr>
								        	<?php foreach ($data->list_banking as $row): ?>
												<tr class="items<?php if ($row === end($data->list_banking)) echo ' last' ?>">
													<?php if ($row->is_default) { ?>
													<td width="29"></td>
													<? } else { ?>
													<td width="29">&nbsp;&nbsp; <input type="checkbox" name="id[]" value="<?php echo $row->id ?>" /></td>
													<? } ?>
								                    <td>
								                    	<strong><a href="#edit" rel="<?php echo $row->id ?>" title="<?php echo $row->title ?>"><?php echo $row->title ?></a></strong><?php if ($row->is_default) { ?><font class="default">&nbsp;(По умолчанию)</font><? } ?><br />
								                    	<font class="datetime">
								                    	<?php foreach ($data->list_games_banking as $row1): ?>
								                    		<?php if ($row->id === $row1->banking_id): ?>
								                    			<?php foreach ($data->list_games as $row2): ?>
								                    				<?php if ($row1->games_id === $row2->id): ?>
								                    					<?php echo $row2->title ?>, 
								                    				<?php endif ?>
								                    			<?php endforeach ?>								                    		
								                    		<?php endif ?>
								                    	<?php endforeach ?>
								                    	</font>
								                    </td>
								                    <td><?php echo Kohana::config('const.setting.banking.type.'.$row->type); ?></td>
								                    <td align="right"><?php echo number_format($row->balance, 2, '.', ''); ?></td>
												</tr>
											<?php endforeach ?>												
								            </table>		
								        <div class="pages"><?php echo $data->pagination ?></div>
								        <br class="clearfloat" />
								    </div>
								</div>
                            </div>
                        </div>
                        <?php echo $template->left ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $template->foot ?>
</div>
<?php echo $template->footer ?>