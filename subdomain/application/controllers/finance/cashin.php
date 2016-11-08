<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cashin_Controller extends Fields_Controller
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
        $this->template = 'finance/cashin/main';
        
        $this->assign('pagination', new Pagination(array
            (
                'uri_segment' => 'page',
                'total_items' => Finance_Cashin_Model::instance()->get_total_cashin(uri::segment('filter', 0)),
                'style' => 'sitex',
                'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
            )
        ));
        
        $this->assign('list_cashin', Finance_Cashin_Model::instance()->get_list_cashin(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));
        $this->assign('summ_cashin', Finance_Cashin_Model::instance()->get_summ_cashin(uri::segment('filter', 0)));
        $this->assign('list_player', Finance_Cashin_Model::instance()->get_list_player());
        
        $this->render();
    }
}