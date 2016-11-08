<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = Array
(
    'username' => Array
	(
    	'required' => 'Введите логин',
        'default' => 'Логин может содержать тока латинские буквы и цифры',
    ),
    
	'password' => Array
    (
    	'required' => 'Введите пароль',
        'default' => 'Пароли не совпадает',
    ),
    
	'retype' => Array
    (
    	'required' => 'Введите повторно пароль',
	),
	
    'email'	=> Array
    (
    	'required' => 'Введите E-mail',
        'email' => 'Введите E-mail правильно',
    ),
);
    