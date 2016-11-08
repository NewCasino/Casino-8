<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $head; ?>
<?php echo $header; ?>
     
<div id="flashcontent">
  casino
</div>

    <script type="text/javascript">
        // <![CDATA[
        var so = new SWFObject("<?php echo $game; ?>", "index", "100%", "100%", "8", "#000000");
        so.addParam("allowFullScreen", "true");
        so.write("flashcontent");
        // ]]>
    </script>

<?php echo $footer; ?>