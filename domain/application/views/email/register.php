<?php defined('SYSPATH') OR die('No direct access allowed.');

echo Kohana::lang('gamer.register.email.template',$user_info->username,$user_info->password_original);