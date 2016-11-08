<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?
foreach ($item as $key => $value)
{
    echo "&".$key."=".$value;
}
?>