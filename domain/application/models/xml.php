<?php defined('SYSPATH') OR die('No direct access allowed.');

class Xml_Model extends Model 
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
       
    public function news($count = FALSE, $orderby = FALSE)
    {
        return $this->db
            ->from('content_news')
            ->orderby('date', $orderby)
            ->limit($count)
            ->get()
            ->result_array();
    }
    
    public function lang()
    {
        return $this->db
            ->from('setting_lang')
            ->get()
            ->result_array();
    }
    
    public function menu_type()
    {
        return $this->db
            ->from('content_menu_type')
            ->get()
            ->result_array();
    }
    
    public function menu($type_id = FALSE)
    {
        if ($type_id)
        {
            return $this->db
                ->from('content_menu')
                ->where('type_id', $type_id)
                ->orderby('position', 'ASC')
                ->get()
                ->result_array();
        }

        return NULL;
    }
    
    public function games_categories()
    {
        $categories = $this->db
            ->select('categories.*, avatar_categories.src as avatar_src')
            ->from('categories')
            ->join('avatar_categories', 'avatar_categories.id', 'categories.avatar_id', 'LEFT')
            ->orderby('sort', 'ASC')
            ->get()
            ->result_array();
                            
        foreach ($categories as $key => $value)
        {
            $categories[$key]->games = $this->db
                ->select('games.*, media.name as media_name')
                ->from('games')
                ->join('media', 'media.id', 'games.media_id', 'LEFT')
                ->where(array('games.categories_id' => $value->id, 'view' => 1))
                ->orderby('games.sort', 'ASC')
                ->get()
                ->result_array();
        }
        
        return $categories;
    }
    
    public function template_name()
    {
        $result = reset($this->db
            ->select('setting_template.name AS name')
            ->from('setting_template')
            ->join('setting', 'setting.template_id', 'setting_template.id')
            ->get()
            ->result_array());
            
       return $result->name;
    }
    
        
    public function jackpot()
    {
        $result->value = $this->db
            ->query("SELECT SUM(balance) as total_jackpot FROM banking WHERE type=?", 'jackpot')
            ->current()
            ->total_jackpot;
        
        $result->interval = 100;
        return $result;
//        $object = new stdClass();
//        
//        $result = reset($this->db
//            ->select('amount')
//            ->from('jackpot')
//            ->where(array('default' => 1))
//            ->get()
//            ->result_array());
//        
//        $object->value = $result->amount + doubleval('0.00'.rand(0, rand(1, 999)));
//        
//        $this->db->update('jackpot', array('amount' => $object->value), array('default' => '1'));
//        
//        $object->value = number_format($object->value, 2, ',', '.');     
//        $object->interval = rand(1, 30);
//            
//        return $object;
    }
    
    public function player()
    {
        return $this->db
            ->from('mp3')
            ->orderby(NULL, 'RAND()')
            ->get()
            ->result_array();
    }
    
    public function avatar()
    {
        $male = $this->db
            ->from('avatar_user')
            ->where('mode', 1)
            ->orderby('sort', 'ASC')
            ->get()
            ->result_array();
        $female = $this->db
            ->from('avatar_user')
            ->where('mode', 2)
            ->orderby('sort', 'ASC')
            ->get()
            ->result_array();
        
        return array('male' => $male, 'female' => $female);
    }
    
    public function currency()
    {
        return $this->db
            ->from('currency')
            ->where('active', 1)
            ->orderby('sort', 'ASC')
            ->get()
            ->result_array();
    }

}