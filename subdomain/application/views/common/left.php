<?php defined('SYSPATH') or die('No direct access allowed.'); ?>

<div class="left">
    <div class="menu">
        <h3>Финансы</h3>
        <ul>
            <li <?php if (stristr(url::current(),'finance/pincode' )) echo 'class="active"' ?>><span class="q03"><a href="/finance/pincode" title="Пинкоды">Пинкоды</a></span></li>
            <li <?php if (stristr(url::current(),'finance/bonus')) echo 'class="active"' ?>><span class="q00"><a href="/finance/bonus" title="Пинкоды">Бонусы регистраций</a></span></li>
            <li <?php if (stristr(url::current(),'finance/cashin')) echo 'class="active"' ?>><span class="q04"><a href="/finance/cashin" title="Пополнение средств">Пополнение средств</a></span></li>
            <li <?php if (stristr(url::current(),'finance/cashout')) echo 'class="active"' ?>><span class="q05"><a href="/finance/cashout" title="Заказы на выплату">Заказы на выплату</a></span></li>
        </ul>
        <h3>Управление</h3>
        <ul>
            <li <?php if (stristr(url::current(),'manage/games') || stristr(url::current(),'manage/categories')) echo 'class="active"' ?>><span class="q07"><a href="/manage/games" title="Управление играми">Игры и категории</a></span></li>
            <li <?php if (stristr(url::current(),'manage/music')) echo 'class="active"' ?>><span class="q05"><a href="/manage/music" title="Управление музыкой">Управление музыкой</a></span></li>
            <li <?php if (stristr(url::current(),'manage/pages')) echo 'class="active"' ?>><span class="q05"><a href="/manage/pages" title="Управление страницами">Страницы</a></span></li>
        </ul>
        <h3>Пользователи</h3>
        <ul>
            <li <?php if (stristr(url::current(),'users/admin')) echo 'class="active"' ?>><span class="q10"><a href="/users/admin" title="Администраторы">Администраторы</a></span></li>
            <li <?php if (stristr(url::current(),'users/player')) echo 'class="active"' ?>><span class="q10"><a href="/users/player" title="Игроки">Игроки</a></span></li>
        </ul>
        <h3>Настройки</h3>
        <ul>
            <li <?php if (stristr(url::current(),'setting/banking')) echo 'class="active"' ?>><span class="q12"><a href="/setting/banking" title="Игровые банки">Игровые банки</a></span></li>
            <li <?php if (stristr(url::current(),'setting/value')) echo 'class="active"' ?>><span class="q14"><a href="/setting/value" title="Значения">Настройки сайта</a></span></li>
        </ul>
    </div>
</div>
<br class="clearfloat" />