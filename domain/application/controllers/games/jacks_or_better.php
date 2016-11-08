<?php defined('SYSPATH') OR die('No direct access allowed.');

class Jacks_or_better_Controller extends Game_Controller
{
    public $use_auth = FALSE;
    public $pref = 'jacks_or_better';
    
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
        $action = $this->input->post('ACTION', '');
    }
    
    
    if (! isset($action) OR ! $action)
    {
        $this->exit_game();
    }
    elseif ($action == 'ENTER' AND $this->user_cash() > Kohana::config($this->pref.'.min_balance'))
    {
        $item['RESULT'] = 'OK';
        $item['BALANCE'] = $this->user_cash();
        Session::instance()->delete('cards');
        Games_Model::instance()->user_games($game_id);
    }
    elseif ($this->user_cash() <= Kohana::config($this->pref.'.min_balance'))
    {
        $this->exit_game($item);
    }    
    elseif ($action == 'EXIT')
    {
        $this->exit_game($item);
    }    
    elseif ($action == 'ERROR')
    {
        $this->exit_game($item);
    }
    elseif ($action == 'MAKEBET')
    {
        $this->make_bet($game_id, $item);
    }
    elseif ($action == 'KEEPCARDS')
    {
        $this->keep_cards($game_id, $item);
    }
    elseif ($action == 'MOVE')
    {
        $this->exit_game($item);
    }

    $this->assign('item', $item);
    $this->view();
}


public function make_bet($game_id = 0, &$item = array())
{
    $config['bets'] = Kohana::config($this->pref.'.bets');
    list($bet_id, $bet_count) = explode(' ', $this->input->post('BET', 0));
    $bet = $config['bets'][$bet_id];
    $all_bet = $bet * $bet_count;

    if ($all_bet <= 0)
    {
        $item['RESULT'] = 'BAD_BET';
    }
    elseif ($all_bet >= $this->user_cash())
    {
        $item['RESULT'] = 'LOW_BALANCE';
    }
    else
    {
        $this->pick_cash($all_bet, $game_id);
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
        if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
        {
            $win_chance = $this->chance($this->game_configs['win_chance']);
        }
        else
        {
            $win_chance = FALSE;
        }
        
        Session::instance()->set('chance', $win_chance);
        Session::instance()->set('jp_betcount', $bet_count);
        Session::instance()->set('jp_betid', $bet_id);
        Session::instance()->set('jp_bet', $bet);
        
        $card_map = $this->make_cards_map();
        Games_saving_Model::instance()->save_job($card_map, $game_id);
        Session::instance()->set('cards', array($this->new_card($game_id, $card_map), $this->new_card($game_id, $card_map), $this->new_card($game_id, $card_map), $this->new_card($game_id, $card_map), $this->new_card($game_id, $card_map)));
        
        Kohana::log('error', '__start|win='.(($win_chance)?'1':'0').'|cards='.implode('|', Session::instance()->get('cards'))); Kohana::log_save();

        $item['RESULT'] = 'OK';
        $item['BALANCE'] = $this->user_cash();
        $item['CARDS'] = implode('|', Session::instance()->get('cards'));
    }
}



public function keep_cards($game_id = 0, &$item = array()) 
{
    $config['combos'] = Kohana::config($this->pref.'.combos');//Комбинации карт
    $all_bet = Session::instance()->get('jp_betcount') * Session::instance()->get('jp_bet');
    $hold_cards = explode('|', $this->input->post('CARDSKEPT'));
    $possible_exit = FALSE;
    $combo = FALSE;
    $win_all = 0;
    $number_loop = 0;
    
    $map = Games_saving_Model::instance()->read_job($game_id);

    while (! $possible_exit)
    {
        $cards = Session::instance()->get('cards');
        $win_all = 0;
        
        if ($hold_cards[0] == 0) 
        {
            $item['NEWCARD0'] = '1';
            $cards[0] = $this->new_card($game_id);
        }
        
        if ($hold_cards[1] == 0)
        {
            $item['NEWCARD1'] = '1';
            $cards[1] = $this->new_card($game_id);
        }
        
        if ($hold_cards[2] == 0)
        {
            $item['NEWCARD2'] = '1';
            $cards[2] = $this->new_card($game_id);
        }
        
        if ($hold_cards[3] == 0)
        {
            $item['NEWCARD3'] = '1';
            $cards[3] = $this->new_card($game_id);
        }
        
        if ($hold_cards[4] == 0)
        {
            $item['NEWCARD4'] = '1';
            $cards[4] = $this->new_card($game_id);
        }
        
        $combo = $this->check_cards($cards);
        $possible_exit = $this->consent_loop_end($combo, $number_loop, $config, $game_id);
    }
    
    Kohana::log('error', '===end->cards='.implode('|', $cards)); Kohana::log_save();
    

    if ($combo !== FALSE)
    {
        $payout = $config['combos'][$combo]['payout'] * Session::instance()->get('jp_betcount');
        Games_Model::instance()->user_add($payout);
        Games_Model::instance()->bank_pay($game_id, 'game', $payout);
        $item['PAYOUT'] = $payout;
        $item['PAYOUTTYPE'] = $config['combos'][$combo]['payout_type'];
        Games_Model::instance()->statistics($game_id, $all_bet, $this->user_cash(), Kohana::config('game.map.main'), $payout);
    }
    else
    {
        Games_Model::instance()->statistics($game_id, $all_bet, $this->user_cash());
    }
    
    $item['RESULT'] = 'OK';
    $item['BALANCE'] = $this->user_cash();
    $item['CARDS'] = implode('|', $cards);
    
}

//------------------------------------------------------------------------------
//
//------------------------------------------------------------------------------
//
//------------------------------------------------------------------------------
//


public function make_cards_map()
{
    $result = array();
    $i = 0;
    foreach (Kohana::config($this->pref.'.cards_map') as $key => $value)
    {
        $result[$i++] = $key;
    }
    
    return $result;
}


public function new_card($game_id = NULL, &$card_map = array())
{
    mt_srand();
    if ($card_map)
    {
        $cards = $card_map;
    }
    else
    {
        $cards = Games_saving_Model::instance()->read_job($game_id);
    }
    
    $id = mt_rand(0, (count($cards) - 1));
    while (! isset($cards[$id]))
    {
        $id = mt_rand(0, (count($cards) - 1));
    }
    
    $card = $cards[$id];
    
    unset($cards[$id]);
    if (isset($card_map[$id]))
    {
        unset($card_map[$id]);
    }
    
    Games_saving_Model::instance()->save_job($cards, $game_id);
    
    //$current_map = array();
//    $i = 0;
//    foreach ($cards as $v)
//    {
//        $current_map[$i++] = $v;
//    }
//    
//    $cards = $current_map;
//    $card_map = $current_map;
    //Session::instance()->set('cards_map', $cards);
    
    
    return $card;
}



//Функции определения комбинации.
public function is_royal_flash($cards)//Роял флеш
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $type = '';
    $prev = FALSE;

    foreach ($cards as $k => $v)
    {
        if ($prev === FALSE)
        {
            switch ($config['cards_map'][$v]['weight']) 
            {
                case 1:   //Туз
                case 10:  //Десятка
                case 13:  //Король
                case 12:  //Дама
                case 11:  //Валет
                    $type = $config['cards_map'][$v]['type'];
                    $prev = TRUE;
                    break;

                default:
                    return FALSE;
            }
        }
        elseif ($config['cards_map'][$v]['type'] == $type)
        {
            switch ($config['cards_map'][$v]['weight'])
            {
                case 1:
                case 10:
                case 13:
                case 12:
                case 11:
                    $type = $config['cards_map'][$v]['type'];
                    $prev = TRUE;
                    break;

                default:
                    return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    return TRUE;
}

//Джокер роял флеш
public function is_joker_royal_flash($cards)
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $type = '';
    $prev = FALSE;

    foreach ($cards as $k => $v)
    {
        if ($prev === FALSE)
        {
            switch ($config['cards_map'][$v]['weight'])
            {
                case 1:   //Туз
                case 10:  //Десятка
                case 13:  //Король
                case 12:  //Дама
                case 11:  //Валет
                case 14:  //Джокер
                    $type = $config['cards_map'][$v]['type'];
                    $prev = TRUE;
                    break;

                default:
                    return FALSE;
            }
        }
        elseif ($config['cards_map'][$v]['type'] == $type)
        {
            switch ($config['cards_map'][$v]['weight'])
            {
                case 1:
                case 10:
                case 13:
                case 12:
                case 11:
                case 14:
                    $type = $config['cards_map'][$v]['type'];
                    $prev = TRUE;
                    break;

                default:
                    return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    return TRUE;
}

//Пятёрка
public function is_five_of_a_kind($cards)
{
    $groups = $this->cards_group_count($cards);
    foreach ($groups as $count)
    {
        if (($count == 4) AND (isset($groups[14]) AND $groups[14] == 1))
        {
            return TRUE;
        }
    }
    
    return FALSE;
}


//Стрит флеш.
public function is_straight_flush($cards)
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $cards = $this->cards_natsort($cards);
    $prev = FALSE;
    $type = '';
    $joker = FALSE;
    foreach ($cards as $card)
    {
        if ($prev === FALSE)
        {
            $prev = $config['cards_map'][$card]['weight'];
            $type = $config['cards_map'][$card]['type'];
        }
        else
        {
            if (($type == $config['cards_map'][$card]['type']) AND ($prev+1 == $config['cards_map'][$card]['weight']))
            {
                $prev = $config['cards_map'][$card]['weight'];
            }
            elseif ($config['cards_map'][$card]['weight'] == 14)
            {
                $joker = TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }

    return TRUE;
}

//Флеш
public function is_flush($cards)
{
    $groups = $this->cards_group_count($cards, "type");
    foreach ($groups as $count)
    {
        if (($count == 4) AND (isset($groups['joker']) AND $groups['joker'] == 1))
        {
            return TRUE;
        }
        elseif ($count == 5)
        {
            return TRUE;
        }
    }
    return FALSE;
}

//Стрит
public function is_straight($cards)
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $cards = $this->cards_natsort($cards);
    $prev = FALSE;
    $joker = FALSE;
    foreach ($cards as $card)
    {
        if ($prev === FALSE)
        {
            if ($config['cards_map'][$card]['weight'] != 14)
            {
                $prev = $config['cards_map'][$card]['weight'];
            }
        }
        else
        {
            if ($prev+1 == $config['cards_map'][$card]['weight'])
            {
                $prev = $config['cards_map'][$card]['weight'];
            }
            elseif ($config['cards_map'][$card]['weight'] == 14)
            {
                $joker = TRUE;
            }
            else
            {
                return FALSE;
            }
        }
    }

    return TRUE;
}


//Каре
public function is_four_of_kind($cards)
{
    $groups = $this->cards_group_count($cards);
    foreach ($groups as $count)
    {
        if (($count == 3) AND (isset($groups[14]) AND $groups[14] == 1))
        {
            return TRUE;
        }
        elseif ($count == 4)
        {
            return TRUE;
        }
    }
    return FALSE;
}


//фул хаус
public function is_full_house ($cards)
{
    $group = $this->cards_group_count($cards, 'weight');
    
    if (count($group) == 2)
    {
        return TRUE;
    }
    elseif (count($group) == 3)
    {
        if (isset($group[14]))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    else
    {
        return FALSE;
    }
}

//Тройка
public function is_three_of_kind($cards)
{
    $groups = $this->cards_group_count($cards);//$this->log_add($groups, 'group');
    foreach ($groups as $count)
    {
        if (($count == 2) AND (isset($groups[14]) AND $groups[14] == 1))
        {
            return TRUE;
        }
        elseif ($count == 3)
        {
            return TRUE;
        }
    }
    
    return FALSE;
}


//Две пары - а надо пара выше валета!!!!!!!!!!!!!!!!!
public function is_two_pairs($cards)
{
    $group = $this->cards_group_count($cards, 'weight');
    $pairs = 0;

    foreach ($group as $count)
    {
        if ($count == 2)
        {
            $pairs++;
        }
    }

    return ($pairs == 2)? TRUE: FALSE;
}

//Короли или выше
public function is_kings_or_better ($cards)
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $cards = $this->cards_natsort($cards);
    $king = 0;
    $one = 0;
    $joker = FALSE;
    
    foreach ($cards as $card)
    {
        switch ($config['cards_map'][$card]['weight'])
        {
            case 13:
                $king++;
                break;

            case 1:
                $one++;
                break;

            case 14:
                if ($king < 2)
                {
                    $king++;
                }
                
                if ($one < 2)
                {
                    $one++;
                }
                $joker = TRUE;
                break;
        }
    }

    if (($king == 2) OR ($one == 2))
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}


public function fucks_or_better($cards, $what_min = 11, $one_is_upper = TRUE)
{
    $group = $this->cards_group_count($cards, 'weight');
    $pairs = 0;

    foreach ($group as $what => $count)
    {
        if ((($what >= $what_min) OR (($what == 1) AND ($one_is_upper))) AND ($count == 2))
        {
            return TRUE;
        }
    }

    return FALSE;
}


public function cards_natsort($cards, $param = 'weight')
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $index = array();
    $result = array();
    foreach ($cards as $card)
    {
        $index[$card] = $config['cards_map'][$card][$param];
    }
    
    natsort($index);
    foreach ($index as $k => $v)
    {
        $result[] = $k;
    }
    
    return $result;
}


public function cards_group_count($cards, $param = 'weight')
{
    $config['cards_map'] = Kohana::config($this->pref.'.cards_map');
    $cards = $this->cards_natsort($cards, $param);
    $rezult = array();

    foreach ($cards as $card)
    {
        if (isset($result[$config['cards_map'][$card][$param]]))
        {
            $result[$config['cards_map'][$card][$param]]++;
        }
        else
        {
            $result[$config['cards_map'][$card][$param]] = 1;
        }
    }

    return $result;
}


public function check_cards($cards)
{
    if ($this->is_royal_flash($cards))
    {
        return 'royal_flush';
    }
    elseif ($this->is_straight_flush($cards))
    {
        return 'straight_flush';
    }
    elseif ($this->is_four_of_kind($cards))
    {
        return 'four_of_kind';
    }
    elseif ($this->is_full_house($cards))
    {
        return 'full_house';
    }
    elseif ($this->is_flush($cards))
    {
        return 'flush';
    }
    elseif ($this->is_straight($cards))
    {
        return 'straight';
    }
    elseif ($this->is_three_of_kind($cards))
    {
        return 'three_of_kind';
    }
    elseif ($this->is_two_pairs($cards))
    {
        return 'two_pairs';
    }
    elseif ($this->fucks_or_better($cards, 11, TRUE))
    {
        return 'jacks_or_better';
    }
    else
    {
        return FALSE;
    }
}


public function consent_loop_end($combo = FALSE, &$number_loop = 1, $config, $game_id = 1)
{
    if ($combo !== FALSE AND Session::instance()->get('chance'))
    {
        Kohana::log('error', '__if|win='.((Session::instance()->get('chance'))?'1':'0').'|$combo='.(($combo)?1:0)); Kohana::log_save();
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
        $win_all = $config['combos'][$combo]['payout'] * Session::instance()->get('jp_betcount') * Session::instance()->get('jp_bet');
        
        if ($bank_balance >= $win_all)
        {
            return TRUE;
        }
    }
    elseif ($combo === FALSE AND ! Session::instance()->get('chance'))
    {
        Kohana::log('error', '__else|win='.((Session::instance()->get('chance'))?'1':'0').'|$combo='.(($combo)?1:0)); Kohana::log_save();
        return TRUE;
    }
    else
    {
        if (++$number_loop > Kohana::config($this->pref.'.limit_loop'))
        {
            Kohana::log('error', '__need_out|win='.((Session::instance()->get('chance'))?'1':'0').'|$combo='.(($combo)?1:0)); Kohana::log_save();
            return TRUE;
        }
    }
    
    return FALSE;
}


public function exit_game(&$item) 
{
    Session::instance()->delete('cards');
    Session::instance()->delete('cards_map');
    $item['RESULT'] = 'OK';
}

public function get_gauge($chance_win = FALSE) 
{
    $gauges = array();
    foreach (Kohana::config($this->pref.'.gauge') as $key => $value)
    {
        $gauges[$key] = $this->game_configs[$key];
    }
    asort($gauges);
    
    if ($gauges AND $chance_win)
    {
        srand( ((int)((double)microtime() * 1000003)) );
        $chance_gauge = rand(1, 100);
        foreach ($gauges as $key => $value)
        {
            if (($chance_gauge % (100/ $value)) == 0)
            {
                return Kohana::config($this->pref.'.gauge.'.$key);
            }
        }
        return Kohana::config($this->pref.'.gauge.jacks_or_better');
    }
    else
    {
        return FALSE;
    }
}




public function pick_cash($cash = 0, $game_id = 1)
{
    $profit = $cash * (Games_Model::instance()->profit_percent($game_id) / 100);
    Games_Model::instance()->user_pay($cash);
    Games_Model::instance()->bank_add($game_id, 'game', $cash - $profit);
    Games_Model::instance()->bank_add($game_id, 'profit', $profit);
}


public function test() 
{
    //Games_saving_Model::instance()->save_job(array(), array(1,2,3,4), 54);
    $a = '';
    $this->keep_cards(54, $a);
    
    //$a = Games_saving_Model::instance()->read_job(54);
    print Kohana::debug($a);
}


}







//$config['bets'] = Kohana::config($this->pref.'.bets');
//$config['combos'] = Kohana::config($this->pref.'.combos');//Комбинации карт
//$config['cards_map'] = Kohana::config($this->pref.'.cards_map');


//public function is_in_array($a, $v)
//{
//    $rezult = FALSE;
//    foreach ($a as $value) 
//    {
//        if ($value == $v) 
//        {
//            $rezult = TRUE;
//            break;
//        }
//    }

//    return $rezult;
//}

//Возвращает максимальное значение из множества элементов распиханых в один "прямой" массив
//public function array_max($a, $return_key = FALSE)
//{
//    $mv = NULL;
//    $mk = NULL;
//    foreach ($a as $k => $value)
//    {
//        if ($mv == NULL)
//        {
//            $mv = $value;
//            $mk = $k;
//        }
//        elseif ($value>$mv)
//        {
//            $mv = $value;
//            $mk = $k;
//        }
//    }

//    return ($return_key)? $mk: $mv;
//}

//Возвращает минимальное значение из множества элементов распиханых в один "прямой" массив
//public function array_min($a, $return_key = FALSE)
//{
//    $mv = NULL;
//    $mk = NULL;
//    foreach ($a as $k => $value)
//    {
//        if ($mv == NULL)
//        {
//            $mv = $value;
//            $mk = $k;
//        }
//        elseif ($value<$mv)
//        {
//            $mv = $value;
//            $mk = $k;
//        }
//    }

//    return ($return_key)? $mk: $mv;
//}


//public function array_mathfind($a, $from, $to = NULL, $offset = 0, $from_end = FALSE)
//{
//    if ($from_and)
//    {
//        $a = array_reverse($a, TRUE);
//    }

//    foreach ($a as $k => $value)
//    {
//        if ($offset == 0)
//        {
//            if ((is_int($value)) OR (is_float($value)))
//            {
//                if (($from <= $value) AND (($to >= $value) OR ($to === NULL)))
//                {
//                    return $k;
//                }
//            }
//        }
//        else
//        {
//            $offset--;
//        }
//    }
//    
//    return FALSE;
//}


//public function array_myshuffle($a)
//{
//    $b = range(0, count($a)-1);
//    shuffle($b);
//    $rezult = array();
//    foreach ($b as $id)
//    {
//        $rezult[$id] = $a[$id];
//    }
//    
//    return $rezult;
//}


//public function array_randelem($arr)
//{
//    $a = array();
//    $i = 0;
//    foreach ($arr as $v)
//    {
//        $a[$i] = $v;
//        $i++;
//    }
//    
//    return $a[mt_rand(0, (count($a)-1))];
//}

