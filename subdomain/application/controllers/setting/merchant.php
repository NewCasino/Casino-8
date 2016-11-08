<?php defined('SYSPATH') OR die('No direct access allowed.');

class Merchant_Controller extends Fields_Controller
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
    	Setting_Merchant_Model::instance()->save($this->input->post());

    	url::redirect('setting/merchant', 301);
    }
    
    public function edit()
    {
    	$this->template = 'setting/merchant/form';
		
    	$this->assign('item_merchant', Setting_Merchant_Model::instance()->get_item_merchant(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function add()
    {
    	$this->template = 'setting/merchant/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	Setting_Merchant_Model::instance()->delete($this->input->post('id'));
    }
    
    public function index()
    {
    	$this->template = 'setting/merchant/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Setting_Merchant_Model::instance()->get_total_merchant(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$array = Setting_Merchant_Model::instance()->get_list_merchant(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', ''), uri::segment('sort', 0));
    	
		$this->assign('list_merchant', $array);    	
    	
    	$this->render();
    }
}