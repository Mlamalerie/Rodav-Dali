<?php

include_once("varSession.inc.php");

if(!empty($_GET) && $okconnectey){
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
    } else {
        // verif que la quantité est résonable

        $qte = (int) $qte; // la quantité a jouté askip
        $qteDejaPan = 0;
        $okExisteDejaDansPanier = false;
        if(!$okMonPanierEstVide){ // si mon panier n'est pas vide je recupere les quantité

            $Produits2MonPan = array_keys($_SESSION['user_panier']); // prérefable de verif la bdd nan... mais bon pas grv ça marche
            
            // si le produit est deja dans le panier
            if(in_array($key,$Produits2MonPan)) {
                $okExisteDejaDansPanier = true;
                // recuperer la quantité du produit deja dans le panier
                $qteDejaPan += $_SESSION['user_panier'][$key]['q'];
                var_dump("qté deja dans le panier",$qteDejaPan);
            }




        }
        if($qte + $qteDejaPan > $verif_p['produit_quantity']) {
            $ok = false;
            echo "pas assez en stock.. ".($qte + $qteDejaPan)." > ".$verif_p['produit_quantity'];
        } else if ($qte < 1) {
            $ok = false;
            echo "augmente wsh c quoi ça";
        }


    }

    // juska la le produit peut etre ajouté
    if($ok){


        // si panier pas vide
        if(!$okMonPanierEstVide) {
            // si le produit est deja dans le panier
            if($okExisteDejaDansPanier){
                $qte += (int) $_SESSION['user_panier'][$key]["q"]; // add qte

            } 
        }


        //}

        var_dump("panier du boug avant ajout");
        var_dump($_SESSION['user_panier'] );

        /*
        $ajout = array("produit_id" => $key, "produit_title" => $verif_p['produit_title'], "produit_author" => $verif_p['produit_author'], "produit_price" => $verif_p['produit_price'], "produit_src" => $verif_p['produit_src'], "produit_quantity" => $verif_p['produit_quantity'] "q" => $qte );


        $panier[$key] = $ajout; // ajouter la mise à jour au panier

        var_dump("element a ajouté"); 
        var_dump($ajout); 

*/
        if($okExisteDejaDansPanier) {
            $req = $BDD->prepare("UPDATE panier SET panier_quantity = ? WHERE panier_produit_id = ?"); 
            $req->execute(array($qte,$key));

        } else {
            $req = $BDD->prepare("INSERT INTO panier (panier_produit_id,panier_quantity,panier_user_id) VALUES (?, ?, ?)"); 
            $req->execute(array($key,$qte,$_SESSION['user_id']));
        }


        $_SESSION['user_panier'] = getDataBDDPanier($_SESSION['user_id'],$BDD); // maj panier
        var_dump("panier du boug APRES ajout");
        var_dump($_SESSION['user_panier'] ); 



        echo "*** sendPanier p$key := $qte ***";

    }
} else {
    if($okconnectey){ echo "get vide.. ";} else {echo "pas connecté.. ";};
}

?>