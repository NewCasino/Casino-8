<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'error' => array
    (
        'not_isset_game_id' => 'Ошибка передачи данных',
    ),
    
    'setting' => array
    (
    	'banker_win_chance' => array
    	(
    		'title' => 'Шанс выигрыша банкира',
    		'postfix' => 'число',
    		'description' => 'Это число, вероятность того что выиграют карты банкира. От 3 выше, чем больше число, тем вероятность выигрыша меньше.',//
    	),
    	'player_win_chance' => array
    	(
    		'title' => 'Шанс выигрыша игрока',
    		'postfix' => 'число',
    		'description' => 'Это число, вероятность того что выиграют карты игрока. От 3 выше, чем больше число, тем вероятность выигрыша меньше.',
    	),
    	'tie_win_chance' => array
    	(
    		'title' => 'Шанс выпадения ничьей',
    		'postfix' => 'число',
    		'description' => 'Это число, вероятность того что будет равные очки у игрока и банкира. От 3 выше, чем больше число, тем вероятность выигрыша меньше.',
    	),
    	'bonus_chance' => array
    	(
    		'title' => 'Шанс выподения бонусной игры',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью выпадет бонусная игра. 3 - щедрый, 10 и выше - жадный, оптимальный 7 - 8.',
    	),
    	'bonus1_chance' => array
    	(
    		'title' => 'Шанс выподения 1-й бонусной игры',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью выпадет бонусная игра. 3 - щедрый, 10 и выше - жадный, оптимальный 7 - 8.',
    	),
    	'bonus2_chance' => array
    	(
    		'title' => 'Шанс выподения 2-й бонусной игры',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью выпадет бонусная игра. 3 - щедрый, 10 и выше - жадный, оптимальный 7 - 8.',
    	),
    	'coin_size' => array
    	(
    		'title' => 'Курс монеты в игре',
    		'postfix' => 'число',
    		'description' => 'Курс денег игры по отношению к валюте казино.',
    	),
    	
        'win_chance' => array
    	(
    		'title' => 'Шанс выигрыша игрока',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью выиграет игрок. 3 - щедрый, 9 и выше - жадный, оптимальный 5 - 6.',
    	),
    	'win_coins_avg' => array
    	(
    		'title' => 'Средний калибр',
    		'postfix' => '%',
    		'description' => 'Шанс выпадения среднего калибра выигрыша. Оптимально 30%',
    	),
    	'win_coins_big' => array
    	(
    		'title' => 'Большой калибр',
    		'postfix' => '%',
    		'description' => 'Шанс выпадения большого калибра выигрыша. Оптимально 9%',
    	),
    	'win_coins_small' => array
    	(
    		'title' => 'Маленький калибр',
    		'postfix' => '%',
    		'description' => 'Шанс выпадения маленького калибра выигрыша. Оптимально 60%',
    	),
    	'win_coins_super' => array
    	(
    		'title' => 'Супер большой калибр',
    		'postfix' => '%',
    		'description' => 'Шанс выпадения супер большого калибра выигрыша. С этим калибром вообще надо поокуратнее. Оптимально 1%',
    	),
    	'double_2_chance' => array
    	(
    		'title' => 'Шанс выигрыша в удвоении по цветам',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью игрок правельно угадает цвет. 3 - щедрый, 8 и выше - жадный, оптимальный 4 - 5.',
    	),
    	'double_4_chance' => array
    	(
    		'title' => 'Шанс выигрыша в удвоении по мастям',
    		'postfix' => 'число',
    		'description' => 'Показатель того, с какой вероятностью игрок правельно угадает масть. 3 - щедрый, 8 и выше - жадный, оптимальный 5 - 6.',
    	),
    	'wildchar_win_multiplication' => array
    	(
    		'title' => 'При выпадении скатера сумму умнажаем на это число',
    		'postfix' => 'x',
    		'description' => 'Бонусная сумма при скатере. Оптимально 1 - 2.',
    	),
    	'onfree_win_multiplication' => array
    	(
    		'title' => 'Умножение при выпадение скатера, в свободной игре',
    		'postfix' => 'x',
    		'description' => 'Бонусная сумма при скатере. Оптимально 1.',
    	),
    	'free_game_chance' => array
    	(
    		'title' => 'Шанс выигрыша в игре',
    		'postfix' => 'число',
    		'description' => 'Вероятность того, что игрок выиграет. 3 - щедрый, 8 и выше - жадный, оптимальный 4 - 5.',
    	),
    	'onfree_free_game_chance' => array
    	(
    		'title' => 'Шанс выпадения "свободной" игры',
    		'postfix' => 'число',
    		'description' => 'Это подобно бонусной игры. Вероятность того, что выпадет "свободная" игра. 3 - щедрый, 9 и выше - жадный, оптимально 6.',
    	),
    	'onfree_win_chance' => array
    	(
    		'title' => 'Шанс выигрыша в "свободной" игре',
    		'postfix' => 'число',
    		'description' => 'Вероятность того, что игрок выиграет в "свободной" игре. 4 - щедрый, 10 и выше - жадный, оптимальный 6 - 8.',
    	),
    	'mode' => array
    	(
    		'title' => 'Режим работы',
    		'postfix' => 'число',
    		'description' => 'Этот параметр может принимать следующие занчения:<br />
				1 - все калибры<br />
				2 - маленькие калибры<br />
				3 - маленькие и средние калибры<br />
				4 - средние и большие калибры<br />
				5 - большие калибры<br />
				6 - супер большие калибры'
    	),
    ),
    
    'banking' => array
    (
    	'game' => array
    	(
    		'title' => 'Банк игры',
    		'postfix' => '%',
    		'description' => '',
    	),
    	'profit' => array
    	(
    		'title' => 'Банк прибыли',
    		'postfix' => '%',
    		'description' => '',
    	),
    	'jackpot' => array
    	(
    		'title' => 'Банк джекпота',
    		'postfix' => '%',
    		'description' => '',
    	)
    )
    
);
/*
'currency' => 'Ru',
            'lng' => 'RU',
            'cas_log' => 'YC',
            'pop_use' => '0',
            'pop_1disp' => '30',
            'pop_nextdisp' => '60',
            'pop_url' => '',
            
            't_payouts' => 'ВЫВЕСТИ',
            't_select' => 'ВЫБРАТЬ ЛИНИИ',
            't_betlines' => 'ПАРЫ ЛИНИЙ',
            't_spin' => 'КРУТИТЬ',
            't_betmax' => 'ПАРЫ MAX.',
            't_double' => 'ДВОЙНАЯ',
            't_collect' => 'ЗАБРАТЬ',
            't_play' => 'ИГРАТЬ',
            't_cancel' => 'ОТМЕНА',
            't_back' => 'ВЕРНУТСЯ К ИГРЕ',
            't_help' => 'ПОМОЩЬ',
            't_exit' => 'ВЫХОД',
            't_rules' => 'ПРАВИЛА',
            't_info' => 'ИНФОРМАЦИЯ',
            't_bank' => 'БАНК',
            't_numlines' => 'НОМЕРА ЛИНИЙ',
            't_coinslines' => 'СТАВКА ЗА ЛИНИИ',
            't_totalbet' => 'ИТОГИ ПАР',
            't_credit' => 'ДОВЕРИЕ',
            't_winpaid' => 'ИТОГ ПОБЕДЫ',
            't_bonuswin' => 'БОНУС ПОБЕДЫ',
            't_gameover1' => 'GAME',
            't_gameover2' => 'OVER',
            't_coinvalue' => 'СТАВКА',
            't_bet' => 'ПАРА',
            't_scatterspay' => 'SCATTERS PAY',
            't_unfinished' => 'A FREE MODE WAS NOT COMPLETED',
            't_payoutsincoins' => 'PAYOUTS IN COINS',
            't_pays2x' => 'PAYS 2x',
            't_pays' => 'PAYS',
            't_choosecolor' => 'Select a color',
            't_choosesymbol' => 'Select a symbol',
            't_paylines' => 'ОПЛАЧЕНЫЕ ЛИНИИ',
            't_characters' => 'РЕПУТАЦИЯ',
            't_items' => 'ОБЪЕКТ',
            't_symbols1' => 'СИМВОЛЫ 1',
            't_symbols2' => 'СИМВОЛЫ 2',
            't_specials' => 'ОСОБЫЙ',
            't_bonusgame' => 'БОНУСНАЯ ИГРА',
            't_bonuspays' => 'Bonus pays : number of lines x number of coins x station\'s payout',
            't_doubleup' => 'ДВОЙНОЙ ПОДЪЕМ',
            't_previous' => 'ПРЕДЫДУЩИЙ',
            't_next' => 'СЛЕДУЮЩИЦ',
            't_3dices' => ' >3 DICES',
            't_4dices' => ' >4 DICES',
            't_5dices' => ' >5 DICES',
            't_any3' => 'anywhere on the screen gives 3 dices throws',
            't_any4' => 'anywhere on the screen gives 4 dices throws',
            't_any5' => 'anywhere on the screen gives 5 dices throws',
            't_rulesdouble' => 'Any winnings (Except bonus winnings) with a value of less than three times the wagers can be doubled or quadrupled.',
            't_rulesbonus' => 'After each dice throw, your pawn moves to the station corresponding to the result of the dice throw. You win the the number of coins given for this station, multiplied by the number of lines played and multiplied by the number of coins.',
            't_click' => 'Click here to go back to the game',
            't_eachline' => 'On each line, you can bet from 1 to 10 coins',
            't_replace_pint' => 'Substitutes other symbols except Scatters. Every payout where it substitutes a symbol is doubled',
            't_close' => '
*/