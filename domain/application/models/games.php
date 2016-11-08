<?php defined('SYSPATH') OR die('No direct access allowed.');

class Games_Model extends Model 
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
    
    public function profile($game_id = NULL)
    {
        if (isset($game_id))
        {
            $result = $this->db
                ->from('games')
                ->where('id', $game_id)
                ->get()
                ->current();
                
            if ($result)
            {
                return $result->current_profile_id;
            }
            else 
            {
                return 1;
            }
        }
        else 
        {
            return 1;
        }
    }
    
    public function bonus_percent($game_id = NULL)
    {
        if (isset($game_id))
        {
            return (int) $this->db
                ->select('percent')
                ->from('games')
                ->join('games_banking', array
                (
                    'games_banking.games_id' => 'games.id',
                    'games_banking.profiles_id' => 'games.current_profile_id'
                ))
                ->where(array('id' => $game_id, 'games_banking.type' => 'jackpot'))
                ->get()
                ->current()
                ->percent;
        }
        else 
        {
            return 1;
        }
    }    
    
    public function profit_percent($game_id = NULL)
    {
        if (isset($game_id))
        {
            return (int) $this->db
                ->select('percent')
                ->from('games')
                ->join('games_banking', array
                (
                    'games_banking.games_id' => 'games.id',
                    'games_banking.profiles_id' => 'games.current_profile_id'
                ))
                ->where(array('id' => $game_id, 'games_banking.type' => 'profit'))
                ->get()
                ->current()
                ->percent;
        }
        else 
        {
            return 1;
        }
    }
	   
	public function configs($game_id = NULL)
	{
        if (isset($game_id))
        {
            $where['games_id'] = $game_id;
            $where['profiles_id'] = $this->profile($game_id);
            $result = array();
            
            $settigs = $this->db
                ->from('games_setting')
                ->where($where)
                ->get()
                ->result_array();
            
            foreach ($settigs as $row)
            {
                $result[$row->name] = ($row->name == 'coin_size')? floatval($row->value): intval($row->value);
            }
            
            return $result;
        }
        else 
        {
            return NULL;
        }
    }
    
//------------------------------------------------------------------------------
//          B A N K
    public function is_bank($game_id = NULL, $jackpot = TRUE)
    {
        if (isset($game_id))
        {
            $in = array();
            $in[] = $this->get_bank_id($game_id, 'game');
            $in[] = $this->get_bank_id($game_id, 'profit');
            if ($jackpot)
            {
                $in[] = $this->get_bank_id($game_id, 'jackpot');
            }
            
            $result = $this->db
                ->from('banking')
                ->in('id', $in)
                ->get()
                ->result_array();
                
            if ($jackpot AND count($result) == 3)
            {
                return TRUE;
            }
            elseif (! $jackpot AND count($result) == 2)
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
    
    public function bank_balance($game_id = NULL, $role = 'game', $round = TRUE)
    {
        if (isset($game_id))
        {
            $bank_id = $this->get_bank_id($game_id, $role);
            $result = $this->db
                ->from('banking')
                ->where('id', $bank_id)
                ->get()
                ->current();
            
            if ($result)
            {
                return ($round)? round($result->balance): $result->balance;
            } 
            else 
            {
                return 0;
            }
        } 
        else 
        {
            return 0;
        }
    }
    
    public function bank_add($game_id = 1, $role = 'game', $summa = 0)
    {
        if ($summa > 0 AND Auth::instance()->logged_in())
        {
            $bank_id = $this->get_bank_id($game_id, $role);
            $bank_balance = $this->bank_balance($game_id, $role, FALSE);
            $this->db->update('banking', array('balance' => $bank_balance + $summa), array('id' => $bank_id));
        }
    }

    public function bank_pay($game_id = NULL, $role = 'game', $win = 0)
    {
        if ($win > 0 AND Auth::instance()->logged_in())
        {
            $bank_id = $this->get_bank_id($game_id, $role);
            $bank_balance = $this->bank_balance($game_id, $role, FALSE);
            $this->db->update('banking', array('balance' => $bank_balance - $win), array('id' => $bank_id));
        }
    }
    
    public function get_bank_id($game_id, $role)
    {
         return (int) $this->db
            ->select('banking_id')
            ->from('games')
            ->join('games_banking', array
            (
                'games_banking.games_id' => 'games.id',
                'games_banking.profiles_id' => 'games.current_profile_id'
            ))
            ->where(array('games.id' => $game_id, 'games_banking.type' => $role))
            ->get()
            ->current()
            ->banking_id;
    }
    
//------------------------------------------------------------------------------
//              U S E R    
    public function user_pay($summa = 0)
    {
        if ($summa > 0) 
        {
            if (Auth::instance()->logged_in())
            {
                Cash_Model::instance()->save(array
                (
                    'pincode_id' => 0,
                    'amount' => $summa,
                    'type' => 0,
                    'status' => 4,
                ), FALSE, FALSE);
            }
            else 
            {
                Session::instance()->set('demo_user_balance', Session::instance()->get('demo_user_balance', 0) - $summa);
            }
        }
    }
    
    public function user_add($summa = 0)
    {
        if ($summa > 0) 
        {
            if (Auth::instance()->logged_in())
            {
                Cash_Model::instance()->save(array
                (
                    'pincode_id' => 0,
                    'amount' => $summa,
                    'type' => 1,
                    'status' => 1,
                ), FALSE, FALSE);
            }
            else 
            {
                Session::instance()->set('demo_user_balance', Session::instance()->get('demo_user_balance', 0) + $summa);
            }
        }
    }
    
    public function user_games($game_id = NULL)
    {
        if (isset($game_id) AND Auth::instance()->logged_in())
        {
            $this->db->insert('user_games', array('user_id' => Auth::instance()->get_user()->id, 'game_id' => $game_id));
        }
        else 
        {
            return FALSE;
        }
    }
    
    
    public function statistics($game_id = 0, $bet = 0, $balance = 0, $map = 1, $win = 0)
    {
        if (Auth::instance()->logged_in())
        {
            $this->db->insert('statistics', array('user_id' => Auth::instance()->get_user()->id, 'game_id' => $game_id, 'map' => $map, 'bet' => $bet, 'win' => $win, 'gamer_balance' => $balance, 'time' => time()));
        }
    }
    
}