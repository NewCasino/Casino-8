<?php defined('SYSPATH') OR die('No direct access allowed.');

class Event_Model extends Model 
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
    
    public function info($field = NULL)
    {
        return reset($this->db
            ->from('user_info')
            ->select($field)
            ->where('id', Auth::instance()->get_user()->id)
            ->get()
            ->current());
    }
    
}