<? //include ("header.php");?>
<h3>Результат платежа</h3>
<? if ( isset ( $_POST['WMI_PAYMENT_NO'] ) and isset ( $_POST['MY_PAYERID'] ) ) { ?>
   <p>Платеж <?=$_POST['MY_PAYERID']?> принят! номер платежа <?=$_POST['WMI_PAYMENT_NO']?> PayID: <?=$_POST['WMI_PAYMENT_NO']?> </p>
<?} else {?>
<p>Ошибка !!!</p>
<?}//include ("footer.php");?>