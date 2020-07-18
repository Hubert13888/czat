<?php
session_start();
header('Content-Type: text/html; charset=utf-8');

$user=$_SESSION['user'];
$userip=$_SERVER['REMOTE_ADDR'];
$msg_date=new DateTime();
$msg_date=$msg_date->format("Y-m-d H:i:s");

$message=trim($_POST['msg']);

require_once "conn_info.php";

$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$zapytanie0="SELECT msg_id FROM messages ORDER BY msg_id DESC LIMIT 1";
$rezultat0=$polaczenie->query($zapytanie0);
$rezultat0=$rezultat0->fetchAll(PDO::FETCH_NUM);
foreach($rezultat0 as $klucz0=>$rezultat0_1){
    foreach($rezultat0_1 as $klucz0_1=>$rezultat0_2){
    }
}
$rezultat0_2=$rezultat0_2+1;

$informacje=Array($user,$msg_date,$message,$rezultat0_2);
$informacje=json_encode($informacje);
echo $informacje;

$zapytanie1="SELECT * FROM messages";
$rezultat1=$polaczenie->query($zapytanie1);

if($rezultat1->rowCount()>99){
//Usuwa z bazy gdy ilość wiadomości będzie większa niż 100
$zapytanie2="DELETE FROM messages ORDER BY msg_id ASC LIMIT 1";
$rezultat2=$polaczenie->query($zapytanie2); 
    
}
//Dodaje nową wiadomość do bazy
$zapytanie3="INSERT INTO messages VALUES ('',?,?,?,?)";
$rezultat3=$polaczenie->prepare($zapytanie3);
$rezultat3->bindValue(1,$user,PDO::PARAM_STR);
$rezultat3->bindValue(2,$userip,PDO::PARAM_STR);
$rezultat3->bindValue(3,$msg_date,PDO::PARAM_STR);
$rezultat3->bindValue(4,$message,PDO::PARAM_STR);
$rezultat3->execute();

$polaczenie=NULL;