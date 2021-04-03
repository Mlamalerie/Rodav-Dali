<?php

if(!empty($_GET)){

    $key = (int) $key;
    $qte = (int) $qte;

    $ok = true;

    if($ok){

        $req = $BDD->prepare("INSERT INTO panier (panier_beat_id,panier_user_id) VALUES (?, ?)"); 
        $req->execute(array($idbeat,$idboug));

        echo "*** sendPanier ***";
    }
}

?>