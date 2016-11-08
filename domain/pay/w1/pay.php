<?php
include ( "../setmerchant.php" ) ;
debug_writer ( "W1" ) ;// ����� ��� ������� � ���� 

// �������� ������� ����������� ���������� � POST-�������
if ( !isset ( $_POST["WMI_SIGNATURE"]   ) ) print_answer ( "Retry", "����������� �������� WMI_SIGNATURE");
if ( !isset ( $_POST["WMI_PAYMENT_NO"]  ) ) print_answer ( "Retry", "����������� �������� WMI_PAYMENT_NO");
if ( !isset ( $_POST["WMI_ORDER_STATE"] ) ) print_answer ( "Retry", "����������� �������� WMI_ORDER_STATE" );

foreach($_POST as $name => $value) if ($name !== "WMI_SIGNATURE") $params[$name] = $value;// ���������� ���� ���������� POST-�������, ����� WMI_SIGNATURE

uksort($params, "strcasecmp"); $values = "" ;                     // ���������� ������� �� ������ ������ � ������� �����������
foreach($params as $name => $value) $values .= $params[$name] ; // � ������������ ���������, ����� ����������� �������� �����
$signature = base64_encode(pack("H*", md5($values . $seckey))) ; // ������������ ������� ��� ��������� �� � ���������� WMI_SIGNATURE
//��������� ���������� ������� � �������� W1
if ( $signature == $_POST["WMI_SIGNATURE"] )
 {
  if ( strtoupper ( $_POST["WMI_ORDER_STATE"] ) == "ACCEPTED")
   {
    enlist_payment ( $_POST['MY_PAYERID'], $_POST['WMI_PAYMENT_AMOUNT'] ) ;
    print_answer("Ok", "����� #" . $_POST["WMI_PAYMENT_NO"] ." �������!");
   }
  else if (strtoupper($_POST["WMI_ORDER_STATE"]) == "PROCESSING") print_answer("Ok", "����� #" . $_POST["WMI_PAYMENT_NO"] . " �������!");
  else if (strtoupper($_POST["WMI_ORDER_STATE"]) == "REJECTED") print_answer("Ok", "����� #" . $_POST["WMI_PAYMENT_NO"] . " �������!");
  else print_answer("Retry", "�������� ��������� ". $_POST["WMI_ORDER_STATE"]) ;// ��������� ���-�� ��������, ������ ����������� ��������� ������
 }
else print_answer("Retry", "�������� ������� " . $_POST["WMI_SIGNATURE"]) ; // ������� �� ���������, �������� �� �������� ��������� ��������-��������
//Powered Timur & K MEDIA developer@gamatic.ru
?>