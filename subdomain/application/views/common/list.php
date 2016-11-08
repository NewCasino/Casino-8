<?php defined('SYSPATH') or die('No direct access allowed.'); ?>
<pre>
<?php // print_r($data->array); ?>
<?php // print_r($data->columns); ?>
</pre>
<h2>Управление списками</h2>
<!--
<div class="tabs">
    <ul>
        <li class="active">Главное</li>
        <li><a href="javascript:;" title="#">Дополнительно</a></li>
        <li class="last"><a href="javascript:;" title="#">Настройки</a></li>
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
-->
<div class="bg">
    <div class="in-bg2">
        <table cellpadding="0" cellspacing="0" class="t4">
        	<tr>
        		<td width="29"></td>
<?php /* foreach ($data->columns as $rows): ?>
				<td title="<?php echo $rows['description']; ?>"><?php echo $rows['title']; ?> <img src="/media/images/bullet.gif" alt="#" /></td>
<?php endforeach; */ ?>
			</tr>
			<!-- 
            <tr>
                <td width="29"></td>                
                <td>Название <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="132">Статус <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="111">Контакты <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="108">Настройки <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="85">Клубы <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="82">Игроки <img src="/media/images/bullet.gif" alt="#" /></td>
                <td width="24"></td>
            </tr>
            -->
        </table>
        <table cellpadding="0" cellspacing="0" class="t5">
            <tr>
                <td width="29"></td>
                <td><input type="text" class="f10" /></td>
                <td width="132"><select class="f11">
                        <option>Активен</option>
                    </select></td>
                <td width="410"></td>
            </tr>
        </table>
        <div class="pad2">
            <table cellpadding="0" cellspacing="0" class="t6">
<?php /* foreach ($data->array as $rows): ?>
				<tr>
                    <td width="29">&nbsp;&nbsp; <input type="checkbox" /></td>
                    <td><strong><a href="javascript:;" title="#">Аккаунт 1</a></strong></td>
                    <td width="132"><img src="/media/images/flag1.gif" alt="#" /> Не активен</td>
                    <td width="111">Не активен</td>
                    <td width="108"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="85"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="82"><a href="javascript:;" title="#">edit</a></td>
                    <td width="24"><a href="javascript:;" title="#"><img src="/media/images/bullet3.gif" alt="#" /></a></td>
                </tr>
<?php endforeach; */ ?>
				 
                <tr class="active">
                    <td width="29">&nbsp;&nbsp;
                        <input type="checkbox" /></td>
                    <td><strong><a href="javascript:;" title="#">Аккаунт 1</a></strong></td>
                    <td width="132"><img src="/media/images/flag1.gif" alt="#" /> Не активен</td>
                    <td width="111">Не активен</td>
                    <td width="108"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="85"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="82"><a href="javascript:;" title="#">edit</a></td>
                    <td width="24"><a href="javascript:;" title="#"><img src="/media/images/bullet3.gif" alt="#" /></a></td>
                </tr>
                <tr>
                    <td width="29">&nbsp;&nbsp;
                        <input type="checkbox" /></td>
                    <td><strong><a href="javascript:;" title="#">Аккаунт 1</a></strong></td>
                    <td width="132"><img src="/media/images/flag1.gif" alt="#" /> Не активен</td>
                    <td width="111">Не активен</td>
                    <td width="108"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="85"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="82"><a href="javascript:;" title="#">edit</a></td>
                    <td width="24"><a href="javascript:;" title="#"><img src="/media/images/bullet3.gif" alt="#" /></a></td>
                </tr>
                <tr>
                    <td width="29">&nbsp;&nbsp;
                        <input type="checkbox" /></td>
                    <td><strong><a href="javascript:;" title="#">Аккаунт 1</a></strong></td>
                    <td width="132"><img src="/media/images/flag1.gif" alt="#" /> Не активен</td>
                    <td width="111">Не активен</td>
                    <td width="108"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="85"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="82"><a href="javascript:;" title="#">edit</a></td>
                    <td width="24"><a href="javascript:;" title="#"><img src="/media/images/bullet3.gif" alt="#" /></a></td>
                </tr>
                <tr class="last">
                    <td width="29">&nbsp;&nbsp;
                        <input type="checkbox" /></td>
                    <td><strong><a href="javascript:;" title="#">Аккаунт 1</a></strong></td>
                    <td width="132"><img src="/media/images/flag1.gif" alt="#" /> Не активен</td>
                    <td width="111">Не активен</td>
                    <td width="108"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="85"><a href="javascript:;" title="#"><img src="/media/images/bullet2.gif" alt="#" /></a></td>
                    <td width="82"><a href="javascript:;" title="#">edit</a></td>
                    <td width="24"><a href="javascript:;" title="#"><img src="/media/images/bullet3.gif" alt="#" /></a></td>
                </tr>
                
            </table>
        </div>
        <div class="filter-l"> Отмеченные &nbsp;
            <select class="f02">
                <option>Удалить</option>
            </select>
        </div>
        <div class="filter-r"> Показывать &nbsp;
            <select class="f12">
                <option>10</option>
            </select>
        </div>
        <div class="pages">Страницы &nbsp;&nbsp;<span>1</span><a href="javascript:;" title="#">2</a><a href="javascript:;" title="#">3</a><a href="javascript:;" title="#">4</a><a href="javascript:;" title="#">5</a></div>
        <br class="clearfloat" />
    </div>
</div>
<div class="info">
    <ul>
        <li><span>*</span>Определены соперники украинских клубов в плей-офф Лиги Европы<br class="clearfloat" />
        </li>
        <li><span>**</span>Израиль получил запрос от Украины о возможном пребывании Лозинского<br class="clearfloat" />
        </li>
    </ul>
</div>