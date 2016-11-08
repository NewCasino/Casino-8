<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<news title="<?php echo Kohana::lang('news.title'); ?>">
<?php 
foreach ($item as $row)
{
?>
    <item date="<?php echo date('d.m.y', $row->date); ?>" title="<?php echo $row->title?>"><?php echo $row->body; ?></item>
<?php
}
?>
</news>
		
		