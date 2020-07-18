<?php
header('Content-Type: text/html; charset=utf-8');

require_once "conn_info.php";

$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$zapytanie="SELECT * FROM messages ORDER BY msg_date ASC";
$rezultat=$polaczenie->query($zapytanie);
$wynik=$rezultat->fetchAll(PDO::FETCH_NUM);
$wynik=json_encode($wynik);
print_r ($wynik);

$polaczenie=NULL;