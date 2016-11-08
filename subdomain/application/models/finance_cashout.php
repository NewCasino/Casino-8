<?php defined('SYSPATH') or die('No direct access allowed.');

class Finance_Cashout_Model extends Model {

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

    public function get_item_cashout($id = NULL)
    {
        if ($id)
        {
            return reset($this->db
            	->select('*, user_cashout.id as cashout_id')
                ->from('user_cashout')
                ->join('users', array('users.id' => 'user_cashout.user_id'), 'LEFT')
                ->where(array('user_cashout.id' => $id))
                ->get()
                ->result_array());
        }
        
        return NULL;
    }
    
    public function get_list_cashout($current_page, $items_per_page, $filter = NULL, $sort=NULL)
    {
        $this->db
        	->select('*, user_cashout.id as cashout_id')
            ->from('user_cashout')
            ->join('users', 'users.id', 'user_cashout.user_id', 'LEFT');
            
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_cashout.user_id' => $array[0]));
        	}
        	
        	if ($array[1])
        	{
        		$this->db
                	->where(array('user_cashout.status' => $array[1]));
        	}
        	
        	if ($array[2] && $array[3] && $array[4])
        	{
        		$this->db
                	->where(array('user_cashout.changed >' => mktime(0, 0, 0, $array[3], $array[2], $array[4]), 'user_cashout.changed <' => mktime(23, 59, 59, $array[3], $array[2], $array[4])));
        	}
        }
            
        $this->db->offset($current_page * $items_per_page - $items_per_page)
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
        	->orderby('status', 'ASC')
        	->orderby('created', 'DESC')
            ->orderby('changed', 'DESC')
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
    
	public function get_summ_cashout($filter = NULL)
    {       
    	$this->db
    		->select('SUM(amount) as sum')
    		->from('user_cashout');
    		
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_cashout.user_id' => $array[0]));
        	}
        	
        	if ($array[1])
        	{
        		$this->db
                	->where(array('user_cashout.status' => $array[1]));
        	}
        	
        	if ($array[4] && $array[2] && $array[3])
        	{
        		$this->db
                	->where(array('user_cashout.changed >' => mktime(0, 0, 0, $array[3], $array[2], $array[4]), 'user_cashout.changed <' => mktime(23, 59, 59, $array[3], $array[2], $array[4])));
        	}
        }
        
        $result = $this->db
            ->get()
            ->result_array();       
            
        return (isset($result[0]->sum)) ? $result[0]->sum : NULL;
    }
    
    public function get_total_cashout($filter = NULL)
    {       
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('user_cashout.user_id' => $array[0]));
        	}
        	
        	if ($array[1])
        	{
        		$this->db
                	->where(array('user_cashout.status' => $array[1]));
        	}
        	
        	if ($array[4] && $array[2] && $array[3])
        	{
        		$this->db
                	->where(array('user_cashout.changed >' => mktime(0, 0, 0, $array[3], $array[2], $array[4]), 'user_cashout.changed <' => mktime(23, 59, 59, $array[3], $array[2], $array[4])));
        	}
        }
        
        return $this->db
            ->count_records('user_cashout');       
    }
    
    public function save($array = array())
	{
		$this->db->update('user_cashout', array
			(
				'status' => $array['cashout']['status'],
				'changed' => time(),
			),
			array('id' => $array['cashout']['id'])
		);
		
		$this->db->update('user_payment_history', array
			(
				'status' => $array['cashout']['status'],
			),
			array('cashout_id' => $array['cashout']['id'])
		);
				
	}
	
}