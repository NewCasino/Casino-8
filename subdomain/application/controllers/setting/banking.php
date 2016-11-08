<?php defined('SYSPATH') OR die('No direct access allowed.');

class Banking_Controller extends Fields_Controller
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
    	$array = $this->input->post();
        
    	$id = Setting_Banking_Model::instance()->save($array);
        
        if (Setting_Banking_Model::instance()->get_total_type_banking($array['banking']['type']) == 1)
        {
        	Setting_Banking_Model::instance()->set_default($id);
        }
        
        if (isset($array['banking']['is_default']) && ($array['banking']['is_default'] == 1))
        {
        	Setting_Banking_Model::instance()->unset_default($id, $array['banking']['type']);
        }
        
        url::redirect('setting/banking', 301);
    }
    
    public function edit()
    {
        $this->template = 'setting/banking/form';
        
        $this->assign('item_banking', Setting_Banking_Model::instance()->get_item_banking(uri::segment('id', 0)));
        
        $this->render();
    }
    
	public function add()
    {
    	$this->template = 'setting/banking/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	foreach ($this->input->post('id') as $row)
    	{
    		$type = Setting_Banking_Model::instance()->get_type($row);
    		$id = Setting_Banking_Model::instance()->get_default($type);
    		Setting_Banking_Model::instance()->update_games_banking($row, $id);
    		Setting_Banking_Model::instance()->delete($row);
    		
    	}
    }
    
    public function index()
    {
        $this->template = 'setting/banking/main';
        
        $this->assign('pagination', new Pagination(array
            (
                'uri_segment' => 'page',
                'total_items' => Setting_Banking_Model::instance()->get_total_banking(uri::segment('filter', 0)),
                'style' => 'sitex',
                'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
            )
        ));
        
        $this->assign('list_banking', Setting_Banking_Model::instance()->get_list_banking(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));
        $this->assign('list_games', Setting_Banking_Model::instance()->get_list_games());
    	$this->assign('list_games_banking', Setting_Banking_Model::instance()->get_list_games_banking());
        
        $this->render();
    }
}