<?php
include ( "../setmerchant.php" ) ;

if ( isset ( $_POST['w1_sum'] ) ) $w1_sum =  number_format ( preg_replace ( "/[^0-9.]/", '', $_POST['w1_sum'] ), 2, '.', '' )  ; else $w1_sum = '10.00' ;
//$w1_sum = '0.01' ;
$payid = rand(1111,9999)."-". $_POST['w1_num'];

$fields = array(); 
// Добавление полей формы в ассоциативный массив
$fields["WMI_MERCHANT_ID"]    = $merchant  ; 
$fields["WMI_PAYMENT_AMOUNT"] = $w1_sum ;
$fields["WMI_CURRENCY_ID"]    = "643"; //код валюты
$fields["WMI_PAYMENT_NO"]     = $payid ;//номер платежа
$fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Payment for order #".$payid ." : ".$_POST['w1_num'] );// $l
$fields["WMI_EXPIRED_DATE"]   = "2019-12-31T23:59:59";
$fields["WMI_SUCCESS_URL"]    = "http://".$_SERVER['SERVER_NAME']."/pay/success_w1.php";
$fields["WMI_FAIL_URL"]       = "http://".$_SERVER['SERVER_NAME']."/pay/fail.php";
$fields["WMI_AUTO_ACCEPT"]    = "1"  ;
$fields["MY_PAYERID"]         = $_POST['w1_num']; //$l   ;    // Дополнительные параметры
$fields["MY_OPERATOR"]        = "W1" ;    // интернет-магазина тоже участвуют
//$fields["MyShopParam3"]     = "Value3"; // при формировании подписи!
//Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
//$fields["WMI_PTENABLED"]      = array("ContactRUB", "UnistreamRUB", "SberbankRUB", "RussianPostRUB");
/*
Идентификатор валюты (ISO 4217):
643 — Российские рубли
710 — Южно-Африканские ранды
840 — Американские доллары
980 — Украинские гривны
398 — Казахстанские тенге
*/

//Сортировка значений внутри полей
foreach ( $fields as $name => $val ) 
{
  if ( is_array ( $val ) )
  {
     usort ( $val, "strcasecmp" ) ;
     $fields[$name] = $val ;
  }
}
// Формирование сообщения, путем объединения значений формы, 
// отсортированных по именам ключей в порядке возрастания.
uksort ( $fields, "strcasecmp" ) ;
$fieldValues = "";

foreach ( $fields as $value ) 
 {
  if ( is_array ( $value ) ) foreach ( $value as $v )$fieldValues .= iconv("utf-8", "windows-1251", $v) ; //Конвертация из текущей кодировки (UTF-8) необходима только если кодировка магазина отлична от Windows-1251
  else $fieldValues .=iconv("utf-8", "windows-1251", $value); //Конвертация из текущей кодировки (UTF-8) необходима только если кодировка магазина отлична от Windows-1251
 }
// Формирование значения параметра WMI_SIGNATURE, путем 
// вычисления отпечатка, сформированного выше сообщения, 
// по алгоритму MD5 и представление его в Base64
$signature = base64_encode(pack("H*", md5($fieldValues . $seckey )));
$fields["WMI_SIGNATURE"] = $signature ;//Добавление параметра WMI_SIGNATURE в словарь параметров формы
?>
<style>
 input {display: none;}
</style>
<form name="paymentform" action="https://merchant.w1.ru/checkout/default.aspx" method="POST" enctype="application/x-www-form-urlencoded" accept-charset="cp1251">
<? foreach ( $fields as $key => $val ) { if ( is_array ( $val ) ) { foreach ( $val as $value ) ?>
<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<? } else {?>
<input type="hidden" name="<?=$key?>" value="<?=$val?>" />
<? } }?>
<input type="submit" />
</form>
<script type="text/javascript">
    document.paymentform.submit();
</script>
<noscript><p><h4>Оплата счета №: <?=$payid?>, на сумму : <?=$w1_sum?> Руб.</h4></p><br /></noscript>
<!-- //Powered Timur & K MEDIA developer@gamatic.ru -->