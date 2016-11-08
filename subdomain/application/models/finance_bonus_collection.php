<?php defined('SYSPATH') or die('No direct access allowed.');

class Finance_Bonus_Collection_Model extends Model {

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

	public function get_item_collection($id = NULL)
	{
		if ($id)
		{
			return reset($this->db
				->from('bonus_collection')
				->where(array('id' => $id))
				->get()
				->result_array());
		}
		
		return NULL;
	}
	
	public function get_list_collection($current_page, $items_per_page, $filter = NULL, $sort = NULL)
	{
		$this->db
			->select('*, COUNT(bonus.id) as count_bonus, bonus_collection.id as id')
			->from('bonus_collection')
			->join('bonus', 'bonus.collection_id', 'bonus_collection.id', 'LEFT');
			
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
        	->groupby('bonus_collection.id')
			->get()
			->result_array();		
	}
	
	public function get_total_collection($filter = NULL)
	{		
	    $this->db
			->from('bonus_collection');
       
	    return $this->db
	       ->count_records('bonus_collection');		
	}
	
	public function save($array = array())
	{
		$id = $this->db->merge('bonus_collection', array
			(
				'id' => $array['collection']['id'],
				'title' => $array['collection']['title'],
			)
		)
		->insert_id();		
	}
	
	public function delete($id = array())
	{
		foreach ($id as $row)
		{
			$this->db->delete('bonus_collection', array('id' => $row));
		}
	}
}