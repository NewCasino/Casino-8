<?php defined('SYSPATH') OR die('No direct access allowed.');

class Cash_Model extends Model 
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function instance()
    {
        static $instance;
        
        if ($instance === NULL)
        {        
            $instance = new self;
        }
        
        return $instance;
    }
    
    public function save($value = NULL, $cash_out = TRUE, $history = TRUE)
    {                                                  
        $user = Gamer_Model::instance()->find_by('id', isset($value['user_id'])? $value['user_id']: Auth::instance()->get_user()->id );
        
        if ($user)
        {
            if ($value['type'])
            {
                $this->db->update('user_payment', array
                (
                    'cash' => $user->cash + $value['amount'], 
                    'total_in' => $user->total_in + $value['amount']
                ), array
                (
                    'id' => $user->id,
                ));
            }
            else
            {
                $this->db->update('user_payment', array
                (
                    'cash' => $user->cash - $value['amount'], 
                    'total_out' => $user->total_out + $value['amount']
                ), array
                (
                    'id' => $user->id
                ));
            }   
            
            
            $value['payment_info'] = (isset($value['payment_info']))? $value['payment_info']: 'cash in';
            
            if ($cash_out AND $history)
            {               
                $this->cash_motion(array
                (
                    'user_id' => $user->id,
                    'amount' => $value['amount'],
                    'status' => $value['status'],
                    'type' => $value['type'],
                    'pincode_id' => isset($value['pincode_id'])? $value['pincode_id']: 0,
                    'merchant_request_id' => isset($value['merchant_request_id'])? $value['merchant_request_id']: 0,
                    'payment_info' => $value['payment_info'],
                ));
            }
            elseif ($cash_out)
            {
                $this->db->insert('user_cashout', array
                (
                    'user_id' => $user->id,
                    'amount' => $value['amount'],
                    'payment_info' => $value['payment_info'],
                    'status' => $value['status'],
                    'created' => time(),
                ));
            }
            elseif ($history)
            {
                $this->payment_history_add(array
                (
                    'user_id' => $user->id,
                    'amount' => $value['amount'],
                    'status' => $value['status'],
                    'type' => $value['type'],
                    'pincode_id' => isset($value['pincode_id'])? $value['pincode_id']: 0,
                    'merchant_request_id' => isset($value['merchant_request_id'])? $value['merchant_request_id']: 0,
                ));
            }
            
            
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function cash_motion($pairs = NULL)
    {
        $res = $this->db->insert('user_cashout', array
        (
            'user_id' => $pairs['user_id'],
            'amount' => $pairs['amount'],
            'payment_info' => $pairs['payment_info'],
            'status' => $pairs['status'],
            'created' => time(),
        ));
        $pairs['cashout_id'] = $res->insert_id();
        
        $this->payment_history_add($pairs);
    }
    
    public function payment_history_add($pairs = NULL)
    {
        $this->db->insert('user_payment_history', array
        (
            'user_id' => $pairs['user_id'],
            'pincode_id' => isset($pairs['pincode_id'])? $pairs['pincode_id']: 0,
            'merchant_request_id' => isset($pairs['merchant_request_id'])? $pairs['merchant_request_id']: 0,
            'type' => $pairs['type'],
            'amount' => $pairs['amount'],
            'status' => $pairs['status'],
            'datetime' => time(),
            'cashout_id' => (isset($pairs['cashout_id']))? $pairs['cashout_id']: 0,
        ));
    }
    
    public function payment_history($cash_out = FALSE)
    {
        return $this->db
            ->from('user_payment_history')
            ->where('user_id', Auth::instance()->get_user()->id)
            ->orderby('id', 'DESC')
            ->get()
            ->result_array();
    }
    
    public function cancel($payment_id = NULL)
    {
        $payment = $this->db
            ->select('amount, status, cashout_id')
            ->from('user_payment_history')
            ->where(array('id' => $payment_id, 'user_id' => Auth::instance()->get_user()->id))
            ->get()
            ->result_array();
        
        if (! isset($payment[0]) OR $payment[0]->status != 2)
        {
            return FALSE;
        }
        
        $user_payment = $this->db
            ->from('user_payment')
            ->where('id', Auth::instance()->get_user()->id)
            ->get()
            ->result_array();
            
        $this->db->update
        (
            'user_payment', 
            array('cash' => $user_payment[0]->cash + $payment[0]->amount, 'total_out' => $user_payment[0]->total_out - $payment[0]->amount),
            array('id' => Auth::instance()->get_user()->id,)
        );
        
        $this->db->update
        (
            'user_payment_history', 
            array('status' => 3),
            array('id' => $payment_id, 'user_id' => Auth::instance()->get_user()->id)
        );        
        
        $this->db->update
        (
            'user_cashout', 
            array('status' => 3),
            array('id' => $payment[0]->cashout_id, 'user_id' => Auth::instance()->get_user()->id)
        );

        return TRUE;
    }
    
//------------------------------------------------------------------------------
//      M E R C H A N T
    public function claim_add($payment_id = NULL)
    {
        $this->db->insert('merchant_request', array
        (
            'user_id' => Auth::instance()->get_user()->id,
            'payment_id' => $payment_id,
        ));
        
        return TRUE; 
    }
    
    public function claim_update($payment_id = NULL, $pairs = NULL)// $count = NULL, $currency_id = NULL
    {
        if (isset($pairs) AND isset($payment_id))
        {
            $this->db->update('merchant_request', $pairs, array('payment_id' => $payment_id));
            $request_id = $this->db
                ->from('merchant_request')
                ->where('payment_id', $payment_id)
                ->get()
                ->result_array();
                
            return (isset($request_id[0]))? $request_id[0]->id: FALSE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function price($currency = NULL)
    {
        if (isset($currency))
        {
            $price = $this->db
                ->from('currency')
                ->where(array('src' => $currency, 'active' => 1))
                ->get()
                ->result_array();
            
            return (isset($price[0]))? $price[0]: FALSE;    
        }
        else
        {
            return FALSE;
        }
    }
    
    public function status($payment_id = NULL)
    {
        if (isset($payment_id))
        {
            $status = $this->db
                ->from('merchant_request')
                ->where('payment_id', $payment_id)
                ->get()
                ->result_array();
            
            return (isset($status[0]))? $status[0]->status: FALSE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function get_payment($payment_id = NULL)
    {
        if (isset($payment_id))
        {
            $payment = $this->db
                ->from('merchant_request')
                ->where('id', $payment_id)
                ->get()
                ->result_array();
                
            return (isset($payment[0]))? $payment[0]: FALSE;
        }
        else
        {
            return FALSE;
        }
    }
    
    public function set_status($payment_id = NULL, $status = NULL)
    {
        if (isset($payment_id) AND isset($status))
        {
            $this->db->update('merchant_request', array
            (
                'status' => $status, 
                'time_end' => time()
            ), 
            array('id' => $payment_id));
        }
    }

    
    
    public function detect_payment($payment_id = NULL, $user_id = NULL)
    {
        if (isset($payment_id) AND isset($user_id))
        {
            $result = $this->db
                ->from('merchant_request')
                ->where(array('id' => $payment_id, 'user_id' => $user_id))
                ->get()
                ->result_array();
            if (isset($result[0]) AND $result[0]->status == 1)
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
    
    public function load_merchant($merchant_id = NULL)
    {
        if (isset($merchant_id) AND is_numeric($merchant_id))
        {
            return $this->db
                ->from('merchant')
                ->where('id', $merchant_id)
                ->get()
                ->current();
        }
        else 
        {
            return FALSE;
        }
    }

//------------------------------------------------------------------------------
//    
    public function bonus_use($bonus_id = NULL, $user_id = NULL, $amount = NULL)
    {
        if (isset($bonus_id) AND isset($user_id) AND isset($amount))
        {
            $this->db->update('bonus', array('status' => 2, 'user_id' => $user_id, 'changed' => time()), array('id' => $bonus_id));
            $this->save(array
            (
                'user_id' => $user_id,
                'amount' => $amount,
                'status' => 1,
                'type' => 1,
            ), FALSE);
            
            return TRUE;
        }
        else 
        {
            return FALSE;
        }
    }
    
}