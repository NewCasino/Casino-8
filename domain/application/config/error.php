<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
    'error' => 1,
    'availability' => 1,
    'login' => 1,
    'register' => 1,
    'forgot' => 1,
    
    'gamer' => array
    (
        'successfully' => 0,
        'online' => 0,
        'offline' => 1,
    ),    
    
    'pincode' => array
    (
        'successfully' => 0,
        'empty_code' => 1,
        'exists_code' => 1,
    ),
    
    'cash' => array
    (
        'successfully' => 0,
        'not_enough' => 1,
    ),
);