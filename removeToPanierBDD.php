<?php
include_once("varSession.inc.php");

if(!empty($_GET) && $okconnectey ){
    $ok = true;

    extract($_GET);

    $key = (int) $key;
    var_dump($key);

    /*** Verif la clé du produit */
    $req = $BDD->prepare("SELECT *
                            FROM produit
                            WHERE produit_id = ?");
    $req->execute(array($key));
    $verif_p = $req->fetch();

    if(!isset($verif_p) || empty($verif_p)) {
        $ok = false;
        echo " # produit $key existe pas dans la boutique!";
    }else { // produit existe ok

        $panier = $_SESSION['user_panier'] ;
        var_dump("le panier avant",$panier);
        if(!$okMonPanierEstVide){
            // verif que lelement est bien present
            if(!in_array($key,array_keys($panier))){
                $ok = false;
                echo " # produit $key n'était pas pas dans le panier chakal";
            }
        } else {
            $ok = false;
            echo "panier vide";
        }
    }



    if($ok){


        // si un qté à diminuer est préciser alors
        if(isset($diminu) && !empty($diminu)) {
            // ici le panier est considéré pas vide

            //diminuer lbail
            $x = (int) $_SESSION['user_panier'][$key]['q'];
            $newQte = ($x-1);

            if($newQte > 0) {
                $req = $BDD->prepare("UPDATE panier SET panier_quantity = ? WHERE panier_produit_id = ?"); 
                $req->execute(array($newQte,$key));
            } else { // si =0 on supprime le bail
                $req = $BDD->prepare("DELETE FROM panier WHERE panier_produit_id = ? AND panier_user_id = ? "); 
                $req->execute(array($key,$_SESSION['user_id']));

            }

            echo $key." : ".$_SESSION['user_panier'][$key]['q']. " := ".$newQte;


        } 
        // si rien n'est préciser on suppr tout mgl
        else {
            $req = $BDD->prepare("DELETE FROM panier WHERE panier_produit_id = ? AND panier_user_id = ? "); 
            $req->execute(array($key,$_SESSION['user_id']));
            echo "we c suppr c bon";
        }

        $_SESSION['user_panier'] = getDataBDDPanier($_SESSION['user_id'],$BDD); // maj panier
        var_dump("le panier après",$_SESSION['user_panier']);



        echo "***removePanier $key ***";

    }
} else {
    if($okconnectey){ echo "get vide.. ";} else {echo "pas connecté.. ";};
}

?>