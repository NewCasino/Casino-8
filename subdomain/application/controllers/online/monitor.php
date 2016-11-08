<?php defined('SYSPATH') OR die('No direct access allowed.');

class Monitor_Controller extends Fields_Controller
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
        $this->template = 'online/monitor/main';
        
        $array = Online_Model::instance()->get_list_games();
        $list_games = array();
        
        foreach ($array as $row)
        {
        	$list_games[$row->categories_title][] = $row;
        }
        
        $this->assign('list_games', $list_games);
        $this->assign('events_list', Online_Model::instance()->get_list_events(NULL));
        
        $this->render();
    }
}