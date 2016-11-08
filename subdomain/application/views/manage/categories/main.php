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
                url: '/manage/categories/edit/id/'+$('.t6 tr.items input[type=checkbox]:checked').val(),         
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
    $('.t6 tr.items a[href=#edit]').bind('click', function(){
        $('.loading').fadeIn(150);
        $.ajax({
            type: 'POST',
            url: '/manage/categories/edit/id/' + $(this).parents('tr').find('input[type=checkbox]').val(),
            success: function(result){
                $('.form').html(result);
                $('.form').fadeIn(500);
                $('.loading').fadeOut(50);
            }
        });
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
								    <h2><?php echo Kohana::lang('categories.header') ?></h2>
								    <p><?php echo Kohana::lang('categories.description') ?> </p>
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
                                <h2><?php echo Kohana::lang('categories.list') ?></h2>
                                <div class="tabs">
                                    <ul>
                                        <li><a href="/manage/games">Игры</a></li>
                                        <li class="active">Категории</li>
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
								                	<?php if (strpos(url::current(),'/sort/up,title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,title"><?php echo Kohana::lang('categories.title') ?>&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,title'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,title"><?php echo Kohana::lang('categories.title') ?>&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,title"><?php echo Kohana::lang('categories.title') ?></a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>								                
								                <th>
								                	<?php if (strpos(url::current(),'/sort/up,count_games'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,count_games"><?php echo Kohana::lang('categories.count') ?>&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,count_games'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,count_games"><?php echo Kohana::lang('categories.count') ?>&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,count_games"><?php echo Kohana::lang('categories.count') ?></a>
                                                	<?php
                                                	}
                                                	?>
                                                </th>
                                                <th>
								                	<nobr><?php if (strpos(url::current(),'/sort/up,sort'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="down,sort"><?php echo Kohana::lang('categories.sort') ?>&nbsp;<img src="/media/images/up.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	elseif (strpos(url::current(),'/sort/down,sort'))
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,sort"><?php echo Kohana::lang('categories.sort') ?>&nbsp;<img src="/media/images/down.gif" alt="#"></a>
                                                	<?php
                                                	}
                                                	else
                                                	{
                                                	?>
                                                		<a href="javascript:;" rel="up,sort"><?php echo Kohana::lang('categories.sort') ?></a>
                                                	<?php
                                                	}
                                                	?></nobr>
                                                </th>
								            </tr>	
								            <?php foreach ($data->list_categories as $row): ?>
												<tr class="items<?php if ($row === end($data->list_categories)) echo ' last' ?>">
								                    <td width="29">&nbsp;&nbsp; <input type="checkbox" name="id[]" value="<?php echo $row->id ?>" /></td>
								                    <td>
								                    	<strong><a href="#edit" title="<?php echo $row->title ?>"><?php echo $row->title ?></a></strong>
								                    </td>
								                    <td><a href="/manage/games/filter/<?php echo $row->id ?>">Всего&nbsp;<?php echo $row->count_games ?></a></td>
								                    <td><?php echo $row->sort ?></td>
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