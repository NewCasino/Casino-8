<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>'; 

?>
<avatar type="male">
<?php 
foreach ($item['male'] as $row) 
{
?>
    <item id="<?php echo $row->id; ?>" src="<?php echo '/media/flash/avatars/user/'.$row->src; ?>" />
<?php
}
?>
</avatar>
<avatar type="female">
<?php 
foreach ($item['female'] as $row)
{
?>
    <item id="<?php echo $row->id; ?>" src="<?php echo '/media/flash/avatars/user/'.$row->src; ?>" />
<?php
}
?>
</avatar>