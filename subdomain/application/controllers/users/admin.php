<?php defined('SYSPATH') OR die('No direct access allowed.');

class Admin_Controller extends Fields_Controller
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
    	Users_Admin_Model::instance()->save($this->input->post());

    	url::redirect('users/admin', 301);
    }
    
    public function edit()
    {
    	$this->template = 'users/admin/form';
		
    	$this->assign('item_admin', Users_Admin_Model::instance()->get_item_admin(uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function add()
    {
    	$this->template = 'users/admin/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	Users_Admin_Model::instance()->delete($this->input->post('id'));
    }
    
    public function index()
    {
    	$this->template = 'users/admin/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Users_Admin_Model::instance()->get_total_admin(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$this->assign('list_admin', Users_Admin_Model::instance()->get_list_admin(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));    	
    	
    	$this->render();
    }
    
	public function count_username()
    {
    	$this->template = 'users/admin/data';

    	$this->assign('data', Users_Admin_Model::instance()->get_username_count(uri::segment('username', ''), uri::segment('id', 0)));
    	
    	$this->render();
    }
    
	public function count_email()
    {
    	$this->template = 'users/admin/data';

    	$this->assign('data', Users_Admin_Model::instance()->get_email_count(uri::segment('email', ''), uri::segment('id', 0)));
    	
    	$this->render();
    }
}