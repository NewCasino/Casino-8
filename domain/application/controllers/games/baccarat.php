<?php defined('SYSPATH') OR die('No direct access allowed.');

class Baccarat_Controller extends Game_Controller
{
    public $use_auth = FALSE;
    public $pref = 'baccarat';
    
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
        list($bets, $total_bet, $make_bet) = $this->get_bet();
        $item['RESULT'] = 'OK';
        $item['BALANCE'] = $this->user_cash();
        $item['JACKPOT'] = '0.00';
    }

    if (! isset($make_bet))
    {
        $item['RESULT'] = 'BAD_BET';
    }
    elseif (! $make_bet AND $this->input->post('ACTION', '') == 'EXIT')
    {
        $item = url::redirect(Setting_Model::instance()->get('url'));
    }    
    elseif (! $make_bet AND $this->input->post('ACTION', '') == 'ENTER')
    {
        $item['HASHISTORY'] = 'N';//GAMECOUNT=1000&JACKPOT=0.00&TIMELIMIT=10800000&RESULT=OK&HASHISTORY=N&BALANCE=1000.00&
    }
    elseif (! Games_Model::instance()->is_bank($game_id, FALSE))
    {
        $item['RESULT'] = 'BAD_BET';
    }
    elseif ($make_bet AND $total_bet <= 0)
    {
        $item['RESULT'] = 'BAD_BET_VALUE';
    }
    elseif ($make_bet AND $this->user_cash() < $total_bet)
    {
        $item['RESULT'] = 'LOW_USER_BALANCE';
    }
    else
    {
        //Games_Model::instance()->user_games($game_id);
        //$item['coinsize'] = $this->game_configs['coin_size'];
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
        list($player_win_chance, $banker_win_chance, $tie_win_chance) = $this->generet_chances($bank_balance);
        
        while (TRUE) 
        {
            $player_cards = array();
            $banker_cards = array();
            $player_score = 0;
            $banker_score = 0;
            $total_win = 0;
            $payout = array(0,0,0,0);
            $payout_type = 0;
            $game = FALSE;
            $cards_pack = $this->new_cards_pack();

            $player_cards = $this->take_cards(2, $cards_pack);
            $banker_cards = $this->take_cards(2, $cards_pack);

            $player_score = $this->calculate_score($player_cards);
            $banker_score = $this->calculate_score($banker_cards);

            if (($player_score <= 5) AND ($banker_score < 8)) 
            {
                $player_cards[] = $this->take_cards(1, $cards_pack);
                $player_score = $this->calculate_score($player_cards);
            }

            if ($player_score < 8) 
            {
                if ($banker_score <= 2)
                {
                    $banker_cards[] = $this->take_cards(1, $cards_pack);
                    $banker_score = $this->calculate_score($banker_cards);
                } 
                elseif (($banker_score == 3) AND ((isset($player_cards[2])) AND (($player_cards[2] <= 7) OR ($player_cards[2] == 9))))
                {
                    $banker_cards[] = $this->take_cards(1, $cards_pack);
                    $banker_score = $this->calculate_score($banker_cards);
                } 
                elseif (($banker_score == 4) AND ((isset($player_cards[2])) AND (($player_cards[2] >= 2) AND ($player_cards[2] <= 7))))
                {
                    $banker_cards[] = $this->take_cards(1, $cards_pack);
                    $banker_score = $this->calculate_score($banker_cards);
                }
                elseif (($banker_score == 5) AND ((isset($player_cards[2])) AND (($player_cards[2] >= 4) AND ($player_cards[2] <= 7))))
                {
                    $banker_cards[] = $this->take_cards(1, $cards_pack);
                    $banker_score = $this->calculate_score($banker_cards);
                }
                elseif (($banker_score == 6) AND ((isset($player_cards[2])) AND (($player_cards[2] == 6) OR ($player_cards[2] == 7))))
                {
                    $banker_cards[] = $this->take_cards(1, $cards_pack);
                    $banker_score = $this->calculate_score($banker_cards);
                }
            }

            if ((($player_win_chance) AND (! $banker_win_chance)) AND (! $tie_win_chance))
            {// У игрока больше
                if ($player_score > $banker_score) 
                {
                    $payout[1] = $bets['player'] + $bets['player'];
                    $payout[3] = 0;
                    $payout[2] = 0;
                    $payout_type = 0;
                    $game = TRUE;
                }
            }
            elseif (((! $player_win_chance) AND ($banker_win_chance)) AND (! $tie_win_chance))
            {// У банкира больше
                if ($player_score < $banker_score) 
                {
                    $payout[1] = 0;
                    $payout[2] = ($bets['banker'] / 100 * 95) + $bets['banker'];
                    $payout[3] = 0;
                    $payout_type = 1;
                    $game = TRUE;
                }
            }
            elseif (((! $player_win_chance) AND (! $banker_win_chance)) AND ($tie_win_chance))
            {// Ничья
                if ($player_score == $banker_score)
                {
                    $payout[1] = $bets['player'];
                    $payout[2] = $bets['banker'];
                    $payout[3] = ($bets['tie'] * 8) + $bets['tie'];
                    $payout_type = 2;
                    $game = TRUE;
                }
            }
            else
            {// xxx
                list($player_win_chance, $banker_win_chance, $tie_win_chance) = $this->generet_chances($bank_balance);
            }

            $payout[0] = $payout[1] + $payout[2] + $payout[3];
            $total_win = $payout[0];

            if ($game)
            {
                if ($bank_balance >= $total_win)
                {
                    break;
                } 
                else 
                {
                    $game = FALSE;
                    list($player_win_chance, $banker_win_chance, $tie_win_chance) = $this->generet_chances($bank_balance);
                }
            }
        }


        
        if ($total_win < $total_bet) 
        {
            Games_Model::instance()->user_pay($total_bet);
            if (($total_win > 0) AND ($total_win < $total_bet))
            {
                $bet_profit = ($total_bet - $total_win);// * $this->game_configs['coin_size'];
            }
            else
            {
                $bet_profit = $total_bet;// * $this->game_configs['coin_size'];
            }
            
            $profit = $bet_profit * (Games_Model::instance()->profit_percent($game_id) / 100);
            Games_Model::instance()->bank_add($game_id, 'game', $total_bet - $profit);
            Games_Model::instance()->bank_add($game_id, 'profit', $profit);
        }
        elseif ($total_win >= $total_bet)
        {
            Games_Model::instance()->user_pay($total_bet);
            Games_Model::instance()->bank_add($game_id, 'game', $total_bet);
        }
        
        if ($total_win > 0)
        {
            Games_Model::instance()->user_add($total_win);
            Games_Model::instance()->bank_pay($game_id, 'game', $total_win);
        }

        $item['SCORES'] = ''.$player_score.'|'.$banker_score;
        $item['CARDS'] =  ''.implode('|', $player_cards).','.implode('|', $banker_cards);
        $item['PAYOUT'] = implode('|', $payout);
        $item['PAYOUTTYPE'] = $payout_type;// 0 - Player, 1 - Banker, 2 - Tie
    }      
    
    $this->assign('item', $item);
    $this->view();
}
//    if (($win_total_coins > 0) AND ($win_total_coins < $bet_coins))
//    {
//        $bet_profit = ($bet - $win_total) * $this->game_configs['coin_size'];
//    }
//    else
//    {
//        $bet_profit = $bet * $this->game_configs['coin_size'];
//    }
//    $profit = $bet_profit * (Games_Model::instance()->profit_percent($game_id) / 100);
//    Games_Model::instance()->bank_add($game_id, 'game', $bet_profit - $profit - $bonus);
//    Games_Model::instance()->bank_add($game_id, 'profit', $profit);
//if ($win_total != 0) 
//{
//    Games_Model::instance()->user_add($win_total);
//    Games_Model::instance()->bank_pay($game_id, 'game', $win_total);
//}     

    
                
//            if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
//            {
//                $win_chance = $this->chance($this->game_configs['win_chance']);// + Kohana::config($this->pref.'.chance_to_count_lines.'.$this->input->post('nb_lines'))
//            }
//            else
//            {
//                $win_chance = FALSE;
//            }
//            $gauge = $this->rand_gauge($this->game_configs, $win_chance);
            
                //if ((! $win_chance) AND ($win_total_coins < $bet_coins))// (! $win_total)
//                {
//                    break;
//                }
//                elseif (Gauge_Model::instance()->is_true($win_total, $gauge, $gauge_profile)
//                    AND ($win_total <= $bank_balance) )
//                {
//                    break;
//                }



    public function get_bet() 
    {
        $bets = array();
        $total_bet = 0;
        $make_bet = NULL;
        
        if ($this->input->post('ACTION', '') == 'MAKEBET')
        {
            $post_bets = explode("|", $this->input->post('BET', ''));
            if (isset($post_bets[0]) AND isset($post_bets[1]) AND isset($post_bets[2]))//??? is need this "if" ?
            {
                $make_bet = TRUE;
                $bets['player'] = intval($post_bets[0]);
                $bets['banker'] = intval($post_bets[1]);
                $bets['tie'] = intval($post_bets[2]);
            }
            
            foreach ($bets as $bet) 
            {
                $total_bet += $bet;
            }
        }
        elseif ($this->input->post('ACTION', ''))
        {
            $make_bet = FALSE;
        }

        return array($bets, $total_bet, $make_bet);
    }
    
    
    public function new_cards_pack()
    {
        $cards_pack = Kohana::config($this->pref.'.cards_pack');
        $rnd = $this->rand_chance(1, 5);
        for ($i = 0; $i <= $rnd; $i++) 
        {
            srand((float)microtime() * 1000000);
            shuffle($cards_pack);
        }
        return $cards_pack;
    }

    public function take_cards($count = 1, $cards_pack = array()) 
    {
        if ($count == 1) 
        {
            $result = 0;
            $card_key = $this->rand_chance(0, count($cards_pack) - 1);
            while (! isset($cards_pack[$card_key])) 
            {
                $card_key = $this->rand_chance(0, count($cards_pack)-1);
            }
            
            $result = $cards_pack[$card_key];
            unset($cards_pack[$card_key]);
            return $result;
        } 
        elseif ($count > 1) 
        {
            $result = array();
            for ($i = 0; $i < $count; $i++) 
            {
                $card_key = $this->rand_chance(0, count($cards_pack) - 1);
                while (! isset($cards_pack[$card_key])) 
                {
                    $card_key = $this->rand_chance(0, count($cards_pack)-1);
                }
                $result[] = $cards_pack[$card_key];
                unset($cards_pack[$card_key]);
            }
            return $result;
        } 
        else 
        {
            //trace_str("WARNING: take_cards('".$count."') - count must > 0");
            return NULL;
        }
    }

    public function calculate_score($cards)
    {
        $result = 0;
        $card_scores = Kohana::config($this->pref.'.card_scores');

        foreach ($cards as $card) 
        {
            $result += $card_scores[$card];
        }
        
        if ($result >= 10) 
        {
            $result -= 10;
        }

        return $result;
    }

    public function generet_chances($bank_balance)
    {
        $player_win_chance = FALSE;
        $banker_win_chance = FALSE;
        $tie_win_chance = FALSE;
        if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
        {
            $player_win_chance = $this->chance($this->game_configs['player_win_chance']);
            $banker_win_chance = $this->chance($this->game_configs['banker_win_chance']);
            $tie_win_chance = $this->chance($this->game_configs['tie_win_chance']);
            while (! (($player_win_chance XOR $banker_win_chance) XOR $tie_win_chance))
            {
                $player_win_chance = $this->chance($this->game_configs['player_win_chance']);
                $banker_win_chance = $this->chance($this->game_configs['banker_win_chance']);
                $tie_win_chance = $this->chance($this->game_configs['tie_win_chance']);
            }
        }

        return array($player_win_chance, $banker_win_chance, $tie_win_chance);
    }

            
            
}