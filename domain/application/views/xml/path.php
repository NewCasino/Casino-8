<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>

<path>
    <item name="loader" src="/media/flash/template/<?php echo $template_name; ?>/loader.swf" />
    <item name="background" src="/media/flash/template/<?php echo $template_name; ?>/background.swf" />
    <item name="content" src="/media/flash/template/<?php echo $template_name; ?>/content.swf" />
    <item name="logo" src="/media/flash/template/<?php echo $template_name; ?>/logo.swf" />
    <item name="jackpot" src="/media/flash/template/<?php echo $template_name; ?>/jackpot.swf" />
    <item name="logo_url" src="<?php echo (isset($url_logo))? $url_logo: '#'; ?>" />
    <item name="load_button" src="<?php echo (isset($url_logo))? $url_logo: '#'; ?>"/>
</path>