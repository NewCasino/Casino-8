<?php defined('SYSPATH') OR die('No direct access allowed.');

class Lang_Model extends Model 
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
	   
	public function save($lang = NULL)
	{
        $lang_id = $this->db
            ->from('setting_lang')
            ->where('name', $lang)
            ->get()
            ->result_array();
            
	    if (isset($lang_id[0]))
        {
            $this->db->update('user_info', array
                (
                    'lang_id' => $lang_id[0]->id,
                ), 
                array
                (   
                    'id' => Auth::instance()->get_user()->id,
                )
            );
        }
	}
    
    public function current_lang()
    {
        if (Auth::instance()->get_user()->id)
        {
            $lang = ($this->db
                ->select('setting_lang.name')
                ->from('user_info')
                ->join('setting_lang', array('setting_lang.id' => 'user_info.lang_id'))
                ->where('user_info.id', Auth::instance()->get_user()->id)
                ->get()
                ->result_array());
            
            if (isset($lang[0]))
            {
                return $lang[0]->name;
            }
            else
            {
                return 'en_US';
            }
        }
        else
        {
            return 'en_US';
        }
    }
    
    public function load($lang_id = 1) 
    {
        return $this->db
            ->from('setting_lang')
            ->where('id', $lang_id)
            ->limit(1)
            ->get()
            ->current()
            ->name;
    }
	
}
