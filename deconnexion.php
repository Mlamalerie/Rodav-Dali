<?php

include_once("varSession.inc.php");

if($okconnectey){
    $panier = $_SESSION['user_panier'];

    //var_dump('Le panier',$panier);
    //var_dump('le panier de u avant ',$Data_Users[$_SESSION['user_email']]['panier']);
    $Data_Users[$_SESSION['user_email']]['panier']['produit'] = $panier;

   // var_dump('le panier de u après',$Data_Users[$_SESSION['user_email']]['panier']);

    if(writeUsersXMLFile($Data_Users)) {
        echo "ok write save panier";

    }
  
}

/*
    print_r($_SESSION);
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier'], $_SESSION["user_panier"]);
    $Data_Users[$_SESSION["user_email"]]['panier']['produit'] = $_SESSION["user_panier"];
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier']); // manque plus qu'à ecrire ça*/

//writeUsersXMLFile($Data_Users);  // mettre à jour le fichier des users ?

session_unset();
session_destroy();

header('Location: index.php');
exit;


?>