<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $head; ?>
<?php echo $header; ?>


<div style="background-color: #FFFFFF;">
<?php             
if (Auth::instance()->logged_in())
{
?>

<a href="/gamer/logout">Logout</a><br />

<br />_________________________________________________SLOT_25_JOKER<br /><br />
<h1>slot 25</h1>
<form action="Atlantis_Init.asp" method="post">INIC
<input type="submit" />
</form><br />
<form action="Atlantis_Spin.asp" method="post">SPIN >>nb_coins:
<input type="text" name="nb_coins" value="3" />nb_lines:
<input type="text" name="nb_lines" value="3" />
<!--<input type="text" name="session_jeu" value="" />-->
<input type="submit" /></form>

<h3>bonus 1</h3>
<form action="/Atlantis_Bonus1.asp" method="post">choix_case(1-24)
<input type="text" name="choix_case" value="4" /><input type="submit" /></form>

<br />_________________________________________________SLOT_9_FREE<br /><br />
<h1>game free</h1>
<form action="cartoons_init.asp" method="post">INIC
<input type="submit" />
</form><br />
<form action="cartoons_spin.asp" method="post">SPIN >>nb_coins:
<input type="text" name="nb_coins" value="3" />nb_lines:
<input type="text" name="nb_lines" value="3" />
<input type="submit" />
</form>
_________________________________________________<br /><br />




<!--
<form action="/pincode/in" method="post">
Pincode:<br />
<input name="code" value="<?php
if (isset($code)) 
{
    echo $code;
}
?>" /><br /> 
<input type="submit" /><br />
<?php
if (isset($notice)) 
{
    echo $notice;
}
?>
</form>

<h1>Out cash</h1>

<form action="/cash/out" method="post">
Payment info:<br />
<input type="text" name="payment_info" value=""><br />
Amount:<br />
<input name="cash" value="<?php
if (isset($cash)) 
{
    echo $cash;
}
?>" /><br /> 
<input type="submit" /><br />
<?php
if (isset($notice)) 
{
    echo $notice;
}
?>
</form>

<h1>Cancel Out id</h1>
<form action="/cash/cancel" method="post">
<input type="text" name="id" value="1" /><br />
<input type="submit" /><br />
</form>



<h1>Music controll</h1>
<form action="/event/player/play" method="post">
<input type="submit" value="Play" /><br />
</form>

<form action="/event/player/pause" method="post">
<input type="submit" value="Pause" /><br />
</form>


<h1>Fullscreen controll</h1>

<form action="/event/iface/fullscreen" method="post">
<input type="submit" /><br />
</form>

<h1>Volume</h1>

<form action="/event/player/volume" method="post">
<input type="hidden" name="level" value="45">
<input type="submit" /><br />
</form>

<h1>Status</h1>
<form action="/gamer/status" method="post">
<input type="submit" /><br />
</form>


<h1>Profile</h1>
<form action="/gamer/profile" method="post">
<input type="hidden" name="sex" value="1" />
<input type="hidden" name="birthday" value="1988-08-08" />
<input type="hidden" name="name" value="Igor" />
<input type="hidden" name="surname" value="Family" />
<input type="hidden" name="lastname" value="Jonov" />
<input type="hidden" name="avatar" value="avatar" />
<input type="hidden" name="country" value="3" />
<input type="hidden" name="city" value="Moskov" />
<input type="hidden" name="address" value="Voroshilova 13" />
<input type="hidden" name="phone" value="798789789" />
<input type="hidden" name="passport_info" value="AE 78789" />
<input type="submit" /><br />
</form>

<h1>Avatar</h1>
<form action="/gamer/avatar" method="post" enctype="multipart/form-data">
<input type="file" name="Filedata" value="D:\images\avatar\avatar_robo_man.gif">
<input type="submit" /><br />
</form>


<h1>New password</h1>
<form action="/gamer/change_password" method="post">
<input type="hidden" name="new_password" value="1234" />
<input type="hidden" name="retry_password" value="1234" />
<input type="hidden" name="old_password" value="4321" />
<input type="submit" /><br />
</form>

<h1>Language: <?php echo Kohana::lang('gamer.lang.successfully');?></h1>
<a href="/lang/set/ru_RU">ru_RU</a><br />
<a href="/lang/set/en_US">en_US</a><br /><br />

<h1>Alert</h1>
<form action="/xml/alert" method="post">
<input type="hidden" name="alert" value="demo_cash" />
<input type="submit" /><br />
</form>
______________________________________________________________PAYMENT
<h1>Get ID payment</h1>
<form action="/cash/payment_id" method="post">
<input type="text" name="amount" />
<input type="submit" /><br />
</form><br />

<h1>Get Status payment</h1>
<form action="/cash/status" method="post">
<input type="text" name="payment_id" />
<input type="submit" /><br />
</form><br />


<h1>visa i</h1>
<form action="/cash/payment/visa" method="post">
<input type="text" name="count" value="4" />
<input type="text" name="payment_id" value="" />
<input type="submit" />
</form>
<br />

<h1>emulate status interkassa</h1>
<form name="payment" action="/cash/response_interkassa" method="post">
id<input type="text" name="ik_payment_id" value=""><br />
state<input type="text" name="ik_payment_state" value=""><br />
amount<input type="text" name="ik_payment_amount" value=""><br />

<input type="hidden" name="ik_shop_id" value="123">
<input type="hidden" name="ik_paysystem_alias" value="123">
<input type="hidden" name="ik_baggage_fields" value="123">
<input type="hidden" name="ik_trans_id" value="123">
<input type="hidden" name="ik_currency_exch" value="123">
<input type="hidden" name="ik_fees_payer" value="123">
<input type="hidden" name="ik_sign_hash" value="123">
<input type="submit"><br />
</form>

____inter kassa
<h1>Send site interkassa.ru</h1>
<form name="payment" action="https://interkassa.com/lib/payment.php" method="post" target="_top">
<input type="hidden" name="ik_shop_id" value="58E55BF1-59B7-6FB1-2537-4F281B52EFD0">
<input type="hidden" name="ik_payment_amount" value="1.00">
<input type="hidden" name="ik_payment_id" value="1001">
<input type="hidden" name="ik_payment_desc" value="PAYMENT_DESCRIPTION">
<input type="submit" name="process" value="Оплатить"><br />
</form>

-->
________________________________________________________SLOT
<h2>slot 9 line double|bonus</h2>
<form action="vegas_init.asp" method="post">INIT
<input type="submit" />
</form><br /><br /><br />

<form action="vegas_spin.asp" method="post">count
<input type="text" name="count" disabled="disabled" value="3" />nb_coins
<input type="text" name="nb_coins" value="3" />nb_lines
<input type="text" name="nb_lines" value="3" />
<input type="submit" />
</form><br /><br /><br />

<form action="bonus_game.asp" method="post">Bonus game
<input type="submit" />
</form><br /><br /><br />

<form action="double_up.asp" method="post">double
<input type="text" name="bet_2" value="2" />
<!--<input type="text" name="bet_4" value="4" />-->
<input type="submit" />
</form><br /><br />

________________________________________________________Baccarat
<h2>Baccarat</h2>
<!--GAMESESSION=Baccarat&ACTION=ENTER&GAMECOUNT=&TIMELIMIT=-->
<form action="" method="post">ACTION:
<input type="text" name="ACTION" value="ENTER" />
<input type="submit" />
</form><br /><br /><br />
________________________________________________________Black jack Diamond
<h2>Black jack Diamond</h2>
<!--GAMESESSION=Baccarat&ACTION=ENTER&GAMECOUNT=&TIMELIMIT=-->
<form action="black_jack_diamond_mat" method="post">ACTION:
<!--<input type="text" name="ACTION" value="ENTER" />-->
<input type="text" name="ACTION" value="MOVE" />
<input type="text" name="GAMESESSION" value="11112" />
<input type="text" name="TYPE" value="STAND" />
<input type="text" name="GAMECOUNT" value="%2D4" />
<input type="submit" />
</form><br /><br /><br />
________________________________________________________Caribbean poker
<h2>Caribbean poker</h2>
<!--GAMESESSION=carpoker%5Fgold%5F9542&ACTION=MAKEBET&BET=25&GAMECOUNT=%2D1&TIMELIMIT=0-->
<form action="caribbean_poker" method="post">ACTION:
<input type="text" name="ACTION" value="MAKEBET" />
<input type="text" name="BET" value="25" />
<input type="submit" />
</form><br /><br /><br />

_________________________________________________Jack or better<br /><br />
<h1>enter</h1>
<form action="jacks_or_better" method="post">
<input type="hidden" name="ACTION" value="ENTER" />bet
<input type="submit" />
</form>
<br />
<h1>make bet</h1>
<form action="jacks_or_better" method="post">action
<input type="text" name="ACTION" value="MAKEBET" />bet
<input type="text" name="BET" value="2+1" />
<input type="submit" />
</form>
<h1>KEEP CARDS</h1>
<form action="jacks_or_better" method="post">action
<input type="text" name="ACTION" value="KEEPCARDS" />bet
<input type="text" name="CARDSKEPT" value="0|0|0|1|1" />
<input type="submit" />
</form>
_________________________________________________<br /><br /><br />







__________________________________________________________________________________________________ emulate status interkassa
<h1>emulate status interkassa</h1>
<form name="payment" action="/cash/response_interkassa" method="post">
id<input type="text" name="ik_payment_id" value="">
state<input type="text" name="ik_payment_state" value="">
amount<input type="text" name="ik_payment_amount" value="">
hash:<input type="text" name="ik_sign_hash" value="">

<input type="hidden" name="ik_shop_id" value="123">
<input type="hidden" name="ik_paysystem_alias" value="123">
<input type="hidden" name="ik_baggage_fields" value="123">
<input type="hidden" name="ik_trans_id" value="123">
<input type="hidden" name="ik_currency_exch" value="123">
<input type="hidden" name="ik_fees_payer" value="123">

<input type="submit"><br />
</form>


<br />
______________________________________________________________Start Black jack classic<br />
<form action="/black_jack_classic" method="post">
<input type="text" name="game" value="/black_jack_classic.swf" />
<input type="submit" />
</form>




<?php
     
}
else 
{
?>

<h1>Gamer Login</h1>

<form action="/gamer/login" method="post">
Username:<br />
<input name="username" value="<?php
if (isset($username)) 
{
    echo $username;
}
?>" /><br />
Password:<br />
<input type="password" name="password" /><br />
<input type="submit" /><br />
<?php
if (isset($notice)) 
{
    echo $notice;
}
?>
</form>

<h1>Gamer Register</h1>

<form action="/gamer/register" method="post">
<input type="hidden" name="is18" value="1" />
Email:<br />
<input name="email" value="<?php
if (isset($email)) 
{
    echo $email;
}
?>" /><br />
Username:<br />
<input name="username" value="<?php
if (isset($username)) 
{
    echo $username;
}
?>" /><br />
Password:<br />
<input type="password" name="password" /><br />
Retype password:<br /> 
<input type="password" name="retype" /><br />
Bonus:<br />
<input type="text" name="bonus" /><br />
<input type="submit" /><br />
</form>

<h1>Gamer Forgot</h1>

<form action="/gamer/forgot" method="post">
Email:<br />
<input name="email" value="<?php
if (isset($email)) 
{
    echo $email;
}
?>" /><br />
<input type="submit" /><br />
<?php
if (isset($notice)) 
{
    echo $notice;
}
?>
</form>

<h1>Switch Lang/ <?php echo Kohana::lang('gamer.register.notice');?></h1>
<form action="/lang/set/ru_RU" method="post">
<input type="hidden" name="lang" value="ru_RU" /><!--en_US-->
<input type="submit" /><br />
</form>

<?php 
}
?>
</div>
<?php echo $footer; ?>