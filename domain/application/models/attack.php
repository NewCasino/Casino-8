<?php defined('SYSPATH') OR die('No direct access allowed.');

class Attack_Model extends Model 
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
	   
	public function save($request = NULL, $system_message = NULL)
	{
	    $this->db->insert('user_attack', array
        (
            'user_id' => (Auth::instance()->logged_in()) ? Auth::instance()->get_user()->id : $this->guest_id(), 
            'request' => $request, 
            'system_message' => $system_message,
            'created' => time(),
        ));
    }
    
    public function guest_id()
    {
        return NULL;
    }	
}