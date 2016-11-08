<?php defined('SYSPATH') or die('No direct access allowed.');

class Manage_Music_Model extends Model {

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

	public function get_item_music($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('mp3')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	public function get_list_music($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->from('mp3');
			
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
	
	public function get_total_music($filter = NULL)
	{		
	    return $this->db
	       ->count_records('mp3');		
	}
	
	public function save(array $pairs)
	{
		if (is_array($pairs))
  		{
  			if (isset($pairs['id']) && $pairs['id']!='')
  			{
  				return $this->db->update('mp3', $pairs, array('id' => $pairs['id']))->insert_id();
  			}
  			else
  			{
  				return $this->db->merge('mp3', $pairs)->insert_id();
  			}
  		}
  		
  		return NULL;		
	}
	
	public function get_file($id = NULL)
	{
		if ($id)
		{
			$result = $this->db
				->select('file')
				->from('mp3')
				->where(array('id' => $id))
				->get()
				->result_array();
				
			return (isset($result[0]->file)) ? $result[0]->file : NULL;
		}
		
		return NULL;
	}
	
	public function delete($id = NULL)
	{
		if ($id)
		{
			$this->db->delete('mp3', array('id' => $id));
		}
	}
}