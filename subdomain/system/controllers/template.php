<?php defined('SYSPATH') or die('No direct access allowed.');

class Template_Controller extends Controller {
	
	public $template;
	
	public function __construct() 
	{
		parent::__construct();
		
		(Kohana::config('config.display_profiler')) and new Profiler();
	}
	
	public function __call($method, array $args) 
	{}
	
	public static function instance() 
	{
		static $instance;
		
		($instance === NULL) and $instance = new self();
		
		return $instance;
	}
	
	public function assign($name, $value, $view = null) 
	{
		if ($view) 
		{
			$this->temp->view->$view->data->$name = $value;
		} 
		else 
		{
			$this->temp->data->$name = $value;
		}
	}
	
	public function implement()
	{
		if (isset($this->temp->view))
		{
			foreach ($this->temp->view as $key => $value)
			{
				$this->view->template->$key->data = $value->data;
			}			
		}
		
		(isset($this->temp->data)) and $this->view->data = $this->temp->data;		
	}
	
	public function render() 
	{		
		$this->view = new View($this->template);
		$this->view->template = new stdClass();
		
		foreach (Kohana::config('template') as $key => $value)
		{
			$this->view->template->$key = new View($value);
		}
		
		$this->implement();
		
		$this->view->render(TRUE);
	}	
}