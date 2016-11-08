<?php defined('SYSPATH') or die('No direct access allowed.');

class Setting_Value_Model extends Model {

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

	public function get_item_value($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('setting')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	public function get_list_value($current_page, $items_per_page, $filter = NULL)
	{
		return reset($this->db
			->from('setting')
			->get()
			->result_array());		
	}
	
	public function get_total_value($filter = NULL)
	{		
	    return $this->db
	       ->count_records('setting');		
	}
	
	public function save($array = array())
	{
		$this->db->update('setting', array
			(
				'url' => $array['url'],
				'title' => $array['title'],
				'description' => $array['description'],
				'keywords' => $array['keywords'],
				'google_analytics' => htmlspecialchars_decode($array['google_analytics']),
				'google_webmaster_tools' => $array['google_webmaster_tools'],
				'one_login' => $array['one_login'],
				'currency' => $array['currency'],
				'demo_user_balance' => $array['demo_user_balance'],
				'lang_id_default' => $array['lang_id_default'],
				'banking_limit_min_cash' => $array['banking_limit_min_cash'],
				'banking_limit_min_cash_bonus' => $array['banking_limit_min_cash_bonus'],
			),
			array('template_id' => '1')
		);
	}
	

}