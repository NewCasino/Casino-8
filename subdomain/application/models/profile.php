<?php defined('SYSPATH') or die('No direct access allowed.');

class Profile_Model extends Model {

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

	public function get_item_profile($id = NULL)
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
	
	public function save($array = array())
	{
		$id = $this->db->update('users', array
			(
				'username' => $array['profile']['username'],
				'email' => $array['profile']['email'],
			),
			array('id' => Auth::instance()->get_user()->id)
		);		
		
		$this->db->merge('user_info', array
			(
				'id' => Auth::instance()->get_user()->id,
				'name' => $array['profile']['name'],
				'sex' => $array['profile']['sex'],
				'phone' => $array['profile']['phone'],
			)
		);
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
	
	public function get_password($user_id = NULL)
    {
    	if (isset($user_id))
    	{
    		$result = $this->db
    			->from('users')
    			->where('id', $user_id)
    			->get()
    			->result_array();
    			
    		return (isset($result[0]->password)) ? $result[0]->password : NULL;
    	}
    }
    
	public function set_password($user_id = NULL, $password = NULL)
    {
    	if (isset($user_id))
    	{
    		$this->db->update('users', array('password' => $password), array('id' => $user_id));
    	}
    }
	
}