<?php defined('SYSPATH') OR die('No direct access allowed.');

class Collection_Controller extends Fields_Controller
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
    	Finance_Bonus_Collection_Model::instance()->save($this->input->post());

    	url::redirect('finance/bonus/collection', 301);
    }
    
    public function edit()
    {
    	$this->template = 'finance/bonus/collection/form';
		
    	$this->assign('item_collection', Finance_Bonus_Collection_Model::instance()->get_item_collection(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function add()
    {
    	$this->template = 'finance/bonus/collection/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	Finance_Bonus_Collection_Model::instance()->delete($this->input->post('id'));
    }
    
    public function index()
    {
    	$this->template = 'finance/bonus/collection/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Finance_Bonus_Collection_Model::instance()->get_total_collection(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$array = Finance_Bonus_Collection_Model::instance()->get_list_collection(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', ''), uri::segment('sort', 0));
    	
		$this->assign('list_collection', $array);    	
    	
    	$this->render();
    }
}