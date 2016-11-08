<?php defined('SYSPATH') OR die('No direct access allowed.');

class Game_core_Controller extends Game_Controller
{	
    public $use_auth = FALSE;
    public $pref = 'slot';  


    public function get_array_gauge($config = NULL)
    {
        if (isset($config))
        {
            if (isset($config['win_coins_small']) AND ($config['win_coins_small'] != 0))
            {
                $gauges['win_coins_small'] = $config['win_coins_small'];
            }
            else 
            {
                return FALSE;
            }
            
            if (isset($config['win_coins_avg']) AND ($config['win_coins_avg'] != 0))
            {
                $gauges['win_coins_avg'] = $config['win_coins_avg'];
            }
            else 
            {
                return FALSE;
            }
            
            if (isset($config['win_coins_big']) AND ($config['win_coins_big'] != 0))
            {
                $gauges['win_coins_big'] = $config['win_coins_big'];
            }
            else 
            {
                return FALSE;
            }
            
            if (isset($config['win_coins_super']) AND ($config['win_coins_super'] != 0))
            {
                $gauges['win_coins_super'] = $config['win_coins_super'];
            }
            else 
            {
                return FALSE;
            }
            
            if (array_sum($gauges) != 100)
            {
                return FALSE;
            }
            
            asort($gauges);
            return $gauges;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function rand_gauge($config = NULL, $chance_win = FALSE, $gauge = NULL)
    {
        if (isset($config) AND $chance_win)
        {
            $gauge = (isset($gauge))? $gauge: $this->get_array_gauge($config);
            if ($gauge)
            {
                srand( ((int)((double)microtime() * 1000003)) );
                $chance_gauge = rand(1, 100);
                foreach ($gauge as $key => $value)
                {
                    if (($chance_gauge % (100/ $value)) == 0)
                    {
                        return Kohana::config($this->pref.'.gauge.'.$key);
                    }
                }
                
                return Kohana::config($this->pref.'.gauge.win_coins_small');
            }
            else 
            {
                return Kohana::config($this->pref.'.gauge.zero');
            }
        }
        else 
        {
            return Kohana::config($this->pref.'.gauge.zero');
        }
    }   
    
    public function rand_icon()
    {
        return mt_rand(Kohana::config($this->pref.'.min_icon'), Kohana::config($this->pref.'.max_icon'));
    }
    
    public function render_line($map, $line)
    {
        $lines_config = Kohana::config($this->pref.'.lines_config');
        $result = array();
        foreach ($lines_config[$line - 1] as $index) 
        {
            $result[] = $map[$index];
        }
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
                $result[]= $wheels[$real_wheel][(Session::instance()->get('wheel_'.$real_wheel.'_size', Kohana::config($this->pref.'.wheel_size.min')) - 1)];
                $result[]= $wheels[$real_wheel][$position];
                $result[]= $wheels[$real_wheel][$position + 1];
            } 
            elseif ($position == (Session::instance()->get('wheel_'.$real_wheel.'_size', Kohana::config($this->pref.'.wheel_size.min')) - 1))
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

    public function wheel_positions() 
    {
        $result = array
        (
            mt_rand(1, Session::instance()->get('wheel_1_size', Kohana::config($this->pref.'.wheel_size.min'))),
            mt_rand(1, Session::instance()->get('wheel_2_size', Kohana::config($this->pref.'.wheel_size.min'))),
            mt_rand(1, Session::instance()->get('wheel_3_size', Kohana::config($this->pref.'.wheel_size.min'))),
            mt_rand(1, Session::instance()->get('wheel_4_size', Kohana::config($this->pref.'.wheel_size.min'))),
            mt_rand(1, Session::instance()->get('wheel_5_size', Kohana::config($this->pref.'.wheel_size.min')))
        );
        return $result;
    }
 
 
 
public function test()
{
    //echo $this->rand_gauge(Games_Model::instance()->configs(1), TRUE);
    //var_dump($a = Gauge_Model::instance()->is_true(65, 1, 3));
    //print Kohana::debug($a = Games_Model::instance()->get_bank_id(1,'profit'));
    //print Kohana::debug($a = Games_Model::instance()->bank_balance(1, 'game'));
    //var_dump($a = Games_Model::instance()->is_bank(1, 'game'));
    //Games_Model::instance()->user_pay(66);
    //Games_Model::instance()->user_add(50);
    //Games_Model::instance()->bank_pay(1, 'jackpot', 2);
    //print Kohana::debug($a = Games_Model::instance()->configs(1));
    //print Kohana::debug($a = Games_Model::instance()->profit_percent(1));
    //print Kohana::debug($a = Setting_Model::instance()->get('lang_id_default'));
    
    //SLOT 25
    //echo $this->rand_gauge(Games_Model::instance()->configs(1), TRUE);
    //var_dump($a = Gauge_Model::instance()->is_true(65, 1, 3));
    //print Kohana::debug($a = Games_Model::instance()->get_bank_id(1,'profit'));
    //print Kohana::debug($a = Games_Model::instance()->bank_balance(1, 'game'));
    //var_dump($a = Games_Model::instance()->is_bank(1, 'game'));
    //Games_Model::instance()->user_pay(66);
    //Games_Model::instance()->user_add(50);
    //Games_Model::instance()->bank_pay(1, 'jackpot', 2);
    //print Kohana::debug($a = Games_Model::instance()->configs(1));
    //print Kohana::debug($a = Games_Model::instance()->profit_percent(1));
    //print Kohana::debug($a = Setting_Model::instance()->get('lang_id_default'));
    //var_dump($a = Slot_Model::instance()->isset_wheels(1));
    //print Kohana::debug($a = $this->generet_weels($a= 1));exit('<br />stop');
    //print Kohana::debug($a = Slot_Model::instance()->wheels_save($this->generet_weels($a = 1), 1));
    //print Kohana::debug($a = Slot_Model::instance()->wheels_read(1));
    //Kohana::config_set('config.display_profiler', TRUE);
    
    /*$wheels = Slot_Model::instance()->wheels_read(1);
    $generate_wheels = $this->wheel_positions();
    $map = $this->render_map($generate_wheels, $wheels);
    print Kohana::debug($map);*/
    //print Kohana::debug($a = $this->rand_icon());
    
    //SLOT_FREE
    //echo $this->rand_gauge(Games_Model::instance()->configs(1), TRUE);
    //var_dump($a = Gauge_Model::instance()->is_true(65, 1, 3));
    //print Kohana::debug($a = Games_Model::instance()->get_bank_id(1,'profit'));
    //print Kohana::debug($a = Games_Model::instance()->bank_balance(1, 'game'));
    //var_dump($a = Games_Model::instance()->is_bank(1, 'game'));
    //Games_Model::instance()->user_pay(66);
    //Games_Model::instance()->user_add(50);
    //Games_Model::instance()->bank_pay(1, 'jackpot', 2);
    //print Kohana::debug($a = Games_Model::instance()->configs(1));
    //print Kohana::debug($a = Games_Model::instance()->profit_percent(1));
    //print Kohana::debug($a = Setting_Model::instance()->get('lang_id_default'));
    //var_dump($a = Slot_Model::instance()->isset_wheels(1));
    //print Kohana::debug($a = $this->generet_weels($a= 1));exit('<br />stop');
    //print Kohana::debug($a = Slot_Model::instance()->wheels_save($this->generet_weels($a = 1), 1));
    //print Kohana::debug($a = Slot_Model::instance()->wheels_read(1));
    //Kohana::config_set('config.display_profiler', TRUE);
    
    /*$wheels = Slot_Model::instance()->wheels_read(1);
    $generate_wheels = $this->wheel_positions();
    $map = $this->render_map($generate_wheels, $wheels);
    print Kohana::debug($map);*/
    //$a = Slot_Model::instance()->get_where(1);
    
    //$a = Games_Model::instance()->get_bank_id(47, 'game');
    $a = Setting_Model::instance()->get('demo_user_balance');
    print Kohana::debug($a);
}

   
}