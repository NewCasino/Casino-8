<?php defined('SYSPATH') OR die('No direct access allowed.');

class Profile_Controller extends Fields_Controller
{
    public function __construct()
    {
    	$this->use_auth = TRUE;
    	
    	parent::__construct();
    	self::initialize();	    	
    }

    protected function initialize()
    {}
    
    public function __call($method, array $args)
    {    
    	$this->index();
    }
    
	public function save()
    {
    	$this->template = 'profile/data';
    	
    	Profile_Model::instance()->save($this->input->post());
    	
    	$this->assign('data', Kohana::lang('profile.save_success'));
    	
    	$this->render();
    }
    
    public function edit()
    {
    	$this->template = 'profile/data';

    	$this->assign('data', json_encode(Profile_Model::instance()->get_item_profile(uri::segment('id', 0))));
    	
    	$this->render();
    }
    
	public function count_username()
    {
    	$this->template = 'profile/data';

    	$this->assign('data', Profile_Model::instance()->get_username_count(uri::segment('username', ''), Auth::instance()->get_user()->id));
    	
    	$this->render();
    }
    
	public function count_email()
    {
    	$this->template = 'profile/data';

    	$this->assign('data', Profile_Model::instance()->get_email_count(uri::segment('email', ''), Auth::instance()->get_user()->id));
    	
    	$this->render();
    }
    
	public function compare_password()
    {
    	$this->template = 'profile/data';
		
    	if (Auth::instance()->hash_password(uri::segment('password', ''), Auth::instance()->find_salt(Profile_Model::instance()->get_password(Auth::instance()->get_user()->id))) != Profile_Model::instance()->get_password(Auth::instance()->get_user()->id))
    	{
    		$this->assign('data', 1);
    	}
    	else
    	{
    		$this->assign('data', 0);
    	}
    	
    	$this->render();
    }
    
	public function save_password()
    {
    	$this->template = 'profile/data';
    	
    	Profile_Model::instance()->set_password(Auth::instance()->get_user()->id, Auth::instance()->hash_password(uri::segment('password', '')));
    	
    	$this->assign('data', Kohana::lang('profile.password_save_success'));
    	
    	$this->render();
    }
    
	
    
}