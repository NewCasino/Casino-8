<?php defined('SYSPATH') or die('No direct access allowed.');

class Manage_Categories_Model extends Model {

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

	public function get_item_categories($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('categories')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	
	public function get_list_categories($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->select('*, COUNT(games.id) as count_games, categories.id as id, categories.title as title, categories.sort as sort')
			->from('categories')
			->join('games', 'games.categories_id', 'categories.id', 'LEFT')
			->where(array('games.view' => '1'));
			
 		$this->db->offset($current_page * $items_per_page - $items_per_page)
            ->limit($items_per_page);
            
		if ($sort)
        {
        	$array = explode(",", $sort);
        	
        	if ($array[0] == 'up')
        	{
        		$this->db
                	->orderby('categories.'.$array[1], 'ASC');
        	}
        	
        	if ($array[0] == 'down')
        	{
        		$this->db
                	->orderby('categories.'.$array[1], 'DESC');
        	}
        }
        
        return $this->db
        	->groupby('categories.id')
			->get()
			->result_array();			
	}
	
	public function get_total_categories($filter = NULL)
	{		
	    return $this->db
	       ->count_records('categories');		
	}
	
	public function save($array = array())
	{
		$id = $this->db->update('categories', array
			(
				'title' => $array['categories']['title'],
				'sort' => $array['categories']['sort'],
			),
			array('id' => $array['categories']['id'])
		)
		->insert_id();		
	}
}