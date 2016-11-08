<?php defined('SYSPATH') OR die('No direct access allowed.');

class Games_Controller extends Fields_Controller
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
    	Manage_Games_Model::instance()->save($this->input->post());

    	url::redirect('manage/games', 301);
    }
    
    public function edit()
    {
    	$this->template = 'manage/games/form';
		
    	$this->assign('item_games', Manage_Games_Model::instance()->get_item_games(uri::segment('id', 0)));
    	$this->assign('list_games_setting', Manage_Games_Model::instance()->get_list_games_setting(uri::segment('id', 0)));
    	$this->assign('list_banking', Manage_Games_Model::instance()->get_list_banking());
    	$this->assign('list_categories', Manage_Games_Model::instance()->get_list_categories());    	
    	$this->assign('list_games_banking', Manage_Games_Model::instance()->get_list_games_banking(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
    public function index()
    {
    	$this->template = 'manage/games/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Manage_Games_Model::instance()->get_total_games(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$this->assign('list_categories', Manage_Games_Model::instance()->get_list_categories());    	
    	$this->assign('list_games', Manage_Games_Model::instance()->get_list_games(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));    	
    	$this->assign('list_banking', Manage_Games_Model::instance()->get_list_banking());
    	$this->assign('list_games_banking', Manage_Games_Model::instance()->get_list_games_banking());
    	
    	$this->render();
    }
}