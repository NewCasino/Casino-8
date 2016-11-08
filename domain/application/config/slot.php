<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
    'average_bet' => 18,
    'max_icon' => 12,
    'min_icon' => 1,
    'chance_default_max' => 9,
    'dice_max' => 6,
    'dice_min' => 1,
    'avg_bonus_dice_win' => 50,
    'bank_part_divider' => 10,
    'bank_part_divider_bonus' => 12,
    'repeat_max_count' => 200,
    
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

    'bank_procent' => array
    (
        'profit' => 10,
        'game' => 90,
    ),
    
    'wheel_size' => array
    (
        'min' => 30,
        'max' => 50,
    ),

    'icon_scatter_max' => 5,
    'icon_scatter_min_bonus' => 2,

    'gauge' => array
    (
        'zero' => 0,
        'win_coins_small' => 1,
        'win_coins_avg' => 2,
        'win_coins_big' => 3,
        'win_coins_super' => 4,
    ),
    
    'error' => array
    (
        'on' => '1',
        'off' => '0',
        'two' => '2',
    ),
    
    'bonus' => array
    (
        'on' => '1',
        'off' => '0',
    ),    
    
    'rebuild' => array
    (
        'on' => '1',
        'off' => '0',
    ),
    
    'init' => array
    (
        //'min_icon' => 1,
        //'max_icon' => 12,
        'double_bet_2_black' => 2,//not
        'double_bet_2_red' => 1,//not
        'double_bet_4_heart' => 3,//not
        'double_bet_4_cross' => 1,//not
        'double_bet_4_box' => 2,//not
        'double_bet_4_spade' => 4,//not
        'card_id_min' => 2,//not
        'card_id_max' => 53,//not
        //'chance_default_max' => 12,
        //'chance_default_level' => 7,
        'average_win' => 100,//not
        'average_bet' => 18,//not
        //'delitel' => 100,
        //'avarage_bonus_dice_win' => 50,
        //'dice_min' => 1,
        //'dice_max' => 6,
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
    
    'gauge_number' => array//2 - small| 5 - avg| 10 - big| ? - super
    (
        1 => array(1,  10),//min - 20
        2 => array(10, 20),//min - 40
        3 => array(21, 30),//min - 60
        4 => array(31, 40),//min - 80
        5 => array(41, 50),//min - 100
        6 => array(51, 60),//min - 120
        7 => array(61, 70),//min - 140
        8 => array(71, 80),//min - 160
        9 => array(81, 90),//min - 180
        10 => array(91, 100),//min - 200
        11 => array(101, 110),//min - 220
        12 => array(111, 120),//min - 240
        13 => array(121, 130),//min - 260
        14 => array(131, 140),//min - 280
        15 => array(141, 150),//min - 300
        16 => array(151, 160),//min - 320
        17 => array(161, 170),//min - 340
        18 => array(171, 180),//min - 360
        19 => array(181, 190),//min - 380
        20 => array(191, 200),//min - 400
        21 => array(201, 210),//min - 420
        22 => array(211, 225),//min - 450
    ),
    
    'scatter_char'  => 12,
    'scatter_dices' => array(3 => 3, 4 => 4, 5 => 5),
    'scatter_wins'  => array(2 => 2, 3 => 5, 4 => 10, 5 => 100),
    'cards' => array
    (
        array('id' => 2, 'type' => 1, 'color' => 2),
        array('id' => 3, 'type' => 1, 'color' => 2),
        array('id' => 4, 'type' => 1, 'color' => 2),
        array('id' => 5, 'type' => 1, 'color' => 2),
        array('id' => 6, 'type' => 1, 'color' => 2),
        array('id' => 7, 'type' => 1, 'color' => 2),
        array('id' => 8, 'type' => 1, 'color' => 2),
        array('id' => 9, 'type' => 1, 'color' => 2),
        array('id' => 10, 'type' => 1, 'color' => 2),
        array('id' => 11, 'type' => 1, 'color' => 2),
        array('id' => 12, 'type' => 1, 'color' => 2),
        array('id' => 13, 'type' => 1, 'color' => 2),
        array('id' => 14, 'type' => 1, 'color' => 2),
        array('id' => 15, 'type' => 2, 'color' => 1),
        array('id' => 16, 'type' => 2, 'color' => 1),
        array('id' => 17, 'type' => 2, 'color' => 1),
        array('id' => 18, 'type' => 2, 'color' => 1),
        array('id' => 19, 'type' => 2, 'color' => 1),
        array('id' => 20, 'type' => 2, 'color' => 1),
        array('id' => 21, 'type' => 2, 'color' => 1),
        array('id' => 22, 'type' => 2, 'color' => 1),
        array('id' => 23, 'type' => 2, 'color' => 1),
        array('id' => 24, 'type' => 2, 'color' => 1),
        array('id' => 25, 'type' => 2, 'color' => 1),
        array('id' => 26, 'type' => 2, 'color' => 1),
        array('id' => 27, 'type' => 2, 'color' => 1),
        array('id' => 28, 'type' => 3, 'color' => 1),
        array('id' => 28, 'type' => 3, 'color' => 1),
        array('id' => 29, 'type' => 3, 'color' => 1),
        array('id' => 30, 'type' => 3, 'color' => 1),
        array('id' => 31, 'type' => 3, 'color' => 1),
        array('id' => 32, 'type' => 3, 'color' => 1),
        array('id' => 33, 'type' => 3, 'color' => 1),
        array('id' => 34, 'type' => 3, 'color' => 1),
        array('id' => 35, 'type' => 3, 'color' => 1),
        array('id' => 36, 'type' => 3, 'color' => 1),
        array('id' => 37, 'type' => 3, 'color' => 1),
        array('id' => 38, 'type' => 3, 'color' => 1),
        array('id' => 39, 'type' => 3, 'color' => 1),
        array('id' => 40, 'type' => 3, 'color' => 1),
        array('id' => 41, 'type' => 4, 'color' => 2),
        array('id' => 42, 'type' => 4, 'color' => 2),
        array('id' => 43, 'type' => 4, 'color' => 2),
        array('id' => 44, 'type' => 4, 'color' => 2),
        array('id' => 45, 'type' => 4, 'color' => 2),
        array('id' => 46, 'type' => 4, 'color' => 2),
        array('id' => 47, 'type' => 4, 'color' => 2),
        array('id' => 48, 'type' => 4, 'color' => 2),
        array('id' => 49, 'type' => 4, 'color' => 2),
        array('id' => 50, 'type' => 4, 'color' => 2),
        array('id' => 51, 'type' => 4, 'color' => 2),
        array('id' => 52, 'type' => 4, 'color' => 2),
        array('id' => 53, 'type' => 4, 'color' => 2),
    ),
    
    'bonus_map' => array
    (
        0 => 0,
        1 => 250,
        2 => 100,
        3 => 10,
        4 => 25,                  
        5 => 5,
        6 => 50,
        7 => 20,
        8 => 100,
        9 => 35,
        10 => 75,
        11 => 150,
        12 => 0,
        13 => 50,
        14 => 25,
        15 => 5,
        16 => 5,
        17 => 10,
        18 => 5,
        19 => 75,
        20 => 250,
        21 => 50,
        22 => 20,
        23 => 100,
        24 => 75,
        25 => 200,
        26 => 125,
        27 => 250,
        28 => 75,
        29 => 500,
        30 => 2500,
    ),
);