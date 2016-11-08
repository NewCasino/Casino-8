<?php defined('SYSPATH') or die('No direct access allowed.');

class Setting_Merchant_Model extends Model {

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

    public function get_item_merchant($id = NULL)
    {
        if ($id)
        {
            return reset($this->db
                ->from('merchant')
                ->where(array('id' => $id))
                ->get()
                ->result_array());
        }
        
        return NULL;
    }
    
    public function get_list_merchant($current_page, $items_per_page, $filter = NULL, $sort=NULL)
    {
        $this->db
            ->from('merchant');
            
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
			->get()
            ->result_array();
    }
    
    public function get_total_merchant($filter = NULL)
    {       
        if ($filter)
        {
            $this->db
                ->where(array('type' => $filter));
        }
        
        return $this->db
            ->count_records('merchant');       
    }
    
    public function save($array = array())
	{
		return $this->db->merge('merchant', array
			(
				'id' => $array['merchant']['id'],
				'name' => $array['merchant']['name'],
				'form' => $array['merchant']['form'],
				'secret_key' => $array['merchant']['secret_key'],
			)
		)
		->insert_id();		
	}
	
	public function delete($id = array())
	{
		foreach ($id as $row)
		{
			$this->db->delete('merchant', array('id' => $row));
		}
	}
}