<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pincode_Model extends Model 
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
    
    public function exists($code = NULL)
    {        
        return $this->db            
            ->where(array('code' => $code, 'status' => Kohana::config('pincode.status.enabled')))
            ->count_records('pincode');
    }
    
    public function enter($code = NULL)
    {        
        $this->db
            ->update('pincode', 
                array
                (
                    'status' => Kohana::config('pincode.status.disabled'),
                    'user_id' => Auth::instance()->get_user()->id,
                    'changed' => time()
                ), 
                array
                (
                    'code' => $code
                )
            );
    }
    
    public function info($key = NULL, $value = NULL)
    {                        
        return $this->db     
            ->from('pincode')
            ->where($key, $value)
            ->get()
            ->result_array();
    }
    
}