<?php defined('SYSPATH') OR die('No direct access allowed.');

class Roulette_Controller extends Game_core_Controller
{
    public $use_auth = FALSE;
    public $pref = 'roulette';
    
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
            $bet_data = explode('|', $this->input->post('BET', ''));
            list($total_bet, $action) = $this->get_bet($bet_data);
            $item['RESULT'] = 'OK';
            $total_win = 0;
            $total_win_coin = 0;
            $total_bet_coin = 0;
            $i = 0;
            if ($this->game_configs['coin_size'] > 0)
            {
                $total_bet_coin = $total_bet * $this->game_configs['coin_size'];
            }
        }

        if (! isset($action) AND ! $action)
        {
            $item['RESULT'] = 'BAD_BET';
        }
        elseif (! Games_Model::instance()->is_bank($game_id, FALSE))
        {
            $item['RESULT'] = 'BAD_BET';
        }
        elseif ($action == 'ENTER')
        {
            $item['BALANCE'] = $this->user_cash();
            Games_Model::instance()->user_games($game_id);
        }
        elseif ($total_bet <= 0)
        {
            $item['RESULT'] = 'BAD_BET';
        }
        elseif ($this->user_cash() < $total_bet_coin)
        {
            $item['RESULT'] = 'LOW_BALANCE';
        }
        elseif ($action == 'MAKEBET')
        {
            $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            $win_chance = ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))? $this->chance($this->game_configs['win_chance']): FALSE;
            
            while (++$i < Kohana::config($this->pref.'.limit_loop'))
            {
                list($total_win, $number) = $this->get_win($bet_data, Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider'));
                if ($this->game_configs['coin_size'] > 0)
                {
                    $total_win_coin = $total_win * $this->game_configs['coin_size'];
                }
                
                if (($total_win_coin > $total_bet_coin) AND $win_chance)
                {
                    break;
                }
                elseif (($total_win_coin < $total_bet_coin) AND ! $win_chance)
                {
                    break;
                }
            }

            
            $this->pick_cash($total_bet_coin, $game_id);
            
            if ($total_win > 0) 
            {
                Games_Model::instance()->user_add($total_win_coin);
                Games_Model::instance()->bank_pay($game_id, 'game', $total_win_coin);
                Games_Model::instance()->statistics($game_id, $total_bet_coin, $this->user_cash(), Kohana::config('game.map.main'), $total_win_coin);
            }
            else
            {
                Games_Model::instance()->statistics($game_id, $total_bet_coin, $this->user_cash());
            }
            
            $item['id'] = '5001';
            $item['JACKPOT'] = '0.00';
            $item['PAYOUT'] = $total_win_coin;
            $item['BET'] = $total_bet_coin;
            $item['NUMBER'] = $number;
            $item['BALANCE'] = $this->user_cash();
    

$this->log_str('~~~$win_chance='.($win_chance? 1: 0).'|$total_win='.$total_win.'|$total_win_coin='.$total_win_coin.'|$total_bet='.$total_bet.'|$total_bet_coin='.$total_bet_coin.'|$number='.$number.'|couis='.$this->game_configs['coin_size']);
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



    public function generate_number()
    {
        mt_srand ((double) microtime() * time() + 128);
        return mt_rand(0, 36);
    }
    
    public function get_bet($bet_data = array())
    {
        $total_bet = 0;
        if (($action = $this->input->post('ACTION', '')) == 'MAKEBET')
        {
            for ($cell = 0; $cell <= 162; $cell++) 
            {
                if ($bet_data[$cell] > 0) 
                {
                    $total_bet += $bet_data[$cell];
                }
            }
        }
        
        return array($total_bet, $action);
    }
    
    public function get_win($bet_data = array(), $bank = 0)
    {
        while (TRUE) 
        {
            $number = $this->generate_number();
            $total_win = 0;
            
            foreach (Kohana::config($this->pref.'.map.'."$number") as $cell) 
            {
                if (isset($bet_data[$cell]) AND $bet_data[$cell] > 0) 
                {
                    if (($cell >= 0) AND ($cell <= 36)) 
                    { 
                        $total_win += $bet_data[$cell] * 36; 
                    }
                    elseif (($cell >= 37) AND ($cell <= 93)) 
                    { 
                        $total_win += $bet_data[$cell] * 18; 
                    }
                    elseif (($cell >= 94) AND ($cell <= 105)) 
                    { 
                        $total_win += $bet_data[$cell] * 12; 
                    }
                    elseif (($cell >= 106) AND ($cell <= 128)) 
                    { 
                        $total_win += $bet_data[$cell] * 9; 
                    }
                    elseif (($cell >= 130) AND ($cell <= 140)) 
                    { 
                        $total_win += $bet_data[$cell] * 7; 
                    }
                    elseif (($cell >= 146) AND ($cell <= 151)) 
                    { 
                        $total_win += $bet_data[$cell] * 4; 
                    }
                    elseif (($cell >= 157) AND ($cell <= 162)) 
                    { 
                        $total_win += $bet_data[$cell] * 3; 
                    }
                }
            }

            if ($bank >= $total_win) 
            {
                return array($total_win, $number);
            }
        }
    }


    public function pick_cash($cash = 0, $game_id = 1)
    {
        $profit = $cash * (Games_Model::instance()->profit_percent($game_id) / 100);
        Games_Model::instance()->user_pay($cash);
        Games_Model::instance()->bank_add($game_id, 'game', $cash - $profit);
        Games_Model::instance()->bank_add($game_id, 'profit', $profit);
    }



}