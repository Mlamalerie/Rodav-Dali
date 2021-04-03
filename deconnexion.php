<?php
session_start();

include_once("varSession.inc.php");
print_r($_SESSION);
if($okconnectey){
    print_r($_SESSION);
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier'], $_SESSION["user_panier"]);
    $Data_Users[$_SESSION["user_email"]]['panier']['produit'] = $_SESSION["user_panier"];
    var_dump( $Data_Users[$_SESSION["user_email"]]['panier']);
    
    //writeUsersXMLFile($Data_Users);  // mettre à jour le fichier des users ?


    
    session_unset();
    session_destroy();


} else {
    echo '#';
}

//header('Location:'.$_SERVER['HTTP_REFERER']);
//header('Location: index.php');
//exit;

?>