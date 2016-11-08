<?php defined('SYSPATH') or die('No direct access allowed.');

class Finance_Bonus_Model extends Model {

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

    public function get_item_bonus($id = NULL)
    {
        if ($id)
        {
            return reset($this->db
                ->from('bonus')
                ->where(array('id' => $id))
                ->get()
                ->result_array());
        }
        
        return NULL;
    }
    
    public function get_list_bonus($current_page, $items_per_page, $filter = NULL, $sort = NULL)
    {
        $this->db
        	->select('*, bonus.id as id')
            ->from('bonus')
            ->join('users', 'users.id', 'bonus.user_id', 'LEFT');
            
    	if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('bonus.status' => $array[0]));
        	}
        	
        	if ($array[1])
        	{
        		$this->db
                	->where(array('bonus.collection_id' => $array[1]));
        	}
        	
        	if ($array[2] && $array[3] && $array[4])
        	{
        		$this->db
                	->where(array('bonus.changed >' => mktime(0, 0, 0, $array[3], $array[2], $array[4]), 'bonus.changed <' => mktime(23, 59, 59, $array[3], $array[2], $array[4])));
        	}
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
            ->orderby('created', 'DESC')         
            ->get()
            ->result_array();
    }
    
    public function get_total_bonus($filter = NULL)
    {       
   		if ($filter)
        {
        	$array = explode(",", $filter);
        	
        	if ($array[0])
        	{
        		$this->db
                	->where(array('status' => $array[0]));
        	}
        	
        	if ($array[1])
        	{
        		$this->db
                	->where(array('collection_id' => $array[1]));
        	}
        	
        	if ($array[2] && $array[3] && $array[4])
        	{
        		$this->db
                	->where(array('changed >' => mktime(0, 0, 0, $array[3], $array[2], $array[4]), 'changed <' => mktime(23, 59, 59, $array[3], $array[2], $array[4])));
        	}
        }
        
        return $this->db
            ->count_records('bonus');       
    }
    
    public function save($array = array())
    {
        for ($i = 0; $i < $array['count']; $i++) 
        {
            $flag = TRUE;
            
            while ($flag) 
            {
                $code = array();
                
                for ($j = 0; $j < 12; $j++)
                {
                    $code[] = rand(0, 9);
                }
                
                if ( ! $this->db
                    ->where(array('code' => implode('', $code)))
                    ->count_records('bonus'))
                {
                    $flag = FALSE;
                }
            }
            
            $this->db->merge('bonus', array
                (
                    'id' => NULL,
                    'user_id' => 0,
                    'code' => implode('', $code),
                    'amount' => $array['amount'],
                	'collection_id' => $array['collection_id'],
                    'status' => 1,
                	'created' => time(),
                )
            );
        }
    }
    
	public function save_collection($array = array())
    {
		return $this->db->merge('bonus_collection', array
			(
				'id' => NULL,
				'title' => $array['title'],
			)
		)
		->insert_id();
    }
    
	public function get_list_collection()
	{
		return $this->db
			->from('bonus_collection')
			->get()
			->result_array();		
	}
}