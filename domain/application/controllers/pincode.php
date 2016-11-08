<?php defined('SYSPATH') OR die('No direct access allowed.');

class Pincode_Controller extends Base_Controller
{
    public function __construct()
    {
        $this->use_auth = TRUE;
        
    	parent::__construct();
    }

    public function __call($method, array $args)
    {}
    
    public function in()
    {
        $this->template = 'xml/cash';
        
        $code = $this->input->post('code');
        
        if (empty($code))
        {
            $this->assign('item', array('error' => Kohana::config('error.pincode.empty_code'), 'notice' => Kohana::lang('pincode.empty')));
        }
        else 
        {
            if (Pincode_Model::instance()->exists($code))
            {
                Pincode_Model::instance()->enter($code);
                
                $pincode = reset(Pincode_Model::instance()->info('code', $code));
                
                Cash_Model::instance()->save(array
                (
                    'pincode_id' => $pincode->id,
                    'amount' => $pincode->amount,
                    'type' => 1,
                    'status' => 1,
                ), FALSE);

                $this->assign('item', array('error' => Kohana::config('error.pincode.successfully'), 'notice' => Kohana::lang('pincode.successfully')));
            }
            else
            {
                $this->assign('item', array('error' => Kohana::config('error.pincode.exists_code'), 'notice' => Kohana::lang('pincode.absent')));
            }
        }
         
        $this->view();
    }
    
}