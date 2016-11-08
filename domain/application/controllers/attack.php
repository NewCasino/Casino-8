<?php defined('SYSPATH') OR die('No direct access allowed.');

class Attack_Controller extends Base_Controller
{
    public function __construct()
    {
		parent::__construct();
    }
    
    public function __call($method, array $args)
    {
        Attack_Model::instance()->save(join('/', $this->uri->segment_array()), $this->system_message());
        $a = '1.1';
        $b = 1.2;
        $c = 1;
        $d = '1,5';
        $e = (float) $a + $b;
        $f = (float) $c + $b;
        echo 'a|'.$a.'|'.doubleval($a).'|'.floatval($a).'|'.((float) $a).'|'.((real) $a).'<br />';
        echo 'b|'.$b.'|'.doubleval($b).'|'.floatval($b).'|'.((float) $b).'|'.((real) $b).'<br />';
        echo 'c|'.$c.'|'.doubleval($c).'|'.floatval($c).'|'.((float) $c).'|'.((real) $c).'<br />';
        echo 'd|'.$d.'|'.doubleval($d).'|'.floatval($d).'<br />';
        echo 'e|'.$e.'|'.doubleval($e).'|'.floatval($e).'<br />';
        echo 'f|'.$f.'|'.doubleval($f).'|'.floatval($f).'<br />';
        
        $e = str_replace(',', '.', $e);
        $f = str_replace(',', '.', $f);
        $f = $f + $a;
        echo 'e|'.$e.'|'.doubleval($e).'|'.floatval($e).'<br />';
        echo 'f|'.$f.'|'.doubleval($f).'|'.floatval($f).'<br />';
    }
    
    public function system_message()
    {
        /**
         * 1. Определять тип атаки
         * 2. Сообщение брать из конфига
         */
        return 'hack';
    }
}