<?php

include_once("varSession.inc.php");
$_SESSION['ici_index_bool'] = true;
$_SESSION['ici_contact_bool'] = false;


if(isset($_GET['n']) && !empty($_GET['n'])) {
    extract($_GET);
    $n = (int) $n;
    switch($n) {
        case 1 : $mess = "Votre message a bien été envoyé ! Vous allez être redirigé vers l'index..."; break;
        case 2 : $mess = "L'inscription c'est bien passé ! Vous allez être redirigé vers l'index... Bienvenue  <b> ". $_SESSION['user_pseudo']. " </b>  :) "; break;
        default : $mess = "?";break;
    }
} else {
    header('HTTP/1.0 404 Not Found');
    exit();
}

if(!isset($mess)) {
    header('HTTP/1.0 404 Not Found');
    exit();
}

header( "refresh:3;url=index.php" );

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href=" css/bravo.css">

        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title>C'est bon ! | Rodav Dalí</title>
    </head>
    <body onload="Loading()">


        <img src="img/valided.png" alt="ok" class="center" width="50">
        <div class="container"><p class="mess"><?=$mess ?></p></div>

        <div id="cover" class="cover">
            <div id="loading" class="ui-circle-loading">
                <ul class="animate">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>

    </body>
</html>
