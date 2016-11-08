<?php defined('SYSPATH') OR die('No direct access allowed.');

echo '<?xml version="1.0" encoding="utf-8"?>';

?>
<error><?php echo $error;?></error>
<message type="<?php echo Kohana::config('cash.type.'.$status);?>">
    <item title="<?php echo Kohana::lang('cash.payment_form.'.$status.'.title');?>" description="<?php echo Kohana::lang('cash.payment_form.'.$status.'.description');?>" agree="<?php echo Kohana::lang('cash.payment_form.'.$status.'.agree');?>" agree_event = "close" deny_event = "" />
</message>