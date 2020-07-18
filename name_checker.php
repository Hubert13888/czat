<?php
    session_start();
    header('Content-Type: text/html; charset=utf-8');

    $_SESSION['sprawdzajka']=0;
    $user=$_POST['user']; $user=trim($user); $user=htmlentities($user,ENT_QUOTES,"UTF-8");
    $dlugosc_user=strlen($user);

    if ($user==''){
        $_SESSION['sprawdzajka']=1;
    }
    elseif ($dlugosc_user<1||$dlugosc_user>15){
        $_SESSION['sprawdzajka']=2;
    }