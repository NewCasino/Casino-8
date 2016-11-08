<?php defined('SYSPATH') OR die('No direct access allowed.');

class Player_Controller extends Fields_Controller
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
    	Users_Player_Model::instance()->save($this->input->post());

    	url::redirect('users/player', 301);
    }
    
    public function edit()
    {
    	$this->template = 'users/player/form';
		
    	$this->assign('item_player', Users_Player_Model::instance()->get_item_player(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function add()
    {
    	$this->template = 'users/player/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	Users_Player_Model::instance()->delete($this->input->post('id'));
    }
    
    public function index()
    {
    	$this->template = 'users/player/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Users_Player_Model::instance()->get_total_player(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$array = Users_Player_Model::instance()->get_list_player(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', ''), uri::segment('sort', 0));
    	
    	foreach ($array as $row)
    	{
    		$row->add_cash = Users_Player_Model::instance()->get_item_add_cash($row->user_id);
    		$row->count_cashout = Users_Player_Model::instance()->get_item_count_cashout($row->user_id);
    		$row->user_balance = Users_Player_Model::instance()->get_item_balance($row->user_id);
    		$row->user_loss = $row->add_cash - $row->user_balance - Users_Player_Model::instance()->get_item_out_cash($row->user_id);
    	}
    	
		$this->assign('list_player', $array);    	
    	
    	$this->render();
    }
    
	public function count_username()
    {
    	$this->template = 'users/player/data';

    	$this->assign('data', Users_Player_Model::instance()->get_username_count(uri::segment('username', ''), uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function count_email()
    {
    	$this->template = 'users/player/data';

    	$this->assign('data', Users_Player_Model::instance()->get_email_count(uri::segment('email', ''), uri::segment('id', 0)));
    	
    	$this->render();
    }
}