<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>'; 

?>
<currency>
<?php
foreach ($item as $row) 
{
?>
    <item name="<?php echo $row->src; ?>" title="<?php echo $row->title; ?>" src="<?php echo '/cash/payment/'.$row->src; ?>" />
<?php
}
?>
</currency>