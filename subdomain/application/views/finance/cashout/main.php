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
                url: '/finance/cashout/edit/id/'+$('.t6 tr.items input[type=checkbox]:checked').val(),         
                success: function(result){
                    $('.form').html(result);
                    $('.form').fadeIn(500);
                    $('.loading').html('').fadeOut(50);
                }
            });
        }
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
            $('.t6 tr.items').addClass('active');
            $('.t6 tr.items').find('input[type=checkbox]').attr({checked: true});
        } else {
            $('.t6 tr.items').removeClass('active');
            $('.t6 tr.items').find('input[type=checkbox]').attr({checked: false});
        }
    });
    $('.t6 tr.items a').bind('click', function(){
        $('.loading').fadeIn(150);
        $.ajax({
            type: 'POST',
            url: '/finance/cashout/edit/id/' + $(this).parents('tr').find('input[type=checkbox]').val(),
            success: function(result){
                $('.form').html(result);
                $('.form').fadeIn(500);
                $('.loading').fadeOut(50);
            }
        });
    });
    $('.filter input[type=button]').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/filter\/([0-9]+,[0-9]+,[0-9]+,[0-9]+,[0-9]+)/', '', url::current()) ?>/filter/'+$('.filter').find('select[name=user_id]').val()+','+$('.filter').find('select[name=status]').val()+','+$('.filter').find('select[name=day]').val()+','+$('.filter').find('select[name=month]').val()+','+$('.filter').find('select[name=year]').val();
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
								    <h2>Управление запросами на вывод средств</h2>
								    <p>В этом модуле вы сможете упровлять запросами на вывод средств. </p>
								</div>
								<div class="pad">
								    <div class="button">
								        <div class="button-r"> <a href="javascript:;" title="Редактировать" name="edit"><img src="/media/images/button1h.png" disabled="disabled" alt="Редактировать" /></a> </div>								        
								    </div>
								    <div class="loading">Загрузка...</div>
								    <div class="notice"></div>
								    <br class="clearfloat" />								    
								</div> 								
								<div class="form hide"></div>
								<!-- END FORM -->
                                <h2>Список запросов на вывод средств</h2>
								<div class="bg">
								    <div class="in-bg">
								        <table border="0" cellpadding="0" cellspacing="0" class="t6">
								        	<tr class="sort">
								        		<th width="29">&nbsp;&nbsp; <input type="checkbox" /></th>
								        		<th>
								        			<?php if (strpos(url::current(),'/sort/up,user_id'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,user_id">Пользователь&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,user_id'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,user_id">Пользователь&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,user_id">Пользователь</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,amount'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,amount">Сумма (кредитов)&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,amount'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,amount">Сумма (кредитов)&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,amount">Сумма (кредитов)</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,payment_info'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,payment_info">Платежная информация&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,payment_info'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,payment_info">Платежная информация&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,payment_info">Платежная информация</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,status'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,status">Статус&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,status'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,status">Статус&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,status">Статус</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,created'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,created">Дата создания&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,created'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,created">Дата создания&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,created">Дата создания</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,changed'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,changed">Дата изменения&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,changed'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,changed">Дата изменения&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,changed">Дата изменения</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
								            </tr>								            
								            <tr class="filter">
								            	<td></td>
								            	<td>
								            		<select name="user_id">
								            			<option value="0"></option>
								            		<?php foreach ($data->list_player as $row): ?>
								            			<option value="<?php echo $row->user_id ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[0] == $row->user_id) echo 'selected="selected"';} ?>><?php echo $row->username ?></option>
								            		<? endforeach ?>
								            		</select>
								            	</td>
								                <td></td>
								                <td></td>
								                <td>
								                	<select name="status">
								                		<option value="0"></option>
								                		<option <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[1] === '2') echo 'selected="selected"';} ?> value="2"><?php echo Kohana::lang('cash.status.2'); ?></option>
								                		<option <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[1] === '3') echo 'selected="selected"';} ?> value="3"><?php echo Kohana::lang('cash.status.3'); ?></option>
								                		<option <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[1] === '4') echo 'selected="selected"';} ?> value="4"><?php echo Kohana::lang('cash.status.4'); ?></option>							                    		
							                    	</select>
								                </td>	
								                <td></td>
								                <td>
								                	<select name="day">
                                                		<option value="0"></option>
                                                	<?php for ($i=1; $i<=31; $i++): ?>
                                                		<option value="<?php echo $i ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[2] == $i) echo 'selected="selected"';} ?>><?php echo $i ?></option>	
                                                	<?php endfor ?>
                                                	</select>
                                                	<select name="month">
                                                		<option value="0"></option>
                                                	<?php foreach (Kohana::lang('cash.month') as $key => $value): ?>
                                                		<option value="<?php echo $key ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[3] == $key) echo 'selected="selected"';} ?>><?php echo $value ?></option>	
                                                	<?php endforeach ?>
                                                	</select>
                                                	<select name="year">
                                                		<option value="0"></option>
                                                	<?php for ($i=2009; $i<=2020; $i++): ?>
                                                		<option value="<?php echo $i ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[4] == $i) echo 'selected="selected"';} ?>><?php echo $i ?></option>	
                                                	<?php endfor ?>
                                                	</select>
                                                	<input type="button" value="Фильтр" />
								                </td>
								            </tr>
								        	<?php foreach ($data->list_cashout as $row): ?>
												<tr class="items<?php if ($row === end($data->list_cashout)) echo ' last' ?>" <?php if ($row->status == 2) echo 'bgcolor="#f8f2d6"'; ?><?php if ($row->status == 3) echo 'bgcolor="#f2f2f2"'; ?><?php if ($row->status == 4) echo 'bgcolor="#d6ead6"'; ?>>
													<td width="29">&nbsp;&nbsp; <input type="checkbox" name="id[]" value="<?php echo $row->cashout_id ?>" /></td>
													<td>
								                    	<strong><a href="#edit" title="<?php echo $row->username ?>"><?php echo $row->username ?></a></strong>
								                    </td>
								                    <td align="right"><?php echo number_format($row->amount, 2, '.', ''); ?></td>
								                    <td><?php echo $row->payment_info; ?></td>
								                    <?php if ($row->status == 2) echo '<td width="41"><img src="/media/images/circle6.png" alt="#" /></td>' ?>
													<?php if ($row->status == 3) echo '<td width="41"><img src="/media/images/circle1.png" alt="#" /></td>' ?>
													<?php if ($row->status == 4) echo '<td width="41"><img src="/media/images/circle3.png" alt="#" /></td>' ?>
								                    <td><font class="datetime"><?php if ($row->created) echo date('d M Y g:i a', $row->created) ?></font></td>
								                    <td><font class="datetime"><?php if ($row->changed) echo date('d M Y g:i a', $row->changed) ?></font></td>
								                </tr>
											<?php endforeach ?>
											<tr>
												<th></th>
												<th></th>
                                            	<th style="text-align: right;"><?php echo number_format($data->summ_cashout, 2, '.', ''); ?></th>
                                            	<th></th>
                                            	<th></th>
                                            	<th></th>
                                            	<th></th>
                                            </tr>												
								            </table>		
								        <div class="pages"><?php echo $data->pagination ?></div>
								        <br class="clearfloat" />
								    </div>
								</div>
								<div class="pad4">
									<table cellpadding="0" cellspacing="0" class="t10">
										<tr valign="top">
											<td align="center">
												<table>
													<tr>
														<td width="21"><img src="/media/images/circle6.png" alt="#" /></td>
														<td><?php echo Kohana::lang('cash.status.2'); ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle1.png" alt="#" /></td>
														<td><?php echo Kohana::lang('cash.status.3'); ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle3.png" alt="#" /></td>
														<td><?php echo Kohana::lang('cash.status.4'); ?></td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
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