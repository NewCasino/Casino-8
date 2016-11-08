<?php defined('SYSPATH') OR die('No direct access allowed.');

class Auth_Controller extends Base_Controller
{
    public function __construct()
    {
		parent::__construct();
    }

    public function __call($method, array $args)
    {}
    
	public function initialize()
    {}
    
    public function register()
    {}
    
    public function login()
    {
    	if (Auth::instance()->logged_in('admin') || Auth::instance()->logged_in('root'))
    	{
    		Auth::instance()->logout();
    	}
    	
    	if ($this->input->post())
		{
			$this->template = 'notice';
			
			$user = ORM::factory('user', $this->input->post('username'));
			
			if ($user->id and Auth::instance()->login($user, $this->input->post('password')))
            {}
            else 
            {
            	$this->assign('notice', Kohana::lang('notice.auth.failed'));
            }            
		}
		else 
		{
			$this->template = 'base/auth/login';
		}
		
		$this->render();
    }
    
	public function forgot()
    {
    	if (Auth::instance()->logged_in())
    	{
    		Auth::instance()->logout();
    	}    	
    	
    	if ($this->input->post()) 
		{
			$this->template = 'notice';
			
			$user = ORM::factory('user', $this->input->post('username'));
			
			if ($user->email === $this->input->post('email') and $user->username === $this->input->post('username')) 
			{
				if ($this->send('sergey.shevsky@gmail.com', 'Forgot password', 'Forgot Password'))
				{				
					$this->assign('notice', Kohana::lang('notice.forgot.successfully'));
				}
				else 
				{
					$this->assign('notice', Kohana::lang('notice.forgot.failed'));
				}
			} 
			else 
			{
				$this->assign('notice', Kohana::lang('notice.forgot.notfound'));
			}
			
			$this->render();
		}
		else 
		{
			$this->template = 'base/auth/forgot';
			$this->render();
		}
    }
    
	public function logout()
    {
    	if (Auth::instance()->logged_in())
    	{
    		Auth::instance()->logout();
    	}
    	
    	url::redirect(Kohana::config('urls.main'));
    }
}