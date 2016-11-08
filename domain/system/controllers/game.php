<?php defined('SYSPATH') OR die('No direct access allowed.');

class Game_Controller extends Base_Controller 
{
    public $use_auth = FALSE;
    public $pref = 'slot';
    
    public function __construct()
    {                
        parent::__construct();
        
        if ($this->use_auth)
        {
            if ( ! Auth::instance()->logged_in()) 
            {
                url::redirect(Kohana::config('urls.login'));            
            }
        }
        
        $this->initialize(); 
    } 
	
	public function __destruct()
	{}
	
	public function __call($method, array $args)
	{}
			
	public static function instance()
	{		
		static $instance;

		($instance === NULL) and $instance = new self;

		return $instance;
	}
    
    public function initialize()
    { }

    
    public function user_cash()
    {
        return floatval(Auth::instance()->logged_in()
            ? Gamer_Model::instance()->find_by('id', $this->user_id)->cash
            : Session::instance()->get('demo_user_balance', 0.00));
    }
 
    public function log_add($var, $title = '')
    {
        Kohana::log('error', $title.' -> '. Kohana::debug($var));
        kohana::log_save();
    }
    
    public function log_str($str = '')
    {
        Kohana::log('error', $str);
        kohana::log_save();
    }
    
    public function rand_chance($min = 1, $max = NULL)
    {
        mt_srand();
        if (is_null($max)) 
        {
            $max = Kohana::config($this->pref.'.chance_default_max');
        }
        
        return mt_rand($min, $max);
    }
    
    public function chance($max = NULL)
    {
        $result = 0;
        if (is_null($max)) 
        {
            $max = Kohana::config($this->pref.'.chance_default_max');
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

       
}