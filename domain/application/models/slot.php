<?php defined('SYSPATH') OR die('No direct access allowed.');

class Slot_Model extends Model 
{
    public function __construct()
    {
		parent::__construct();
    }

    public static function instance()
    {
		static $instance;
	        
		if ($instance === NULL)
		{        
	        $instance = new self;
		}
		
		return $instance;
	}
	   

    public function wheels_save($wheels = NULL, $game_id = NULL)
    {
        if (isset($wheels) AND isset($game_id))
        {
            $insert = $this->get_where($game_id);
            $insert['w1'] = join(',', $wheels[1]);
            $insert['w2'] = join(',', $wheels[2]);
            $insert['w3'] = join(',', $wheels[3]);
            $insert['w4'] = join(',', $wheels[4]);
            $insert['w5'] = join(',', $wheels[5]);
            $insert['create'] = time();
            $this->db->merge('user_games_saving', $insert);
            
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function wheels_read($game_id = NULL)
    {
        if (isset($game_id))
        {
            $wheels = $this->db
                ->from('user_games_saving')
                ->where($this->get_where($game_id))
                ->get()
                ->current();
                
            if ($wheels)
            {
                $array[1] = explode(',', $wheels->w1);
                $array[2] = explode(',', $wheels->w2);
                $array[3] = explode(',', $wheels->w3);
                $array[4] = explode(',', $wheels->w4);
                $array[5] = explode(',', $wheels->w5);
                return $array;
            }
            else 
            {
                return array();
            }
        }
        else 
        {
            return array();
        }
    }
    
    public function isset_wheels($game_id = NULL)
    {
        if (isset($game_id))
        {
            $result = $this->db
                ->from('user_games_saving')
                ->where($this->get_where($game_id))
                ->get()
                ->current();
                
            if ($result)
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
    
    public function get_gamer_id()
    {
        if (Auth::instance()->logged_in())
        {
            return Auth::instance()->get_user()->id;
        }
        else 
        {
            return 1;
        }
    }
    
    public function get_where($game_id)
    {
        if (Auth::instance()->logged_in())
        {
            return array('id' => Auth::instance()->get_user()->id, 'demo_id' => 0, 'game_id' => $game_id);
        }
        else 
        {
            if (Session::instance()->get('auth_gamer_id', FALSE))
            {
                return array('id' => 1, 'demo_id' => Session::instance()->get('auth_gamer_id'), 'game_id' => $game_id);
            }
            else
            {
                Session::instance()->set('auth_gamer_id', mt_rand());
                return array('id' => 1, 'demo_id' => Session::instance()->get('auth_gamer_id'), 'game_id' => $game_id);
            }
        }
    }
    
    
    public function map_save($map = NULL, $game_id = NULL)
    {
        if (isset($map) AND isset($game_id))
        {
            $insert = $this->get_where($game_id);
            //$insert['id'] = $this->get_gamer_id();
            //$insert['game_id'] = $game_id;
            $insert['w1'] = $map[0];
            $insert['w2'] = $map[1];
            $insert['w3'] = $map[2];
            $insert['create'] = time();
            $this->db->merge('user_games_saving', $insert);
            
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function map_read($game_id = NULL)
    {
        if (isset($game_id))
        {
            $map = $this->db
                ->from('user_games_saving')
                ->where($this->get_where($game_id))
                ->get()
                ->current();
                
            if ($map)
            {
                $array[0] = $map->w1;
                $array[1] = $map->w2;
                $array[2] = $map->w3;
                return $array;
            }
            else 
            {
                return array();
            }
        }
        else 
        {
            return array();
        }
    }
    
    public function bet_to_gauge($bet = 1)
    {
        foreach (Kohana::config('slot.gauge_number') as $key => $value)
        {
            if ($bet >= $value[0] AND $bet <= $value[1])
            {
                return $key;
            }
        }
        
        return 1;
    }
}