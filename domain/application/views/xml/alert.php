<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>
<message name="<?php echo $alert['name'];?>" type="<?php echo $alert['type'];?>"> 
    <item title="<?php echo $alert['title'];?>" description="<?php echo $alert['description'];?>" agree="<?php echo $alert['agree'];?>" deny="<?php echo $alert['deny'];?>" agree_event="<?php echo $alert['agree_event'];?>" deny_event="<?php echo $alert['deny_event'];?>" />
</message>