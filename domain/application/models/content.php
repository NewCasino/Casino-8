<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Model extends Model 
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
    
    public function page($page_id = 1, $lang = 'body_en') 
    {
        return $this->db
            ->from('pages')
            ->where('id', $page_id)
            ->limit(1)
            ->get()
            ->current()
            ->{$lang};
    }
	
}
