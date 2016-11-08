<?php defined('SYSPATH') OR die('No direct access allowed.'); 

echo '<?xml version="1.0" encoding="utf-8"?>'; 

?>

<jackpot interval="<?php
if (isset($item->interval))
{
    echo $item->interval;
}
?>" value="<?php
if (isset($item->value))
{
    echo $item->value;
}
?>" />
