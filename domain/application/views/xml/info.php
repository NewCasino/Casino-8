<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>
<gamer>
<?php
if (isset($item['info']))
{
    foreach ($item['info'] as $key => $value)
    {
    ?>
        <<? echo $key;?>>
            <?
            foreach ($value as $k => $v)
            {
            ?>
                <item name="<?php echo $k;?>" value="<?php echo $v;?>" />
            <?php
            }
            ?>
        </<? echo $key;?>>
    <?php
    }
}
?>
<games>
<?php
if (isset($item['game']))
{
    foreach ($item['game'] as $key => $value)
    {
    ?>
        <item categories_name="<?php echo $value->name_category?>" name="<?php echo $value->game_name?>" title="<?php echo $value->game_title?>" avatar="/media/flash/games/<?php echo $value->media_name;?>/icon.swf" src="/media/flash/games/<?php echo $value->media_name;?>/game.swf" id="<?php echo $value->id; ?>" />
    <?php
    }
}
?>
</games>
<payment_history>
<?php
if (isset($item['pay']))
{
    foreach ($item['pay'] as $key => $value)
    {
    ?>
        <item type="<?php echo $value->type;?>" title="<?php echo Kohana::lang('cash.motion.'.$value->type);?>" amount="<?php echo $value->amount;?>" date="<?php echo date('H:i d.m.Y',$value->datetime);?>" status="<?php echo $value->status;?>" message="<?php echo Kohana::lang('cash.status.'.$value->status);?>" id="<?php echo $value->id;?>" />
    <?php
    }
}
?>
</payment_history>
</gamer>