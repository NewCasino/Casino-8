<?php defined('SYSPATH') OR die('No direct access allowed.');

$exist_key = array
(
    '_first_',
    'BALANCE',
    'credit',
    'coinsize',
    'nb_coins',
    'betamount',
    'total_win_money',
    'money_win_total',
    'nb_coins_win_total',
    'scatter_win',
    'bonus2_result',
    'bonus2_win_coins',
    'bonus2_win_money',
    'bonus2_winning_comment',
    'bonus1_win_coins',
    'bonus1_win_money',
    'bonus1_winning_comment',
);

foreach ($item as $key => $value)
{
	if (in_array($key, $exist_key))
    {
        $value = str_replace(',', '.', $value);
    }
    
    echo "&".$key."=".$value;
}