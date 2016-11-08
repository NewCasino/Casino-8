<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cash_Controller extends Base_Controller
{
    public function __construct()
    {
        if (url::current() != 'cash/response_interkassa')
        {
            $this->use_auth = TRUE;
        }
        
        parent::__construct();
    }

    public function __call($method, $args)
    {}
    
    public function out()
    {
        $this->template = 'xml/cash';
        
        $user = Gamer_Model::instance()->find_by('id', Auth::instance()->get_user()->id);
        $amount = (int) $this->input->post('amount');
        
        if ($user->cash > $amount AND $amount > 0)
        {
            Cash_Model::instance()->save(array
            (
                'pincode_id' => 0,
                'amount' => $amount,
                'type' => 0,
                'status' => 2,
                'payment_info' => $this->input->post('payment_info'),
            ), TRUE, TRUE);
                
            $this->assign('item', array('error' => Kohana::config('error.cash.successfully'), 'notice' => Kohana::lang('cash.successfully')));
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.cash.not_enough'), 'notice' => Kohana::lang('cash.not_enough')));
        }
        
        $this->view();
    }
    
    public function cancel()
    {
        $this->template = 'xml/cash';
        
        if ($this->input->post('id'))
        {
            if (Cash_Model::instance()->cancel($this->input->post('id')))
            {
                $this->assign('item', array('error' => Kohana::config('error.cash.successfully'), 'notice' => Kohana::lang('cash.cansel_successfully')));
            }
            else
            {
                $this->assign('item', array('error' => Kohana::config('error.cash.not_enough'), 'notice' => Kohana::lang('cash.cansel_not')));
            }    
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.cash.not_enough'), 'notice' => Kohana::lang('cash.empty_id')));
        }
        
        $this->view();
    }
    
    
    
    
    public function payment_id()
    {
        $this->template = 'xml/cash';
        
        Session::instance()->set('user_id', Auth::instance()->get_user()->id);
        
        if ($this->input->post('amount') AND $this->input->post('amount') > 0)
        {
            $payment_id = md5(time());
            Cash_Model::instance()->claim_add($payment_id);
            
            $this->assign('item', array('error' => Kohana::config('error.cash.successfully'), 'payment_id' => $payment_id));
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.cash.not_enough'), 'notice' => Kohana::lang('cash.empty_fields')));
        }

        $this->view();
    }
    
    public function payment()
    {
        $this->template = 'cash';
        
        //print Kohana::debug($_POST);
        
        Session::instance()->set('user_id', Auth::instance()->get_user()->id);
        
        $currency = Cash_Model::instance()->price(uri::segment(3, NULL));
        $amount = $this->input->post('count') / Setting_Model::instance()->get('currency');
        
        if ($currency === FALSE)
        {
            $this->assign('item', Kohana::lang('cash.payment_add_error'));
        }
        elseif ($amount AND $this->input->post('payment_id'))
        {
            $request_id = Cash_Model::instance()->claim_update($this->input->post('payment_id') ,array
            (
                'merchant_id' => $currency->merchant_id,
                'amount' => $amount,
                'credit' => $this->input->post('count'),
                'time_begin' => time(),
                'currency_id' => $this->input->post('currency_id', 0),
            ));
            
            $merchant = Cash_Model::instance()->load_merchant($currency->merchant_id);
            if ($request_id !== FALSE AND $merchant)
            {
                $this->assign('item', sprintf($merchant->form, $amount, $request_id));
            }
            else
            {
                $this->assign('item', Kohana::lang('cash.empty_fields'));
            }            
        }
        else
        {
            $this->assign('item', Kohana::lang('cash.empty_fields'));
        }

        $this->view();
    }    
    
    public function status()
    {
        $this->template = 'xml/cash_status';
        
        if ($this->input->post('payment_id'))
        {
            $status = Cash_Model::instance()->status($this->input->post('payment_id'));
            if ($status !== FALSE)
            {
                $this->assign('error', Kohana::config('error.cash.successfully'));
                $this->assign('status', $status);
            }
            else
            {
                $this->assign('error', Kohana::config('error.cash.not_enough'));
                $this->assign('status', 0);
            }
        }
        else
        {
            $this->assign('error', Kohana::config('error.cash.not_enough'));
            $this->assign('status', 0);
        }
        
        $this->view();
    }
    
    public function response_interkassa()
    {
        Kohana::log('error', Kohana::debug($this->input->post()));
        if ($payment = Cash_Model::instance()->get_payment($this->input->post('ik_payment_id', 0)))
        {
            if ($merchant = Cash_Model::instance()->load_merchant($payment->merchant_id))
            {
                $secret_key = $merchant->secret_key;
            }
            else
            {
                $secret_key = '';
            }
        }
        else
        {
            $merchant = FALSE;
            $secret_key = '';
        }
        
        $sing_hash_str = $this->input->post('ik_shop_id').':'
            .$this->input->post('ik_payment_amount').':'
            .$this->input->post('ik_payment_id').':'
            .$this->input->post('ik_paysystem_alias').':'
            .$this->input->post('ik_baggage_fields').':'
            .$this->input->post('ik_payment_state').':'
            .$this->input->post('ik_trans_id').':'
            .$this->input->post('ik_currency_exch').':'
            .$this->input->post('ik_fees_payer').':'.$secret_key;
        $sign_hash = strtoupper(md5($sing_hash_str));
        
        
        $log = array($this->input->post('ik_sign_hash'), $sign_hash, ($this->input->post('ik_sign_hash')=== $sign_hash)? 'good':'not');
        Kohana::log('error', 'hash---'.Kohana::debug($log));  Kohana::log_save();
        
        
        if (! $merchant)
        {
            Kohana::log('error', 'not found merchant|ik_payment_id='.$this->input->post('ik_payment_id', 0));  Kohana::log_save();
        }
        elseif (($payment !== FALSE) AND ($payment->status == 1) AND ($payment->amount == $this->input->post('ik_payment_amount')) AND ($this->input->post('ik_sign_hash') === $sign_hash) AND ($this->input->post('ik_payment_state') == 'success'))
        {
            Cash_Model::instance()->set_status($payment->id, ($this->input->post('ik_payment_state') == 'success')? 2: 3);
            Cash_Model::instance()->save(array
            (
                'user_id' => $payment->user_id,
                'amount' => $payment->credit,
                'status' => 1,
                'type' => 1,
                'merchant_request_id' => $payment->id,
            ), FALSE);
        }
        else
        {
            Kohana::log('error', '-not_success->>> $payment='.Kohana::debug($payment));  Kohana::log_save();
        }
    }    
    
    public function success_ik()
    {
        $this->template = 'cash_responce';
        Session::instance()->delete('user_id');
        $this->view();
    }
    
    public function fail_ik()
    {
        $this->template = 'cash_responce';
        Session::instance()->delete('user_id');
        $this->view();
    }
}