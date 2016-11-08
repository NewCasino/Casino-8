<?php defined('SYSPATH') OR die('No direct access allowed.');

class Home_Controller extends Base_Controller
{
    public function __construct()
    {
		$this->use_auth = TRUE;
		
    	parent::__construct();
    	self::initialize();
    }

    public function __call($method, array $args)
    {
    	url::redirect('finance/cashout', 301);
    }
    
	public function initialize()
    {}
    
    public function index()
    {
    	url::redirect('finance/cashout', 301);
    }
    
	public function template1()
    {
    	$this->template = 'template1';
    	$this->render();
    }
    
	public function template2()
    {
    	$this->template = 'template2';
    	$this->render();
    }
    
	public function template3()
    {
    	$this->template = 'template3';
    	$this->render();
    }
}