<?php
ob_start();
header('Content-Type: text/html; charset=utf-8');

require_once "conn_info.php";

$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$zapytanie="SELECT user_name FROM logged_users ORDER BY user_name ASC";
$rezultat=@$polaczenie->query($zapytanie);
$rezultat=$rezultat->fetchAll(PDO::FETCH_NUM);
ob_end_clean();

$rezultat=json_encode($rezultat);
echo $rezultat;

$polaczenie=NULL;