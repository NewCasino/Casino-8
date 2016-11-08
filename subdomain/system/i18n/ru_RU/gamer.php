<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'login' => array
    (
        'empty' => 'Пусто',
        'error' => 'Ошибка',        
        'absent' => 'Отсутствует',
        'successfully' => 'Доступ разрешен',
        'member' => 'Вход по сесси',
        'two_user' => 'Вам доступ закрыт',
    ),
    
    'forgot' => array
    (
        'absent' => 'Отсутствует',
        'empty' => 'Пусто',
        'successfully' => 'Отправлено',        
        'notice' => 'Письмо с паролем отправлено',        
        'email' => array
        (
            'title' => 'Восстановление пароля',
            'template' => 'Ваш пароль: %s',
        ),
    ),
    
    'register' => array
    (
        'double_email' => 'Такой e-mail уже существует',
        'double_name' => 'Такое имя уже существует',
        'not_register' => 'Попробуйте зарегистрироваться позже',
        'notice' => 'Вы зарегистрированы',
        'email' => array
        (
            'title' => 'Регистрация',
            'template' => 'Спасибо за регистрацию,<br />Ваш <br />логин: %s<br />пароль: %s',
        ),
        'complete' => 'Регистрация прошла успешно',
        'is_18' => 'Вам нет 18 лет',
    ),
    
    'logout' => array
    (
        'notice' => 'Вы разлогинелись',
    ),
    
    'status' => array
    (
        'online' => 'Вы онлайн',
        'offline' => 'Вы оффлайн',
    ),
    
    'profile' => array
    (
        'notice' => 'Сохранение профайла прошло успешно',
        'login' => 'не залогиненый',
        'no_save' => 'Ошибка сохранения',
    ),
    
    'avatar' => array
    (
        'bad' => 'Не корректный аватар',
        'successfully' => 'Аватар сохранен',
    ),    
    
    'password' => array
    (
        'not_change' => 'Пароль небыл изменен',
        'empty_new' => 'Вы не ввели новый пароль',
        'empty_old' => 'Вы не ввели старый пароль',
        'empty_retry' => 'Вы не ввели повторно пароль',
        'equal' => 'Пароли не совпадают',
        'successfully' => 'Пароль успешно изменен',
    ),
    
    'lang' => array
    (
        'successfully' => 'Изменение прошло успешно',
        'error' => 'Ошибка при сохранении',
    ),
    
);