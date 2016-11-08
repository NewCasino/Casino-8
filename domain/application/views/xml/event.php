<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<event> 
    <gamer>
        <item name="login" src="/gamer/login" />
        <item name="register" src="/gamer/register" />
        <item name="forgot" src="/gamer/forgot" />
        <item name="logout" src="/gamer/logout" />
        <item name="status" event="/gamer/status" />
        <item name="fullscreen" event="/event/iface/fullscreen" />
        <item name="profile" src="/gamer/profile" />
    </gamer>
    <player> 
        <item name="play" event="/event/player/play" /> 
        <item name="pause" event="/event/player/pause" /> 
        <item name="next" event="/event/player/next" />
        <item name="prev" event="/event/player/prev" />
        <item name="volume" event="/event/player/volume" />
    </player>
    <cash>
        <item name="in" src="/pincode/in" />
        <item name="out" src="/cash/out" />
        <item name="cancel" src="/cash/cancel" />
    </cash>
</event>