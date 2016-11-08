<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(

//Переменные по мерчанту
    'status' => array
    (
        '1' => 'send',
        '2' => 'payment_success',
        '3' => 'payment_fail',
    ),
    
    'type' => array
    (
        '0' => 'error',
        '1' => 'wait',
        '2' => 'cashIn',
        '3' => 'error',
    ),
    
);