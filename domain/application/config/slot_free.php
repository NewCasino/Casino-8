<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
    'error' => array
    (
        'off' => '0',
        'on' => '1',
        'two' => '2',
    ),
    
    'wheel_size' => 50,
    'min_icon' => 1,
    'max_icon' => 12,
    'repeat_max_count' => 200,
    
    'max_symb' => 15,
    
    'mode_free' => 0,
    'nb_gratuit_to_play' => '',
    'nb_gratuit_played' => '',
    
    'avg_win' => 100,
    'avg_bet' => 18,
    'bank_part_divider' => 10,
    
    
    
    'chance_to_count_lines' => array
    (
        1 => 4,
        2 => 3,
        3 => 3,
        4 => 2,
        5 => 2,
        6 => 1,
        7 => 1,
        8 => 0,
        9 => 0,
    ),
    
    'gauge_to_bet_coins' => array
    (
        1 => 1,
        2 => 1.2,
        3 => 1.3,
        4 => 1.4,
        5 => 1.5,
        6 => 1.6,
        7 => 1.7,
        8 => 1.8,
        9 => 1.9,
        10 => 2,
    ),
    
    'gauge' => array
    (
        'zero' => 0,
        'win_coins_small' => 1,
        'win_coins_avg' => 2,
        'win_coins_big' => 3,
        'win_coins_super' => 4,
    ),
    
    'lines_config' => array
    (
        array(1, 4, 7, 10, 13),//1
        array(0, 3, 6, 9,  12),//2
        array(2, 5, 8, 11, 14),//3
        array(0, 4, 8, 10, 12),//4
        array(2, 4, 6, 10, 14),//5
        array(0, 3, 7, 9,  12),//6
        array(2, 5, 7, 11, 14),//7
        array(1, 3, 6, 9,  13),//8
        array(1, 5, 8, 11, 13),//9
    ),
    'wild_char' => 1,
    'on_line_wins_config' => array
    (
        1 => array(2 => 15, 3 => 100,4 => 500, 5 => 2500),//special 1 (Super icon - baraban)
        2 => array(2 => 2,  3 => 20, 4 => 100, 5 => 800),//4 icon 4 (cashier)
        3 => array(2 => 2,  3 => 20, 4 => 100, 5 => 400),//4 icon 3 (vrashaet ruletku)
        4 => array(3 => 15, 4 => 50, 5 => 100),//6 icon MGM
        5 => array(3 => 15, 4 => 50, 5 => 100),//6 icon Hamingo
        6 => array(3 => 10, 4 => 25, 5 => 100),//6 icon New Yourk
        7 => array(3 => 5,  4 => 20, 5 => 100),//6 icon 3 Stardust
        8 => array(3 => 5,  4 => 20, 5 => 100),//6 icon 2
        9 => array(3 => 5,  4 => 20, 5 => 100),//6 icon 1
        10 => array(2 => 2, 3 => 5,  4 => 20, 5 => 100),//4 icon 2 (konference)
        11 => array(2 => 2, 3 => 5,  4 => 20, 5 => 100),//4 icon 1 (telka)
    ),
    
    'icon_scatter_max' => 5,
    'icon_scatter_min_bonus' => 2,
    
    'scatter_char'  => 12,
    'scatter_free_game' => array(3 => 15, 4 => 20, 5 => 25),
    'scatter_wins'  => array(2 => 2, 3 => 5, 4 => 10, 5 => 100),


);