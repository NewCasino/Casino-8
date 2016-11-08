<?php defined('SYSPATH') or die('No direct access allowed.');

class Base_Mailer_Controller extends Template_Controller {
	
	public function __construct() 
	{
		parent::__construct();
	}
	
	public function send($to = NULL, $subject = NULL, $message = NULL, $attachment = array())
    {
        $swift = email::connect();

        $recipients = new Swift_RecipientList();
        $recipients->addTo($to);

        $message = new Swift_Message($subject, $message, "text/html");

        foreach ($attachment as $key => $value)
        {
            $swiftfile = new Swift_File($value);
            $attachment = new Swift_Message_Attachment($swiftfile);
            $message->attach($attachment);
        }

        if ($swift->send($message, $recipients, Kohana::config('email.from')))
        {
            $swift->disconnect();

            return TRUE;
        }

        return FALSE;
    }
}

class Base_Controller extends Base_Mailer_Controller {
	
	public $use_auth = FALSE;
	
	public function __construct() 
	{			
		if (Session::instance()->get('current_page')) 
		{
			Session::instance()->set('previus_page', Session::instance()->get('current_page'));
		} 
		else 
		{
			Session::instance()->set('previus_page', url::current());
		}
				
		Session::instance()->set('current_page', url::current());
		
		parent::__construct();
		
		if ($this->use_auth) 
		{
			if ( ! (Auth::instance()->logged_in('admin') || Auth::instance()->logged_in('root'))) 
			{
				url::redirect(Kohana::config('urls.login'));
			}
		}
	}	
	
	public function __destruct() 
	{}
	
	public function __call($method, array $args) 
	{}
	
	public static function instance() 
	{
		static $instance;
		
		($instance === NULL) and $instance = new self();
		
		return $instance;
	}
}