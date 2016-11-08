<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Панель управления - Регистрация</title>
<link href="/media/style/auth.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="auth">	
	<div>
		<p>
			Логин <br />
			<input type="text" name="login" class="f01" />
		</p>
		<p>
			Емаил <br />
			<input type="text" name="email" class="f01" />
		</p>
		<p>
			<a href="/login" title="Выполнить вход">Выполнить вход</a>
		</p>
		<p>
			<a href="/forgot" title="Напомнить пароль">Напомнить пароль</a>
		</p>		
		<input type="button" value="Войти" class="f02" />		
	</div>
	<p class="text">
		Регистрация<br />
	</p>
</div>
</body>
</html>