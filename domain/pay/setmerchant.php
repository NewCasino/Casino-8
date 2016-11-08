<?php

// Секретный ключ интернет-магазина (настраивается в кабинете)
 switch ( $_SERVER['SERVER_NAME'] )
  {
    default :
     $seckey   = false ;// или указываем настройки здесь для одного домена 
     $merchant = false ;
    break ;
    case  "casino.com" :                            // Тут впишите свой сайт
     $seckey   = "md5";                                 // Тут в пишите свой Секретный ключ от w1.ru
     $merchant = "w1-id" ;                     // Тут в пишите свой Номер кошелька от w1.ru   
     $spCurrency = "rur" ;
    break ;
    case  "usd.z-win.ru" :
     $seckey   = "md5"; // W1 # 
     $merchant = "w1-id" ;                        // W1 # 
    
    break ;
    // и т.д.
  
  }
  
	$dbuname  = 'root' ;                         // Тут пишете имя пользователя
	$dbpass   = '' ;                    // Тут пишете пароль
	$dbhost   = 'localhost';                   // Пропускаем
	$dbname   = 'basename' ;                      // Тут пишете имя пользователя
  mysql_connect($dbhost, $dbuname, $dbpass) or die ( "Error" );
  mysql_select_db($dbname);
  //mysql_query("SET NAMES 'cp1251'"); 
  mysql_query("SET NAMES 'utf8'");
// обработка платежа  
function enlist_payment ( $spUserDataLogin, $spAmount ) 
 {
  $rowid = mysql_fetch_array ( mysql_query ( "select * from merchant_request where id='".$spUserDataLogin."'" ) ) ;// делаем выборку партнера по юзеру
  mysql_query ( "update user_payment set cash=cash+'".$spAmount."', total_in=total_in+'".$spAmount."' where id='".$rowid['user_id']."'" ) ;
  mysql_query ( "update  merchant_request set status='2' where id='".$spUserDataLogin."'" ) ;
  //user_payment_history id user_id 	pincode_id 	merchant_request_id 	cashout_id 	type 	amount 	status 	datetime 
  mysql_query ( "INSERT INTO user_payment_history  VALUES(NULL, '".$rowid['user_id']."','0','".$spUserDataLogin."','0','1','".$spAmount."','1', '".time ( )."' ) " );
 }
  
// Функция, которая возвращает результат в Единую кассу
function print_answer( $result, $description )
 {
    die ( "WMI_RESULT=". strtoupper ( $result ) ."&WMI_DESCRIPTION=". urlencode ( $description ) ) ;
 }
function mess ($error)
 {
    exit($error) ;
 }

function debug_writer ( $info ) 
 {
     $msg = 0 ;
     $data = $info." \n"  ;
     for (Reset($_POST); ($k = key($_POST)); Next ($_POST)) $data .= $k . "=". $_POST[$k] . "\n" ;// скан POST'а
     //писалка 
     $data .= date("d.m.Y").' | '.date( "H:i:s" )."\n";
     $data .= 'Status='.$msg."\n"."=========================="."\n" ;
     $fp = fopen( "debug.txt" , "a" ) or die ( "Не удалось открыть файл" );// открываем файло на запись
     fputs( $fp, $data ); // записываем файл 
     fclose( $fp ); // закрываем файл
     //////////////////////////////////////////////
 }
 

//Powered Timur & K MEDIA developer@gamatic.ru
?>