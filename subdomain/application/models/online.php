<?php defined('SYSPATH') or die('No direct access allowed.');

class Online_Model extends Model {

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
	
	public function get_list_games()
	{
		return $this->db
			->select('*, games.title as games_title, categories.title as categories_title, games.id as id')
			->from('games')
			->join('categories', 'categories.id', 'games.categories_id', 'LEFT')
			->where('games.view', '1')
			->get()
			->result_array();		
	}
	
	public function get_list_events($games_id = NULL, $categories_id = NULL)
	{
		$this->db
			->select('*, statistics.id as id')
			->from('statistics')
			->join('users', 'users.id', 'statistics.user_id')
			->join('games', 'games.id', 'statistics.game_id')
			->where(array('games.view' => '1'));
			
		if (isset($games_id))
		{
			$this->db
				->where(array('statistics.game_id' => $games_id));
		}
		
		if (isset($categories_id))
		{
			$this->db
				->where(array('games.categories_id' => $categories_id));
		}
		
		return $this->db
			->orderby('statistics.id', 'DESC')
			->limit(20)
			->get()
			->result_array();		
	}
	
	public function get_last_events($games_id = NULL, $categories_id = NULL, $last_id = NULL)
	{
		$this->db
			->select('*, statistics.id as id')
			->from('statistics')
			->join('users', 'users.id', 'statistics.user_id')
			->join('games', 'games.id', 'statistics.game_id')
			->where(array('games.view' => '1'));
			
		if (isset($games_id) && $games_id)
		{
			$this->db
				->where(array('statistics.game_id' => $games_id));
		}
		
		if (isset($last_id) && $last_id)
		{
			$this->db
				->where(array('statistics.id >' => $last_id));
		}
		
		if (isset($categories_id) && $categories_id)
		{
			$this->db
				->where(array('games.categories_id' => $categories_id));
		}
		
		return $this->db
			->orderby('statistics.id', 'DESC')
			->limit(20)
			->get()
			->result_array();		
	}
}