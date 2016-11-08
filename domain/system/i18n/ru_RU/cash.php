<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'login' => 'Вы не авторизированны',
    'successfully' => 'Запрос принят',
    'not_enough' => 'У вас недостаточно стредств',
    'empty_id' => 'Ошибка',
    'cansel_successfully' => 'Выплата отменена',
    'cansel_not' => 'Не возможно отменить выплату',
    'payment_add' => 'Заявка принята',
    'payment_add_error' => 'Заявка не принята',
    'empty_fields' => 'Заполните обязательные поля',
    
    'motion' => array
    (
    	'0' => 'Вывод',
    	'1' => 'Ввод',
    ),
    
    'status' => array
    (
        '1' => 'Зачислен',
        '2' => 'Ожидает выплаты',
        '3' => 'Заблокирован',
        '4' => 'Выплачено',
    ),
    
    'payment_status' => array
    (
        '1' => 'Ожидает ответа',
        '2' => 'Оплата прошла успешно',
        '3' => 'Оплата отменена',
    ),

    'payment_form' => array
    (
        '0' => array
        (
            'title' => '',
            'description' => '',
            'agree' => '',
        ),
        '1' => array
        (
            'title' => '',
            'description' => '',
            'agree' => '',
        ),
        '2' => array
        (
            'title' => 'Пополнение счета',
            'description' => 'Ваш счет успешно пополнен',
            'agree' => 'Да',
        ),
        '3' => array
        (
            'title' => 'Ошибка',
            'description' => 'Во время проведения оплаты произошла ошибка',
            'agree' => 'Да',
        ),
    ),
);