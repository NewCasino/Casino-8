<?php defined('SYSPATH') OR die('No direct access allowed.');

class Xml_Controller extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function __call($method, $args)
    {}
    
    public function init()
    {                
        $this->template = 'xml/init';
        $this->view();
    } 
       
    public function path()
    {
        $this->template = 'xml/path';
        $this->assign('template_name', Xml_Model::instance()->template_name());
        $this->assign('url_logo', Setting_Model::instance()->get('url'));
        $this->view();
    }
    
    public function event()
    {
        $this->template = 'xml/event';
        $this->view();
    }
            
    public function news()
    {
        $this->template = 'xml/news';
        $this->assign('item', Xml_Model::instance()->news(3, 'DESC'));
        $this->view();
    }            
    
    public function lang()
    {
        $this->template = 'xml/lang';
        $this->assign('item', Xml_Model::instance()->lang());
        $this->assign('current', Kohana::config('locale.language.0'));
        $this->view();
    }
        
    public function variables()
    {
        $this->template = 'xml/variables';
        
        $this->assign('item', Kohana::lang('variables'));
        $this->assign('currncy', Setting_Model::instance()->get('currency'));
        
        $this->view();
    } 
           
    public function menu()
    {
        $this->template = 'xml/menu';
    
        foreach (Xml_Model::instance()->menu_type() as $row)
        {
            $array[$row->title] = Xml_Model::instance()->menu($row->id);
        }
    
        $this->assign('item', $array);
        $this->view();
    } 
              
    public function games_categories()
    {
        $this->template = 'xml/games_categories';
        $this->assign('item', Xml_Model::instance()->games_categories());
        $this->view();
    }
    
    public function keyboard()
    {
        $this->template = 'xml/keyboard';
        $this->view();
    }    
    
    public function jackpot()
    {
        $this->template = 'xml/jackpot';
        $this->assign('item', Xml_Model::instance()->jackpot());
        $this->view();
    }   
    
    public function player()
    {
        $this->template = 'xml/player';
        $this->assign('item', Xml_Model::instance()->player());
        
        $this->view();
    }    
    
    public function country()
    {
        $this->template = 'xml/country';
        $this->assign('item', Kohana::lang('country'));
                 
        $this->view();
    }
    
    public function avatar()
    {
        $this->template = 'xml/avatar';
        $this->assign('item', Xml_Model::instance()->avatar());
                 
        $this->view();
    }
    
    public function currency()
    {
        $this->template = 'xml/currency';
        $this->assign('item', Xml_Model::instance()->currency());
                 
        $this->view();
    }
    
    public function alert()
    {
        $this->template = 'xml/alert';
        $this->assign('alert', Kohana::lang('xml.'.$this->input->post('alert')));
                 
        $this->view();
    }
}