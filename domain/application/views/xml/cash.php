<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

foreach ($item as $key => $value) 
{
?>
    <<?php echo $key; ?>><?php echo $value; ?></<?php echo $key; ?>>
<?php
}
?>