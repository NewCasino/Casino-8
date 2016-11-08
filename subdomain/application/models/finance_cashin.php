<?php defined('SYSPATH') or die('No direct access allowed.');

class Finance_Cashin_Model extends Model {

    public function __construct()
    {               
        parent::__construct();
        self::initialize();
    }

    public function __call($method, array $args) 
    {}
    
    public static function instance() 
    {
        static $instance;
        
        ($instance === NULL) and $instance = new self();
        
        return $instance;
    }

    protected function initialize()
    {
        $this->setting = current($this->db
            ->from('setting')
            ->get()
            ->result_array());
    }
    
    public function get_setting($name, $default_value = null)
    {
        return (isset($this->setting->$name) and $this->setting->$name) ? $this->setting->$name : $default_value;       
    }

    public function get_list_cashin($current_page, $items_per_page, $filter = NULL, $sort=NULL)
    {
        $this->db
        	->select('user_payment_history.user_id as user_id, user_payment_history.amount as amount, merchant.name as merchant_name,
        		user_payment_history.datetime as datetime, users.username as username, pincode.code as code')
            ->from('user_payment_history')
            ->join('pincode', 'pincode.id', 'user_payment_history.pincode_id', 'left')
            ->join('users', 'users.id', 'user_payment_history.user_id', 'LEFT')
            ->join('merchant_request', 'merchant_request.id', 'user_payment_history.merchant_request_id', 'LEFT')
            ->join('merchant', 'merchant.id', 'merchant_request.merchant_id', 'LEFT');
            
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_payment_history.user_id' => $array[0]));
        	}
        	
        	if ($array[1] && $array[2] && $array[3])
        	{
        		$this->db
                	->where(array('user_payment_history.datetime >' => mktime(0, 0, 0, $array[2], $array[1], $array[3]), 'user_payment_history.datetime <' => mktime(23, 59, 59, $array[2], $array[1], $array[3])));
        	}
        }
            
        $this->db
        	->where(array('user_payment_history.type' => '1'))
        	->offset($current_page * $items_per_page - $items_per_page)
            ->limit($items_per_page);
            
    	if ($sort)
        {
        	$array = explode(",", $sort);
        	
        	if ($array[0] == 'up')
        	{
        		$this->db
                	->orderby($array[1], 'ASC');
        	}
        	
        	if ($array[0] == 'down')
        	{
        		$this->db
                	->orderby($array[1], 'DESC');
        	}
        }

        return $this->db
        	->orderby('datetime', 'DESC')            
            ->get()
            ->result_array();
    }
    
	public function get_list_player()
    {
        $this->db
			->select('*, users.id as users_id')
			->from('users')
			->join('roles_users', 'roles_users.user_id', 'users.id', 'LEFT')
			->where(array('roles_users.role_id' => '5'));
        
		return $this->db
			->get()
			->result_array();
    }
    
	public function get_summ_cashin($filter = NULL)
    {       
    	$this->db
    		->select('SUM(amount) as sum')
    		->from('user_payment_history');
    		
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_id' => $array[0]));
        	}
        	
        	if ($array[1] && $array[2] && $array[3])
        	{
        		$this->db
                	->where(array('datetime >' => mktime(0, 0, 0, $array[2], $array[1], $array[3]), 'datetime <' => mktime(23, 59, 59, $array[2], $array[1], $array[3])));
        	}
        }
        
        $result = $this->db
        	->where(array('type' => '1'))
            ->get()
            ->result_array();       
            
        return (isset($result[0]->sum)) ? $result[0]->sum : NULL;
    }
    
    public function get_total_cashin($filter = NULL)
    {       
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_id' => $array[0]));
        	}
        	
        	if ($array[1] && $array[2] && $array[3])
        	{
        		$this->db
                	->where(array('datetime >' => mktime(0, 0, 0, $array[2], $array[1], $array[3]), 'datetime <' => mktime(23, 59, 59, $array[2], $array[1], $array[3])));
        	}
        }
        
        return $this->db
        	->where(array('type' => '1'))
            ->count_records('user_payment_history');       
    }
    
}