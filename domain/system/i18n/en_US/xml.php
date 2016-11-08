<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(    
    'demo_cash' => array
    (
        'name' => 'demo_cash',
    	'type' => 'error',
        'title' => 'Error',
        'description' => 'Checkout is not available in demo mode. Please login and try again.',
        'agree' => 'Enter',
        'deny' => 'Cancel',
        'agree_event' => 'to_login',
    	'deny_event' => 'close',
    ),
);