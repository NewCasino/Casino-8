<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'login' => array
    (
        'empty' => 'Required fields',
        'error' => 'Error',        
        'absent' => 'None',
        'successfully' => 'Access granted',
        'member' => 'Log on session',
        'two_user' => 'You access closed',
    ),
    
    'forgot' => array
    (
        'absent' => 'None',
        'empty' => 'Required field',
        'successfully' => 'Send',        
        'notice' => 'Email send',
        'email' => array
        (
            'title' => 'Remind password',
            'template' => 'Your password: %s',
        ),
    ),
    
    'register' => array
    (
        'fail_login' => 'Bad login',
        'double_email' => 'Email exist',
        'double_name' => 'Name exist',
        'not_register' => 'Try register later',
        'notice' => 'Successfull registered',
        'email' => array
        (
            'title' => 'Register',
            'template' => 'Thank,<br />Your <br />login: %s<br />password: %s',
        ),
        'complete' => 'Successfull registered',
        'is_18' => 'You are under 18 years',
    ),
    
    'logout' => array
    (
        'notice' => 'Offline',
    ),
    
    'status' => array
    (
        'online' => 'Online',
        'offline' => 'Offline',
    ),
    
    'profile' => array
    (
        'notice' => 'Profile save',
        'login' => 'You are not login',
        'no_save' => 'Profile save error',
    ),
    
    'avatar' => array
    (
        'bad' => 'Avatar error',
        'successfully' => 'Avatar saved',
    ),    
    
    'password' => array
    (
        'not_change' => 'Not saved',
        'empty_new' => 'Not enter new password',
        'empty_old' => 'Not enter old password',
        'empty_retry' => 'Your not enter retry password',
        'equal' => 'Password even',
        'successfully' => 'Password successfully change',
    ),
    
    'lang' => array
    (
        'successfully' => 'Changed',
        'error' => 'Error change',
    ),
    
);