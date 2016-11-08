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
                url: '/manage/games/edit/id/'+$('.t6 tr.items input[type=checkbox]:checked').val(),         
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
            if ($(this + ':checked').length == 1) {
                $('.pad a[name=edit] img').attr({src: '/media/images/button1.png', disabled: ''});
            } else if ($(this + ':checked').length < 1 || $(this + ':checked').length > 1) {
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
            url: '/manage/games/edit/id/' + $(this).parents('tr').find('input[type=checkbox]').val(),
            success: function(result){
                $('.form').html(result);
                $('.form').fadeIn(500);
                $('.loading').fadeOut(50);
            }
        });
    });
    $('.filter input[type=button]').bind('click', function(){
        document.location.href = '/<?php echo preg_replace('/filter\/([0-9])/', '', url::current()) ?>/filter/'+$(this).parent().find('select').val();
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
								    <h2>Управление играми</h2>
								    <p>В этом модуле вы сможете настроить игры игрового комплекса. Раставить игры по категориям, <br />настроить банкинг игр и установить проценты выигрышных комбинаций. </p>
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
                                <h2>Список игр</h2>
                                <div class="tabs">
                                    <ul>
                                        <li class="active">Игры</li>
                                        <li><a href="/manage/categories">Категории</a></li>
                                    </ul>
                                    <br class="clearfloat" />
                                </div>
                                <br class="clearfloat" />
								<div class="bg">
								    <div class="in-bg">
								        <table border="0" cellpadding="0" cellspacing="0" class="t6">
								        	<tr class="sort">
								                <th width="29">&nbsp;&nbsp; <input type="checkbox" /></th>                
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,games_title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,games_title">Название (Категория)&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,games_title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,games_title">Название (Категория)&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,games_title">Название (Категория)</a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>								                
								                <th>Банк игры, баланс</th>
								                <th>Банк прибыли, %, баланс</th>
								                <th>Доп. банки, %, баланс</th>
								                <!-- <th>Ставки</th>
								                <th>Выигрыши</th>
								                <th>Прибыль</th>  -->
								                <th>
								                	<nobr><?php if (strpos(url::current(),'/sort/up,games_sort'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,games_sort">Сорт.&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,games_sort'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,games_sorte">Сорт.&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,games_sort">Сорт.</a>
                                                	<?php
                                                	}
                                                	?></nobr>
                                                </th>								                
								            </tr>								            
								            <tr class="filter">
								                <td></td>
								                <td colspan="12">
								                	<select>
								                		<option value="0"></option>
								                	<?php foreach ($data->list_categories as $row1): ?>							                    		
							                    		<option value="<?php echo $row1->id ?>" <?php if (uri::segment('filter') === $row1->id) echo 'selected="selected"' ?>><?php echo $row1->title ?></option>							                    		
							                    	<?php endforeach ?>								                        
								                    </select>
								                    <input type="button" value="Фильтр" />
								                </td>								                
								            </tr>
								        	<?php foreach ($data->list_games as $row): ?>
												<tr class="items<?php if ($row === end($data->list_games)) echo ' last' ?>">
								                    <td width="29">&nbsp;&nbsp; <input type="checkbox" name="id[]" value="<?php echo $row->games_id ?>" /></td>
								                    <td>
								                    	<strong><a href="#edit" title="<?php echo $row->games_title ?>"><?php echo $row->games_title ?></a></strong><br />
								                    	<font class="datetime"><?php echo $row->categories_title ?></font>							                    	
								                    </td>
								                    <td>
								                    <?php foreach ($data->list_games_banking as $row1): ?>
								                    	<?php if ($row->games_id === $row1->games_id AND $row1->type === 'game'): ?>
								                    		<?php foreach ($data->list_banking as $row2): ?>
								                    			<?php if ($row1->banking_id === $row2->id): ?>
								                    				<?php echo $row2->title ?>, 
								                    				<?php echo number_format($row2->balance, 2, '.', '') ?>
								                    			<?php endif ?>
								                    		<?php endforeach ?>								                    		
								                    	<?php endif ?>
								                    <?php endforeach ?>
								                    </td>
								                    <td>
								                    <?php foreach ($data->list_games_banking as $row1): ?>
								                    	<?php if ($row->games_id === $row1->games_id AND $row1->type === 'profit'): ?>
								                    		<?php foreach ($data->list_banking as $row2): ?>
								                    			<?php if ($row1->banking_id === $row2->id): ?>
								                    				<?php echo $row2->title ?>, 
								                    				<?php echo $row1->percent ?>%, 
								                    				<?php number_format($row2->balance, 2, '.', '') ?>
								                    			<?php endif ?>
								                    		<?php endforeach ?>								                    		
								                    	<?php endif ?>
								                    <?php endforeach ?>
								                    </td>
								                    <td>
								                    <?php foreach ($data->list_games_banking as $row1): ?>
								                    	<?php if ($row->games_id === $row1->games_id AND ! in_array($row1->type, array('game', 'profit'))): ?>
								                    		<?php foreach ($data->list_banking as $row2): ?>
								                    			<?php if ($row1->banking_id === $row2->id): ?>
								                    				<?php echo $row2->title ?>, 
								                    				<?php echo $row1->percent ?>%, 
								                    				<?php number_format($row2->balance, 2, '.', '') ?>
								                    				
								                    				<?php if (end($data->list_games_banking)): ?>
								                    				<br />
								                    				<?php endif ?>
								                    				
								                    			<?php endif ?>
								                    		<?php endforeach ?>								                    		
								                    	<?php endif ?>
								                    <?php endforeach ?>
								                    </td>
								                    <!-- <td>-</td>
								                    <td>-</td>
								                    <td>-</td>  -->
								                    <td align="center" width="5%"><?php echo $row->games_sort ?></td>								                    
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