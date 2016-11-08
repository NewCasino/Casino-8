<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Панель управления - Авторизация</title>
<link href="/media/style/auth.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="/media/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="/media/js/jquery.base.auth.js"></script>
</head>
<body>
<div class="auth">
	<form action="/login">
	<div>
		<p>
			Логин <br />
			<input type="text" name="username" class="f01" value="" filter="username" />
            <span class=""></span>
		</p>
		<p>
			Пароль <br />
			<input type="password" name="password" class="f01" value="" filter="password" />
            <span class=""></span>
		</p>
		<p>
			<a href="/forgot" title="Напомнить пароль">Напомнить пароль</a>
		</p>
		<input type="button" value="Войти" class="f02" /> <span class="notice"></span>
	</div>
	<p class="text">
		Авторизация
	</p>
    </form>
</div>
</body>
</html>