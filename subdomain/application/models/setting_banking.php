<?php defined('SYSPATH') or die('No direct access allowed.');

class Setting_Banking_Model extends Model {

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

    public function get_item_banking($id = NULL)
    {
        if ($id)
        {
            return reset($this->db
                ->from('banking')
                ->where(array('id' => $id))
                ->get()
                ->result_array());
        }
        
        return NULL;
    }
    
    public function get_list_banking($current_page, $items_per_page, $filter = NULL, $sort=NULL)
    {
        $this->db
            ->from('banking');
            
        if ($filter)
        {
            $this->db
                ->where(array('type' => $filter));
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
            ->orderby('changed', 'DESC')           
            ->get()
            ->result_array();
    }
    
    public function get_total_banking($filter = NULL)
    {       
        if ($filter)
        {
            $this->db
                ->where(array('type' => $filter));
        }
        
        return $this->db
            ->count_records('banking');       
    }
    
	public function get_total_type_banking($filter = NULL)
    {       
        return $this->db
			->where(array('type' => $filter))
            ->count_records('banking');       
    }
    
	public function set_default($id = NULL)
    {
    	if ($id)
    	{       
        	$this->db
				->update('banking', array('is_default' => '1'), array('id' => $id));
    	}
	}
	
	public function unset_default($id = NULL, $filter = NULL)
    {
    	if ($id)
    	{       
        	$this->db
				->update('banking', array('is_default' => '0'), array('id !=' => $id, 'type' => $filter));
				
			$this->db
				->update('banking', array('is_default' => '1'), array('id' => $id));
    	}
	}
    
    public function save($array = array())
	{
		return $this->db->merge('banking', array
			(
				'id' => $array['banking']['id'],
				'title' => $array['banking']['title'],
				'balance' => $array['banking']['balance'],
				'type' => $array['banking']['type'],
				'changed' => time(),
			)
		)
		->insert_id();		
	}
	
	public function delete($id = NULL)
	{
		if ($id)
		{
			$this->db->delete('banking', array('id' => $id));
		}
	}

    
	public function get_list_games_banking()
	{
		return $this->db
			->from('games_banking')
			->get()
			->result_array();
	}
	
	public function get_list_games()
	{
		return $this->db
			->from('games')
			->where('view', '1')
			->get()
			->result_array();		
	}
	
	public function get_type($id = NULL)
   	{
   		if (isset($id))
   		{
   			$result = $this->db
   				->select('type')
   				->from('banking')
   				->where('id', $id)
   				->get()
   				->result_array();
   			
   				return (isset($result[0]->type)) ? $result[0]->type : NULL; 
   		}
   		
   		return NULL;
   	}
   	
	public function get_default($type = NULL)
   	{
   		if (isset($type))
   		{
   			$result = $this->db
   				->select('id')
   				->from('banking')
   				->where(array('type' => $type, 'is_default' => '1'))
   				->get()
   				->result_array();
   			
   				return (isset($result[0]->id)) ? $result[0]->id : NULL; 
   		}
   		
   		return NULL;
   	}
   	
	public function update_games_banking($id_old = NULL, $id_new = NULL)
    {
    	if (isset($id_new) && isset($id_old))
    	{       
        	$this->db
				->update('games_banking', array('banking_id' => $id_new), array('banking_id' => $id_old));
	   	}
	}
}