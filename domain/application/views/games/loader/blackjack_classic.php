<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <script type="text/javascript" src="/media/js/flashobject.js"></script>
</head>

<body bgcolor="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="flashdemo" style="background-color:#000000">
    <object classid="application/x-shockwave-flash" data="/cabs/flash/swflash.cab#version=6,0,29,0" width="100%" height="100%" align="middle">
        <param name="movie" value="game.swf?gameid=4051&lang=EN">
        <param name="quality" value="high" />
        <param name="wmode" value="transparent" />
    </object> 
</div>
    
<script type="text/javascript">
   var fo = new FlashObject("black_jack_classic.swf?gameid=4051&lang=EN", "", "100%", "100%", "7", "");
   fo.addParam("wmode", "transparent");
   fo.addParam("quality", "high")
   fo.addParam("menu", "false")
   fo.write("flashdemo");
</script>



</body>
</html>