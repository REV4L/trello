
    <?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "trello3";

    //1. way
    //$con = mysqli_connect($host, $user, $password) or die("Napaka pri povezavi na streznik!");

    //echo 'STREZNIK ✔️<br><br>';

    //$db = "proizvodi";

    //mysqli_select_db($con, $db) or die ("Napaka pri povezani na bazo!");

    //echo 'BAZA ✔️';

    //2. way

    try{
        $link = new mysqli($host, $user, $password, $db);

        //echo 'Status: dela<br><br>';

    }catch(Exception $e){
        //echo 'Status: db error <br><br>';
    }
   
    //POVEZALI juhu

    mysqli_set_charset($link, "utf8");


    ?>