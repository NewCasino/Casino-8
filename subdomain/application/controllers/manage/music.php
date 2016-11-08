<?php defined('SYSPATH') OR die('No direct access allowed.');

class Music_Controller extends Fields_Controller
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
    
	public function add()
    {
    	$this->template = 'manage/music/form';
    	
    	$this->render();
    }
    
	public function delete()
    {
    	$array = $this->input->post('id');
    	foreach ($array as $key => $value)
    	{
    		$file = Manage_Music_Model::instance()->get_file($value);
    		@unlink('media/mp3/'.$file);
     		Manage_Music_Model::instance()->delete($value);
     	}
    }
    
	public function save()
    {
    	$files = Validation::factory($_FILES)
        	->add_rules('file', 'upload::valid', 'upload::required', 'upload::type[mp3]', 'upload::size[10M]');
        	
		if ($files->validate())
		{
			foreach ($this->input->post('music') as $key => $value)
        	{
        		$pairs[$key] = $value;
        	}
        	
			if (isset($pairs['id']) && $pairs['id']!='')
			{
				$file = Manage_Music_Model::instance()->get_file($pairs['id']);
    			unlink('media/mp3/'.$file);
				$pairs['file'] = basename(upload::save($_FILES['file']));
			}
			else
			{
				$pairs['file'] = basename(upload::save($_FILES['file']));
			}
			
			Manage_Music_Model::instance()->save($pairs);
		}
        
    	
    	url::redirect('manage/music', 301);
    }
    
    public function edit()
    {
    	$this->template = 'manage/music/form';
		
    	$this->assign('item_music', Manage_Music_Model::instance()->get_item_music(uri::segment('id', 0)));
  	
    	$this->render();
    }
    
    public function index()
    {
    	$this->template = 'manage/music/main';
		
    	$this->assign('pagination', new Pagination(array
			(
				'uri_segment' => 'page',
				'total_items' => Manage_Music_Model::instance()->get_total_music(uri::segment('filter', 0)),
                'style' => 'sitex',
				'items_per_page' => Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')),
        	)
		));
    	
    	$this->assign('list_music', Manage_Music_Model::instance()->get_list_music(uri::segment('page', Kohana::config('pagination.default.first')), Session::instance()->get('items_per_page', Kohana::config('pagination.default.items_per_page')), uri::segment('filter', 0), uri::segment('sort', 0)));    	
    	
    	$this->render();
    }
}