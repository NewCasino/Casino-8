<?php defined('SYSPATH') OR die('No direct access allowed.');

class Slot_free_Controller extends Game_core_Controller
{
    public $pref = 'slot_free';
    
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
        //Session::instance()->set('GAME_NAME', $this->game_configs['game_name']);
    }


    
    public function init_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        else
        {
            $this->initialization($game_id);
            $item = Kohana::lang($this->pref.'.init');
        }

        if ((! isset($this->game_configs)) AND (! Games_Model::instance()->is_bank($game_id)))
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert_inner');
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        else
        {
            Games_Model::instance()->user_games($game_id);
            if ($this->game_configs['wildchar_win_multiplication'] == 1)
            {
                $item = array_merge($item, Kohana::lang($this->pref.'.wild_icon_win_multiplication.1'));
            }
            elseif ($this->game_configs['wildchar_win_multiplication'] == 2) 
            {
                $item = array_merge($item, Kohana::lang($this->pref.'.wild_icon_win_multiplication.2'));
            }
            elseif ($this->game_configs['wildchar_win_multiplication'] == 3)
            {
                $item = array_merge($item, Kohana::lang($this->pref.'.wild_icon_win_multiplication.3'));
            }
            else
            {
                foreach (Kohana::lang($this->pref.'.wild_icon_win_multiplication.0') as $key => $value)//НЕНАХОДИТ МАССИВ, выяснить причину
                {
                    $item[$key] = Kohana::lang($this->pref.'.wild_icon_win_multiplication.0.'.$key, $this->game_configs['wildchar_win_multiplication']);
                }
            }
            
            if ($this->game_configs['onfree_win_multiplication'] == 1)
            {
                $item['t_payoutsx3'] = Kohana::lang($this->pref.'.onfree_win_multiplication.1');
            }
            elseif ($this->game_configs['onfree_win_multiplication'] == 2)
            {
                $item['t_payoutsx3'] = Kohana::lang($this->pref.'.onfree_win_multiplication.2');
            }
            elseif ($this->game_configs['onfree_win_multiplication'] == 3)
            {
                $item['t_payoutsx3'] = Kohana::lang($this->pref.'.onfree_win_multiplication.3');
            }
            else
            {
                $item['t_payoutsx3'] = Kohana::lang($this->pref.'.onfree_win_multiplication.0', $this->game_configs['onfree_win_multiplication']);
            }
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['mode_free'] = Kohana::config($this->pref.'.mode_free');
            $item['nb_gratuit_to_play'] = Kohana::config($this->pref.'.nb_gratuit_to_play');
            $item['nb_gratuit_played'] = Kohana::config($this->pref.'.nb_gratuit_played');
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $this->generet_weels($game_id);
            $this->generet_icon($item);
        }
        
        $this->assign('item', $item);
        
        $this->view();
    }
    
    
    
    public function spin_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        else
        {
            $this->initialization($game_id);
        }
        
        $nb_coins = $this->input->post('nb_coins', 1);
        $nb_lines = $this->input->post('nb_lines', 1);
        
        if ($this->is_free_game())
        {
            $nb_coins = Session::instance()->get('freegames_nb_coins');
            $nb_lines = Session::instance()->get('freegames_nb_lines');
        }
        elseif (($this->input->post('nb_lines', TRUE) === TRUE) OR (($nb_lines < 1) OR ($nb_lines > 9)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }        
        elseif (($this->input->post('nb_coins', TRUE) === TRUE) OR (($nb_coins < 1) OR ($nb_coins > 10)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
  
        $bet_coins = $nb_coins * $nb_lines;
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
            $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            if ($bank_balance < Setting_Model::instance()->get('banking_limit_min_cash'))
            {
                $win_chance = FALSE;
                $bonus_chance = FALSE;
            }
            elseif ($this->is_free_game())
            {
                if($win_chance = $this->chance($this->game_configs['onfree_win_chance']))
                {
                    $bonus_chance = $this->chance($this->game_configs['onfree_free_game_chance']);
                }
                else
                {
                    $bonus_chance = FALSE;
                }
            }
            else 
            {
                if ($win_chance = $this->chance($this->game_configs['win_chance']))// + Kohana::config($this->pref.'.chance_to_count_lines.'.$nb_lines)
                {
                    $bonus_chance = $this->chance($this->game_configs['free_game_chance']);// + Kohana::config($this->pref.'.chance_to_count_lines.'.$nb_lines)
                }
                else
                {
                    $bonus_chance = FALSE;
                }
            }
            
            $gauge = $this->rand_gauge($this->game_configs, $win_chance);
            
            
            $lines_config = Kohana::config($this->pref.'.lines_config');
            $icon_super = Kohana::config($this->pref.'.wild_char');
            $win_by_line = Kohana::config($this->pref.'.on_line_wins_config');
            $icon_scatter = Kohana::config($this->pref.'.scatter_char');
            $scatter_dices = Kohana::config($this->pref.'.scatter_free_game');
            $win_scatter = Kohana::config($this->pref.'.scatter_wins');
            $wheels = Slot_Model::instance()->wheels_read($game_id);
            $nl = 0;
            
            
$this->log_str('---$win_chance = '.(($win_chance)? 1: 0).' $bonus_chance = '.(($bonus_chance)? 1: 0).' $gauge = '.$gauge.' $bank_balance = '.$bank_balance.' $game_id = '.$game_id.' start = '.$nl);

            
            while (TRUE) 
            {
                $generate_wheels = $this->wheel_positions();
                $map = $this->render_map($generate_wheels, $wheels);
                $win_by_lines = array();
                $icon_win_by_lines = array();
                $active_wilds = array();
                $win_by_coin_scatter = 0;
                $win_total_coins = 0;
                $win_total = 0;
                
                $icon_finded_scatter = 0;
                foreach ($map as $icon) 
                {
                    if ($icon == $icon_scatter) 
                    {
                        $icon_finded_scatter++;
                    }
                }
                
                if ((! $bonus_chance) AND $icon_finded_scatter >= (Kohana::config($this->pref.'.icon_scatter_min_bonus')) )
                {
                    continue;
                }
                elseif ($bonus_chance AND (! isset($win_scatter[$icon_finded_scatter])))
                {
                    continue;
                }
                elseif ($icon_finded_scatter > Kohana::config($this->pref.'.icon_scatter_max'))
                {
                    $icon_finded_scatter = Kohana::config($this->pref.'.icon_scatter_max');
                }
                elseif ($nl++ > Kohana::config($this->pref.'.repeat_max_count'))
                {
                    $win_chance = FALSE;
                    $bonus_chance = FALSE;
                }
                
                if (isset($win_scatter[$icon_finded_scatter]))
                {
                    $win_by_coin_scatter = $win_scatter[$icon_finded_scatter] * $bet_coins;
                }
                
                for ($i = 1; $i <= $nb_lines; $i++)
                {
                    $line = $this->render_line($map, $i);
                    $icon_win_by_lines[$i] = "ppppp";
                    $icon_super_total = 0;
                    $icon_prev = 0;
                    $count_icon_repeat = 0;
                    $double_exist = FALSE;
                    $in_combo = TRUE;
                    
                    foreach ($line as $icon_current)
                    {
                        if ($count_icon_repeat == 0)
                        {
                            $icon_prev = $icon_current;
                            $count_icon_repeat++;
                            
                            if ($icon_current == $icon_super) 
                            {
                                $icon_super_total++;
                            }
                        } 
                        elseif ($in_combo) 
                        {
                            if ($icon_prev == $icon_super) 
                            {
                                if ($icon_current == $icon_super) 
                                {
                                    $icon_super_total++;
                                    $count_icon_repeat++;
                                } 
                                else 
                                {
                                    $icon_prev = $icon_current;
                                    $count_icon_repeat++;
                                    $double_exist = TRUE;
                                }
                            } 
                            elseif ($icon_prev == $icon_current) 
                            {
                                $count_icon_repeat++;
                            } 
                            elseif ($icon_current == $icon_super) 
                            {
                                $count_icon_repeat++;
                                $double_exist = TRUE;
                            } 
                            else 
                            {
                                $in_combo = FALSE;
                            }
                        }
                    }

                    if ($icon_super_total > 0) 
                    {
                        $icon_super_total = ($icon_super_total == 1)? 2: $icon_super_total; 
                        if ($win_by_line[$icon_super][$icon_super_total]) 
                        {
                            $wild = $win_by_line[$icon_super][$icon_super_total];
                        } 
                        else 
                        {
                            $wild = 0;
                        }

                        if (isset($win_by_line[$icon_prev][$count_icon_repeat])) 
                        {   
                            $icon_prev = $win_by_line[$icon_prev][$count_icon_repeat] * $this->game_configs['wildchar_win_multiplication'];# потому что присутствие вилда удваевает выигрыш с линии
                        } 
                        else 
                        {
                            $icon_prev = 0;
                        }

                        if ($wild > $icon_prev) 
                        {
                            $win_by_lines[$i] = $nb_coins * $wild;
                            $icon_win_by_lines[$i] = "";
                            for ($x = 1; $x < 6; $x++) 
                            {
                                if ($x <= $icon_super_total) 
                                {
                                    $icon_win_by_lines[$i] .= "x";
                                    if ($line[$x-1] == $icon_super) 
                                    {
                                        $map_pos = $lines_config[$i - 1][$x - 1];
                                        $active_wilds[$map_pos + 1] = TRUE;
                                    }
                                } 
                                else 
                                {
                                    $icon_win_by_lines[$i] .= "p";
                                }
                            }
                        } 
                        elseif ($icon_prev > $wild) 
                        {
                            $win_by_lines[$i] = $nb_coins * $icon_prev;
                            $icon_win_by_lines[$i] = "";
                            
                            for ($x = 1; $x < 6; $x++) 
                            {
                                if ($x <= $count_icon_repeat) 
                                {
                                    $icon_win_by_lines[$i] .= "x";
                                    if ($line[$x - 1] == $icon_super) 
                                    {
                                        $map_pos = $lines_config[$i - 1][$x - 1];
                                        $active_wilds[$map_pos + 1] = TRUE;
                                    }
                                } 
                                else 
                                {
                                    $icon_win_by_lines[$i] .= "p";
                                }
                            }
                        } 
                        elseif ($icon_prev == $wild) 
                        {
                            $win_by_lines[$i] = $nb_coins * $icon_prev;
                            $icon_win_by_lines[$i] = "";
                            for ($x = 1; $x < 6; $x++) 
                            {
                                if ($x <= $count_icon_repeat) 
                                {
                                    $icon_win_by_lines[$i] .= "x";
                                    if ($line[$x-1] == $icon_super) 
                                    {
                                        $map_pos = $lines_config[$i - 1][$x - 1];
                                        $active_wilds[$map_pos + 1] = TRUE;
                                    }
                                } 
                                else 
                                {
                                    $icon_win_by_lines[$i] .= "p";
                                }
                            }
                        } 
                        else 
                        {
                            $win_by_lines[$i] = 0;
                            $icon_win_by_lines[$i] = "ppppp";
                        }
                    } 
                    else 
                    {
                        if (isset($win_by_line[$icon_prev][$count_icon_repeat])) 
                        {
                            if ($double_exist) 
                            {
                                $win_by_lines[$i] = $nb_coins * $win_by_line[$icon_prev][$count_icon_repeat] * $this->game_configs['wildchar_win_multiplication'];
                            } 
                            else 
                            {
                                $win_by_lines[$i] = $nb_coins * $win_by_line[$icon_prev][$count_icon_repeat];
                            }

                            $icon_win_by_lines[$i] = "";
                            for ($x = 1; $x < 6; $x++) 
                            {
                                if ($x <= $count_icon_repeat) 
                                {
                                    $icon_win_by_lines[$i] .= "x";
                                    if ($line[$x-1] == $icon_super) 
                                    {
                                        $map_pos = $lines_config[$i - 1][$x - 1];
                                        $active_wilds[$map_pos + 1] = TRUE;
                                    }
                                } 
                                else 
                                {
                                    $icon_win_by_lines[$i] .= "p";
                                }
                            }
                        } 
                        else 
                        {
                            $win_by_lines[$i] = 0;
                            $icon_win_by_lines[$i] = "ppppp";
                        }
                    }
                }

                $win_total_coins = $win_by_coin_scatter;
                foreach ($win_by_lines as $line_wincoins) 
                {
                    $win_total_coins += $line_wincoins;
                }
                
                if ($this->is_free_game())
                {
                    $win_total_coins *= $this->game_configs['onfree_win_multiplication'];
                }

                $win_total = $win_total_coins * $this->game_configs['coin_size'];
                
                
$this->log_str('->$win_total ='.$win_total.' $win_total_coins='.$win_total_coins.' $win_by_coin_scatter='.$win_by_coin_scatter.' $gauge_is_true = '.((Gauge_Model::instance()->is_true($win_total, $gauge, $gauge_profile))? 1: 0).' $game_id = '.$game_id.' start = '.$nl);
                
                
                if ((! $win_chance) AND (! $win_total))
                {
                    break;
                }
                elseif (Gauge_Model::instance()->is_true($win_total, $gauge, $gauge_profile) AND ($win_total <= $bank_balance))
                {
                    break;
                }
            }
            
            
            
            if ($this->is_free_game())
            {
                if ($win_total_coins > 0)
                {
                    Games_Model::instance()->bank_pay($game_id, 'jackpot', $win_total);
                    Games_Model::instance()->user_add($win_total);
                    Games_Model::instance()->statistics($game_id, 0, $this->user_cash(), Kohana::config('game.map.free'), $win_total);
                }
            }
            else
            {
                if ($win_total_coins >= $bet_coins)
                {
                    Games_Model::instance()->user_pay($bet);
                    Games_Model::instance()->bank_add($game_id, 'game', $bet);
$this->log_str('>>bank| $bet ='.$bet.' $game_id ='.$game_id);
                } 
                else
                {
                    Games_Model::instance()->user_pay($bet);
                    
                    if (($win_total_coins > 0) AND ($win_total_coins < $bet_coins))
                    {
                        $bet_profit = ($bet - $win_total); //* $this->game_configs['coin_size'];
                    }
                    else
                    {
                        $bet_profit = $bet; //* $this->game_configs['coin_size'];
                    }
                    
                    $bonus = $bet_profit * (Games_Model::instance()->bonus_percent($game_id) / 100);
                    $profit = $bet_profit * (Games_Model::instance()->profit_percent($game_id) / 100);
                    Games_Model::instance()->bank_add($game_id, 'game', $bet_profit - $profit - $bonus);
                    Games_Model::instance()->bank_add($game_id, 'profit', $profit);
                    Games_Model::instance()->bank_add($game_id, 'jackpot', $bonus);
                    
                    
$this->log_str('>>bank| $bet_profit ='.$bet_profit.' $bonus ='.$bonus.' $profit ='.$profit.' game ='.($bet_profit - $profit - $bonus).' $game_id ='.$game_id);
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
            }
            
            for ($i = 1; $i < 10; $i++) 
            {
                if (isset($win_by_lines[$i])) 
                {
                    $item['line_win'.$i] = $win_by_lines[$i];
                } 
                else 
                {
                    $item['line_win'.$i] = 0;
                }
            }
            
            for ($i = 1; $i <= 15; $i++) 
            {
                if ((isset($active_wilds[$i])) AND ($active_wilds[$i])) 
                {
                    $item['active_wild'.$i] = "1";
                } 
                else 
                {
                    $item['active_wild'.$i] = "0";
                }
            }
            
            for ($i = 1; $i <= 9; $i++) 
            {
                if (isset($icon_win_by_lines[$i])) 
                {
                    $item['line_'.$i.'_nbsymbwin'] = $icon_win_by_lines[$i];
                } 
                else 
                {
                    $item['line_'.$i.'_nbsymbwin'] = "ppppp";
                }
            }
            
            foreach ($map as $position => $value) 
            {
                $p = $position + 1;
                $item['symb'.$p] = $value;
            }
            
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['betamount'] = $bet;
            $item['total_win'] = $win_total;
            $item['total_coins_win'] = $win_total_coins;
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $item['nb_coins'] = $nb_coins;
            $item['nb_lines'] = $nb_lines;
            $item['scatter_win'] = $win_by_coin_scatter;

            if ((isset($scatter_dices[$icon_finded_scatter])) AND (! $this->is_free_game())) # Типа мы тока начали # Ща я буду зарабатывать все деньги мира, для любимой тигры! # Боже, как же меня прет
            {
                Session::instance()->set('freegames', TRUE);
                Session::instance()->set('freegames_win_total', 0);
                Session::instance()->set('freegames_nb_coins', $nb_coins);
                Session::instance()->set('freegames_nb_lines', $nb_lines);
                Session::instance()->set('freegames_times', $scatter_dices[$icon_finded_scatter]);
                Session::instance()->set('freegames_times_played', 0);

                $item['total_win_free'] = Session::instance()->get('freegames_win_total');

                $item['mode_free_begin'] = '1';
                $item['mode_free'] = '1';

                $item['nb_gratuit_to_play'] = Session::instance()->get('freegames_times');
                $item['nb_gratuit_played'] = Session::instance()->get('freegames_times_played');
            } 
            elseif (Session::instance()->get('freegames', FALSE))# Продолжаем веселье
            {
                if (isset($scatter_dices[$icon_finded_scatter])) 
                {
                    Session::instance()->set('freegames_times', $scatter_dices[$icon_finded_scatter] + Session::instance()->get('freegames_times'));
                }

                if (Session::instance()->get('freegames_times', 0) > 0) 
                {
                    Session::instance()->set('freegames_win_total', $win_total + Session::instance()->get('freegames_win_total'));
                    Session::instance()->set('freegames_times', Session::instance()->get('freegames_times') - 1);
                    Session::instance()->set('freegames_times_played', Session::instance()->get('freegames_times_played') + 1);

                    $item['total_win_free'] = Session::instance()->get('freegames_win_total');

                    if (Session::instance()->get('freegames_times', 0) > 0) 
                    {
                        $item['mode_free_begin'] = '0';
                        $item['mode_free'] = '1';
                    } 
                    else 
                    {
                        $item['mode_free_begin'] = '0';
                        $item['mode_free'] = '0';
                        Session::instance()->set('freegames', FALSE);
                    }

                    $item['nb_gratuit_to_play'] = Session::instance()->get('freegames_times');
                    $item['nb_gratuit_played'] = Session::instance()->get('freegames_times_played');
                } 
                else 
                {
                    Session::instance()->set('freegames', FALSE);
                    $item['total_win_free'] = Session::instance()->get('freegames_win_total');
                    $item['mode_free_begin'] = '0';
                    $item['mode_free'] = '0';
                    $item['nb_gratuit_to_play'] = Session::instance()->get('freegames_times');
                    $item['nb_gratuit_played'] = Session::instance()->get('freegames_times_played');
                    Session::instance()->set('freegames_win_total', 0);
                    Session::instance()->set('freegames_times', 0);
                    Session::instance()->set('freegames_times_played', 0);
                    Session::instance()->delete('freegames_nb_coins');
                    Session::instance()->delete('freegames_nb_lines');
                }
            } 
            else 
            {
                $item['total_win_free'] = '0';
                $item['mode_free_begin'] = '0';
                $item['mode_free'] = '0';
                $item['nb_gratuit_to_play'] = '0';
                $item['nb_gratuit_played'] = '0';
            }
        }
        
        $this->assign('item', $item);

        $this->view();
    }
    
    
    public function wheel_positions() 
    {
        $result = array
        (
            mt_rand(1, Kohana::config($this->pref.'.wheel_size')),
            mt_rand(1, Kohana::config($this->pref.'.wheel_size')),
            mt_rand(1, Kohana::config($this->pref.'.wheel_size')),
            mt_rand(1, Kohana::config($this->pref.'.wheel_size')),
            mt_rand(1, Kohana::config($this->pref.'.wheel_size'))
        );
        return $result;
    }
    
    
    public function render_map($positions = array(), $wheels = array())
    {
        $result = array();
        foreach ($positions as $wheel => $position)
        {
            $position -= 1;//array begin with 0
            $real_wheel = $wheel + 1;
            if ($position == 0) //MIN value array ->>> 0
            {
                $result[]= $wheels[$real_wheel][Kohana::config($this->pref.'.wheel_size') - 1];
                $result[]= $wheels[$real_wheel][$position];
                $result[]= $wheels[$real_wheel][$position + 1];
            } 
            elseif ($position == (Kohana::config($this->pref.'.wheel_size') - 1))
            {
                $result[] = $wheels[$real_wheel][$position - 1];
                $result[] = $wheels[$real_wheel][$position];
                $result[] = $wheels[$real_wheel][1];
            } 
            else 
            {
                $result[] = $wheels[$real_wheel][$position - 1];
                $result[] = $wheels[$real_wheel][$position];
                $result[] = $wheels[$real_wheel][$position + 1];
            }
        }
        
        return $result;
    }
    
    public function generet_weels($game_id = 1)
    {
        $array = array();
        for ($wheel = 1; $wheel <= 5; $wheel++) 
        {
            $array['wheels'][$wheel] = array();
            for ($icon = 1; $icon <= Kohana::config($this->pref.'.wheel_size'); $icon++) 
            {
                $array['wheels'][$wheel][$icon] = $this->rand_icon();
                if ($icon != 1)
                {
                    while ($array['wheels'][$wheel][$icon] == $array['wheels'][$wheel][$icon - 1])
                    {
                        $array['wheels'][$wheel][$icon] = $this->rand_icon();
                    }
                }
            }
        }
        
        Slot_Model::instance()->wheels_save($array['wheels'], $game_id);
        return TRUE;
    }
    
    public function generet_icon(&$item)
    {
        for ($i = 1; $i <= Kohana::config($this->pref.'.max_symb'); $i++)
        {
            $item['symb'.$i] = $this->rand_icon();
        }
    }
    
    public function is_free_game()
    {
        if (Session::instance()->get('freegames', FALSE) AND (Session::instance()->get('freegames_times', 0) > 0))
        {
$this->log_str('_free=1|session_coins='.Session::instance()->get('freegames_nb_coins').'|session_lines='.Session::instance()->get('freegames_nb_lines'));
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }


}