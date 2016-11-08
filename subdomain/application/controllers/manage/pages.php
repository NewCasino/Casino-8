<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pages_Controller extends Fields_Controller
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
    	Manage_Pages_Model::instance()->save($this->input->post());

    	url::redirect('manage/pages', 301);
    }
    
    public function edit()
    {
    	$this->template = 'manage/pages/form';
		
    	$this->assign('item_pages', Manage_Pages_Model::instance()->get_item_pages(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
    public function index()
    {
    	$this->template = 'manage/pages/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Manage_Pages_Model::instance()->get_total_pages(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$array = Manage_Pages_Model::instance()->get_list_pages(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', ''), uri::segment('sort', 0));
    	
		$this->assign('list_pages', $array);    	
    	
    	$this->render();
    }
}