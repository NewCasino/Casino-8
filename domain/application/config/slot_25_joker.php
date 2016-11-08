<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
    'bank_part_devider_game' => 9,
    'bank_part_devider_bonus' => 12,
    'bank_part_divider' => 10,
    'avg_win' => 100,
    'avg_bet' => 18,
    'wild_char' => 1,
    'icon_scatter_max' => 5,
    'icon_scatter_min_bonus' => 2,
    'repeat_max_count' => 200,
    
    'bonus2_win_config' => array
    (
        1 => 2,
        2 => 4,
        3 => 5,
        4 => 8,
        5 => 10
    ),
    
    'wheel_size' => array
    (
        'min' => 30,
        'max' => 50,
    ),

    'error' => array
    (
        'off' => '0',
        'on' => '1',
        'two' => '2',
    ),
    
    'session_jeu' => '69225457',
    'icons_count' => 41,
    'icons' => array
    (
        'A','A','A', 
        'B','B','B', 
        'C','C','C', 
        'G','G','G', 
        'D','D','D', 
        'G','G','G', 
        'E','E','E', 
        'F','F','F', 
        'G','G','G', 
        'H','H','H', 
        'I','I','I', 
        'J','J','J', 
        'K','K','K', 
        'L','L','L',
    ),    
    
    'chance_to_count_lines' => array
    (
        1 => 4,
        2 => 4,
        3 => 4,
        4 => 4,
        5 => 4,
        6 => 3,
        7 => 3,
        8 => 3,
        9 => 3,
        10 => 3,
        11 => 2,
        12 => 2,
        13 => 2,
        14 => 2,
        15 => 2,
        16 => 1,
        17 => 1,
        18 => 1,
        19 => 1,
        20 => 1,
        21 => 0,
        22 => 0,
        23 => 0,
        24 => 0,
        25 => 0,
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
        1 =>  array(2, 5, 8, 11, 14),
        2 =>  array(1, 4, 7, 10, 13),
        3 =>  array(3, 6, 9, 12, 15),
        4 =>  array(1, 5, 9, 11, 13),
        5 =>  array(3, 5, 7, 11, 15),
        6 =>  array(1, 4, 8, 10, 13),
        7 =>  array(3, 6, 8, 12, 15),
        8 =>  array(2, 4, 7, 10, 14),
        9 =>  array(2, 6, 9, 12, 14),
        10 =>  array(1, 4, 7, 11, 15),
        11 =>  array(3, 6, 9, 11, 13),
        12 =>  array(1, 5, 9, 12, 15),
        13 =>  array(3, 5, 7, 10, 13),
        14 =>  array(2, 4, 8, 10, 14),
        15 =>  array(2, 6, 8, 12, 14),
        16 =>  array(1, 4, 8, 12, 15),
        17 =>  array(3, 6, 8, 10, 13),
        18 =>  array(1, 5, 8, 11, 13),
        19 =>  array(3, 5, 8, 11, 15),
        20 =>  array(1, 6, 7, 12, 13),
        21 =>  array(3, 4, 9, 10, 15),
        22 =>  array(1, 4, 9, 10, 13),
        23 =>  array(3, 6, 7, 12, 15),
        24 =>  array(1, 6, 9, 12, 13),
        25 =>  array(3, 4, 7, 10, 15),
    ),
    
    'on_line_wins_config' => array
    (
        'I' => array(5 => 100, 4 => 25, 3 => 5),
        'J' => array(5 => 100, 4 => 25, 3 => 5),
        'K' => array(5 => 100, 4 => 25, 3 => 5),
        'L' => array(5 => 100, 4 => 25, 3 => 5),
        'E' => array(5 => 250, 4 => 75, 3 => 20, 2 => 2),
        'F' => array(5 => 250, 4 => 75, 3 => 20, 2 => 2),
        'C' => array(5 => 500, 4 => 100,3 => 40, 2 => 5),
        'D' => array(5 => 500, 4 => 100,3 => 40, 2 => 5),
        'B' => array(5 => 5000,4 => 500,3 => 75, 2 => 10),
    ),
    
    'bonus1_char' => 'G',
    'bonus2_char' => 'H',
    'joker_char' => 'A',
    'joker_replace' => array('B', 'C', 'D', 'E', 'F'),
    
    
    'scatter_char'  => 12,
    'scatter_free_game' => array(3 => 15, 4 => 20, 5 => 25),
    'scatter_wins'  => array(2 => 2, 3 => 5, 4 => 10, 5 => 100),


    'bonus1_map' => array(1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 5),
);