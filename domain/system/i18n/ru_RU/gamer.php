<?php defined('SYSPATH') OR die('No direct access allowed.');

$lang = array
(
    'login' => array
    (
        'empty' => 'Заполните форму',
        'error' => 'Не верный пароль',        
        'absent' => 'Этот игрок отсутствует',
        'successfully' => 'Доступ разрешен',
        'member' => 'Вход по сессии',
        'two_user' => 'Вам доступ закрыт',
    ),
    
    'forgot' => array
    (
        'absent' => 'Отсутствует',
        'empty' => 'Заполните форму',
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
        'fail_login' => 'Длина логина должна быть от 4 символа до 32',
        'double_email' => 'Такой E-mail уже существует',
        'double_name' => 'Такой логин уже существует',
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
        'notice' => 'Вы разлогинились',
    ),
    
    'status' => array
    (
        'online' => 'Вы онлайн',
        'offline' => 'Вы оффлайн',
    ),
    
    'profile' => array
    (
        'notice' => 'Сохранение профайла прошло успешно',
        'login' => 'Не залогиненый',
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
        'empty_new' => 'Введите новый пароль',
        'empty_old' => 'Введите старый пароль',
        'empty_retry' => 'Введите повторно пароль',
        'equal' => 'Пароли не совпадают',
        'successfully' => 'Пароль успешно изменен',
    ),
    
    'lang' => array
    (
        'successfully' => 'Изменение прошло успешно',
        'error' => 'Ошибка при сохранении',
    ),
);