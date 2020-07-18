<?php

header('Content-Type: text/html; charset=utf-8');

require_once "conn_info.php";

$currdate=time();
$deldate=$currdate-$del_time;

$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

if($polaczenie->errorCode()!=0){
    echo "Nieudane połączenie z bazą... Kod błędu: "+$polaczenie->errorCode();
}
else{
    $zapytanie="DELETE FROM logged_users WHERE user_date<?";
    
    $rezultat=$polaczenie->prepare($zapytanie);
    $rezultat->bindValue(1,$deldate,PDO::PARAM_STR);
    $rezultat->execute();
    
    echo "1";

    $polaczenie=NULL;
}
