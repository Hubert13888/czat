<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
if (isset($_SESSION['sprawdzajka'])){
        switch ($_SESSION['sprawdzajka']){
            case 1:{
                    $error='<div id="error">Wpisz nazwę użytkownika!</div>';
                    break;
                } //koniec case 1
            case 2:{
                    $error='<div id="error">Nazwa użytkownika musi zawierać do 15 znaków!</div>';
                    break;
                } //koniec case 2
            default:{
                    $error='<div id="error">Nazwa użytkownika zawiera niedozwolone znaki!</div>';
                    break;
                } //koniec default
        } //koniec switch
    unset($_SESSION['sprawdzajka']);
    } //koniec if
else $error=''; 
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Czat</title>
    <link rel="stylesheet" href="index_style.css">
</head>
<body>
    <div id="version">Alpha v.1.0 Stable</div>
      
       <form method="post" action="chat">
            <h4>Wprowadź swój nick :D</h4>
            <?php
                echo $error;
            ?>
            <div id="spajacz">
                <input type="text" id="inp_name" name="user"/>

                <button id="sub_name">Wyślij!</button>
            </div>
       </form>

</body>
</html>