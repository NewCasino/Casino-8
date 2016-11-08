<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'init' => array
    (
        'currency' => '',
        'lng' => 'EN',
        'cas_log' => 'YC',
        'pop_use' => '0',
        'pop_1disp' => '30',
        'pop_nextdisp' => '60',
        'pop_url' => '',
        'rules' => Kohana::config('urls.root'),
        'help' => Kohana::config('urls.root'),
        'bank' => Kohana::config('urls.root'),
        'casino' => Kohana::config('urls.root'),
        't_payouts' => 'PAYOUTS',
        't_select' => 'SELECT LINES',
        't_betlines' => 'BET PER LINE',
        't_spin' => 'SPIN',
        't_betmax' => 'BET MAX.',
        't_autoplay' => 'AUTO PLAY',
        't_stop' => 'STOP',
        't_help' => 'HELP',
        't_exit' => 'EXIT',
        't_rules' => 'RULES',
        't_info' => 'INFO',
        't_bank' => 'BANK',
        't_numlines' => 'NUMBER OF LINES',
        't_coinslines' => 'COINS PER LINE',
        't_totalbet' => 'TOTAL BET',
        't_credit' => 'CREDIT',
        't_winpaid' => 'WINPAID',
        't_gameover1' => 'GAME',
        't_gameover2' => 'OVER',
        't_coinvalue' => 'COIN VALUE',
        't_bet' => 'BET',
        't_scatterspay' => 'SCATTERS PAY',
        't_unfinished' => 'A FREE MODE WAS NOT COMPLETED',
        't_freeplayed' => 'FREE GAMES PLAYED',
        't_freetoplay' => 'FREE GAMES LEFT',
        't_payoutsincoins' => 'PAYOUTS IN COINS',
        't_15freegames' => '15 FREE GAMES',
        't_20freegames' => '20 FREE GAMES',
        't_25freegames' => '25 FREE GAMES',
        't_scatterpays' => 'Scatter pays anywhere on the screen',
        
        't_replace' => 'Mona Lisa substitute other symbols except Scatters',
        't_replace_james' => 'The symbol James substitutes other symbols except Scatters',
        't_replace_jv' => 'The symbol Jules Verne substitutes other symbols except Scatters',
        't_replace_heroe' => 'The symbol SuperHeroe substitute other symbols except Scatters',
        't_replace_cat' => 'The symbol Cat ABCDEF substitute other symbols except Scatters',
        't_replace_referee' => 'The symbol Referee substitute other symbols except Scatters',
        't_replace_guns' => 'The symbol Lasers substitute other symbols except Scatters',
        't_replace_invaders' => 'The symbol Invaders substitute other symbols except Scatters',
        't_replace_peacock' => 'The symbol peacock substitute other symbols except ScattersThe symbol King substitute other symbols except Scatters',
        't_replace_king' => 'The symbol King substitute other symbols except Scatters',
        't_replace_snow' => 'The symbol SnowFlake substitute other symbols except Scatters',
        
        't_alert1' => 'Not enough cash, please top up your balance.',
        't_alert2' => 'Please login.',
        't_alert3' => 'Inner error serevr',
        't_jackpotwon' => 'Inner error serevr',
        't_close' => 'Close',
    ),
    
    'wild_icon_win_multiplication' => array
    (
        0 => array
        (
            't_pays2x' => 'PAYS 3x',
            't_doubled' => 'Every payout where Mona Lisa substitute a symbol is multiply by %s',
            't_doubled_james' => 'Every payout where the symbol James substitutes a symbol is multiply by %s',
            't_doubled_jv' => 'Every payout where the symbol Jules Verne substitutes a symbol is multiply by %s',
            't_doubled_heroe' => 'Every payout where the symbol SuperHeroe substitute a symbol is multiply by %s',
            't_doubled_cat' => 'Every payout where the symbol Cat ABCDEF substitute a symbol is multiply by %s',
            't_doubled_referee' => 'Every payout where the symbol Referee substitute a symbol is multiply by %s',
            't_doubled_guns' => 'Every payout where the symbol Lasers substitute a symbol is multiply by %s',
            't_doubled_guns' => 'Every payout where the symbol Invaders substitute a symbol is multiply by %s',
            't_doubled_peacock' => 'Every payout where the symbol peacock substitute a symbol is multiply by %s',
            't_doubled_king' => 'Every payout where the symbol King substitute a symbol is multiply by %s',
            't_doubled_snow' => 'Every payout where the symbol SnowFlake substitutes a symbol is multiply by %s',
        ),
        
        1 => array
        (
            't_pays2x' => '',
            't_doubled' => '',
            't_doubled_james' => '',
            't_doubled_jv' => '',
            't_doubled_heroe' => '',
            't_doubled_cat' => '',
            't_doubled_referee' => '',
            't_doubled_guns' => '',
            't_doubled_guns' => '',
            't_doubled_peacock' => '',
            't_doubled_king' => '',
            't_doubled_snow' => '',
        ),
        
        2 => array
        (
            't_pays2x' => 'PAYS 2x',
            't_doubled' => 'Every payout where Mona Lisa substitute a symbol is doubled',
            't_doubled_james' => 'Every payout where the symbol James substitutes a symbol is doubled',
            't_doubled_jv' => 'Every payout where the symbol Jules Verne substitutes a symbol is doubled',
            't_doubled_heroe' => 'Every payout where the symbol SuperHeroe substitute a symbol is doubled',
            't_doubled_cat' => 'Every payout where the symbol Cat ABCDEF substitute a symbol is doubled',
            't_doubled_referee' => 'Every payout where the symbol Referee substitute a symbol is doubled',
            't_doubled_guns' => 'Every payout where the symbol Lasers substitute a symbol is doubled',
            't_doubled_guns' => 'Every payout where the symbol Invaders substitute a symbol is doubled',
            't_doubled_peacock' => 'Every payout where the symbol peacock substitute a symbol is doubled',
            't_doubled_king' => 'Every payout where the symbol King substitute a symbol is doubled',
            't_doubled_snow' => 'Every payout where the symbol SnowFlake substitutes a symbol is doubled',
        ),
        
        3 => array
        (
            't_pays2x' => 'PAYS 3x',
            't_doubled' => 'Every payout where Mona Lisa substitute a symbol is tripled',
            't_doubled_james' => 'Every payout where the symbol James substitutes a symbol is tripled',
            't_doubled_jv' => 'Every payout where the symbol Jules Verne substitutes a symbol is tripled',
            't_doubled_heroe' => 'Every payout where the symbol SuperHeroe substitute a symbol is tripled',
            't_doubled_cat' => 'Every payout where the symbol Cat ABCDEF substitute a symbol is tripled',
            't_doubled_referee' => 'Every payout where the symbol Referee substitute a symbol is tripled',
            't_doubled_guns' => 'Every payout where the symbol Lasers substitute a symbol is tripled',
            't_doubled_guns' => 'Every payout where the symbol Invaders substitute a symbol is tripled',
            't_doubled_peacock' => 'Every payout where the symbol peacock substitute a symbol is tripled',
            't_doubled_king' => 'Every payout where the symbol King substitute a symbol is tripled',
            't_doubled_snow' => 'Every payout where the symbol SnowFlake substitutes a symbol is tripled',
        ),
    ),
    
    'onfree_win_multiplication' => array
    (
        0 => 'In free mode, all payouts are multiply by %s',
        1 => 'In free mode',
        2 => 'In free mode, all payouts are doubled',
        3 => 'In free mode, all payouts are tripled',
    ),
    
    'error' => array
    (
        'not_isset_game_id' => 'Game no isset.',
    ),
    
    
    'init_error' => array
    (
        't_alert_inner' => 'Inner error',
        't_alert2' => 'Inner error',
        't_alert3' => 'Error server',
    ),
    
    
    
    'init_message' => array
    (
        'pop_var1' => 'Do you want to play for real money?',
        'pop_var2' => 'Yes',
        'pop_var3' => 'No',
        'pop_var4' => '',
        'pop_var' => '',
        't_alert1' => 'Few cash, please top up your balance',
        't_alert2' => 'Please login',
        't_alert3' => 'Please game in one window',
    ),
    
);
