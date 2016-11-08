<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<?php
foreach ($data->events_list as $row)
{
	if ($row->win == 0)
	{
	?>
	<tr class="bg7 hide" name="<?php echo $row->id; ?>">
		<td width="41"><img src="/media/images/circle3.png" alt="#" /></td>
	<?
	}
	elseif ($row->win > $row->bet*100)
	{
	?>
	<tr class="bg8 hide" name="<?php echo $row->id; ?>">
		<td width="41"><img src="/media/images/circle4.png" alt="#" /></td>
	<?php
	}
	elseif ($row->win > $row->bet*10)
	{
	?>
	<tr class="bg9 hide" name="<?php echo $row->id; ?>">
		<td width="41"><img src="/media/images/circle5.png" alt="#" /></td>
	<?php
	}
	elseif ($row->win > $row->bet*5)
	{
	?>
	<tr class="bg10 hide" name="<?php echo $row->id; ?>">
		<td width="41"><img src="/media/images/circle6.png" alt="#" /></td>
	<?php
	}
	elseif ($row->win > $row->bet)
	{
	?>
	<tr class="bg5 hide" name="<?php echo $row->id; ?>">	
		<td width="41"><img src="/media/images/circle1.png" alt="#" /></td>
	<?php
	}
	else
	{
	?>
	<tr class="bg6 hide" name="<?php echo $row->id; ?>">
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