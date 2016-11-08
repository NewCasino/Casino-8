<?php defined('SYSPATH') or die('No direct access allowed.');

class Fields_Model extends Model {

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

	public function get_list()
	{
		return $this->db
			->select(implode(', ', fields::get_form_keys()))
			->from(fields::get_table())
			->offset(uri::segment('page', 1) * $this->get_setting('items_per_page', Kohana::config('values.model.fields.items_per_page')) - $this->get_setting('items_per_page', Kohana::config('values.model.fields.items_per_page')))
            ->limit($this->get_setting('items_per_page', Kohana::config('values.model.fields.items_per_page')))
			->get()
			->result_array();
	}
}