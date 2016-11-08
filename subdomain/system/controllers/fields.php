<?php defined('SYSPATH') or die('No direct access allowed.');

class Fields_Controller extends Base_Controller {
	
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
	{}
	
	public function index()
	{	
		//echo '<pre>';
		
		//print_r(Fields_Model::instance()->get_list());
		$this->assign('array', Fields_Model::instance()->get_list(), 'list');
		$this->assign('columns', fields::get_list_columns(), 'list');
		//print_r(Fields_Model::instance()->get_list());
		//print_r(Fields_Model::instance()->get_list());
		//print_r(Fields_Model::instance()->get_list());
		
		//print_r(fields::get_form_keys());
		
		/* form */		
		//$this->assign('fields', fields::get_form_fields(), 'footer');
		//$this->assign('fields', fields::get_form_fields());
		//$this->assign('tabs', fields::get_form_tabs(), 'form');
		
		/* list */
		//$this->assign('fields', fields::get_list_fields(), 'list');
		//$this->assign('tabs', fields::get_list_fields(), 'list');
		
		$this->template = fields::get_template();
		$this->render();
	}
	
	public function edit()
	{}
	
	public function save()
	{}
	
	public function delete()
	{}
}