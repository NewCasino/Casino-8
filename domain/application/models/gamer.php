<?php defined('SYSPATH') OR die('No direct access allowed.');

class Gamer_Model extends Model 
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
    
    public function email_exists($email = NULL) 
    { 
        return (bool) $this->db
            ->where(array('email' => $email))
            ->count_records('users'); 
    }

    public function username_exists($username = NULL) 
    { 
        return (bool) $this->db
            ->where(array('username' => $username))
            ->count_records('users'); 
    }
     
    
    public function find_by($key = NULL, $value = NULL)
    {
        $this->db
            ->select('users.*, user_info.*, user_payment.*')
            ->from('users')
            ->join('user_info', array('user_info.id' => 'users.id'))
            ->join('user_payment', array('user_payment.id' => 'users.id'));
            
        if (isset($key))
        {
            $this->db->where('users.'.$key, $value);                
        }
        
        return $this->db
            ->get()->current();
    }

    
    public function save($user = NULL)
    {
        $this->db->insert('user_info', array('id' => $user->id, 'lang_id' => Setting_Model::instance()->get('lang_id_default')));
        $this->db->insert('user_payment', array('id' => $user->id));
        $this->db->insert('roles_users', array('user_id' => $user->id, 'role_id' => Kohana::config('gamer.role')));
    }
 
    
    public function info()
    {
        if (Auth::instance()->logged_in())
        {
            $user = $this->find_by('id', Auth::instance()->get_user()->id);
            
            $lang = $this->db
                ->select('name')
                ->from('setting_lang')
                ->where('id', $user->lang_id)
                ->get()
                ->result_array();
            
            if (! isset($lang[0]))
            {
                $lang[0]->name = 'en_US';
            }
            
            if (! $user->country_id)
            {
                $user->country_id = 0;
            }
            
            $result_user['info'] = array
            (
                'balance' => $user->cash,
            );
            
            $result_user['profile'] = array
            (
                'name' => $user->name, 
                'email' => $user->email,
                'phone' => $user->phone,
                'country_id' => $user->country_id,
                'city' => $user->city,
                'sex' => $user->sex,
                'lang' => $lang[0]->name,
                'avatar_id' => $user->avatar_id,
                'mailer' => $user->mailing,
                'fullscreen' => $user->fullscreen,
                'player_status' => $user->player_status,
                'player_volume' => $user->player_volume,
            );

            $game_load = $this->db
                ->select('games.id, media.name as game_name, games.title as game_title, categories.title as name_category, media.name as media_name')
                ->from('user_games')
                ->join('games', array('games.id' => 'user_games.game_id'))
                ->join('categories', array('categories.id' => 'games.categories_id'))
                ->join('media', array('media.id' => 'games.media_id'))
                ->where('user_id', Auth::instance()->get_user()->id)
                ->groupby('user_games.game_id')
                ->get()
                ->result_array();
            
            $game = array();
            if ($game_load)
            {
                foreach ($game_load as $key => $value)
                {
                    array_unshift($game, $value);
                }
            }
            
            return array('info' => $result_user, 'game' => $game, 'pay' => Cash_Model::instance()->payment_history());
        }
    }
    
    
    public function save_profile($user_pairs = NULL, $pairs = NULL, $user_id = NULL)
    {
        if ($this->db->update('user_info', $pairs, array('id' => isset($user_id)? $user_id: Auth::instance()->get_user()->id)))
        {
            if (isset($user_pairs))
            {
                $this->db->update('users', $user_pairs, array('id' => isset($user_id)? $user_id: Auth::instance()->get_user()->id));
            }
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function set_ip($ip = 0)
    {
        $this->db->update('users', 
        array('ip' => $ip), 
        array('id' => Auth::instance()->get_user()->id));
    }
    
    public function get_ip()
    {
        return reset($this->db
            ->select('ip')
            ->from('users')
            ->where('id', 36)
            ->get()
            ->result_array());
    }
    
    public function last_bang()
    {
        $this->db->update('users', array('last_bang' => time()), array('id' => Auth::instance()->get_user()->id));
    }
    
    public function access_login($user_id = NULL, $ip = '')
    {
        if (! Setting_Model::instance()->get('one_login'))
        {
            return TRUE;
        }
        elseif (isset($user_id))
        {
            $last_bang = $this->db
                ->select('last_bang')
                ->from('users')
                ->where('id', $user_id)
                ->get()
                ->current();
                
            if (isset($last_bang->last_bang))
            {
                if ((time() - $last_bang->last_bang) > 40 OR $this->get_ip()->ip == $ip)
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
        else
        {
            return FALSE;
        }
    }
    
    public function bonus_use($code = NULL, $user_id = NULL)
    {
        if (isset($code) AND isset($user_id))
        {
            $result = $this->db
                ->from('bonus')
                ->where('code', $code)
                ->limit(1)
                ->get()
                ->current();
                
            if (isset($result->status) AND $result->status)
            {
                if (Cash_Model::instance()->bonus_use($result->id, $user_id, $result->amount))
                {
                    return $result->id;
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
        else 
        {
            return FALSE;
        }
    }
    
    public function role_control($user = NULL)
    {
        if (isset($user->id))
        {
            $result = $this->db
                ->from('roles_users')
                ->where('user_id', $user->id)
                ->get()
                ->result_array();
            
            foreach ($result as $key => $value)
            {
                if ($value->role_id == Kohana::config('gamer.role'))
                {
                    return TRUE;
                }
            }
            
            return FALSE;
        }
        else 
        {
            return FALSE;
        }
    }

}