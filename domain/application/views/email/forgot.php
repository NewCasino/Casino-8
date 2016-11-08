<?php defined('SYSPATH') OR die('No direct access allowed.');

echo Kohana::lang('gamer.forgot.email.template', $user_info->password_original);