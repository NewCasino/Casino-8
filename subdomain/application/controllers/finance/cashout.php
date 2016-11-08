<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cashout_Controller extends Fields_Controller
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
        Finance_Cashout_Model::instance()->save($this->input->post());

        url::redirect('finance/cashout', 301);
    }
    
    public function edit()
    {
        $this->template = 'finance/cashout/form';
        
        $this->assign('item_cashout', Finance_Cashout_Model::instance()->get_item_cashout(uri::segment('id', 0)));
        
        $this->render();
    }
    
    public function index()
    {
        $this->template = 'finance/cashout/main';
        
        $this->assign('pagination', new Pagination(array
            (
                'uri_segment' => 'page',
                'total_items' => Finance_Cashout_Model::instance()->get_total_cashout(uri::segment('filter', 0)),
                'style' => 'sitex',
                'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
            )
        ));
        
        $this->assign('list_cashout', Finance_Cashout_Model::instance()->get_list_cashout(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));
        $this->assign('summ_cashout', Finance_Cashout_Model::instance()->get_summ_cashout(uri::segment('filter', 0)));
         $this->assign('list_player', Finance_Cashout_Model::instance()->get_list_player());
        
        $this->render();
    }
}