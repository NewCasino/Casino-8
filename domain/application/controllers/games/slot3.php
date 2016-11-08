<?php defined('SYSPATH') OR die('No direct access allowed.');

class Slot3_Controller extends Base_Controller
{
    public $pref = 'slot3';
    
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
    
    public function init_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
            $item = Kohana::lang($this->pref.'.init');
        }

        if ((! isset($this->game_configs)) AND (! Games_Model::instance()->is_bank($game_id, FALSE)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.bank');
        }
        else
        {
            Games_Model::instance()->user_games($game_id);
            $item['credit'] = $this->user_cash();
            $item['coinsize'] = $this->game_configs['coin_size'];
            Session::instance()->delete('map');
        }

        $this->assign('item', $item);
        
        $this->view();
    }
    
    public function spin_game($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
            $item['Transfert_OK'] = '1';
            $must_hold = FALSE;
        }
        
        $item['credit'] = $this->user_cash();
        
        
        if (! isset($this->game_configs) OR (! Games_Model::instance()->is_bank($game_id, FALSE)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.bank');
        }
        elseif ($this->input->post('coins', TRUE) === TRUE)
        {
            $item['error'] = Kohana::config($this->pref.'.error.coins');
        }
        elseif ($this->input->post('coins') != 1 AND $this->input->post('coins') != 2)
        {
            $item['error'] = Kohana::config($this->pref.'.error.coins');
        }
        elseif ((! $bet = $this->input->post('coins', 1) * $this->game_configs['coin_size']) OR ($this->user_cash() < $bet))
        {
            $item['error'] = Kohana::config($this->pref.'.error.user');
            $item['Transfert_OK'] = 0;
        }
        else
        {
            if ($this->input->post('coins') == 1)# Проверим сколько монеток кинул человек # Если одна монета то второй раз вращать уже нельзя))) # А если две, то нужно будет холдить и перевращать барабаны)
            {
                $must_hold = FALSE;
            }
            else
            {
                $must_hold = TRUE;
            }

            $bank = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            if ($bank > Setting_Model::instance()->get('banking_limit_min_cash'))
            {
                $win_chance = $this->chance($this->game_configs['win_chance']);
            }
            else
            {
                $win_chance = FALSE;
            }
            
Kohana::log('error','---S1--$win_chance = '.(($win_chance)?1:0).'$bank = '.$bank.'$game_id = '.$game_id);
            
            $wild_icon = Kohana::config($this->pref.'.super_icon');
            $win_maps = Kohana::config($this->pref.'.win_maps');

            switch ($this->game_configs['mode']) 
            {
                default:
                case 1:
                    $avalible = Kohana::config($this->pref.'.profile_config.full');
                    break;

                case 2:
                    $avalible = Kohana::config($this->pref.'.profile_config.small');
                    break;

                case 3:
                    $avalible = Kohana::config($this->pref.'.profile_config.small_avg');
                    break;

                case 4:
                    $avalible = Kohana::config($this->pref.'.profile_config.avg_big');
                    break;

                case 5:
                    $avalible = Kohana::config($this->pref.'.profile_config.big');
                    break;

                case 6:
                    $avalible = Kohana::config($this->pref.'.profile_config.super');
                    break;
            }

            for ($i=0; $i < 50; $i++) 
            {
                $map = $this->generate_map($avalible);
                $win = $this->calculate_win($map, $win_maps, $wild_icon) * $this->game_configs['coin_size'];
                
Kohana::log('error','>>s1$map = '.$map[0].'|'.$map[1].'|'.$map[2].'$win = '.$win.'$game_id='.$game_id.'start='.$i);Kohana::log_save();

                if (($win <= $bank) AND ( ($win_chance AND $win != 0) OR (! $win_chance AND $win == 0) ))
                {
                    break;
                }
            }
            
            
            if ($must_hold) 
            {
                Session::instance()->delete('avalible');
                Session::instance()->delete('map');
                Session::instance()->set('map', $map);
                Session::instance()->set('avalible', $avalible);
            }
            else//! $must_hold
            {
                $win_total = $win * $this->game_configs['coin_size'];
                if ($win_total > 0)
                {
                    Games_Model::instance()->user_pay($bet);#Снимаем ставку
                    Games_Model::instance()->bank_add($game_id, 'game', $bet);
                    #Добавляем выигрыш
                    Games_Model::instance()->user_add($win_total);
                    Games_Model::instance()->bank_pay($game_id, 'game', $win_total);
                    Games_Model::instance()->statistics($game_id, $bet, $this->user_cash(), Kohana::config('game.map.main'), $win_total);
                }
                else
                {
                    Games_Model::instance()->user_pay($bet);#Снимаем ставку
                    $profit = $bet / 100;
                    $profit = $profit * Games_Model::instance()->profit_percent($game_id);
                    Games_Model::instance()->bank_add($game_id, 'game', $bet - $profit);
                    Games_Model::instance()->bank_add($game_id, 'profit', $profit);
                    Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
                }
            }

            # Расположение Символов на экране
            # 1 4 7
            # 2 5 8
            # 3 6 9
            if ($map[0] == 0)# Первый барабан
            {
                $item['symb1'] = mt_rand(1, 7);
                $item['symb2'] = 0;
                $item['symb3'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb1'] = '0';
                $item['symb2'] = $map[0];
                $item['symb3'] = '0';
            }

            if ($map[1] == 0)# Второй барабан
            {
                $item['symb4'] = mt_rand(1, 7);
                $item['symb5'] = '0';
                $item['symb6'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb4'] = '0';
                $item['symb5'] = $map[1];
                $item['symb6'] = '0';
            }

            if ($map[2] == 0) # Третий барабан
            {
                $item['symb7'] = mt_rand(1, 7);
                $item['symb8'] = '0';
                $item['symb9'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb7'] = '0';
                $item['symb8'] = $map[2];
                $item['symb9'] = '0';
            }

            # Кстати, эта флешка требует чтоб все изменённые параметры сбрасывались каждый ход из PHP
            # Если от пользователя требуются ешо действия, то выигрыш сегодня не выводим, выводим завтра)))
            if ($must_hold) 
            {
                $item['allow_hold'] = '1'; # Зато разрешаем перевращать барабан
                $item['win1'] = '0';
                $item['totalwin'] = '0';
            }
            else
            {
                $item['win1'] = $win;
                $item['totalwin'] = $win_total;
                $item['allow_hold'] = '0';
            }
            
            $item['win2'] = '0';
            $item['betamount'] = '0';
            $item['credit'] = $this->user_cash();
            //$item['data_ok'] = 'true';
        }

        
        $this->assign('item', $item);
        
        //echo '&symb1=0&symb2=1&symb3=0&symb4=0&symb5=1&symb6=0&symb7=0&symb8=1&symb9=0&win1=4&totalwin=4&allow_hold=0&win2=0&betamount=0&credit=13102&Transfert_OK=1';
        //exit;
        
        $this->view();
    }
    
    public function spin_game2($game_id = NULL)
    {
        $this->template = 'game';
        
        if (! isset($game_id))
        {
            $item['error'] = Kohana::config($this->pref.'.error.on');
        }
        else
        {
            $this->initialization($game_id);
            $map = Session::instance()->get('map', FALSE);
        }
        
        
        if (! isset($this->game_configs) OR (! Games_Model::instance()->is_bank($game_id, FALSE)))
        {
            $item['error'] = Kohana::config($this->pref.'.error.bank');
        }
        elseif ($this->input->post('hold1', FALSE) === FALSE OR $this->input->post('hold2', FALSE) === FALSE AND $this->input->post('hold3', FALSE) === FALSE)
        {
            $item['error'] = Kohana::config($this->pref.'.error.user');
        }
        elseif (! isset($map) AND ! is_array($map))
        {
            $item['error'] = Kohana::config($this->pref.'.error.user');
        }
        else
        {
            $win_maps = Kohana::config($this->pref.'.win_maps');
            $wild_icon = Kohana::config($this->pref.'.super_icon');
            $bank = Games_Model::instance()->bank_balance($game_id, 'game') / Kohana::config($this->pref.'.bank_part_divider');
            if ($bank > Setting_Model::instance()->get('banking_limit_min_cash'))
            {
                $win_chance = $this->chance($this->game_configs['win_chance']);
            }
            else
            {
                $win_chance = FALSE;
            }
            
            if ($this->input->post('hold1', 0) == 1 AND $this->input->post('hold2', 0) == 1 AND $this->input->post('hold3', 0) == 1)
            {
                $win_chance = TRUE;
            }
            
            
Kohana::log('error','---S2--$win_chance = '.(($win_chance)?1:0).'$bank = '.$bank.'$game_id = '.$game_id);


            for ($i = 0; $i < 100; $i++) # Если 1, то остановлен.
            {
                if ($this->input->post('hold1', 0) == 0) # Генерация первого барабана
                {
                    $map[0] = $this->generate_bar(Session::instance()->get('avalible', 1));
                }

                if ($this->input->post('hold2', 0) == 0)# Генерация второго барабана
                {
                    $map[1] = $this->generate_bar(Session::instance()->get('avalible', 1));
                }

                if ($this->input->post('hold3', 0) == 0)# Генерация третьего барабана
                {
                    $map[2] = $this->generate_bar(Session::instance()->get('avalible', 1));
                }

                # Расчет выигрыша
                $win = $this->calculate_win($map, $win_maps, $wild_icon);
                $win_total = $win * $this->game_configs['coin_size'];
                
Kohana::log('error','>>s2$map = '.$map[0].'|'.$map[1].'|'.$map[2].'$win_total = '.$win_total.'$game_id='.$game_id.'start='.$i);Kohana::log_save();

                if (($win_total <= $bank) AND ( ($win_chance AND $win != 0) OR (! $win_chance AND $win == 0) ))
                {
                    break;
                }
            }

            $bet = 2 * $this->game_configs['coin_size'];
            $win_total = $win * $this->game_configs['coin_size'];

            if ($win_total > 0)
            {
                Games_Model::instance()->user_pay($bet);#Снимаем ставку
                Games_Model::instance()->bank_add($game_id, 'game', $bet);
                #Добавляем выигрыш
                Games_Model::instance()->user_add($win_total);
                Games_Model::instance()->bank_pay($game_id, 'game', $win_total);
                Games_Model::instance()->statistics($game_id, $bet, $this->user_cash(), Kohana::config('game.map.main'), $win_total);
            }
            else
            {
                Games_Model::instance()->user_pay($bet);#Снимаем ставку
                $profit = $bet / 100;
                $profit = $profit * Games_Model::instance()->profit_percent($game_id);
                Games_Model::instance()->bank_add($game_id, 'game', $bet - $profit);
                Games_Model::instance()->bank_add($game_id, 'profit', $profit);
                Games_Model::instance()->statistics($game_id, $bet, $this->user_cash());
            }

            # Расположение Символов на экране
            # 1 4 7
            # 2 5 8
            # 3 6 9

            if ($map[0] == 0) # Первый барабан
            {
                $item['symb1'] = mt_rand(1, 7);
                $item['symb2'] = '0';
                $item['symb3'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb1'] = '0';
                $item['symb2'] = $map[0];
                $item['symb3'] = '0';
            }

            if ($map[1] == 0) # Второй барабан
            {
                $item['symb4'] = mt_rand(1, 7);
                $item['symb5'] = '0';
                $item['symb6'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb4'] = '0';
                $item['symb5'] = $map[1];
                $item['symb6'] = '0';
            }

            if ($map[2] == 0)# Третий барабан
            {
                $item['symb7'] = mt_rand(1, 7);
                $item['symb8'] = '0';
                $item['symb9'] = mt_rand(1, 7);
            }
            else
            {
                $item['symb7'] = '0';
                $item['symb8'] = $map[2];
                $item['symb9'] = '0';
            }

            # Вывод выигрыша
            $item['win2'] = $win;
            $item['totalwin'] = $win_total;
            $item['allow_hold'] = '0';
            $item['data_ok'] = 'true';
            $item['credit'] = $this->user_cash();   
        }
        
        $this->assign('item', $item);

        $this->view();
    }

    private function calculate_win($map, $win_maps, $wild_icon)
    {
        if (is_array($map)) 
        {
            foreach ($win_maps as $win) 
            {
                $first = FALSE;
                $third = FALSE;
                $second = FALSE;
                
                if ((array_search($map[0], $win['icons']) !== FALSE) OR ($map[0] == $wild_icon)) 
                {
                    $first = TRUE;
                }
                if ((array_search($map[1], $win['icons']) !== FALSE) OR ($map[1] == $wild_icon)) 
                {
                    $second = TRUE;
                }
                if ((array_search($map[2], $win['icons']) !== FALSE) OR ($map[2] == $wild_icon)) 
                {
                    $third = TRUE;
                }

                if (($first) AND (($second) AND ($third))) 
                {
                    return $win['wins'];
                }
            }
            
            return 0.00;
        } 
        else 
        {
            return FALSE;
        }
    }

    private function generate_map($avalible) # Генерация варрианта из колоды
    {
        $result = array(0, 0, 0);# Результат

        for ($i = mt_rand(0, 8); $i < 10; $i++) # Перетряхивание колоды
        {
            shuffle($avalible);
        }

        # Вытаскивание динамических символов
        $result[0] = $avalible[mt_rand(0, count($avalible)-1)];
        $result[1] = $avalible[mt_rand(0, count($avalible)-1)];
        $result[2] = $avalible[mt_rand(0, count($avalible)-1)];

        return $result;
    }

    private function generate_bar($avalible) # Генерация одного символа из колоды
    {
        $result = 0;
        for ($i = mt_rand(0, 8); $i < 10; $i++) # Перетряхивание колоды
        {
            shuffle($avalible);
        }

        $result = $avalible[mt_rand(0, count($avalible) - 1)];# Вытаскивание динамического символа

        return $result;
    }
    
    private function user_cash()
    {
        return Auth::instance()->logged_in()
            ? Gamer_Model::instance()->find_by('id', $this->user_id)->cash
            : Session::instance()->get('demo_user_balance', 0);
    }
    
    private function chance($max = NULL)
    {
        $result = 0;
        if (is_null($max)) 
        {
            $max = Kohana::config('slot.chance_default_max');
        } 
        else 
        {
            $max = intval($max);
        }

        $result = $this->rand_chance(1, $max);
        if ($result == 1) 
        {
            return TRUE;
        } 
        else 
        {
            return FALSE;
        }
    }
    
    private function rand_chance($min = 1, $max = NULL)
    {
        mt_srand();
        if (is_null($max)) 
        {
            $max = Kohana::config('slot.chance_default_max');
        }
        
        return mt_rand($min, $max);
    }

    
public function test()
{
    //$avalible = Kohana::config($this->pref.'.profile_config.full');
    //$a = $this->generate_map($avalible);
    //Slot_Model::instance()->map_save($a, 2);
    //$map = Slot_Model::instance()->map_read(2);
    
    
    $wild_icon = Kohana::config($this->pref.'.super_icon');
    $win_maps = Kohana::config($this->pref.'.win_maps');
    $map = array(4,5,4);
    //print Kohana::debug($wild_icon);
    //print Kohana::debug($win_maps);
    $am = $this->calculate_win($map, $win_maps, $wild_icon);
    print Kohana::debug($am);
}


}