<?php defined('SYSPATH') OR die('No direct access allowed.');

class Event_Controller extends Base_Controller
{
    public function __construct()
    {
        $this->use_auth = TRUE;
        
        parent::__construct();
    }

    public function __call($method, array $args)
    {}
    
    public function iface($action = NULL)
    {
        if (uri::segment(3, 0))
        {
            Event_Model::instance()->save_info(array(uri::segment(3) => ! Event_Model::instance()->info(uri::segment(3))));
        }
    }
    

}