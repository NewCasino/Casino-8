<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>'; 

?>
<player>
<?php
foreach ($item as $row) 
{
?>
    <item artist="<?php echo $row->artist;?>" track="<?php echo $row->track;?>" src="/media/mp3/<?php echo $row->file;?>" />
<?php
}
?>
</player>