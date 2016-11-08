<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<?php 
foreach ($item as $key => $value) 
{                                                  
?>
<categories id="<?echo $value->id;?>" name="<?echo $value->name;?>" title="<?php echo Kohana::lang('category.menu.'.$value->name); ?>" avatar="/media/flash/avatars/categories/<?php echo $value->avatar_src;?>" event="/event/categories/<?php echo $value->title; ?>">
    <?
    foreach ($value->games as $k => $v)
    {
    ?>
        <item name="<?php echo $v->media_name;?>" title="<?php echo $v->title;?>" src="/<?php echo $v->media_name;?>.swf" avatar="/media/flash/games/<?php echo $v->media_name;?>/icon.swf" />
    <?php
    }
    ?>
</categories>
<?php
}                   
?>