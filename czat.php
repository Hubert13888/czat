<?php
include_once "name_checker.php";
     if ($_SESSION['sprawdzajka']!=0){
        header("Location: strona-logowania");
        exit();
    }
$_SESSION['user']=$_POST['user'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Czat</title>
    <link rel="stylesheet" href="czat_style.css">
    <script src="jquery-3.1.1.min.js"></script>
    <script src="czat_name_checker.js"></script>
    
</head>

<body>
    <div id="container">
        <div id="main_cnt">
            <div id="okno_gl_czatu">
                
            </div>
            
            <div id="names">
            </div>
        </div>
            <form id="msg" method="post">
                <input type="text" id="inp_msg"/>

                <button id="sub_msg">Wyślij!</button>
           </form>
    </div>    
</body>
<script>
    var timer1,timer2,user_name="<?php echo $_POST['user']; ?>";
    function time_update(){
        $.ajax({
            url: "user_updater.php",
            error: function(){
                window.stop();
                document.write("Błąd krytyczny!!! Spróbuj ponownie później (user_updater)");
                clearTimeout(timer1);
            }, //koniec error
        }); //koniec ajax
        
    } //koniec funkcji time_update()
    function logged_users_update(){
        $.ajax({
            type: "GET",
            url: "logged_user_choose.php",
            contentType:"application/json; charset=utf8",
            dataType:"json",
            success: function(json){
                var il_im_w_json=0,il_im_w_class=0;
                var tb_class=Array(),tb_json=Array();
                // Algorytm dodający użytkownika na listę
                $.each(json,function(index,wartosc){ //funkcja dodaje do containera nicki
                    tb_json[il_im_w_json]=wartosc;
                    il_im_w_json++;                  //jeżeli użytkownika z bazy nie ma w divie, czyli 
                    var licznik=0;                   //licznik=0 to użytkownik jest dodawany do diva
                    $('.user').each(function(){                       
                        var tekst=$(this).text();   //Dodaje wszystkich użytkowników z bazy do 
                        if(tekst==wartosc){         //jednej tablicy i zlicza ich (il_im_w_json)
                            licznik++;
                        }
                    }); //koniec each2  
                    if (licznik==0){
                        $('#names').append('<div class="user">'+ wartosc +'</div>');
                    }
                }); // koniec each 1
                
                // Algorytm usuwający użytkownika z listy
                $('.user').each(function(){
                    var tekst=$(this).text();      //wypełnia tablicę imionami z diva i zlicza ilu userów
                    tb_class[il_im_w_class]=tekst; //jest w divie (il_im_w_class)
                    il_im_w_class++;
                }); //koniec each

                for(var i=0;i<il_im_w_class;i++){
                    var imie_spraw=tb_class[i],licznik=1;
                         for(var j=0;j<il_im_w_json;j++){
                             var imie_porow=tb_json[j]; // Jeżeli imie z diva jest równie któremuś z bazy
                             if(imie_spraw==imie_porow){ // to licznik się zeruje (imie jest, nie trzeba
                                 licznik=0;             //usuwać)
                             } //koniec if
                         } //koniec for 2
                    if(licznik==1){
                        $('.user').each(function(){ // jeżeli jednak imie nie istnieje w bazie (użytkownik
                            var tekst=$(this).text(); // offline, licznik nadal=1), to wtedy jest wyszukiwane w
                                if(tekst==imie_spraw){ // divie funkcją each i usuwane
                                    $(this).remove();
                                }
                        }); //koniec each
                    } //koniec if
                } //koniec for 1
            },//koniec success
            error: function(){
                window.stop();
                document.write("Błąd krytyczny!!! Spróbuj ponownie później (logged_user_choose)");
                clearTimeout(timer1);
            }
        }); //koniec ajax
    } //koniec funkcji logged_users_update()
    function message_add(){
        $.ajax({
            type: "GET",
            url: "message_add.php",
            contentType:"application/json; charset=utf-8",
            dataType:"json",
            success: function(all_msgs){
                $.each(all_msgs,function(index1,wartosc1){
                    $.each(wartosc1,function(index2,wartosc2){
                            switch(index2){
                                case 0:
                                    index_ost_wiad=wartosc2;
                                    break;
                                case 1:
                                    if(wartosc2==user_name){
                                        $('#okno_gl_czatu').append("<div class=u_message>");
                                    }
                                    else $('#okno_gl_czatu').append("<div class=message>");
                                    
                                    $('#okno_gl_czatu').append(wartosc2);
                                    break;
                                case 2:
                                    break;
                                case 3:
                                    $('#okno_gl_czatu').append(" | "+wartosc2+" >> ");
                                    break;
                                case 4:{
                                    $('#okno_gl_czatu').append(wartosc2);
                                    break; 
                                }//koniec case 4
                            }//koniec switch
                    }); //koniec each
                    $('#okno_gl_czatu').append("</div>");
                }); //koniec each all_msgs
            },
            complete: function(){           calk_wysokosc=document.getElementById("okno_gl_czatu").scrollHeight; $('#okno_gl_czatu').scrollTop(calk_wysokosc);
            },
            error: function(){
                window.stop();
                document.write("Błąd krytyczny!!! Spróbuj ponownie później (message_add)");
                clearTimeout(timer2);
            }
        }); //koniec ajax
    } //koniec message_add
    
    function message_update(){
        $.ajax({
            type: "POST",
            url: "message_updater.php",
            data:{
                ind_wiad:index_ost_wiad},
            dataType:'json',
            success: function(all_msgs){
              
                $.each(all_msgs,function(index1,wartosc1){        
                    $.each(wartosc1,function(index2,wartosc2){
                            switch(index2){
                                case 0:
                                    index_ost_wiad=wartosc2;
                                    break;
                                case 1:
                                    if(wartosc2==user_name){
                                        $('#okno_gl_czatu').append("<div class=u_message>");
                                    }
                                    else $('#okno_gl_czatu').append("<div class=message>");
                                    
                                    $('#okno_gl_czatu').append(wartosc2);
                                    break;
                                case 2:
                                    break;
                                case 3:
                                    $('#okno_gl_czatu').append(" | "+wartosc2+" >> ");
                                    break;
                                case 4:{
                                    $('#okno_gl_czatu').append(wartosc2);
                                    break; 
                                }//koniec case 4
                            }//koniec switch
                    }); //koniec each
                    $('#okno_gl_czatu').append("</div>");
                    
                      
                    var odleglosc_od_gory=document.getElementById("okno_gl_czatu").scrollHeight;
                    var aktualny_scroll=$('#okno_gl_czatu').scrollTop();
                    var wielkosc_suwaka=$('#okno_gl_czatu').innerHeight();

                    
                    if(all_msgs==true){
                        if(aktualny_scroll+wielkosc_suwaka==odleglosc_od_gory){

                        }
                        else { //gdy suwak nie jest przy dolnej krawędzi

                        }
                    }
                    
                    setTimeout(function(){index_ost_wiad++;},100);
                    
                 }); //koniec each
            },
            error: function(){
                window.stop();
                document.write("Błąd krytyczny!!! Spróbuj ponownie później (msg_updater)");
                clearTimeout(timer1);
            }
        });//koniec ajax
    } //koniec message_update
    function chat_working(){
        time_update();
        logged_users_update();
        message_update();
        timer1=setTimeout('chat_working()',1000);
    } //koniec chat_working
    
    /*----DOCUMENT READY----*/
    
    $(document).ready(function(){
        $.ajax({ //ajax 1
            type: "GET",
            url: "offline_remover.php",
            success: function(info){
                if(info!=1){
                    document.write(info);
                } //koniec if
                else {
                   $.ajax({ //ajax 2
                        url: "name_insert.php",
                        success: function(){
                            message_add();
                            timer2=setTimeout('chat_working()',1000);
                        } //koniec success sTo
                    });//koniec ajax 2
                } //koniec else
            } //koniec success info
        }); //koniec ajax 1
        
        //algorytm dodający wiadomość
        $('#sub_msg').click(function(){
            var message=$('#inp_msg').val();

           $.ajax({
                type: "POST",
                url: "message_sender.php",
                data: {msg:message},
                dataType: "json",
                success: function(informacje){
                    
                    $('#okno_gl_czatu').append("<div class=u_message>");
                    $.each(informacje, function(index, wartosc){
                        switch(index){
                            case 0:
                                $('#okno_gl_czatu').append(wartosc);
                                break;
                            case 1:
                                $('#okno_gl_czatu').append(" | "+wartosc+" >> ");
                                break;
                            case 2:
                                $('#okno_gl_czatu').append(wartosc);
                                break;
                            case 3:
                                index_ost_wiad=wartosc;
                                break;
                        }
                    }); //koniec each
                $('#okno_gl_czatu').append("</div>");
                },
               complete: function(){
                    $('#inp_msg').val('');
                    $('#inp_msg').focus();
                    var calk_wysokosc=document.getElementById("okno_gl_czatu").scrollHeight;
					$('#okno_gl_czatu').scrollTop(calk_wysokosc);
               },
                error: function(){
                    $('body').prepend('NIe udało się wysłać wiadomości (message_sender)');
                }
            });//koniec ajax
        }); //koniec click
    }); //koniec ready
</script>
</html>