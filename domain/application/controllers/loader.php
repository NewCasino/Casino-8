<?php defined('SYSPATH') OR die('No direct access allowed.');

class Loader_Controller extends Base_Controller
{
	public function __construct()
	{
	    parent::__construct();
    }

	public function __call($method, $args)
	{}
	
	public function index()
	{
		$game = $this->input->post('game', FALSE);
        if ($game)
        {
            $sgame = substr($game, 1);
            $sgame = substr($sgame, 0, -4);
            
            if (Kohana::config('loader.'.$sgame))
            {
                $this->template = Kohana::config('loader.'.$sgame);
            }
            else
            {
                $this->template = 'games/loader';
                $this->assign('game', $game);
            }
        }
        else
        {
            $this->template = 'loader';
        }
        
		$this->view();	 
	}
}