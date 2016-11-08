<?php defined('SYSPATH') OR die('No direct access allowed.');

class Events_Controller extends Fields_Controller
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
    
    public function index()
    {
        $this->template = 'online/monitor/events';
        
        $this->assign('events_list', Online_Model::instance()->get_list_events($this->input->post('games_id'), $this->input->post('categories_id')));
        
        $this->render();
    }
    
	public function get_last()
    {
        $this->template = 'online/monitor/last_events';
        
        $this->assign('events_list', Online_Model::instance()->get_last_events($this->input->post('games_id'), $this->input->post('categories_id'), $this->input->post('last_id')));
        
        $this->render();
    }
}