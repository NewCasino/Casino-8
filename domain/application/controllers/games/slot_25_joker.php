<?php defined('SYSPATH') OR die('No direct access allowed.');

class Slot_25_joker_Controller extends Game_core_Controller//Base_Controller
{
    public $pref = 'slot_25_joker';
    
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
        //Session::instance()->set('game_name', $this->game_configs['game_name']);
    }


    
    public function init_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
            $item = Kohana::lang($this->pref.'.init');
        }

        if ((! isset($this->game_configs)) AND (! Games_Model::instance()->is_bank($game_id)))
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert_inner');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            Games_Model::instance()->user_games($game_id);
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $item['session_jeu'] = Kohana::config($this->pref.'.session_jeu');
            $this->generet_weels($item, $game_id);
            Session::instance()->set('bonus_game_1', FALSE);
            Session::instance()->set('bonus_game_1_started', FALSE);
            Session::instance()->set('icons', Kohana::config($this->pref.'.icons'));
        }
        
        $this->assign('item', $item);
        
        $this->view();
    }
    
    
public function spin_game($game_id = NULL)
{
    $this->template = 'game';
    
    if (! isset($game_id))
    {
        $item['t_alert2'] = Kohana::lang('games.error.not_isset_game_id');
        $item['error'] = Kohana::config($this->pref.'.error.two');
    }
    else
    {
        $this->initialization($game_id);
    }
    
    if (($this->input->post('nb_lines', TRUE) === TRUE) OR (($this->input->post('nb_lines', 1) < 1) OR ($this->input->post('nb_lines', 1) > 25)))
    {
        $item['error'] = Kohana::config($this->pref.'.error.on');
    }        
    elseif (($this->input->post('nb_coins', TRUE) === TRUE) OR (($this->input->post('nb_coins', 1) < 1) OR ($this->input->post('nb_coins', 1) > 10)))
    {
        $item['error'] = Kohana::config($this->pref.'.error.on');
    }

    Session::instance()->set('nb_coins', $this->input->post('nb_coins', 1));
    Session::instance()->set('nb_lines', $this->input->post('nb_lines', 1));
    $bet_coins = $this->input->post('nb_coins', 1) * $this->input->post('nb_lines', 1);
    $bet = $bet_coins * $this->game_configs['coin_size'];
    $gauge_profile = Slot_Model::instance()->bet_to_gauge($bet_coins);
    
    if (isset($item) OR (! isset($this->game_configs)) OR (! Slot_Model::instance()->isset_wheels($game_id)))
    {                   
        $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert2');
        $item['error'] = Kohana::config($this->pref.'.error.on');
    }
    elseif (($this->user_cash() < $bet) OR (! Games_Model::instance()->is_bank($game_id)))
    {
        $item['error'] = Kohana::config($this->pref.'.error.on');
    }
    else 
    {
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_devider_game');
        list($win_chance, $must_bonus1, $must_bonus2) = $this->generet_chances($bank_balance, Games_Model::instance()->bank_balance($game_id, 'jackpot') / Kohana::config($this->pref.'.bank_part_devider_bonus'));
        $gauge = $this->rand_gauge($this->game_configs, $win_chance);
        
        $bonus1_char = Kohana::config($this->pref.'.bonus1_char');
        $bonus2_char = Kohana::config($this->pref.'.bonus2_char');
        $joker_char = Kohana::config($this->pref.'.joker_char');
        $joker_replace = Kohana::config($this->pref.'.joker_replace');
        $win_by_line = Kohana::config($this->pref.'.on_line_wins_config');
        $wheels = Slot_Model::instance()->wheels_read($game_id);
        $nl = 0;
        $c = 0;
        
        

$this->log_str('---$win_chance = '.(($win_chance)? 1: 0).' $must_bonus1 = '.(($must_bonus1)? 1: 0).' $must_bonus2 = '.(($must_bonus2)? 1: 0).' $gauge = '.$gauge.' $gauge_profile='.$gauge_profile.' $bank_balance = '.$bank_balance.'$gauge_profile = '.$gauge_profile.' $game_id = '.$game_id.' start = '.$nl);
        
        
        
        while (TRUE) 
        {
            $generate_wheels = $this->wheel_positions();
            $map = $this->render_map($generate_wheels, $wheels);
            
            $win = FALSE;
            $win_total_coins = 0;
            $bonus1_start = FALSE;
            $bonus1_line = 0;
            $bonus2_start = FALSE;
            $bonus2_count_icon = 0;
            $joker_2 = FALSE;
            $joker_4 = FALSE;

//___Bonus 2
            foreach ($map as $char)
            {
                if ($char == $bonus2_char) 
                {
                    $bonus2_count_icon++;
                    if ($bonus2_count_icon >= 3) 
                    {
                        $bonus2_start = TRUE;
                    }
                }
            }
            
            if ($must_bonus2 AND ! $bonus2_start)
            {
                continue;
            }
            elseif (! $must_bonus2 AND $bonus2_start)
            {
                continue;
            }
            elseif ($nl > Kohana::config($this->pref.'.repeat_max_count'))
            {
                $win_chance = FALSE;
                $must_bonus1 = FALSE;
                $must_bonus2 = FALSE;
            }
//___Bonus 1
            for ($i = 1; $i <= $this->input->post('nb_lines', 1); $i++) 
            {
                $line = $this->render_line($map, $i);
                if ($line[0] == $bonus1_char AND $line[1] == $bonus1_char AND $line[2] == $bonus1_char AND $line[3] == $bonus1_char AND $line[4] == $bonus1_char)
                {
                    $bonus1_start = TRUE;
                    $bonus1_line = $i;
                }
            }
            
            if ($must_bonus1 AND ! $bonus1_start)
            {
                continue;
            }
            elseif (! $must_bonus1 AND $bonus1_start)
            {
                continue;
            }
            
          

            if (($map[3] == $joker_char) OR (($map[4] == $joker_char) OR ($map[5] == $joker_char))) 
            {
                $joker_2 = TRUE;
            }

            if (($map[9] == $joker_char) OR (($map[10] == $joker_char) OR ($map[11] == $joker_char))) 
            {
                $joker_4 = TRUE;
            }

            
            for ($i=1; $i <= $this->input->post('nb_lines', 1); $i++) 
            {
                $line = $this->render_line($map, $i);

                $left = 0;
                $left_char = '';
                $left_display = '';

                if (((($line[0] == $line[1]) OR (($joker_2) AND (array_search($line[0], $joker_replace) !== FALSE)))
                    AND (($line[0] == $line[2]) AND (($line[0] == $line[3]) OR (($joker_4) 
                    AND (array_search($line[0], $joker_replace) !== FALSE))) ))  AND ($line[0] == $line[4])) 
                {
                    $left = 5;
                    $left_char = $line[0];
                    $left_display = $line[0].$line[0].$line[0].$line[0].$line[0];
                    if ($left_char == $bonus1_char) 
                    {
                        if ($must_bonus1 AND ! $bonus1_start)
                        {
                            continue;
                        }
                        elseif (! $must_bonus1 AND $bonus1_start)
                        {
                            continue;
                        }
            
                        $bonus1_start = TRUE;
                        $bonus1_line = $i;
                    }
                } 
                elseif ((($line[0] == $line[1]) OR (($joker_2) AND (array_search($line[0], $joker_replace) !== FALSE))) 
                    AND (($line[0] == $line[2]) AND (($line[0] == $line[3]) OR (($joker_4) AND (array_search($line[0], $joker_replace) !== FALSE))))) 
                {
                    $left = 4;
                    $left_char = $line[0];
                    $left_display = $line[0].$line[0].$line[0].$line[0].'0';
                } 
                elseif ((($line[0] == $line[1]) OR (($joker_2) AND (array_search($line[0], $joker_replace) !== FALSE)))
                    AND ($line[0] == $line[2])) 
                {
                    $left = 3;
                    $left_char = $line[0];
                    $left_display = $line[0].$line[0].$line[0].'00';
                } 
                elseif (($line[0] == $line[1]) OR (($joker_2) AND (array_search($line[0], $joker_replace) !== FALSE))) 
                {
                    $left = 2;
                    $left_char = $line[0];
                    $left_display = $line[0].$line[0].'000';
                } 
                else 
                {
                    $left = FALSE;
                    $left_display = "00000";
                }


                if (! isset($win_by_line[$left_char][$left])) 
                {
                    $left = FALSE;
                    $left_char = '';
                    $left_display = '00000';
                }

                $right = 0;
                $right_char = '';
                $right_display = '';

                if (((($line[4] == $line[3]) OR (($joker_4) 
                    AND (array_search($line[4], $joker_replace) !== FALSE))) 
                    AND (($line[4] == $line[2]) AND (($line[4] == $line[1]) OR (($joker_2) 
                    AND (array_search($line[4], $joker_replace) !== FALSE))))) 
                    AND ($line[4] == $line[0])) 
                {
                    $right = 5;
                    $right_char = $line[4];
                    $right_display = $line[4].$line[4].$line[4].$line[4].$line[4];
                } 
                elseif ((($line[4] == $line[3]) 
                    OR (($joker_4) AND (array_search($line[4], $joker_replace) !== FALSE))) 
                     AND (($line[4] == $line[2]) AND (($line[4] == $line[1]) 
                     OR (($joker_2) AND (array_search($line[4], $joker_replace) !== FALSE))))) 
                {
                    $right = 4;
                    $right_char = $line[4];
                    $right_display = '0'.$line[4].$line[4].$line[4].$line[4];
                } 
                elseif ((($line[4]==$line[3]) OR (($joker_4) AND (array_search($line[4], $joker_replace) !== FALSE))) AND ($line[4]==$line[2])) 
                {
                    $right = 3;
                    $right_char = $line[4];
                    $right_display = '00'.$line[4].$line[4].$line[4];
                } 
                elseif (($line[4] == $line[3]) OR (($joker_4) AND (array_search($line[4], $joker_replace) !== FALSE))) 
                {
                    $right = 2;
                    $right_char = $line[4];
                    $right_display = '000'.$line[4].$line[4];
                } 
                else 
                {
                    $right = FALSE;
                    $right_display = '';
                }

                if (! isset($win_by_line[$right_char][$right])) 
                {
                    $right = FALSE;
                    $right_char = '';
                    $right_display = '00000';
                }

                if (($right !== FALSE) AND ($left === FALSE)) 
                {
                    $win_lines[$i] = $this->input->post('nb_coins', 1) * $win_by_line[$right_char][$right];
                    $display_lines[$i] = $right_display;
                } 
                elseif (($right === FALSE) AND ($left !== FALSE)) 
                {
                    $win_lines[$i] = $this->input->post('nb_coins', 1) * $win_by_line[$left_char][$left];
                    $display_lines[$i] = $left_display;
                } 
                elseif (($right !== FALSE) AND ($left !== FALSE)) 
                {
                    if ($win_by_line[$left_char][$left] > $win_by_line[$right_char][$right]) 
                    {
                        $win_lines[$i] = $this->input->post('nb_coins', 1) * $win_by_line[$left_char][$left];
                        $display_lines[$i] = $left_display;
                    } 
                    elseif ($win_by_line[$left_char][$left] < $win_by_line[$right_char][$right]) 
                    {
                        $win_lines[$i] = $this->input->post('nb_coins', 1) * $win_by_line[$right_char][$right];
                        $display_lines[$i] = $right_display;
                    } 
                    else 
                    {
                        $win_lines[$i] = $this->input->post('nb_coins', 1) * $win_by_line[$left_char][$left];
                        $display_lines[$i] = $left_display;
                    }
                } 
                else 
                {
                    $win_lines[$i] = 0;
                    $display_lines[$i] = '00000';
                }
                
                $win_total_coins += $win_lines[$i];
            }

            $win_total = $win_total_coins * $this->game_configs['coin_size'];
                
                
                
$this->log_str('>>$win_total = '.$win_total.' $game_id = '.$game_id.' $gauge_is_true = '.((Gauge_Model::instance()->is_true($win_total, $gauge, $this->input->post('nb_coins', 1)))? 1: 0).' start = '.++$nl);
            
            
            
            if ((! $win_chance) AND ($win_total_coins < $bet_coins))
            {
                break;
            }
            elseif (Gauge_Model::instance()->is_true($win_total, $gauge, $gauge_profile) AND ($win_total <= $bank_balance))
            {
                break;
            }
                

            //$c++;
            //if ($c%20 == 0) 
            //{
            //    list($win_chance, $must_bonus1, $must_bonus2) = $this->generet_chances($bank_balance);
            //}                
        }
        
        
        
        
//------------------------------------------------------------------------------
//        
        
        
        if ($win_total_coins >= $bet_coins) 
        {
            Games_Model::instance()->user_pay($bet);
            Games_Model::instance()->bank_add($game_id, 'game', $bet);
        } 
        else
        {
            Games_Model::instance()->user_pay($bet);
            
            if (($win_total_coins > 0) AND ($win_total_coins < $bet_coins)) 
            {
                $bet_profit = ($bet - $win_total);// * $this->game_configs['coin_size'];
            } 
            else 
            {
                $bet_profit = $bet; //* $this->game_configs['coin_size'];
            }
            
            //$bonus2 = $bet_profit * (Games_Model::instance()->bonus_percent($game_id) / 100);
            $bonus1 = $bet_profit * (Games_Model::instance()->bonus_percent($game_id) / 100);
            $profit = $bet_profit * (Games_Model::instance()->profit_percent($game_id) / 100);
            Games_Model::instance()->bank_add($game_id, 'game', $bet - $profit - $bonus1);// - $bonus2
            Games_Model::instance()->bank_add($game_id, 'profit', $profit);
            Games_Model::instance()->bank_add($game_id, 'jackpot', $bonus1);//bonus1
            //Games_Model::instance()->bank_add($game_id, 'jackpot', $bonus2);//bonus2
        }
        

        if ($win_total != 0) 
        {
            Games_Model::instance()->user_add($win_total);
            Games_Model::instance()->bank_pay($game_id, 'game', $win_total);
            Games_Model::instance()->statistics($game_id, $bet, $this->user_cash(), Kohana::config('game.map.main'), $win_total);
        }
        else
        {
            Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
        }

        //$bonus1_start = TRUE;
        //$bonus1_line = 1;
        //$bonus2_count_icon = 1;
        
        if ($bonus1_start) 
        {
            $item['bonus_1'] = 1;
            $item['bonus_1_line'] = $bonus1_line;
            Session::instance()->set('bonus_game_1', TRUE);
        } 
        else 
        {
            Session::instance()->set('bonus_game_1', FALSE);
            $item['bonus_1'] = 0;
            $item['bonus_1_line'] = 0;
        }

        if ($bonus2_start) 
        {
            $item['bonus_2'] = 1;
            Session::instance()->set('bonus_game_2', TRUE);
            Session::instance()->set('bonus_game_2_chars_count', $bonus2_count_icon);
        } 
        else 
        {
            $item['bonus_2'] = 0;
        }

        $item['credit'] = $this->user_cash();
        $item['coinsize'] = $this->game_configs['coin_size'];
        $item['session_jeu'] = $this->input->post('session_jeu');
        $item['error'] = 0;
        $item['wheelsize1'] = Session::instance()->get('wheel_1_size', Kohana::config($this->pref.'.wheel_size.min'));
        $item['wheelpos1'] = $generate_wheels[0];
        $item['wheelsize2'] = Session::instance()->get('wheel_2_size', Kohana::config($this->pref.'.wheel_size.min'));
        $item['wheelpos2'] = $generate_wheels[1];
        $item['wheelsize3'] = Session::instance()->get('wheel_3_size', Kohana::config($this->pref.'.wheel_size.min'));
        $item['wheelpos3'] = $generate_wheels[2];
        $item['wheelsize4'] = Session::instance()->get('wheel_4_size', Kohana::config($this->pref.'.wheel_size.min'));
        $item['wheelpos4'] = $generate_wheels[3];
        $item['wheelsize5'] = Session::instance()->get('wheel_5_size', Kohana::config($this->pref.'.wheel_size.min'));
        $item['wheelpos5'] = $generate_wheels[4];

        if ($joker_2) 
        {
            $item['wild_2'] = 1;
        } 
        else 
        {
            $item['wild_2'] = 0;
        }

        if ($joker_4) 
        {
            $item['wild_4'] = 1;
        } 
        else 
        {
            $item['wild_4'] = 0;
        }

        for ($i = 1; $i <= 25; $i++) 
        {
            if (isset($win_lines[$i])) 
            {
                $item['win_line_'.$i] = $win_lines[$i];
                $item['display_line_'.$i] = $display_lines[$i];
            } 
            else 
            {
                $item['win_line_'.$i] = '0';
                $item['display_line_'.$i] = '00000';
            }
        }

        $item['total_win_money'] = $win_total;
        $item['total_win_coins'] = $win_total_coins;

    }
    
    $this->assign('item', $item);

    $this->view();
}

    public function bonus_1_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
        }
        
Session::instance()->set('bonus_game_1', TRUE);

        if ((! isset($this->game_configs)) AND (! Games_Model::instance()->is_bank($game_id)))
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert_inner');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif (! Session::instance()->get('bonus_game_1', FALSE))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif ($this->input->post('choix_case', 0) < 1 OR $this->input->post('choix_case', 0) > 24)
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        
        if (! Session::instance()->get('bonus_game_1_started', FALSE))
        {
            Session::instance()->set('bonus_game_1_started', TRUE);
            $bonus_map = Kohana::config($this->pref.'.bonus1_map');
            Session::instance()->delete('bonus1_selected');
            Session::instance()->set('bonus1_selected', array());
            shuffle($bonus_map);
            Session::instance()->set('bonus1_map', $bonus_map);

$this->log_str('---Bonus_start_> nb_coins ='.Session::instance()->get('nb_coins', 99).' bonus1_map='.Kohana::debug($bonus_map));
        }
        
        
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'jackpot') / Kohana::config($this->pref.'.bank_part_devider_bonus');
        if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
        {
            $win_result = mt_rand(10, 100);
        }
        else
        {
            $win_result = mt_rand(10, 25);
        }
        
        $prom = Session::instance()->get('bonus1_selected');
        $prom[] = array
        (
            'pos' => $this->input->post('choix_case'),
            'type' => Session::instance()->get('bonus1_map.'.$this->input->post('choix_case'), 1),
            'amount' => $win_result
        );
        Session::instance()->set('bonus1_selected', $prom);

$this->log_str('__add new el|$prom='.Kohana::debug($prom));
        
        
        $item['error'] = '0';
        $item['session_jeu'] = '69225457';

        $allwin = 0;
        $counts = array(0,0,0,0,0,0,0);
        $king = FALSE;
        $end = FALSE;
        $winchar = 0;

        foreach (Session::instance()->get('bonus1_selected') as $index => $turn)
        {
            $index++;
            $item['case_pos_'.$index] = $turn['pos'];
            $item['case_type_'.$index] = $turn['type'];
            $item['case_amount_'.$index] = $turn['amount'];
            $counts[$turn['type']]++;

            if ($turn['type'] == 5) 
            {
                $king = FALSE;
            }
            
            if ($counts[$turn['type']] == 3)
            {
                $end = TRUE;
                $winchar = $turn['type'];
            }
        }

        if ($end) 
        {
            $c = 0;
            $winall = 0;
            foreach (Session::instance()->get('bonus1_selected') as $turn) 
            {
                if ($counts[$turn['type']] == 3) 
                {
                    $c++;
                    $winall += $turn['amount'];
                    $item['pos_win_case_'.$c] = $turn['pos'];
                }
            }
            
            if ($king) 
            {
                $item['pos_win_case_double'] = '1';
                $winall *= 2;
            } 
            else 
            {
                $item['pos_win_case_double'] = '0';
            }
            
            $winall_coins = $winall * Session::instance()->get('nb_coins', 1);
            $winall_money = $winall_coins * $this->game_configs['coin_size'];
            Games_Model::instance()->bank_pay($game_id, 'jackpot', $winall_money);
            Games_Model::instance()->user_add($winall_money);
            Games_Model::instance()->statistics($game_id, 0, $this->user_cash(), Kohana::config('game.map.bonus_1'), $winall_money);
            $item['bonus1_win_coins'] = $winall_coins;
            $item['bonus1_win_money'] = $winall_money;
            $item['bonus1_winning_comment'] = 'You win : '.$winall." x "
                .Session::instance()->get('nb_coins', 1).' (coins bet) = '.$winall_coins
                .' coins = '.$winall_money;
            $item['end_bonus'] = '1';
            Session::instance()->set('bonus_game_1_started', FALSE);
            Session::instance()->delete('bonus_game_1');
            Session::instance()->delete('bonus1_selected');
        } 
        else 
        {
            $item['end_bonus'] = '0';
        }

        $item['credit'] = $this->user_cash();
        $this->assign('item', $item);
        $this->view();
    }
    
    public function bonus_2_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
            //$item = Kohana::lang($this->pref.'.init');
        }

        if (! isset($this->game_configs))
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert_inner');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }

        $win_config = Kohana::config($this->pref.'.bonus2_win_config');
        
        switch (Session::instance()->get('bonus_game_2_chars_count', 1))
        {
            case 3:
                $mult = 1;
                break;

            case 4:
                $mult = 2;
                break;

            case 5:
                $mult = 3;
                break;
            
            default:
                $mult = 1;
                break;
        }

        $repeat = 0;
        $win = 0;
        $result = 0;
        $win_coins = 0;
        $win_money = 0;
        $bank_balance = Games_Model::instance()->bank_balance($game_id, 'jackpot') / Kohana::config($this->pref.'.bank_part_devider_bonus');
        
        while(TRUE) 
        {
            $result = mt_rand(1, 5);
            $win = $win_config[$result] * $mult;
            $win_coins = $win * Session::instance()->get('nb_coins', 1) * Session::instance()->get('nb_lines', 1);
            $win_money = $win_coins * $this->game_configs['coin_size'];

            if ($bank_balance >= $win_money) 
            {
                break;
            }
            
            if ($repeat++ > (Kohana::config($this->pref.'.repeat_max_count') + 100))
            {
                break;
            }
        }
        
        Games_Model::instance()->bank_pay($game_id, 'jackpot', $win_money);
        Games_Model::instance()->user_add($win_money);
        Games_Model::instance()->statistics($game_id, 0, $this->user_cash(), Kohana::config('game.map.bonus_2'), $win_money);

        $item['credit'] = $this->user_cash();
        $item['error'] = '0';
        $item['session_jeu'] = '';
        $item['nb_scatter'] = Session::instance()->get('bonus_game_2_chars_count');

        Session::instance()->set('bonus_game_2_chars_count', 0);
        $item['bonus2_result'] = $result;
        $item['bonus2_win_coins'] = $win_coins;
        $item['bonus2_win_money'] = $win_money;
        $item['bonus2_winning_comment'] = 'You win : '.$win.' x '
            .Session::instance()->get('nb_coins', 1).' (coins bet) x '
            .Session::instance()->get('nb_lines').' (lines bet) = '.$win_coins.' coins = '.$win_money;
        
        
        $this->assign('item', $item);
        $this->view();
    }    
    
    private function generet_weels(&$item, $game_id = 1)
    {
        $array = array();
        for ($wheel = 1; $wheel <= 5; $wheel++) 
        {
            $array['wheels'][$wheel] = array();
            $array['wheel_'.$wheel.'_size'] = mt_rand(Kohana::config('slot.wheel_size.min'), Kohana::config('slot.wheel_size.max'));
            Session::instance()->set('wheel_'.$wheel.'_size', $array['wheel_'.$wheel.'_size']);
            $item['wheelsize'.$wheel] = $array['wheel_'.$wheel.'_size'];
            $item['wheelpos'.$wheel] = mt_rand(1, $array['wheel_'.$wheel.'_size']);
            
            for ($icon = 1; $icon <= $array['wheel_'.$wheel.'_size']; $icon++) 
            {
                $array['wheels'][$wheel][$icon] = $this->rand_icon();
                if ($icon != 1)
                {
                    while ($array['wheels'][$wheel][$icon] == $array['wheels'][$wheel][$icon - 1])
                    {
                        $array['wheels'][$wheel][$icon] = $this->rand_icon();
                    }
                }
                $item['wheel'.$wheel.'_'.$icon] = $array['wheels'][$wheel][$icon];
            }
        }
        
        Slot_Model::instance()->wheels_save($array['wheels'], $game_id);
        return TRUE;
    }
    
    public function rand_icon()
    {
        return  Kohana::config($this->pref.'.icons.'.mt_rand(0, Kohana::config($this->pref.'.icons_count')));
    }
    
    public function generet_chances($bank_balance, $bonus_bank)
    {
        if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
        {
            $must_bonus1 = $this->chance($this->game_configs['bonus1_chance']);
            if ($must_bonus1)
            {
                $win_chance = FALSE;
                $must_bonus2 = FALSE;
            }
            else
            {
                $win_chance = $this->chance($this->game_configs['win_chance']);
                $must_bonus2 = $this->chance($this->game_configs['bonus2_chance']);
            }
        }
        else
        {
            $must_bonus1 = FALSE;
            $win_chance = FALSE;
            $must_bonus2 = $this->chance($this->game_configs['bonus2_chance']);
        }
        
        $this->log_str('__chance='.(($win_chance)?1:0). ' b1='.(($must_bonus1)?1:0). ' b2='.(($must_bonus2)?1:0));
        
        return array($win_chance, $must_bonus1, $must_bonus2);
    }
    
    public function render_line($map, $line)
    {
        $lines_config = Kohana::config($this->pref.'.lines_config');
        $result = array();
        foreach ($lines_config[$line] as $index) 
        {
            $result[] = $map[$index - 1];
        }
        return $result;
    }


}