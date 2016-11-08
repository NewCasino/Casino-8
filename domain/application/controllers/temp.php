<?php defined('SYSPATH') OR die('No direct access allowed.');

class Temp_Controller extends Base_Controller
{
	public function __construct()
	{
	    parent::__construct();	    
	}

	public function __call($method, array $args)
	{}
	
	public function index()
	{
		$this->template = 'temp';
		$this->view();	 
	}
}