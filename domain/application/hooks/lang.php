<?php defined('SYSPATH') OR die('No direct access allowed.');

class Lang 
{
    public function get_lang()
    {
        if (Auth::instance()->logged_in())
        {
            $lang = Lang_Model::instance()->current_lang();
        }
        elseif(Session::instance()->get('lang'))
        {
            $lang = Session::instance()->get('lang');
        }
        else
        {
            $lang_id = Setting_Model::instance()->get('lang_id_default');
            $lang = Lang_Model::instance()->load($lang_id);
        }
        
        header("Content-type: text/html; charset=".Kohana::config('lang.'.$lang));
        header("Content-Language: ".Kohana::config('lang.content_lang.'.$lang));
        Kohana::config_set('locale.language', array($lang, ''));
    }
}

Event::add('system.pre_controller', array('Lang', 'get_lang'));