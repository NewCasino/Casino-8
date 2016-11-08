<?php defined('SYSPATH') OR die('No direct access allowed.');

class Bonus_Controller extends Fields_Controller
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
        Finance_Bonus_Model::instance()->save($this->input->post());

        url::redirect('finance/bonus', 301);
    }
    
	public function save_collection()
    {
    	$this->template = 'finance/bonus/data';
        echo Finance_Bonus_Model::instance()->save_collection($this->input->post());
    }
    
    public function edit()
    {
        $this->template = 'finance/bonus/form';
        
        $this->assign('item_bonus', Finance_Bonus_Model::instance()->get_item_bonus(uri::segment('id', 0)));
        $this->assign('list_collection', Finance_Bonus_Model::instance()->get_list_collection());
        
        $this->render();
    }
    
    public function index()
    {
        $this->template = 'finance/bonus/main';
        
        $this->assign('pagination', new Pagination(array
            (
                'uri_segment' => 'page',
                'total_items' => Finance_Bonus_Model::instance()->get_total_bonus(uri::segment('filter', 0)),
                'style' => 'sitex',
                'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
            )
        ));
        
        $this->assign('list_bonus', Finance_Bonus_Model::instance()->get_list_bonus(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));
        $this->assign('list_collection', Finance_Bonus_Model::instance()->get_list_collection());
        
        $this->render();
    }
}