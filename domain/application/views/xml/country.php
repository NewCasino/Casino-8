<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>'; 

?>
<country>
<?php 
foreach ($item as $key => $value) 
{
?>
    <item name="<?php echo $key; ?>" value="<?php echo $value; ?>" />
<?php
}
?>
</country>