<?php defined('SYSPATH') OR die('No direct access allowed.');

class Base_Controller extends Template_Controller {
	
    public $use_auth = FALSE;
    
	public function __construct()
	{				
		parent::__construct();
		
		if ($this->use_auth)
		{
    	    if ( ! Auth::instance()->logged_in()) 
            {
            	url::redirect(Kohana::config('urls.login'));        	
            }
		}
        
        $this->initialize(); 
	}
	
	public function __destruct()
	{}
	
	public function __call($method, array $args)
	{}
			
	public static function instance()
	{		
		static $instance;

		($instance === NULL) and $instance = new self;

		return $instance;
	}
    
    public function initialize()
    {  }

    public function mail($to = NULL, $subject = NULL, $message = NULL, $attachment = array())
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
    
    public function log_add($var, $title = '')
    {
        Kohana::log('error', $title.' -> '. Kohana::debug($var));
        kohana::log_save();
    }
    
    public function session_append($name = '', $value = '')//Only one level
    {
        if (Session::instance()->get($name, FALSE) === FALSE)
        {
            Session::instance()->set($name, is_array($value)? $value: array($value));
        }
        elseif (is_array(Session::instance()->get($name)))
        {
            //array_merge(Session::instance()->get($name), is_array($value)? $value: array($value)
            $new_arr = Session::instance()->get($name);
            $new_arr += (is_array($value)? $value: array($value));
            Session::instance()->set($name, $new_arr );
        }
    }
    
    public function session_read($name = '', $key = '')
    {
        if (Session::instance()->get($name, FALSE) === FALSE)
        {
            return FALSE;
        }
        elseif (! is_array(Session::instance()->get($name)))
        {
            return FALSE;
        }
        
        $array = Session::instance()->get($name);
        if (isset($array[$key]))
        {
            return $array[$key];
        }
        else
        {
            return FALSE;
        }
    }
    
}