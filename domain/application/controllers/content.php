<?php defined('SYSPATH') OR die('No direct access allowed.');

class Content_Controller extends Base_Controller
{
    public function __construct()
    {
		parent::__construct();
        $this->template = 'xml/content';
    }
    
    public function __call($method, array $args)
    {}
    
    public function rules()
    {                
        $this->assign('title', Kohana::lang('content.title_rules'));
        $this->assign('content', Content_Model::instance()->page(2, $this->get_name()));
        $this->view();
    }    
    
    public function help()
    {                
        $this->assign('title', Kohana::lang('content.title_help'));
        $this->assign('content', Content_Model::instance()->page(1, $this->get_name()));
        $this->view();
    }    
    public function contacts()
    {                
        $this->assign('title', Kohana::lang('content.title_contacts'));
        $this->assign('content', Kohana::lang('content.contacts'));
        $this->view();
    }    
    public function used()
    {                
        $this->assign('title', Kohana::lang('content.title_used'));
        $this->assign('content', Kohana::lang('content.used'));
        $this->view();
    }    
    public function license()
    {                
        $this->assign('title', Kohana::lang('content.title_license'));
        $this->assign('content', Kohana::lang('content.license'));
        $this->view();
    }
    
    public function get_name() 
    {
        switch(Kohana::config('locale.language.0'))
        {
            case 'ru_RU':
                return 'body_ru';
            
            case 'en_US':
                return 'body_en';
                
            default:
                return 'body_en';
        }
    }
}