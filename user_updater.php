<?php

require_once "conn_info.php";


$currdate=time();
$deldate=$currdate-$del_time;
$userip=$_SERVER['REMOTE_ADDR'];
    
$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);

$zapytanie1="UPDATE logged_users SET user_date=? WHERE user_ip=?";
$rezultat1=$polaczenie->prepare($zapytanie1);
$rezultat1->bindValue(1,$currdate,PDO::PARAM_STR);
$rezultat1->bindValue(2,$userip,PDO::PARAM_STR);
$rezultat1->execute();

$zapytanie1="DELETE FROM logged_users WHERE user_date<?";
$rezultat2=$polaczenie->prepare($zapytanie1);
$rezultat2->bindValue(1,$deldate,PDO::PARAM_STR);
$rezultat2->execute();

$polaczenie=NULL;