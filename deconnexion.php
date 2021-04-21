<?php

include_once("varSession.inc.php");

if($okconnectey){
    session_unset();
    session_destroy();

    header('Location: index.php');
    exit;

} else {
    header('HTTP/1.0 404 Not Found');
    exit();

}

/*
    print_r($_SESSION);
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier'], $_SESSION["user_panier"]);
    $Data_Users[$_SESSION["user_email"]]['panier']['produit'] = $_SESSION["user_panier"];
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier']); // manque plus qu'à ecrire ça*/

//writeUsersXMLFile($Data_Users);  // mettre à jour le fichier des users ?




?>