<?php defined('SYSPATH') OR die('No direct access allowed.');

$config = array
(
    'bank_part_divider' => 10,
    'min_balance' => 100,
    'chance_default_max' => 10,
    
    'limit_loop' => 40,
    'bets' => array('0' => 0.05, '1' => 0.25, '2' => 1.00, '3' => 5.00),

    //Комбинации карт
    'combos' => array
    (
        'royal_flush' => array('payout_type' => 8, 'payout' => 250),
        'straight_flush' => array('payout_type' => 7, 'payout' => 50),
        'four_of_kind' => array('payout_type' => 6, 'payout' => 20),
        'full_house' => array('payout_type' => 5, 'payout' => 7),
        'flush' => array('payout_type' => 4, 'payout' => 5),
        'straight' => array('payout_type' => 3, 'payout' => 4),
        'three_of_kind' => array('payout_type' => 2, 'payout' => 3),
        'two_pairs' => array('payout_type' => 1, 'payout' => 2),
        'jacks_or_better' => array('payout_type' => 0, 'payout' => 1),
    ),
    


    'cards_map' => array
    (
        //Червы
        0 => array('type' => 'heart', 'color' => 'red', 'weight' => 1),
        1 => array('type' => 'heart', 'color' => 'red', 'weight' => 2),
        2 => array('type' => 'heart', 'color' => 'red', 'weight' => 3),
        3 => array('type' => 'heart', 'color' => 'red', 'weight' => 4),
        4 => array('type' => 'heart', 'color' => 'red', 'weight' => 5),
        5 => array('type' => 'heart', 'color' => 'red', 'weight' => 6),
        6 => array('type' => 'heart', 'color' => 'red', 'weight' => 7),
        7 => array('type' => 'heart', 'color' => 'red', 'weight' => 8),
        8 => array('type' => 'heart', 'color' => 'red', 'weight' => 9),
        9 => array('type' => 'heart', 'color' => 'red', 'weight' => 10),
        10 => array('type' => 'heart', 'color' => 'red', 'weight' => 11),
        11 => array('type' => 'heart', 'color' => 'red', 'weight' => 12),
        12 => array('type' => 'heart', 'color' => 'red', 'weight' => 13),

        //Буби
        13 => array('type' => 'box', 'color' => 'red', 'weight' => 1),
        14 => array('type' => 'box', 'color' => 'red', 'weight' => 2),
        15 => array('type' => 'box', 'color' => 'red', 'weight' => 3),
        16 => array('type' => 'box', 'color' => 'red', 'weight' => 4),
        17 => array('type' => 'box', 'color' => 'red', 'weight' => 5),
        18 => array('type' => 'box', 'color' => 'red', 'weight' => 6),
        19 => array('type' => 'box', 'color' => 'red', 'weight' => 7),
        20 => array('type' => 'box', 'color' => 'red', 'weight' => 8),
        21 => array('type' => 'box', 'color' => 'red', 'weight' => 9),
        22 => array('type' => 'box', 'color' => 'red', 'weight' => 10),
        23 => array('type' => 'box', 'color' => 'red', 'weight' => 11),
        24 => array('type' => 'box', 'color' => 'red', 'weight' => 12),
        25 => array('type' => 'box', 'color' => 'red', 'weight' => 13),

        //Крести
        26 => array('type' => 'cross', 'color' => 'black', 'weight' => 1),
        27 => array('type' => 'cross', 'color' => 'black', 'weight' => 2),
        28 => array('type' => 'cross', 'color' => 'black', 'weight' => 3),
        29 => array('type' => 'cross', 'color' => 'black', 'weight' => 4),
        30 => array('type' => 'cross', 'color' => 'black', 'weight' => 5),
        31 => array('type' => 'cross', 'color' => 'black', 'weight' => 6),
        32 => array('type' => 'cross', 'color' => 'black', 'weight' => 7),
        33 => array('type' => 'cross', 'color' => 'black', 'weight' => 8),
        34 => array('type' => 'cross', 'color' => 'black', 'weight' => 9),
        35 => array('type' => 'cross', 'color' => 'black', 'weight' => 10),
        36 => array('type' => 'cross', 'color' => 'black', 'weight' => 11),
        37 => array('type' => 'cross', 'color' => 'black', 'weight' => 12),
        38 => array('type' => 'cross', 'color' => 'black', 'weight' => 13),

        //Пики
        39 => array('type' => 'bheart', 'color' => 'black', 'weight' => 1),
        40 => array('type' => 'bheart', 'color' => 'black', 'weight' => 2),
        41 => array('type' => 'bheart', 'color' => 'black', 'weight' => 3),
        42 => array('type' => 'bheart', 'color' => 'black', 'weight' => 4),
        43 => array('type' => 'bheart', 'color' => 'black', 'weight' => 5),
        44 => array('type' => 'bheart', 'color' => 'black', 'weight' => 6),
        45 => array('type' => 'bheart', 'color' => 'black', 'weight' => 7),
        46 => array('type' => 'bheart', 'color' => 'black', 'weight' => 8),
        47 => array('type' => 'bheart', 'color' => 'black', 'weight' => 9),
        48 => array('type' => 'bheart', 'color' => 'black', 'weight' => 10),
        49 => array('type' => 'bheart', 'color' => 'black', 'weight' => 11),
        50 => array('type' => 'bheart', 'color' => 'black', 'weight' => 12),
        51 => array('type' => 'bheart', 'color' => 'black', 'weight' => 13),
        //Джокер
        //$config['cards_map'][53] = array('type' => "joker", 'color' => FALSE, 'weight' => 14);
    ),
    
    'royal_flash' => array
    (
        '1' => array(47, 48, 49, 50, 51),
        '2' => array(34, 35, 36, 37, 38),
        '3' => array(21, 22, 23, 24, 25),
        '4' => array(8, 9, 10, 11, 12),
    ),
    
    'gauge' => array
    (
        'royal_flush' => 1,
        'straight_flush' => 2,
        'four_of_kind' => 3,
        'full_house' => 4,
        'flush' => 5,
        'straight' => 6,
        'three_of_kind' => 7,
        'two_pairs' => 8,
        'jacks_or_better' => 9,
    ),
    
);