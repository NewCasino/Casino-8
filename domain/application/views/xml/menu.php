<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>
 
<menu>
<?php 
foreach ($item as $key => $value) 
{
?>
	<<?php echo $key; ?>>
<?php 	   
    foreach ($value as $row)
    {
?>      <item name="<?php echo $row->name; ?>" src="<? echo $row->src; ?>" title="<?php echo Kohana::lang('menu.'.$key.'.'.$row->name); ?>" />
<?php  
    }
?>
	</<?php echo $key; ?>>
<?php    
}
?>
</menu>