<?php defined('SYSPATH') or die('No direct access allowed.');

class Users_Player_Model extends Model {

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

	public function get_item_player($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->select('*, users.id as id')
				->from('users')
				->join('user_info', 'user_info.id', 'users.id', 'LEFT')
				->where(array('users.id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	public function get_item_add_cash($id = NULL)
	{
		if ($id)
		{
			$result = $this->db
				->select('SUM(amount) as sum')
				->from('user_payment_history')
				->where(array('type' => '1', 'user_id' => $id))
				->get()
				->result_array();
				
			return (isset($result[0]->sum)) ? $result[0]->sum : NULL;
		}
		
		return NULL;
	}
	
	public function get_item_out_cash($id = NULL)
	{
		if ($id)
		{
			$result = $this->db
				->select('SUM(amount) as sum')
				->from('user_cashout')
				->where(array('status' => '4', 'user_id' => $id))
				->get()
				->result_array();
				
			return (isset($result[0]->sum)) ? $result[0]->sum : NULL;
		}
		
		return NULL;
	}
	
	public function get_item_balance($id = NULL)
	{
		if ($id)
		{
			$result = $this->db
				->select('cash')
				->from('user_payment')
				->where(array('id' => $id))
				->get()
				->result_array();
				
			return (isset($result[0]->cash)) ? $result[0]->cash : NULL;
		}
		
		return NULL;
	}
	
	public function get_item_count_cashout($id = NULL)
	{
		if ($id)
		{
			$result = $this->db
				->count_records('user_cashout', (array('user_id' => $id)));
				
			return (isset($result)) ? $result : NULL;
		}
		
		return NULL;
	}
	
	public function get_list_player($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->select('*, users.id as users_id')
			->from('users')
			->join('user_info', 'user_info.id', 'users.id', 'LEFT')
			->join('bonus', 'bonus.id', 'user_info.bonus_id', 'LEFT')
			->join('roles_users', array('roles_users.user_id' => 'users.id'))
			->where(array('roles_users.role_id' => '5'));
			
        if ($filter)
        {
        	$array = explode(",", $filter);
        	
            $this->db
            	->like('user_info.name', $array[0])
                ->like('users.email', $array[1]);
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
			->get()
			->result_array();		
	}
	
	public function get_total_player($filter = NULL)
	{		
	    $this->db
			->from('users')
			->join('user_info', 'user_info.id', 'users.id', 'LEFT')
			->join('roles_users', 'roles_users.user_id', 'users.id', 'LEFT');
				
		if ($filter)
        {
        	$array = explode(",", $filter);
        	
            $this->db
            	->like('user_info.name', $array[0])
                ->like('users.email', $array[1]);
        }
        
	    return $this->db
	       ->count_records('users', array('roles_users.role_id' => '5'));		
	}
	
	public function save($array = array())
	{
		if ($array['player']['id'])
		{
			$id = $this->db->update('users', array
				(
					'username' => $array['player']['username'],
					'email' => $array['player']['email'],
				),
				array('id' => $array['player']['id'])
			)
			->insert_id();		
		
			if(isset($array['player_info']['mailing']))
			{
				$mailing = '1';
			}
			else
			{
				$mailing = '0';
			}
			
			$this->db->merge('user_info', array
				(
					'id' => $array['player']['id'],
					'name' => $array['player_info']['name'],
					'sex' => $array['player_info']['sex'],
					'mailing' => $mailing,
					'country_id' => $array['player_info']['country_id'],
					'city' => $array['player_info']['city'],
					'phone' => $array['player_info']['phone'],
				)
			);
		}
		else
		{
			$id = $this->db->insert('users', array
				(
					'username' => $array['player']['username'],
					'email' => $array['player']['email'],
					'password' => Auth::instance()->hash_password($array['player']['password']),
					'password_original' => $array['player']['password'],
				)
			)
			->insert_id();	

			if(isset($array['player_info']['mailing']))
			{
				$mailing = '1';
			}
			else
			{
				$mailing = '0';
			}
		
			$this->db->insert('user_info', array
				(
					'id' => $id,
					'name' => $array['player_info']['name'],
					'sex' => $array['player_info']['sex'],
					'mailing' => $mailing,
					'country_id' => $array['player_info']['country_id'],
					'city' => $array['player_info']['city'],
					'phone' => $array['player_info']['phone'],
				)
			);
			
			$this->db->insert('roles_users', array('user_id' => $id, 'role_id' => '5'));
			$this->db->insert('roles_users', array('user_id' => $id, 'role_id' => '1'));
			
			
		}
		
	}
	
	public function delete($id = array())
	{
		foreach ($id as $row)
		{
			$this->db->delete('users', array('id' => $row));
			$this->db->delete('user_info', array('id' => $row));
			$this->db->delete('roles_users', array('user_id' => $row));		
		}
	}
	
	public function get_username_count($username = NULL, $id = NULL)
	{	
	    return $this->db
	       ->count_records('users', array('id !=' => $id, 'username' => $username));		
	}
	
	public function get_email_count($email = NULL, $id = NULL)
	{	
	    return $this->db
	       ->count_records('users', array('id !=' => $id, 'email' => $email));		
	}
}