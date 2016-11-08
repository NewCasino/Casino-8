<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'login' => 'You are not authorized',
    'successfully' => 'Accepted',
    'not_enough' => 'You do not have enough money',
    'empty_id' => 'Error',
    'cansel_successfully' => 'Payment canceled',
    'cansel_not' => 'Not possible to cancel the payment',
    'payment_add' => 'Accepted',
    'payment_add_error' => 'Not accepted',
    'empty_fields' => 'Required fields',
    
    'motion' => array
    (
    	'0' => 'Out',
    	'1' => 'In',
    ),
    
    'status' => array
    (
        '1' => 'Accepted',
        '2' => 'Pending payment',
        '3' => 'Blocked',
        '4' => 'Paid',
    ),
        
    'payment_status' => array
    (
        '1' => 'Awaiting response',
        '2' => 'Payment successful',
        '3' => 'Payment canceled',
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
            'title' => 'Deposit balance',
            'description' => 'Your balance successfully recharged',
            'agree' => 'Ok',
        ),
        '3' => array
        (
            'title' => 'Error',
            'description' => 'At the time of payment was an error',
            'agree' => 'Ok',
        ),
    ),
);