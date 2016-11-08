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
        document.location.href = '/<?php echo preg_replace('/filter\/([0-9]+,[0-9]+,[0-9]+,[0-9]+,[0-9]+)/', '', url::current()) ?>/filter/'+$('.filter').find('select[name=status]').val()+','+$('.filter').find('select[name=collection]').val()+','+$('.filter').find('select[name=day]').val()+','+$('.filter').find('select[name=month]').val()+','+$('.filter').find('select[name=year]').val();
    });
    $('a[name=add_collection]').bind('click',function(e){
		$('div.collection').css({'position' : 'absolute'});
		$('div.collection').css('left', e.pageX+20);
		$('div.collection').css('top', e.pageY);
		$('div.collection').fadeIn(350);
	});
	$('div.collection input.cancel').bind('click', function(){
		$('div.collection').fadeOut(350);
	})
	$('div.collection input.submit').bind('click', function(){
		$.ajax({
			type: "POST",
   			url: "/finance/pincode/save_collection",
   			data: "title="+$('div.collection input[name=title]').val(),
   			success: function(id){
     			$('select[name=collection_id]').append('<option value="'+id+'">'+$('div.collection input[name=title]').val()+'</option>');
   			}
 		});
		$('div.collection').fadeOut(350);
	})
	$('.sort a').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/sort\/([a-z_]+,[a-z_]+)/', '', url::current()) ?>/sort/'+$(this).attr('rel');
    });
    $('.button2 input[name=cancel]').bind('click', function(){
		$('.form').fadeOut();		
	});
});
/* ]]> */
</script>
<div class="collection" style="display: none;">
<form action="/finance/pincode/save_collection" method="post"> 
	<br class="clearfloat" />
	<div class="bg">
	<div class="in-bg" tab="main">
		<table cellpadding="0" cellspacing="25" class="t1">
			<tr valign="top">
				<td>
					<p> Название <br />
						<input type="text" class="f06" required="true" name="title" value="" />                                                       
						<span class="hide"></span><br />
						<font class="description">Название коллекции</font>
					</p><br />                    
				</td>                   
			</tr>
		</table>
		<div class="button2"> 
			<input type="button" class="submit" value="Сохранить" /> <input type="button" class="cancel" value="Отменить" />
			<br /><span class="hide"></span>
		</div>
	</div>    
	</div> 
</form>
</div>
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
                                    <h2>Управление пинкода</h2>
                                    <p>В этом модуле вы сможете сгенерировать пинкоды в любом количестве и с любым номиналом, <br />и просмотреть список использованных пользователями пинкодов. </p>
                                </div>
                                <div class="pad">
                                    <div class="button">
                                        <div class="button-r"> <a href="javascript:;" title="Редактировать" name="edit"><img src="/media/images/button2.png" disabled="disabled" alt="Редактировать" /></a> </div>                                     
                                    </div>
                                    <div class="loading">Загрузка...</div>
                                    <div class="notice"></div>
                                    <br class="clearfloat" />                                   
                                </div>                              
                                <div class="form hide">
                                <form action="/finance/pincode/save" method="post"> 
                                    <h2>Создание пинкодов</h2>
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
                                                        <p> Сумма <br />
                                                            <input type="text" class="f24" required="true" name="amount" value="" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description">Целое число</font>
                                                        </p><br />                    
                                                        <p> Количество <br />
                                                            <input type="text" class="f23" required="true" name="count" value="" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description">Количество штук<br />для создания</font>
                                                        </p><br />
                                                        <p> Коллекция <br />
								                			<select name="collection_id">
								                				<option value="0"></option>
								                				<?php foreach ($data->list_collection as $row1): ?>							                    		
							                    					<option value="<?php echo $row1->id ?>" ><?php echo $row1->title ?></option>							                    		
							                    				<?php endforeach ?>								                        
								                    		</select>
								                    		<a href="javascript:;" name="add_collection">+</a>
								                    	</p><br />
								                    </td>                   
                                                    <!--<td class="w01"></td>-->
                                                </tr>
                                            </table>
                                            <div class="button2"> 
                                                <input type="submit" value="Добавить" /> <input type="button" name="cancel" value="Отменить" />
                                                <br /><span class="hide"></span>
                                            </div>
                                        </div>    
                                    </div> 
                                </form>
                                </div>
                                <!-- END FORM -->
                                <h2>Список пинкодов</h2>
                                <div class="tabs">
                                    <ul>
                                        <li class="active">Пинкоды</li>
                                        <li><a href="/finance/pincode/collection">Коллекции</a></li>
                                    </ul>
                                    <br class="clearfloat" />
                                </div>
                                <br class="clearfloat" />
                                <div class="bg">
                                    <div class="in-bg">
                                        <table border="0" cellpadding="0" cellspacing="0" class="t6">
                                            <tr class="sort">
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,code'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,code">Номер&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,code'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,code">Номер&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,code">Номер</a>
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
                                                	<?php if (strpos(url::current(),'/sort/up,collection_id'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,collection_id">Коллекция&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,collection_id'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,collection_ide">Коллекция&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,collection_id">Коллекция</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
                                                	<?php if (strpos(url::current(),'/sort/up,changed'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,changed">Дата использования&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,changed'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,changed">Дата использования&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,changed">Дата использования</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                            </tr>                                           
                                            <tr class="filter">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                	<select name="status">
                                                		<option value="0"></option>
                                                		<option value="1" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[0] == '1') echo 'selected="selected"';} ?>>Свободен</option>
                                                		<option value="2" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[0] == '2') echo 'selected="selected"';} ?>>Использован</option>
                                                </td>
                                                <td>
								                	<select name="collection">
								                		<option value="0"></option>
								                	<?php foreach ($data->list_collection as $row1): ?>							                    		
							                    		<option value="<?php echo $row1->id ?>" <?php if (uri::segment('filter')) {$array = explode(",", uri::segment('filter')); if ($array[1] === $row1->id) echo 'selected="selected"';} ?>><?php echo $row1->title ?></option>							                    		
							                    	<?php endforeach ?>								                        
								                    </select>
								                </td>
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
                                            <?php foreach ($data->list_pincode as $row): ?>
                                                <tr class="items<?php if ($row === end($data->list_pincode)) echo ' last' ?>" <?php if ($row->status == 2) echo 'bgcolor="#f2f2f2"'; ?><?php if ($row->status == 1) echo 'bgcolor="#d6ead6"'; ?>>                                                    
                                                    <td><strong><?php echo $row->code ?></strong></td>
                                                    <td align="right"><?php echo number_format($row->amount, 2, '.', '') ?></td>
                                                    <td>
                                                    	<?php if ($row->status == 2) echo '<img src="/media/images/circle1.png" alt="#" />' ?>
														<?php if ($row->status == 1) echo '<img src="/media/images/circle3.png" alt="#" />' ?>
														<?php if (isset($row->username)) echo '&nbsp;('.$row->username.')' ?>
                                                    </td>
                                                    <td>
                                                    <?php foreach ($data->list_collection as $row1):							                    		
							                    		if ($row1->id == $row-> collection_id) echo $row1->title;							                    		
							                    	endforeach ?>	
                                                    </td>
                                                    <td><font class="datetime"><?php if ($row->changed) echo date('d M Y g:i a', $row->changed) ?></font></td>
                                                </tr>
                                            <?php endforeach ?>
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
														<td width="21"><img src="/media/images/circle1.png" alt="#" /></td>
														<td>Использован</td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle3.png" alt="#" /></td>
														<td>Свободен</td>
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