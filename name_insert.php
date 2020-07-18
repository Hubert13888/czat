<?php
session_start();

$userip=$_SERVER['REMOTE_ADDR'];
$data=time();
echo "Data".$data;
$user=$_SESSION['user'];

require_once "conn_info.php";
$polaczenie=new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",
$dbuser,$dbpass , array(  
        PDO::ATTR_EMULATE_PREPARES => false,  
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    )
);
$zapytanie="INSERT INTO logged_users VALUES ('',?,?,?)";
$rezultat=$polaczenie->prepare($zapytanie);
$rezultat->bindValue(1,$user,PDO::PARAM_STR);
$rezultat->bindValue(2,$data,PDO::PARAM_STR);
$rezultat->bindValue(3,$userip,PDO::PARAM_STR);
$rezultat->execute();

$polaczenie=NULL;