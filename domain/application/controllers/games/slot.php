<?php defined('SYSPATH') OR die('No direct access allowed.');

class Slot_Controller extends Game_core_Controller
{
    public $pref = 'slot';
    
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
    
    public function init_game($game_id)
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
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert1');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            Games_Model::instance()->user_games($game_id);
            Session::instance()->set('current_game_id', $game_id);
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['bonus'] = Kohana::config($this->pref.'.bonus.off');
            $item['rebuild'] = Kohana::config($this->pref.'.rebuild.off');
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $this->generet_weels($item, $game_id);
        }

        $this->assign('item', $item);
        
        $this->view();
    }
    
    public function spin($game_id = NULL)
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
        
        $bet_coins = $this->input->post('nb_coins', 1) * $this->input->post('nb_lines', 1);
        $bet = $bet_coins * $this->game_configs['coin_size'];
        $gauge_profile = Slot_Model::instance()->bet_to_gauge($bet_coins);
        
        if ((! isset($this->game_configs)) OR (! Slot_Model::instance()->isset_wheels($game_id)))
        {                   
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert2');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif (($this->input->post('nb_lines', TRUE) === TRUE) OR (($this->input->post('nb_lines') < 1) OR ($this->input->post('nb_lines') > 9)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }        
        elseif (($this->input->post('nb_coins', TRUE) === TRUE) OR (($this->input->post('nb_coins') < 1) OR ($this->input->post('nb_coins') > 10)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif (($this->user_cash() < $bet) OR (! Games_Model::instance()->is_bank($game_id)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else 
        {
            $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            $bonus_bank = Games_Model::instance()->bank_balance($game_id, 'jackpot') / Kohana::config($this->pref.'.bank_part_divider_bonus');
            
            if ($bank_balance > Setting_Model::instance()->get('banking_limit_min_cash'))
            {
                $win_chance = $this->chance($this->game_configs['win_chance']);// + Kohana::config($this->pref.'.chance_to_count_lines.'.$this->input->post('nb_lines'))
            }
            else
            {
                $win_chance = FALSE;
            }
            
            if ($bonus_bank > Setting_Model::instance()->get('banking_limit_min_cash_bonus'))
            {
                $bonus_chance = $this->chance($this->game_configs['bonus_chance']);
            }
            else 
            {
                $bonus_chance = FALSE;
            }
            
            $gauge = $this->rand_gauge($this->game_configs, $win_chance);
            
            
            $lines_config = Kohana::config($this->pref.'.lines_config');
            $icon_super = Kohana::config($this->pref.'.wild_char');
            $win_by_line = Kohana::config($this->pref.'.on_line_wins_config');
            $icon_scatter = Kohana::config($this->pref.'.scatter_char');
            $scatter_dices = Kohana::config($this->pref.'.scatter_dices');
            $win_scatter = Kohana::config($this->pref.'.scatter_wins');
            $wheels = Slot_Model::instance()->wheels_read($game_id);
            $nl = 0;
            
            
$this->log_str('---S---$win_chance='.(($win_chance)? 1: 0).' $bonus_chance='.(($bonus_chance)? 1: 0).' $gauge_profile='.$gauge_profile.' $gauge='.$gauge.' $bank_balance='.$bank_balance.' $bonus_bank='.$bonus_bank.' $game_id='.$game_id.' |>config_bonus_chance='.$this->game_configs['bonus_chance'].' >config_win_chance='.$this->game_configs['win_chance']);
            
            
            
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
                
//                if ((! $win_chance) AND ($icon_finded_scatter > (Kohana::config($this->pref.'.icon_scatter_min_bonus'))))//isset($win_scatter[$icon_finded_scatter])
//                {
//                    continue;
//                }
                if ((! $bonus_chance) AND $icon_finded_scatter >= (Kohana::config($this->pref.'.icon_scatter_min_bonus')) )
                {
                    continue;
                }
                elseif ($bonus_chance AND $icon_finded_scatter <= Kohana::config($this->pref.'.icon_scatter_min_bonus'))//(! isset($win_scatter[$icon_finded_scatter])))
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
                

                for ($i = 1; $i <= $this->input->post('nb_lines'); $i++)
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
                            $win_by_lines[$i] = $this->input->post('nb_coins') * $wild;
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
                            $win_by_lines[$i] = $this->input->post('nb_coins') * $icon_prev;
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
                            $win_by_lines[$i] = $this->input->post('nb_coins') * $icon_prev;
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
                                $win_by_lines[$i] = $this->input->post('nb_coins') * $win_by_line[$icon_prev][$count_icon_repeat] * $this->game_configs['wildchar_win_multiplication'];
                            } 
                            else 
                            {
                                $win_by_lines[$i] = $this->input->post('nb_coins') * $win_by_line[$icon_prev][$count_icon_repeat];
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

                
                foreach ($win_by_lines as $line_wincoins) 
                {
                    $win_total_coins += $line_wincoins;
                }
                
                
$this->log_str('>>$win_total='.($win_total_coins * $this->game_configs['coin_size']).' $bank_balance='.$bank_balance.' $game_id='.$game_id.' start='.$nl);
                

                if ($bonus_chance AND isset($scatter_dices[$icon_finded_scatter]))
                {
                    $possible_bonus_win = Kohana::config($this->pref.'.avg_bonus_dice_win') * $scatter_dices[$icon_finded_scatter];
                    $possible_bonus_win *= $this->input->post('nb_coins') * $this->input->post('nb_lines') * $this->game_configs['coin_size'];
                    //$this->log_str('>>$possible_bonus_win = '.$possible_bonus_win.'$bonus_bank = '.$bonus_bank.'$game_id = '.$game_id.'start = '.$nl);
                }
                
                $win_total = $win_total_coins * $this->game_configs['coin_size'];
                
                if ((! $win_chance) AND ($win_total_coins < $bet_coins))// (! $win_total)
                {
                    break;
                }
                elseif (Gauge_Model::instance()->is_true($win_total, $gauge, $gauge_profile)
                    AND ($win_total <= $bank_balance) )
                {
                    break;
                }
            }
            
            $win_total_coins += $win_by_coin_scatter;
            
            
            
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
                
$this->log_str('>>>$bet_profit='.$bet_profit.' $bet='.$bet.' $win_total='.$win_total.' bonus_percent='.Games_Model::instance()->bonus_percent($game_id).' $bonus='.$bonus.' profit_percent='.Games_Model::instance()->profit_percent($game_id).' $profit='.$profit.' bank game add='.($bet_profit - $profit - $bonus));

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
            
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['betamount'] = $bet;
            $item['money_win_total'] = $win_total;
            $item['nb_coins_win_total'] = $win_total_coins;
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $item['nb_coins'] = $this->input->post('nb_coins');
            $item['nb_lines'] = $this->input->post('nb_lines');
            $item['scatter_win'] = $win_by_coin_scatter;

            for ($i = 1; $i < 10; $i++) 
            {
                if (isset($win_by_lines[$i])) 
                {
                    $item['line_'.$i.'_wincoins'] = $win_by_lines[$i];
                } 
                else 
                {
                    $item['line_'.$i.'_wincoins'] = 0;
                }
            }
            
            $item['wheel1Pos'] = $generate_wheels[0];
            $item['wheel2Pos'] = $generate_wheels[1];
            $item['wheel3Pos'] = $generate_wheels[2];
            $item['wheel4Pos'] = $generate_wheels[3];
            $item['wheel5Pos'] = $generate_wheels[4];
            $wilds_on_screen = FALSE;
            
            for ($i = 1; $i <= 15; $i++) 
            {
                if ((isset($active_wilds[$i])) AND ($active_wilds[$i])) 
                {
                    $item['active_wild'.$i] = "1";
                    $wilds_on_screen = TRUE;
                } 
                else 
                {
                    $item['active_wild'.$i] = "0";
                    $wilds_on_screen = FALSE;
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

            if (isset($scatter_dices[$icon_finded_scatter])) 
            {
                $item['bonus_game_ok'] = "1";
                $item['nb_dice_to_play'] = $scatter_dices[$icon_finded_scatter];

                Session::instance()->set('_BONUS_GAME', TRUE);
                Session::instance()->set('_BONUS_NB_WIN_COINS', 0);
                Session::instance()->set('_BONUS_NB_DICES', $scatter_dices[$icon_finded_scatter]);
                Session::instance()->set('_BONUS_NB_DICES_PLAYED', 0);
                Session::instance()->set('_BONUS_NB_POSITION', 0);
                Session::instance()->set('_BONUS_NB_COINS', $this->input->post('nb_coins'));
                Session::instance()->set('_BONUS_NB_LINES', $this->input->post('nb_lines'));
            } 
            else 
            {
                $item['bonus_game_ok'] = "0";
                $item['nb_dice_to_play'] = "0";
                Session::instance()->delete('_BONUS_GAME');
                Session::instance()->delete('_BONUS_NB_WIN_COINS');
                Session::instance()->delete('_BONUS_NB_DICES');
                Session::instance()->delete('_BONUS_NB_DICES_PLAYED');
                Session::instance()->delete('_BONUS_NB_POSITION');
                Session::instance()->delete('_BONUS_NB_COINS');
                Session::instance()->delete('_BONUS_NB_LINES');
            }
            
            if (($win_total > 0) AND ((! $wilds_on_screen) AND (! Session::instance()->get('_BONUS_GAME', FALSE)) ))
            {
                Session::instance()->set('ALLOW_DOUBLE', TRUE);
                Session::instance()->set('DOUBLE_GAME_WIN', $win_total);
                Session::instance()->set('last_bet', $bet);
                $item['double_up_ok'] = '1';
            } 
            else 
            {
                Session::instance()->delete('ALLOW_DOUBLE');
                $item['double_up_ok'] = '0';
            }
        }
        
        $this->assign('item', $item);

        $this->view();
    }
    
    
    
    public function double_up()
    {
        $this->template = 'game';
        
        $game_id = Session::instance()->get('current_game_id', NULL);
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
        }
        
        if ($this->input->post('bet_2', FALSE) AND (($this->input->post('bet_2') == "1") OR ($this->input->post('bet_2') == "2")))
        {
            $double_chance = $this->chance($this->game_configs['double_2_chance']);
            $game_mode = 2;
            $bet = $this->input->post('bet_2');
        }
        elseif ($this->input->post('bet_4', FALSE) AND ((($this->input->post('bet_4') == "1") OR ($this->input->post('bet_4') == "2")) OR (($this->input->post('bet_4') == "3") OR ($this->input->post('bet_4') == "4"))))
        {
            $double_chance = $this->chance($this->game_configs['double_4_chance']);
            $game_mode = 4;
            $bet = $this->input->post('bet_4');
        }
        else 
        {
            $game_mode = 0;
        }
        
        
        if ($game_mode == 0)
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert3');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif ((! isset($this->game_configs)) AND Session::instance()->get('ALLOW_DOUBLE', 1) === 1)
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert3');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        elseif ((Session::instance()->get('DOUBLE_GAME_WIN', TRUE) === TRUE) OR Session::instance()->get('DOUBLE_GAME_WIN') <= 0)
        {
            $item['t_alert1'] = Kohana::lang($this->pref.'.init_error.t_alert3');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $bank_balance = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            $cards = Kohana::config($this->pref.'.cards');
            $nl = 0;
            $win = 0;
            $card = 0;
            while (TRUE) 
            {
                $card = mt_rand(0, count($cards) - 1);
                $result_generet = ($game_mode == 4)? $cards[$card]['type']: $cards[$card]['color'];
                if ($result_generet == $bet)
                {
                    $win = Session::instance()->get('DOUBLE_GAME_WIN') * $game_mode;
                } 
                else 
                {
                    $win = 0;
                }
                
                $this->log_add($win.'|'.$result_generet.'|'.$bet.'{'.$game_id);
                
                if ($win <= $bank_balance AND (($double_chance AND $win != 0) OR (! $double_chance AND $win == 0) ))
                {
                    break;
                }
                elseif ($nl++ > Kohana::config($this->pref.'.repeat_max_count'))
                {
                    $win = 0;
                    //break;
                    $double_chance = FALSE;
                }
            }

            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['old_credit'] = $this->user_cash();
            $item['bonus_game_ok'] = '0';
            
            if ($win == 0) 
            {
                Games_Model::instance()->user_pay(Session::instance()->get('DOUBLE_GAME_WIN'));
                Games_Model::instance()->bank_add($game_id, 'game', Session::instance()->get('DOUBLE_GAME_WIN'));
                Games_Model::instance()->statistics($game_id, Session::instance()->get('last_bet'), $this->user_cash(), Kohana::config('game.map.double_'.$game_mode));
                
                $item['credit'] = $this->user_cash();
                $item['du_win_money'] =  '0';
                $item['card_res'] = $cards[$card]['id'];
                $item['double_up_ok'] = '0';
                Session::instance()->delete('DOUBLE_GAME_WIN');
                Session::instance()->delete('ALLOW_DOUBLE');
            } 
            else 
            {
                Games_Model::instance()->user_pay(Session::instance()->get('DOUBLE_GAME_WIN'));
                Games_Model::instance()->bank_add($game_id, 'game', Session::instance()->get('DOUBLE_GAME_WIN'));
                Games_Model::instance()->user_add($win);
                Games_Model::instance()->bank_pay($game_id, 'game', $win);
                
                $item['credit'] = $this->user_cash();
                $item['du_win_money'] = $win;
                $item['card_res'] = $cards[$card]['id'];
                $item['double_up_ok'] = '1';
                Games_Model::instance()->statistics($game_id, Session::instance()->get('last_bet'), $this->user_cash(), Kohana::config('game.map.double_'.$game_mode), $win);
                Session::instance()->set('ALLOW_DOUBLE', TRUE);
                Session::instance()->set('DOUBLE_GAME_WIN', $win);
            }
        }
        
$this->log_str('<<DOUBLE>>$double_chance = '.(($double_chance)?1:0).'$game_mode = '.$game_mode.'$bet = '.$bet.'$win = '.$win.'$game_id = '.$game_id.'Session::DOUBLE_GAME_WIN = '.Session::instance()->get('DOUBLE_GAME_WIN'));

        
        $this->assign('item', $item);
        
        $this->view();
    }
    
    public function bonus_game()
    {
        $this->template = 'game';
        
        $game_id = Session::instance()->get('current_game_id', NULL);
        
        if (! isset($game_id))
        {
            $item['t_alert1'] = Kohana::lang('games.error.not_isset_game_id');
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
        }
        
        /*
        Session::instance()->set('_BONUS_GAME', TRUE);
        Session::instance()->set('_BONUS_NB_DICES', 5);
        Session::instance()->set('_BONUS_NB_COINS', 1);
        Session::instance()->set('_BONUS_NB_LINES', 1);*/
        
        if (! isset($this->game_configs))
        {
            //print Kohana::debug($this->game_configs);
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        elseif ((Session::instance()->get('_BONUS_GAME', 1) === 1) OR (! Session::instance()->get('_BONUS_GAME')))
        {
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        elseif ((Session::instance()->get('_BONUS_NB_DICES', TRUE) === TRUE) OR (Session::instance()->get('_BONUS_NB_DICES') < 0))
        {
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        elseif ((Session::instance()->get('_BONUS_NB_COINS', TRUE) === TRUE) OR (Session::instance()->get('_BONUS_NB_COINS') <= 0))
        {
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        elseif ((Session::instance()->get('_BONUS_NB_LINES', TRUE) === TRUE) OR (Session::instance()->get('_BONUS_NB_LINES') <= 0))
        {
            $item['error'] = Kohana::config($this->pref.'.error.two');
        }
        else
        {
            $bonus_map = Kohana::config($this->pref.'.bonus_map');
            $val_dice = 0;
            $win_dice = 0;

            while (TRUE)
            {
                $val_dice = mt_rand(Kohana::config($this->pref.'.dice_min'), Kohana::config($this->pref.'.dice_max'));
                $new_pos = $val_dice + Session::instance()->get('_BONUS_NB_POSITION', 0);
                
                $win_dice = $bonus_map[$new_pos]; //* Session::instance()->get('_BONUS_NB_COINS') * Session::instance()->get('_BONUS_NB_LINES')
                $bank_balance = Games_Model::instance()->bank_balance($game_id, 'jackpot') / Kohana::config($this->pref.'.bank_part_divider_bonus');
                
                if (($win_dice * $this->game_configs['coin_size']) < $bank_balance)
                {
                    Session::instance()->set('_BONUS_NB_DICES_PLAYED', Session::instance()->get('_BONUS_NB_DICES_PLAYED') + 1);
                    if (Session::instance()->get('_BONUS_NB_DICES_PLAYED') < Session::instance()->get('_BONUS_NB_DICES'))
                    {
                        if ((Session::instance()->get('_BONUS_NB_DICES') - Session::instance()->get('_BONUS_NB_DICES_PLAYED')) * Kohana::config($this->pref.'.avg_bonus_dice_win') < $bank_balance)# На всякий случай проверим чтоб хватало денег продолжать крутить бонусы.
                        {
                            break;
                        }
                    } 
                    else 
                    {
                        break;
                    }
                }
            }
            
            Session::instance()->set('_BONUS_NB_POSITION', $new_pos);
            Session::instance()->set('_BONUS_NB_WIN_COINS', $win_dice + Session::instance()->get('_BONUS_NB_WIN_COINS'));
            
            Games_Model::instance()->user_add($win_dice * $this->game_configs['coin_size']);
            Games_Model::instance()->bank_pay($game_id, 'jackpot', $win_dice * $this->game_configs['coin_size']);
            Games_Model::instance()->statistics($game_id, 0, $this->user_cash(), Kohana::config('game.map.bonus'), $win_dice * $this->game_configs['coin_size']);

            if (Session::instance()->get('_BONUS_NB_DICES') <= Session::instance()->get('_BONUS_NB_DICES_PLAYED'))
            {
                Session::instance()->set('_BONUS_GAME', FALSE);
            }

            $item['double_up_ok'] = '0';
            $item['error'] = Kohana::config($this->pref.'.error.off');
            $item['nb_dice_to_play'] = Session::instance()->get('_BONUS_NB_DICES');# Всего бросков
            $item['current_dice_played'] = Session::instance()->get('_BONUS_NB_DICES_PLAYED');# Сделано бросков
            $item['val_dice'] = $val_dice;# Число на кубике
            $item['pos_dice'] = Session::instance()->get('_BONUS_NB_POSITION');# Позиция на карте
            $item['win_dice'] = $win_dice;# Выигрыш в монетах с позиции

            # Всего выиграно денег за бонус
            $item['coins_win_cumul_bonus'] = Session::instance()->get('_BONUS_NB_WIN_COINS');  # в монетах
            $item['money_win_cumul_bonus'] = Session::instance()->get('_BONUS_NB_WIN_COINS') * $this->game_configs['coin_size'];  # в лавешках
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            $item['nb_coins'] = Session::instance()->get('_BONUS_NB_COINS');
            $item['nb_lines'] = Session::instance()->get('_BONUS_NB_LINES');

            if (Session::instance()->get('_BONUS_GAME', FALSE))# Если 1, то играем. Если 0 то конец бонусу.
            {
                $item['bonus_game_ok'] = "1";
            } 
            else 
            {
                $item['bonus_game_ok'] = "0";
                Session::instance()->delete('_BONUS_GAME');
                Session::instance()->delete('_BONUS_NB_WIN_COINS');
                Session::instance()->delete('_BONUS_NB_DICES');
                Session::instance()->delete('_BONUS_NB_DICES_PLAYED');
                Session::instance()->delete('_BONUS_NB_POSITION');
                Session::instance()->delete('_BONUS_NB_COINS');
                Session::instance()->delete('_BONUS_NB_LINES');
            }

        }
        
        $this->assign('item', $item);

        $this->view();
    }
    
    private function generet_weels(&$item, $game_id = 1)
    {
        $array = array();
        for ($wheel = 1; $wheel <= 5; $wheel++) 
        {
            $array['wheels'][$wheel] = array();
            $array['wheel_'.$wheel.'_size'] = mt_rand(Kohana::config($this->pref.'.wheel_size.min'), Kohana::config($this->pref.'.wheel_size.max'));
            Session::instance()->set('wheel_'.$wheel.'_size', $array['wheel_'.$wheel.'_size']);
            $item['wheel'.$wheel.'size'] = $array['wheel_'.$wheel.'_size'];
            $item['wheel'.$wheel.'Pos'] = mt_rand(1, $array['wheel_'.$wheel.'_size']);
            
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



}