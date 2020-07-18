<?php
header('Content-Type: text/html; charset=utf-8');
$ost_msg=$_POST['ind_wiad'];

require_once "conn_info.php";
$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);
$zapytanie="SELECT * FROM messages WHERE msg_id>?";

$rezultat=$polaczenie->prepare($zapytanie);
$rezultat->bindValue(1,$ost_msg,PDO::PARAM_STR);
$rezultat->execute();

$wynik=$rezultat->fetchAll(PDO::FETCH_NUM);
$wynik=json_encode($wynik);

echo $wynik;

$polaczenie=NULL;