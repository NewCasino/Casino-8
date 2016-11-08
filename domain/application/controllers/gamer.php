<?php defined('SYSPATH') OR die('No direct access allowed.');

class Gamer_Controller extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();        
        
        $this->initialization();
    }
    
    public function __call($method, $args)
    {}
    
    private function initialization()
    {
        foreach ($this->input->post() as $key => $value)
        {
            $this->assign($key, $value);
        }
    } 

    public function status()
    {
        $this->template = 'xml/gamer';
        
        if (Auth::instance()->logged_in())
        {
            Gamer_Model::instance()->last_bang();
        }
        
        $this->assign('item', array
        (
            'error' => Auth::instance()->logged_in() 
        		? Kohana::config('error.gamer.online') 
        		: Kohana::config('error.gamer.offline'),
        		
            'balance' => Auth::instance()->logged_in() 
        		? Gamer_Model::instance()->find_by('id', Auth::instance()->get_user()->id)->cash
        		: '',
        ));
        
        $this->view();
    }
    
public function login()
{
    $this->template = 'xml/gamer';
    
    if (Auth::instance()->logged_in())
    {
        if (! Gamer_Model::instance()->access_login(Auth::instance()->get_user()->id, $this->input->ip_address()))
        {
            $this->assign('item', array('error' => Kohana::config('error.login'), 'notice' => Kohana::lang('gamer.login.two_user')));
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.login.member')));
        }
    }
    elseif (Gamer_Model::instance()->username_exists($this->input->post('username')))
    {
        if ($this->input->post('username', FALSE))
        {
            $user = ORM::factory('user', $this->input->post('username'));
            
            if (Gamer_Model::instance()->role_control($user))
            {
                if (Gamer_Model::instance()->access_login($user->id, $this->input->ip_address()) AND Auth::instance()->login($user, $this->input->post('password')))
                {
                    $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => ''));
                    Gamer_Model::instance()->set_ip($this->input->ip_address());
                }
                else    
                {
                    $this->assign('item', array('error' => Kohana::config('error.login'), 'notice' => Kohana::lang('gamer.login.error')));
                }
            }
            else 
            {
                $this->assign('item', array('error' => Kohana::config('error.login'), 'notice' => Kohana::lang('gamer.login.error')));
            }
        }
        else 
        {
            $this->assign('item', array('error' => Kohana::config('error.login'), 'notice' => Kohana::lang('gamer.login.empty')));
        }
    }
    else 
    {
        $this->assign('item', array('error' => Kohana::config('error.login'), 'notice' => Kohana::lang('gamer.login.absent')));
    }
    
    $this->view();
}
    
    public function register()
    {
        $this->template = 'xml/gamer';
        
        if ($this->input->post('is18'))
        {
            $post = $this->input->post();
            $post = new Validation($post);
            
            $post->pre_filter('trim');
            $post->add_rules('username', 'required', 'chars[a-zA-Z0-9_.]');
            $post->add_rules('password', 'required', 'length[4,32]');
            $post->add_rules('email', 'required', 'valid::email', 'length[4,127]');
            $post->add_rules('retype', 'required', 'matches[password]');
            
            if ($post->validate()) 
            {
            	if (is_numeric(substr($post['username'], 0, 1)))
	            {
					$this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => Kohana::lang('gamer.register.fail_login')));
	            }
                elseif (Gamer_Model::instance()->email_exists($this->input->post('email')))
                {
                    $this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => Kohana::lang('gamer.register.double_email')));
                } 
                elseif (Gamer_Model::instance()->username_exists($this->input->post('username')))
                {
                    $this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => Kohana::lang('gamer.register.double_name')));
                }
                else
                {
                    $user = ORM::factory('user');
                                
                    $user->username = $this->input->post('username');
                    $user->password = $this->input->post('password');
                    $user->email = $this->input->post('email');
                    $user->password_original = $this->input->post('password');
                    
                    if ($user->add(ORM::factory('role', 'login')) AND $user->save()) 
                    {
                        Gamer_Model::instance()->save($user);
                        Gamer_Model::instance()->save_profile(NULL, array
                        (
                            'mailing' => $this->input->post('mailing'),
                            'bonus_id' => Gamer_Model::instance()->bonus_use($this->input->post('bonus'), $user->id),
                        ), $user->id);
                        
                        $this->mail($this->input->post('email'), Kohana::lang('gamer.register.email.title'), new View('email/register', array
                        (
                            'user_info' => Gamer_Model::instance()->find_by('email', $this->input->post('email'))
                        )));
                        
                        $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.register.notice')));
                    } 
                    else 
                    {
                        $this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => Kohana::lang('gamer.register.not_register')));
                    }
                }
            } 
            else 
            {
                $this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => ($post->errors('register_error'))? reset($post->errors('register_error')): ''));
            }
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.register'), 'notice' => Kohana::lang('gamer.register.is_18')));//вам нет 18
        }
        
        $this->view();
    }
    
    public function forgot()
    {
        $this->template = 'xml/gamer';
        
        if ($this->input->post('email'))
        {
            if (Gamer_Model::instance()->email_exists($this->input->post('email')))
            {
                $this->mail($this->input->post('email'), Kohana::lang('gamer.forgot.email.title'), new View('email/forgot', array
                (
                   'user_info' => Gamer_Model::instance()->find_by('email', $this->input->post('email'))
                )));                

                $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.forgot.notice')));
            } 
            else 
            {
                $this->assign('item', array('error' => Kohana::config('error.forgot'), 'notice' => Kohana::lang('gamer.forgot.absent')));
            }
        } 
        else 
        {
            $this->assign('item', array('error' => Kohana::config('error.forgot'), 'notice' => Kohana::lang('gamer.forgot.empty')));
        }
        
        $this->view();
    }
        
    public function logout()
    {
        $this->template = 'xml/gamer';
    	
        Auth::instance()->logout();
        
        $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.logout.notice')));
        
        $this->view();
    }

    public function info()
    {
        $this->template = 'xml/info';
        $this->assign('item', Gamer_Model::instance()->info());
        $this->view();
    }
    
    public function save_profile()
    {
        $this->template = 'xml/gamer';
        
        if (Auth::instance()->logged_in())
        {         
            if (Gamer_Model::instance()->save_profile(array('email' => $this->input->post('email'),),array
            (
                'name' => $this->input->post('name'),
                'avatar_id' => $this->input->post('avatar_id'),
                'country_id' => $this->input->post('country_id'),
                'city' => $this->input->post('city'),
                'sex' => $this->input->post('sex'),
                'phone' => $this->input->post('phone'),
                'mailing' => $this->input->post('mailer'),
            )))
            {
                $this->assign('item', array('error' => Kohana::config('error.gamer.successfully'), 'notice' => Kohana::lang('gamer.profile.notice')));
            }
            else
            {
                $this->assign('item', array('error' => Kohana::config('error.gamer.offline'), 'notice' => Kohana::lang('gamer.profile.no_save')));
            }
        }
        else
        {
            $this->assign('item', array('error' => Kohana::config('error.gamer.offline'), 'notice' => Kohana::lang('gamer.profile.login')));
        }
        
        $this->view();
    }
    
    
    public function main_page() 
    {
        url::redirect(Setting_Model::instance()->get('url'));
    }

}
?>