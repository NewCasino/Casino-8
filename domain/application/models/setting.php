<?php defined('SYSPATH') OR die('No direct access allowed.');

class Setting_Model extends Model 
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
    
    public function get($name = NULL)
    {
        if (isset($name))
        {
            $result = $this->db
                ->select($name)
                ->from('setting')
                ->where('template_id', Kohana::config('gamer.default_template_setting_id'))
                ->limit(1)
                ->get()
                ->current();
            
            return $result->{$name};
        }
        else
        {
            return FALSE;
        }
    }
    
    public function template()
    {
        return $this->db
            ->from('setting')
            ->where('template_id', Kohana::config('gamer.default_template_setting_id'))
            ->limit(1)
            ->get()
            ->current();
    }
    
    
}