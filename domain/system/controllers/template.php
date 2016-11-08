<?php defined('SYSPATH') OR die('No direct access allowed.');

class Template_Controller extends Controller {

	public $template;
	public $implement;

	public function __construct()
	{
        if (stripos($_SERVER['REQUEST_URI'], 'index.php') !== FALSE)
        {
            url::redirect(Kohana::config('urls.login'));
        }
        
		parent::__construct();
		
		(Kohana::config('config.display_profiler')) and new Profiler;
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

    public function assign($name, $value) 
    {        
    	$this->implement[$name] = $value; 
    }
	
	public function view()
	{
        $setting = Setting_Model::instance()->template();
        $this->view = new View($this->template);
        $this->view->head = new View('common/head');
        $this->view->header = new View('common/header');
        $this->view->footer = new View('common/footer');
        
        $this->view->head->title = $setting->title;
        $this->view->head->webmaster_tools = $setting->google_webmaster_tools;
        $this->view->head->description = $setting->description;
        $this->view->head->keywords = $setting->keywords;
        $this->view->footer->analytics = $setting->google_analytics;
        $this->view->index_path = '/media/flash/template/'.Xml_Model::instance()->template_name().'/index.swf';
        
        $this->implement();
        
        $this->view->render(TRUE);
	}
	
	public function implement()
	{
	    if (isset($this->implement))
	    {
    	    foreach ($this->implement as $key => $value)
    	    {
                $this->view->$key = $value;    
    	    }
	    }
	}
}