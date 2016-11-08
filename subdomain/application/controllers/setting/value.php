<?php defined('SYSPATH') OR die('No direct access allowed.');

class Value_Controller extends Fields_Controller
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
    
	public function save()
    {
    	Setting_Value_Model::instance()->save($this->input->post());
    	
    	url::redirect('setting/value', 301);
    }
    
    public function index()
    {
    	$this->template = 'setting/value/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Setting_Value_Model::instance()->get_total_value(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$this->assign('list_value', Setting_Value_Model::instance()->get_list_value(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0)));    	
    	
    	$this->render();
    }
}