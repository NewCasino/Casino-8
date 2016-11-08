<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<lang>
<?php 
foreach ($item as $row)
{
?>
    <item name="<?php echo $row->name; ?>" src="/lang/set/<? echo $row->name; ?>" title="<?php echo $row->title; ?>" <?php if ($current == $row->name) echo 'current="1"';?> />
<?php
}
?>
</lang>												