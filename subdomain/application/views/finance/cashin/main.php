<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<?php echo $template->meta ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
    $('.pad a[name=edit]').bind('click', function(){        
        $('.form').fadeIn(500);
    });
    $('.t6 tr.items').hover(function(){
        $(this).addClass('hover');      
    }, function(){
        $(this).removeClass('hover');
    });
    $('.filter input[type=button]').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/filter\/([0-9]+,[0-9]+,[0-9]+,[0-9]+)/', '', url::current()) ?>/filter/'+$('.filter').find('select[name=user_id]').val()+','+$('.filter').find('select[name=day]').val()+','+$('.filter').find('select[name=month]').val()+','+$('.filter').find('select[name=year]').val();
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
                                    <p>В этом модуле вы сможете посмотреть пополнения игроков казино. </p>
                                </div>
                                <!-- END FORM -->
                                <h2>Список пополнений</h2>
                                <div class="bg">
                                    <div class="in-bg">
                                        <table border="0" cellpadding="0" cellspacing="0" class="t6">
                                            <tr class="sort">
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
                                                		<a href="javascript:;" rel="down,amount">Сумма&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,amount'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,amount">Сумма&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,amount">Сумма</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,code'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,code">Пинкод&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,code'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,code">Пинкод&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,code">Пинкод</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,merchant_name'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,merchant_name">Платежные реквизиты&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,merchant_name'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,merchant_name">Платежные реквизиты&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,merchant_name">Платежные реквизиты</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,datetime'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,datetime">Дата&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,datetime'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,datetime">Дата&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,datetime">Дата</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                            </tr>      
                                            <tr class="filter">
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
								                <td></td>
								                <td>
								                	<select name="day">
                                                		<option value="0"></option>
                                                	<?php for ($i=1; $i<=31; $i++): ?>
                                                		<option value="<?php echo $i ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[1] == $i) echo 'selected="selected"';} ?>><?php echo $i ?></option>	
                                                	<?php endfor ?>
                                                	</select>
                                                	<select name="month">
                                                		<option value="0"></option>
                                                	<?php foreach (Kohana::lang('cash.month') as $key => $value): ?>
                                                		<option value="<?php echo $key ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[2] == $key) echo 'selected="selected"';} ?>><?php echo $value ?></option>	
                                                	<?php endforeach ?>
                                                	</select>
                                                	<select name="year">
                                                		<option value="0"></option>
                                                	<?php for ($i=2009; $i<=2020; $i++): ?>
                                                		<option value="<?php echo $i ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[3] == $i) echo 'selected="selected"';} ?>><?php echo $i ?></option>	
                                                	<?php endfor ?>
                                                	</select>
                                                	<input type="button" value="Фильтр" />
								                </td>
								            </tr>                                     
                                            <?php foreach ($data->list_cashin as $row): ?>
                                                <tr class="items<?php if ($row === end($data->list_cashin)) echo ' last' ?>">                                                    
                                                    <td><strong><?php if (isset($row->username)) echo $row->username ?></strong></td>
                                                    <td align="right"><?php echo number_format($row->amount, 2, '.', '') ?></td>
                                                    <td><?php if (isset($row->code)) echo $row->code ?></td>
                                                    <td><?php if (isset($row->merchant_name)) echo $row->merchant_name ?></td>
                                                    <td><font class="datetime"><?php if ($row->datetime) echo date('d M Y g:i a', $row->datetime) ?></font></td>
                                                </tr>
                                            <?php endforeach ?>
                                            <tr>
                                            	<td></td>
                                            	<th style="text-align: right;"><?php echo number_format($data->summ_cashin, 2, '.', ''); ?></th>
                                            	<td></td>
                                            	<td></td>
                                            	<td></td>
                                            </tr>
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