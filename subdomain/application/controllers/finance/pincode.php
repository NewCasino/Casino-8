<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pincode_Controller extends Fields_Controller
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
        Finance_Pincode_Model::instance()->save($this->input->post());

        url::redirect('finance/pincode', 301);
    }
    
	public function save_collection()
    {
    	$this->template = 'finance/pincode/data';
        echo Finance_Pincode_Model::instance()->save_collection($this->input->post());
    }
    
    public function edit()
    {
        $this->template = 'finance/pincode/form';
        
        $this->assign('item_pincode', Finance_Pincode_Model::instance()->get_item_pincode(uri::segment('id', 0)));
        $this->assign('list_collection', Finance_Pincode_Model::instance()->get_list_collection());
        
        $this->render();
    }
    
    public function index()
    {
        $this->template = 'finance/pincode/main';
        
        $this->assign('pagination', new Pagination(array
            (
                'uri_segment' => 'page',
                'total_items' => Finance_Pincode_Model::instance()->get_total_pincode(uri::segment('filter', 0)),
                'style' => 'sitex',
                'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
            )
        ));
        
        $this->assign('list_pincode', Finance_Pincode_Model::instance()->get_list_pincode(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));
        $this->assign('list_collection', Finance_Pincode_Model::instance()->get_list_collection());
        
        $this->render();
    }
}