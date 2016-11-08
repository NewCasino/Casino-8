<?php defined('SYSPATH') OR die('No direct access allowed.');

if (isset($item) AND $item)
{
    echo array_xml::to_xml($item, $root);
}