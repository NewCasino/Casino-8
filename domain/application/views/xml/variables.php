<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<?php
foreach ($item as $key => $value) 
{                                                  
?>
<<?php echo $key; ?>>
    <?
    foreach ($value as $k => $v)
    {
    ?>
        <item name ="<?php echo $k;?>" title = "<?php printf($v, $currncy);?>"/>
    <?php
    }
    ?>
</<?php echo $key; ?>>
<?php
}                   
?>