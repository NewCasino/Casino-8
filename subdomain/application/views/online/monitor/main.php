<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<?php echo $template->meta ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	var games_id = 0;
	var categories_id = 0;
	var string = '';
	$('.bg3 ul li a').bind('click', function(){ 
		$(this).parents('tr').find('li').removeClass('active');
		$(this).parents('tr').find('h4').removeClass('active');
		$(this).parents('li').addClass('active');
		games_id = $(this).attr('rel');
		categories_id = 0;
		$.ajax({
			type: "POST",
   			url: "/online/events",
   			data: "games_id="+games_id,
   			success: function(result){
				$('.t9').html(result);
			}
		});
	});
	$('.bg3 a h4').bind('click', function(){ 
		$(this).parents('tr').find('li').removeClass('active');
		$(this).parents('tr').find('h4').removeClass('active');
		$(this).addClass('active');
		categories_id = $(this).parents('a').attr('rel');
		games_id = 0;
		$.ajax({
			type: "POST",
   			url: "/online/events",
   			data: "categories_id="+categories_id,
   			success: function(result){
				$('.t9').html(result);
			}
		});
	});
	setInterval(function(){
		$.ajax({
			type: "POST",
   			url: "/online/events/get_last",
   			data: "games_id="+games_id+"&categories_id="+categories_id+"&last_id="+$('.t9 tr:first').attr('name'),
   			success: function(result){
				$('.t9 tr:first').before(result);
				var tr = $('.t9').find('.hide');
				for (var i = 0; i < tr.length; i++) {
					//$(tr[i]).css('display','none');
					$(tr[i]).removeClass('hide');
					$('.t9 tr:last').slideUp("slow");
					$('.t9 tr:last').remove();
					$(tr[i]).slideDown("slow");
				}
			}
		});
 	}, 10000);
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
								<div class="desc2">
                                    <h2><?php echo Kohana::lang('online.monitor.header') ?></h2>
                                    <p><?php echo Kohana::lang('online.monitor.description') ?> </p>
		                        </div>
		                        <table cellpadding="0" cellspacing="1" class="t7">
		                        	<tr>
		                        	<?php foreach ($data->list_games as $key => $value) { ?>
										<td class="bg3" valign="top">
											<a href="javascript:;" title="#" rel="<?php echo $value[0]->categories_id ?>"><h4><?php echo $key ?></h4></a>
											<ul>
											<?php foreach ($value as $row)
											{
											?>
												<li><a href="javascript:;" title="#" rel="<?php echo $row->id ?>"><?php echo $row->games_title ?></a></li>
											<?php
											}
											?>
											</ul>
										</td>
									<?php } ?>
									</tr>
								</table>	
								<!-- END FORM -->
								<h2><?php echo Kohana::lang('online.monitor.wins') ?></h2>
                                <div class="tabs">
                                    <ul>
                                        <li class="active" tab="games"><a href="javascript:;" title="Настройки"><?php echo Kohana::lang('online.monitor.games') ?></a></li>
                                    </ul>
                                    <br class="clearfloat" />
                                </div>
                                <br class="clearfloat" />
                                <!-- <div class="relbox">
									<div class="view-mode">
										<table cellpadding="0" cellspacing="0">
											<tr>
												<td><a href="javascript:;" title="#"><img src="/media/images/bullet5.gif" alt="#" /></a></td>
												<td class="active"><img src="/media/images/bullet6.gif" alt="#" /></td>
											</tr>
										</table>
									</div>
									<div class="active-color"><a href="javascript:;" title="#">Активный цвет</a>   (Вкл.)</div>
								</div> -->
                                <div class="bg">
                                    <div class="in-bg" tab="events">
                                    	<div class="pad3">
											<table border="0" cellpadding="0" cellspacing="0" class="t8">
                                            	<tr>
                                            		<td width="41"></td>
		                                        	<td><?php echo Kohana::lang('online.monitor.login') ?></td>
                                                	<td width="153"><?php echo Kohana::lang('online.monitor.game') ?></td>
                                                	<td width="90"><?php echo Kohana::lang('online.monitor.bet') ?></td>
                                                	<td width="88"><?php echo Kohana::lang('online.monitor.win') ?></td>
                                                	<td width="111"><?php echo Kohana::lang('online.monitor.balance') ?></td>
                                                	<td width="78"><?php echo Kohana::lang('online.monitor.time') ?></td>
                                            	</tr>
                                            </table>
                                            <table cellpadding="0" cellspacing="0" class="t9">
                                            <?php
											foreach ($data->events_list as $row)
											{
												if ($row->win == 0)
												{
												?>
												<tr class="bg7" name="<?php echo $row->id; ?>">
													<td width="41"><img src="/media/images/circle3.png" alt="#" /></td>
												<?
												}
												elseif ($row->win > $row->bet*100)
												{
												?>
												<tr class="bg8" name="<?php echo $row->id; ?>">
													<td width="41"><img src="/media/images/circle4.png" alt="#" /></td>
												<?php
												}
												elseif ($row->win > $row->bet*10)
												{
												?>
												<tr class="bg9" name="<?php echo $row->id; ?>">
													<td width="41"><img src="/media/images/circle5.png" alt="#" /></td>
												<?php
												}
												elseif ($row->win > $row->bet*5)
												{
												?>
												<tr class="bg10" name="<?php echo $row->id; ?>">
													<td width="41"><img src="/media/images/circle6.png" alt="#" /></td>
												<?php
												}
												elseif ($row->win > $row->bet)
												{
												?>
												<tr class="bg5" name="<?php echo $row->id; ?>">	
													<td width="41"><img src="/media/images/circle1.png" alt="#" /></td>
												<?php
												}
												else
												{
												?>
												<tr class="bg6" name="<?php echo $row->id; ?>">
													<td width="41"><img src="/media/images/circle2.png" alt="#" /></td>
												<?php
												}
												?>
													<td><?php echo $row->username ?></td>
													<td width="253"><?php echo $row->title ?>&nbsp;(<?php echo Kohana::lang('online.monitor.map.'.$row->map) ?>)</td>
													<td width="90"><?php echo number_format($row->bet, 2, '.', '') ?></td>
													<td width="88"><?php echo number_format($row->win, 2, '.', '') ?></td>
													<td width="111"><?php echo number_format($row->gamer_balance, 2, '.', '') ?></td>
													<td width="78"><?php echo date('H:i:s', $row->time) ?></td>
												</tr>
											<?php	
											}
											?>
											</table>
										</div>
                                        <br class="clearfloat" />
                                    </div>
                                </div>
                                <div class="pad4">
									<table cellpadding="0" cellspacing="0" class="t10">
										<tr valign="top">
											<td align="center">
												<table>
													<tr>
														<td width="21"><img src="/media/images/circle3.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.loss') ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle2.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.less_bet') ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle1.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.more_bet') ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle6.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.win_5') ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle5.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.win_10') ?></td>
														<td width="50px"></td>
														<td width="21"><img src="/media/images/circle4.png" alt="#" /></td>
														<td><?php echo Kohana::lang('online.monitor.status.win_100') ?></td>
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