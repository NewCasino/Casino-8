<?php
include ( "../setmerchant.php" ) ;
debug_writer ( "W1" ) ;// пишем все запросы в файл 

// Проверка наличия необходимых параметров в POST-запросе
if ( !isset ( $_POST["WMI_SIGNATURE"]   ) ) print_answer ( "Retry", "Отсутствует параметр WMI_SIGNATURE");
if ( !isset ( $_POST["WMI_PAYMENT_NO"]  ) ) print_answer ( "Retry", "Отсутствует параметр WMI_PAYMENT_NO");
if ( !isset ( $_POST["WMI_ORDER_STATE"] ) ) print_answer ( "Retry", "Отсутствует параметр WMI_ORDER_STATE" );

foreach($_POST as $name => $value) if ($name !== "WMI_SIGNATURE") $params[$name] = $value;// Извлечение всех параметров POST-запроса, кроме WMI_SIGNATURE

uksort($params, "strcasecmp"); $values = "" ;                     // Сортировка массива по именам ключей в порядке возрастания
foreach($params as $name => $value) $values .= $params[$name] ; // и формирование сообщения, путем объединения значений формы
$signature = base64_encode(pack("H*", md5($values . $seckey))) ; // Формирование подписи для сравнения ее с параметром WMI_SIGNATURE
//Сравнение полученной подписи с подписью W1
if ( $signature == $_POST["WMI_SIGNATURE"] )
 {
  if ( strtoupper ( $_POST["WMI_ORDER_STATE"] ) == "ACCEPTED")
   {
    enlist_payment ( $_POST['MY_PAYERID'], $_POST['WMI_PAYMENT_AMOUNT'] ) ;
    print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] ." оплачен!");
   }
  else if (strtoupper($_POST["WMI_ORDER_STATE"]) == "PROCESSING") print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " оплачен!");
  else if (strtoupper($_POST["WMI_ORDER_STATE"]) == "REJECTED") print_answer("Ok", "Заказ #" . $_POST["WMI_PAYMENT_NO"] . " отменен!");
  else print_answer("Retry", "Неверное состояние ". $_POST["WMI_ORDER_STATE"]) ;// Случилось что-то странное, пришло неизвестное состояние заказа
 }
else print_answer("Retry", "Неверная подпись " . $_POST["WMI_SIGNATURE"]) ; // Подпись не совпадает, возможно вы поменяли настройки интернет-магазина
//Powered Timur & K MEDIA developer@gamatic.ru
?>