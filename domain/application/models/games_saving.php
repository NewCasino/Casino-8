<?php defined('SYSPATH') OR die('No direct access allowed.');

class Games_saving_Model extends Model 
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
	   

    public function save_job($cards_map = FALSE, $game_id = NULL)//Jack Or Better
    {
        if (isset($game_id) AND $cards_map)
        {
            $insert = $this->get_where($game_id);
            $insert['w1'] = join(',', $cards_map);
            $insert['create'] = time();
            $this->db->merge('user_games_saving', $insert);
            
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
    public function read_job($game_id = NULL)
    {
        if (isset($game_id))
        {
            $cards = $this->db
                ->from('user_games_saving')
                ->where($this->get_where($game_id))
                ->get()
                ->current();
                
            if ($cards)
            {
                return explode(',', $cards->w1);
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
    
    
    public function isset_job($game_id = NULL)
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