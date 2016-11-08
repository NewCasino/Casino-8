<?php defined('SYSPATH') OR die('No direct access allowed.');
/*
*       Status:
* 1 - показатель окончания игры (в сочетании с 3)
* 2 - управлением наличия кнопок
* 3 - показатель окончания игры (в сочетании с 1)
* 4 - ничего не заметил (при окончании игры, выдает что у диллера Black Jack)
* 5 - затемняем карты (0 - не затемняем/ 1 и выше - затемняем)
* 


'0|1|0|0|0|0' - ждем выбора (кнопка "Карту")
'0|2|0|0|0|0' - ждем выбора (кнопка "Хватит")
'0|3|0|0|0|0' - Ждем выбора (кнопки "Карту" и "Хватит")
'0|4|0|0|0|0' - Ждем выбора (кнопка "Удвоить")
'0|5|0|0|0|0' - Ждем выбора (кнопки "Карту" и "Удвоить")
'0|6|0|0|0|0' - Ждем выбора (кнопки "Хватит" и "Удвоить")
'0|7|0|0|0|0' - Ждем выбора (кнопки "Карту" и "Хватит" и "Удвоить")
'0|8|0|0|0|0' - не работает (какойто Split)
'0|16|0|0|0|0' - выводит диалоговое окно с предложением купить INSURANCE

'1|0|1|0|1|8' - Ничья
'1|0|1|0|1|7' - Black jack выиграл игрок с удвоением
'1|0|1|0|1|6' - Выигрыш игрока с удвоением
'1|0|1|0|1|5' - Black jack выиграл игрок
'1|0|1|0|1|4' - Выигрыш игрока
'1|0|1|0|1|3' - Black Jack у диллера
'1|0|1|0|1|2' - выиграл диллер
'1|0|1|0|1|1' - Black Jack у диллера
'1|0|1|0|1|0' - просто диллер забирает фишку
*/
define('STATUS_MAKE_BET', '0|7|0|0|0|0');


class Black_jack_Controller extends Game_Controller
{
    public $use_auth = FALSE;
    public $pref = 'black_jack';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function __call($method, $args)
    {}
    
    public function initialization($game_id = NULL)
    {
        if (Auth::instance()->logged_in())
        {
            $this->user_id = Auth::instance()->get_user()->id;
        }
        else 
        {
            $this->user_id = 0;
        }
        
        if ((! Session::instance()->get('demo_user_balance', FALSE)) AND (! Auth::instance()->logged_in()))
        {
            Session::instance()->set('demo_user_balance', Setting_Model::instance()->get('demo_user_balance'));
        }

        $this->game_configs = Games_Model::instance()->configs($game_id);
    }
    

    
public function game($game_id = NULL)
{
    $this->template = 'game';
    
    if (isset($game_id))
    {
        $this->initialization($game_id);
        $item['BALANCE'] = $this->user_cash();
        $item['JACKPOT'] = '0';
        $action = $this->input->post('ACTION', '');
        $type = $this->input->post('TYPE', '');
        $bet = abs((int) $this->input->post('BET', 0));
        $payout = '0';
        $cards = Session::instance()->get('card', Kohana::config($this->pref.'.card'));
    }
    
    if (! $action)
    {
        $item['RESULT'] = 'OK';
    }
    elseif ($action == 'ENTER')
    {
        $item['RESULT'] = 'OK';
        Games_Model::instance()->user_games($game_id);
    }
    elseif ($this->user_cash() < $bet)
    {
        $item['RESULT'] = 'OK';
        $this->exit_game();
    }    
    elseif (! $bet AND (Session::instance()->get('bet_mem', FALSE) === FALSE))
    {
        $item['RESULT'] = 'OK';
        $this->exit_game();
    }
    elseif ($action == 'MAKEBET')
    {
        $this->make_bet($item, $game_id, $bet);
    }
    elseif ($action == 'MOVE')
    {
        if($type == 'INSURANCENO')
        {
            $this->insurance_no($item, $cards, $game_id);
        }
        elseif($type == 'INSURANCEYES')
        {
            $this->insurance_yes($item, $cards, $game_id);
        }
        elseif ($type == 'HIT')
        {
            $this->type_hit($item, $cards, $game_id);
        }
        elseif ($type == 'DOUBLE')
        {
            $this->type_double($item, $cards, $game_id);
        }
        elseif ($type == 'STAND')
        {
            $this->type_stand($item, $cards, $game_id);
        }
    }

    $this->assign('item', $item);
    $this->view();
}


public function make_bet(&$item, $game_id, $bet = 0)
{
    //нужна проверка на лимит банка
    $ams = 0;
    $state = STATUS_MAKE_BET;
    $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
    if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
    {
        Session::instance()->set('chance', $this->chance($this->game_configs['win_chance']));
    }
    else
    {
        Session::instance()->set('chance', FALSE);
    }
    $cards = Kohana::config($this->pref.'.card');
    srand((double) microtime() * 1000000);
    shuffle($cards);

//$this->log_add($cards, '----MAKE_BET_new_cards');   $this->log_str('----MAKE_BET-1-$bet='.$bet.' session_bet='.Session::instance()->get('bet_mem'));    
    
    if ($bet)
    {
        Session::instance()->set('bet_mem', $bet);
    }
    else
    {
        $bet = Session::instance()->get('bet_mem');
    }
    
    $this->pick_cash($bet, $game_id);   //$this->log_str('--MAKEBET-2-$bet='.$bet.' session_bet='.Session::instance()->get('bet_mem'));
    
    
    //$cards['25'] = 0;
    //$cards['26'] = 12;
    //$cards['1'] = 0;
    //$cards['2'] = 12;
    
    $cards_dealer = $cards['25'].'|52';
    $cards_player = $cards['1'].'|'.$cards['2'];
$this->log_str('--MAKEBET--$cards_dealer='.$cards_dealer.' $cards_player='.$cards_player);
    
    if (array_search($cards['25'], Kohana::config($this->pref.'.aces')) !== FALSE)// is insurance?
    {
        $state = '0|16|0|0|0|0';
        Session::instance()->set('card', $cards);
        Session::instance()->set('cardsplayer', $cards_player);
    }
    elseif (($score_dealer = $this->score_card($cards['25'].'|'.$cards['26'], TRUE)) == 21)// in dealer black jack?
    {
        $cards_dealer = $cards['25'].'|'.$cards['26'];
        $item['SCORESDEALER'] = $score_dealer;
        $state = '1|0|1|0|1|1';
        $item['PAYOUT'] = $bet.'|0|0|0|0';
        Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
    }
    elseif ($this->score_card($cards_player, TRUE) == 21)//in player black jack?
    {
        $state = '1|0|0|0|1|5';//'1|0|0|1|1|0';//'1|0|1|0|1|5';
        $black_jack_win = round($bet / 2) + $bet;
        $item['PAYOUT'] = '0|'.($black_jack_win + $bet).'|0|'.($black_jack_win + $bet).'|0';
        $item['SCORESDEALER'] = $this->score_card($cards['25'].'|'.$cards['26'], TRUE);
        Games_Model::instance()->user_add($black_jack_win);
        Games_Model::instance()->bank_pay($game_id, 'game', $black_jack_win);
        Games_Model::instance()->statistics($game_id, $bet, $this->user_cash(), Kohana::config('game.map.main'), $black_jack_win);
    }
    else
    {
        Session::instance()->set('card', $cards);
        Session::instance()->set('cardsplayer', $cards_player);
    }
    
    $item['STATE'] = $state;
    $item['CARDSDEALER'] = $cards_dealer;
    $item['CARDSPLAYER'] = $cards_player;
    $item['SCORESPLAYER'] = $this->score_card_view($cards_player);//$this->score_card($cards_player, TRUE);
    $item['RESULT'] = 'OK';
    $item['BET'] = $bet.'|'.$bet.'|0|'.$bet.'|0';
    $item['BALANCE'] = $this->user_cash();
}


public function insurance_no(&$item, $cards, $game_id)
{
    $cards_player = Session::instance()->get('cardsplayer');
    $scores_player = $this->score_card($cards_player);
    Session::instance()->set('insurance', 0);
    $bet = Session::instance()->get('bet_mem', 0);
    
    $state = STATUS_MAKE_BET;
    $cards_dealer = $cards['25'].'|52';
    if (($score_dealer = $this->score_card($cards['25'].'|'.$cards['26'], TRUE)) == 21)// in dealer black jack?
    {
        $cards_dealer = $cards['25'].'|'.$cards['26'];
        $item['SCORESDEALER'] = $score_dealer;
        $state = '1|0|1|0|1|1';
        $item['PAYOUT'] = $bet.'|0|0|0|0';
    }

    $item['STATE'] = $state;
    $item['SCORESPLAYER'] = $this->score_card_view($cards_player);
    $item['CARDSPLAYER'] = $cards_player;
    $item['CARDSDEALER'] = $cards_dealer;
    $item['BET'] = $bet.'|'.$bet.'|0|'.$bet.'|0';
    $item['RESULT'] =  'OK';
}


public function insurance_yes(&$item, $cards, $game_id)
{
    $cards_player = Session::instance()->get('cardsplayer');
    $scores_player = $this->score_card($cards_player);
    $bet = Session::instance()->get('bet_mem', 0);
    $bet_insurance = round($bet / 2);
    Session::instance()->set('insurance', $bet_insurance);
    
    $this->pick_cash($bet_insurance, $game_id);
    
    $state = '0|7|1|0|0|0';
    $cards_dealer = $cards['25'].'|52';
    if (($score_dealer = $this->score_card($cards['25'].'|'.$cards['26'], TRUE)) == 21)// in dealer black jack?
    {
        $cards_dealer = $cards['25'].'|'.$cards['26'];
        $item['SCORESDEALER'] = $score_dealer;
        $state = '1|0|1|0|1|1';
        $item['PAYOUT'] = $bet.'|0|0|0|0';
    }

    $item['STATE'] = $state;
    $item['SCORESPLAYER'] = $this->score_card_view($cards_player);
    $item['CARDSPLAYER'] = $cards_player;
    $item['CARDSDEALER'] = $cards_dealer;
    $item['BET'] = ($bet_insurance + $bet).'|'.$bet.'|'.$bet_insurance.'|'.$bet.'|0';
    $item['RESULT'] =  'OK';
    $item['BALANCE'] = $this->user_cash();
}


public function type_hit(&$item, $cards, $game_id)
{
    $card = $this->generet_card(Session::instance()->get('cardsplayer', '1'));
    while (! isset($cards[$card]))
    {
        $card = $this->generet_card(Session::instance()->get('cardsplayer', '1'));
    }
    
    $cards_player = Session::instance()->get('cardsplayer', '1').'|'.$cards[$card];
    Session::instance()->set('cardsplayer', $cards_player);
    $bet = Session::instance()->get('bet_mem');
    $scores_player = $this->score_card($cards_player);  //$this->log_str('~:::HIT:::$cards_player='.$cards_player.' $card='.$card.' $cards[card]'.$cards[$card]);
    
    if ($scores_player > 21)
    {
        Session::instance()->delete('cardsdealer');
        Session::instance()->delete('cardsplayer');
        
        $cards_dealer = $cards[25].'|'.$cards[26];
        $scores_dealer = $this->score_card($cards_dealer);
        $state = '1|0|0|0|1|0';//'1|0|1|0|1|0';
        $item['SCORESDEALER'] = $scores_dealer;
        $item['PAYOUT'] = $bet.'|0|0|0';
        Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
    }
    else
    {
        $cards_dealer = $cards['25'].'|52';
        $state = '0|3|0|0|0|0';
    }
    
$this->log_str('--HIT--$cards_dealer='.$cards_dealer.' $cards_player='.$cards_player.' $scores_player='.$scores_player);
    
    if ($scores_player == 21)
    {
        $this->type_stand($item, $cards, $game_id);
    }
    else
    {
        $item['STATE'] = $state; //'1|0|1|1|1|0'; 
        $item['SCORESPLAYER'] = $this->score_card_view($cards_player);
        $item['CARDSDEALER'] = $cards_dealer;
        $item['CARDSPLAYER'] = $cards_player;
        $item['BET'] = $bet.'|'.$bet.'|0|'.$bet;
        $item['RESULT'] = 'OK';
    }
}


public function type_double(&$item, $cards, $game_id)
{
    //при подсчете скоре плеера, если 2 карты, значит туз = 11
    $card = $this->generet_card(Session::instance()->get('cardsplayer', '1'));
    while (! isset($cards[$card]))
    {
        $card = $this->generet_card(Session::instance()->get('cardsplayer', '1'));
    }
    $cards_player = Session::instance()->get('cardsplayer', '1').'|'.$cards[$card];
    Session::instance()->set('cardsplayer', $cards_player);
    $bet = Session::instance()->get('bet_mem', 0);
    $this->pick_cash($bet, $game_id);
    $scores_player = $this->score_card($cards_player);
    
    if ($scores_player > 21)
    {
        $bet_double = ($bet * 2);
        $item['STATE'] = '1|0|0|0|1|2';
        $item['PAYOUT'] = $bet_double.'|0|0|0';
        $item['SCORESPLAYER'] = $scores_player;
        $item['SCORESDEALER'] = $this->score_card($cards[25].'|'.$cards[26], TRUE);
        $item['CARDSDEALER'] = $cards[25].'|'.$cards[26];
        $item['CARDSPLAYER'] = $cards_player;
        $item['BET'] = $bet_double.'|'.$bet.'|0|'.$bet_double.'|0';
        $item['RESULT'] = 'OK';
        $item['BALANCE'] = $this->user_cash();
        Session::instance()->delete('cardsdealer');
        Session::instance()->delete('cardsplayer');
        Games_Model::instance()->statistics($game_id, $bet_double, $this->user_cash());
    }
    else
    {
        $this->type_stand($item, $cards, $game_id, TRUE);
    }
}


public function type_stand(&$item, $cards, $game_id, $double = FALSE)
{
    //при подсчете скоре плеера, если 2 карты, значит туз = 11
    $win = 0;
    $cards_player = Session::instance()->get('cardsplayer');
    $cards_dealer = $cards[25].'|'.$cards[26];
    $scores_dealer = $this->score_card($cards_dealer);
    $scores_player = $this->score_card($cards_player);
    $view_scores_dealer = '0,'.$this->score_card_view($cards_dealer);
    
//    if (Session::instance()->get('', FALSE))
//    {
//        $this->dealer_ower($scores_player, $scores_dealer, $view_scores_dealer);
//    }
//    else
//    {
//        $this->dealer_win($scores_player, $scores_dealer, $view_scores_dealer);
//    }
    for ($i = 27; $scores_dealer <= Kohana::config($this->pref.'.min_scores_dealer'); $i++)// OR $scores_dealer < $scores_player
    {
        if ($scores_dealer > $scores_player)
        {
            break;
        }
        $cards_dealer .= '|'.$cards[$i];
        $scores_dealer = $this->score_card($cards_dealer);
        $view_scores_dealer .= ','.$this->score_card_view($cards_dealer);
    }
    

$this->log_str('|~~~Standart:::$cards_dealer='.$cards_dealer.' $view_scores_dealer='.$view_scores_dealer);
    
    
    $scores_dealer = $this->score_card($cards_dealer);
    $bet = Session::instance()->get('bet_mem');
    $bet_view = $bet.'|'.$bet.'|0|'.$bet.'|0';
    
    
    if ($scores_dealer > 21 OR $scores_player > $scores_dealer)
    {
        $win = $bet * 2;
        if ($double)
        {
            $bet_view = $win.'|'.$bet.'|0|'.$win.'|0';
            $win *= 2;
            $payout = '0|'.$win.'|0|'.$win.'|0';
            $state = '1|0|1|0|1|6';
        }
        else
        {
            $payout = '0|'.$win.'|0|'.$win.'|0';
            $state = '1|0|1|0|1|4';
        }
    }
    elseif ($scores_player < $scores_dealer)
    {
        if ($double)
        {
            $bet_view = $bet.'|'.$bet.'|0|'.$bet.'|0';
            $bet_double = ($bet * 2);
            $payout = $bet_double.'|0|0|0|0';
            $state = '1|0|0|0|1|2';//'1|0| 1 |0|1|2'
        }
        else
        {
            $payout = $bet.'|0|0|0|0';
            $state = '1|0|0|0|1|0';
        }
    }
    elseif ($scores_dealer == $scores_player)
    {
        $win = ($double)? $bet * 2: $bet;
        $state = '1|0|1|0|1|8';
        $payout = '0|'.$bet.'|0|0|0';
    }    
                
    
    if (Session::instance()->get('insurance', 0) > 0)// AND $scd1 == 21
    {
        $insurance_payout = Session::instance()->get('insurance') + $bet;
        $payout = explode('|', $payout);
        $payout[0] += $insurance_payout;
        $payout[2] = $insurance_payout;
        $payout = join('|', $payout);

        Games_Model::instance()->user_add($insurance_payout);
        Games_Model::instance()->bank_pay($game_id, 'game', $insurance_payout);
    }
    
    if ($win > 0)
    {
        Games_Model::instance()->user_add($win);
        Games_Model::instance()->bank_pay($game_id, 'game', $win);
        Games_Model::instance()->statistics($game_id, $bet, $this->user_cash(), Kohana::config('game.map.main'), $win);
    }
    else
    {
        Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
    }
    
$this->log_str('--MAKEBET--$cards_dealer='.$cards_dealer.' $cards_player='.$cards_player.' $scores_player='.$scores_player.' $scores_dealer='.$scores_dealer);
    
    $item['STATE'] = $state;
    $item['CARDSDEALER'] = $cards_dealer;
    $item['CARDSPLAYER'] = $cards_player;
    $item['SCORESPLAYER'] = $this->score_card_view($cards_player);
    $item['SCORESDEALER'] = $view_scores_dealer;
    $item['RESULT'] = 'OK';
    $item['PAYOUT'] = $payout;
    $item['BALANCE'] = $this->user_cash();
    $item['BET'] = $bet_view;
    
    Session::instance()->delete('cardsdealer');
    Session::instance()->delete('cardsplayer');
    Session::instance()->delete('insurance');
}




public function score_card_view($cards = '')
{
    $score_card = array();
    $exist_aces = FALSE;
    $cards = explode('|', $cards);
    for ($i = 0; $i < count($cards); ++$i)
    {
        if (($score_card[$i] = $this->detect_card($cards[$i], ! $exist_aces)) == 11)
        {
            $exist_aces = TRUE;
        }
    }
    
    $sum = array_sum($score_card);
        
    if ($sum == 21 AND count($cards) == 2)
    {
        $exist_aces = FALSE;
    }
    elseif ($sum > 20 AND $exist_aces)
    {
        $exist_aces = FALSE;
        $sum -= 10;
    }
    
    return ($exist_aces)? ($sum.'|'.($sum - 10)): $sum;
}


public function score_card($cards = '', $black_jack = FALSE)
{
    $score_card = array();
    $cards = explode('|', $cards);
    $exist_aces = FALSE;
    for ($i = 0; $i < count($cards); ++$i)
    {
        if (($score_card[$i] = $this->detect_card($cards[$i], ! $exist_aces)) == 11)
        {
            $exist_aces = TRUE;
            //$black_jack = FALSE;
        }
    }
    
    $sum = array_sum($score_card);
    if ($sum > 20 AND $exist_aces AND ! $black_jack)
    {
        $sum -= 10;
    }
    
    return $sum;
}


public function detect_card($card = 1, $black_jack = FALSE)
{
    if ($card == 0 OR $card == 13 OR $card == 26 OR $card == 39)
    {
        return ($black_jack)? 11: 1;
    }
    elseif ($card == 1 OR $card == 14 OR $card == 27 OR $card == 40)
    {
        return 2;
    }
    elseif ($card == 2 OR $card == 15 OR $card == 28 OR $card == 41)
    {
        return 3;
    }
    elseif ($card == 3 OR $card == 16 OR $card == 29 OR $card == 42)
    {
        return 4;
    }
    elseif ($card == 4 OR $card == 17 OR $card == 30 OR $card == 43)
    {
        return 5;
    }
    elseif ($card == 5 OR $card == 18 OR $card == 31 OR $card == 44)
    {
        return 6;
    }
    elseif ($card == 6 OR $card == 19 OR $card == 32 OR $card == 45)
    {
        return 7;
    }
    elseif ($card == 7 OR $card == 20 OR $card == 33 OR $card == 46)
    {
        return 8;
    }
    elseif ($card == 8 OR $card == 21 OR $card == 34 OR $card == 47)
    {
        return 9;
    }
    elseif ($card == 9 OR $card == 22 OR $card == 35 OR $card == 48)
    {
        return 10;
    }
    elseif ($card == 10 OR $card == 23 OR $card == 36 OR $card == 49)
    {
        return 10;
    }
    elseif ($card == 11 OR $card == 24 OR $card == 37 OR $card == 50)
    {
        return 10;
    }
    elseif ($card == 12 OR $card == 25 OR $card == 38 OR $card == 51)
    {
        return 10;
    }
    else
    {
        return 0;
    }
}


public function generet_card($card = '')
{
    if ($cards = count(explode('|', $card)) AND isset($cards[1]))
    {
        return $cards + 1;
    }
    else
    {
        srand((double) microtime() * 100024);
        return mt_rand(2, 49);
    }
}

public function dealer_ower($scores_player = 0, $scores_dealer = 0, $view_scores_dealer = '')
{
    for ($i = 27; $scores_dealer <= 16 AND $scores_dealer < $scores_player; $i++)
    {
        $cards_dealer .= '|'.$cards[$i];
        $scores_dealer = $this->score_card($cards_dealer);
        $view_scores_dealer .= ','.$scores_dealer;
    }
}

public function dealer_win($scores_player = 0, $scores_dealer = 0, $view_scores_dealer = '')
{
    for ($i = 27; $scores_dealer <= 16 AND $scores_dealer < $scores_player; $i++)
    {
        $cards_dealer .= '|'.$cards[$i];
        $scores_dealer = $this->score_card($cards_dealer);
        $view_scores_dealer .= ','.$scores_dealer;
    }
}


public function pick_cash($cash = 0, $game_id = 1)
{
    $profit = $cash * (Games_Model::instance()->profit_percent($game_id) / 100);
    Games_Model::instance()->user_pay($cash);
    Games_Model::instance()->bank_add($game_id, 'game', $cash - $profit);
    Games_Model::instance()->bank_add($game_id, 'profit', $profit);
}

public function exit_game() 
{
    url::redirect(Setting_Model::instance()->get('url'));
}




}
