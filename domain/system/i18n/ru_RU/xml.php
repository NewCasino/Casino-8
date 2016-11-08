<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(    
    'demo_cash' => array
    (
        'name' => 'demo_cash',
    	'type' => 'error',
        'title' => 'Ошибка',
        'description' => 'Данная функция не доступна в демонстрационном режиме. Пожалуйста авторизируйтесь и повторите действия.',
        'agree' => 'Авторизация',
        'deny' => 'Отмена',
        'agree_event' => 'to_login',
    	'deny_event' => 'close',
    ),
);