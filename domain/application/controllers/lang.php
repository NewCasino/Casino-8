<?php defined('SYSPATH') OR die('No direct access allowed.');

class Lang_Controller extends Base_Controller
{
    public function __construct()
    {
		parent::__construct();
    }
    
    public function __call($method, array $args)
    {}
    
    public function set()
    {
        $this->template = 'xml/gamer';
        
        if (uri::segment(3, 0) AND Kohana::config('lang.'.uri::segment(3, 0)))
        {
            if (Auth::instance()->logged_in())
            {
                Lang_Model::instance()->save(uri::segment(3, 0));
            }

            Session::instance()->set('lang', uri::segment(3, 0));
            
            $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.lang.successfully')));
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.gamer.availability'), 'notice' => Kohana::lang('gamer.lang.error')));
        }
        
        $this->view();
    }
    
}