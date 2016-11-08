<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * @package  Core
 *
 * Sets the default route to "welcome"
 */
$config['_default'] = 'finance/cashin';

/* user */
$config['login'] = 'base/auth/login';
$config['logout'] = 'base/auth/logout';
$config['register'] = 'base/auth/register';
$config['forgot'] = 'base/auth/forgot';