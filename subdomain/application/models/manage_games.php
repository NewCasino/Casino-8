<?php defined('SYSPATH') or die('No direct access allowed.');

class Manage_Games_Model extends Model {

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

	public function get_item_games($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('games')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	public function get_list_games_setting($games_id = NULL)
	{
		if ($games_id)
		{
			return $this->db
				->from('games_setting')
				->where(array('games_id' => $games_id))
				->get()
				->result_array();
		}
		
		return NULL;
	}
	
	public function get_list_games_banking($games_id = NULL)
	{
		$this->db
			->from('games_banking');
			
		if ($games_id)
		{
			$this->db
				->where(array('games_id' => $games_id));
		}		
		
		return $this->db
			->get()
			->result_array();
	}
	
	public function get_list_games($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->select('
				games.id AS games_id,
				games.title AS games_title,
				games.sort AS games_sort,
				categories.title AS categories_title				
			')
			->from('games')
			->join('categories', array('categories.id' => 'games.categories_id'))
			->where(array('games.view' => '1'));
			
        if ($filter)
        {
            $this->db
                ->where(array('games.categories_id' => $filter));
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
	
	public function get_total_games($filter = NULL)
	{		
	    if ($filter)
        {
            $this->db
                ->where(array('categories_id' => $filter));
        }
        
	    return $this->db
	       ->count_records('games', array('view' => '1'));		
	}
	
	public function get_list_categories()
	{
		return $this->db
			->from('categories')
			->get()
			->result_array();		
	}
	
	public function get_list_banking()
	{
		return $this->db
			->from('banking')
			->get()
			->result_array();		
	}
	
	public function save($array = array())
	{
		$this->db->update('games', array
			(
				'id' => $array['games']['id'],
				'categories_id' => $array['games']['categories_id'],
				'title' => $array['games']['title'],
				'sort' => $array['games']['sort'],
			),
			array('id' => $array['games']['id'])
		);		
		
		if (isset($array['setting']))
		{
			foreach ($array['setting'] as $key => $value) 
			{
				$this->db->merge('games_setting', array
					(
						'games_id' => $array['games']['id'],
						'name' => $key,
						'value' => $value,
					)
				);
			}
		}
		
		foreach ($array['banking'] as $key => $row)
		{
			$pairs = array
			(
				'games_id' => $array['games']['id'],
				'type' => $key,
                'profiles_id' => 1,
			);
			
			foreach ($row as $key => $value)
			{
				$pairs[$key] = $value;
			}
			
			$this->db->merge('games_banking', $pairs);			
		}		
	}
}