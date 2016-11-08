<?php defined('SYSPATH') OR die('No direct access allowed.');

class Gauge_Model extends Model 
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
	   
	public function is_true($win = NULL, $gauge = NULL, $gauge_profit = NULL)
    {
        if (! $gauge)
        {
            return FALSE;
        }
        elseif (isset($win) AND isset($gauge) AND isset($gauge_profit))
        {
            $result = $this->db
                ->from('controllers_gauge_couns')
                ->where(array('id' => $gauge, 'bet_number' => $gauge_profit))
                ->get()
                ->current();
            
            if (! $result)
            {
                return FALSE;
            }
            if (($win >= $result->value_from) AND ($win <= round($result->value_till)))
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
    
    
}