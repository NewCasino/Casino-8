<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = Array
(
    'username' => Array
	(
    	'required' => 'Поле имя пустое',
        'default' => 'Не верное имя',
    ),
    
	'password' => Array
    (
    	'required' => 'Поле пароль пустое',
        'default' => 'Повторный пароль не совпадает',
    ),
    
	'retype' => Array
    (
    	'required' => 'Введите повторно пароль',
	),
	
    'email'	=> Array
    (
    	'required' => 'Поле e-mail пустое',
        'email' => 'Не верный формат e-mail',
    ),
);
    