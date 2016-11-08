<?php defined('SYSPATH') or die('No direct access allowed.');

class Manage_Pages_Model extends Model {

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

	public function get_item_pages($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('pages')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	
	public function get_list_pages($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->from('pages');
			
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
	
	public function get_total_pages($filter = NULL)
	{		
	    return $this->db
	       ->count_records('pages');		
	}
	
	public function save($array = array())
	{
		$id = $this->db->update('pages', array
			(
				'title' => $array['pages']['title'],
				'body_en' => $array['pages']['body_en'],
				'body_ru' => $array['pages']['body_ru'],
			),
			array('id' => $array['pages']['id'])
		)
		->insert_id();		
	}
}