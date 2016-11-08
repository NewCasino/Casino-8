<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Sitex pagination style
 * 
 * @preview « Пред 2 - 5 из 49 След »
 */
?>

<?php if ($previous_page): ?>
	<a href="<?php echo str_replace('{page}', $previous_page, $url) ?>">&laquo;&nbsp;<?php echo Kohana::lang('pagination.previous') ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php else: ?>
	<font>&laquo;&nbsp;<?php echo Kohana::lang('pagination.previous') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
<?php endif ?> 

<?php if ($total_items): ?>
    <?php echo $current_page * $items_per_page - $items_per_page + 1 ?>
<?php else: ?>
    0
<?php endif; ?> 
<?php echo Kohana::lang('pagination.-') ?>
<?php if ($next_page): ?>
	<?php echo $current_page * $items_per_page ?>
<?php else: ?>
	<?php echo $total_items ?>
<?php endif; ?>  
<?php echo Kohana::lang('pagination.of') ?> 
<?php echo $total_items ?>

<?php if ($next_page): ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo str_replace('{page}', $next_page, $url) ?>"><?php echo Kohana::lang('pagination.next') ?>&nbsp;&raquo;</a>
<?php else: ?>
	<font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo Kohana::lang('pagination.next') ?>&nbsp;&raquo;</font>	
<?php endif ?>