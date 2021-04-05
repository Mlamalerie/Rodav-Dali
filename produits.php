<?php
session_start();
include_once("varSession.inc.php");
$weCatExiste = false;

$_SESSION['ici_index_bool'] = false;
$_SESSION['ici_contact_bool'] = false;

if(isset($_GET['cat']) && !empty($_GET['cat'])) {
    $weCatExiste = true;
    $lc = array("albums","mode","tableaux");
    if (in_array(strtolower($_GET['cat']), $lc)) {
        $LaCat = (String) $_GET['cat'];

        switch($LaCat) {
            case "albums" : $CodeCat = 'a'; break;
            case  "tableaux" : $CodeCat = 't'; break;
            case  "mode" : $CodeCat = 'm'; break;
        }


    } else {
        header('HTTP/1.0 404 Not Found');
        exit;
    }


} else {
    header('Location: produits.php?cat=albums');
    // header('Location: index.php');


    exit;
};

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/checkbox.css">
        <link rel="stylesheet" href="css/produits.css">
        <link rel="stylesheet" href="css/buttonmagique.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/notif.css">


        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title><?= ucfirst($LaCat)?> | Rodav Dalí • Web Site</title>

    </head>
    <body >

        <div id="toasts"></div> <!--  NOTIFICICATION -->




        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>
        <!-- ===== WALL ===== -->
        <div class="banner"></div>
        <!-- ===== CORPS ===== -->
        <div class="about text-white">
            <!-- ===== MENU GAUCHE ===== -->
            <?php require_once('php/menugauche.php'); ?>
            <!-- ===== CONTENU MAGASINS ===== -->
            <div class="content  ">
                <?php

                $Pr = $Produits[$LaCat];
                $i = 0;


                while($i < count($Pr)) {
                    $max = (int) $Pr[$i]['Quantity'];

                    $key = $CodeCat."".$i;
                    if($okconnectey && !$okMonPanierEstVide ){

                        // si le produit est deja dans le panier
                        if(in_array($key,array_keys($_SESSION["user_panier"]))) {
                            $q = (int) $_SESSION["user_panier"][$key]['quantity'];
                            $max -= $q;
                        }
                    }

                ?>



                <?php if($i % 3 == 0) {?>  <!-- ===== LIGNE ===== --> <div class="wrapper"> <?php } ?>

                <div class="card">
                    <span class="quantiteBay"><?=$Pr[$i]['Quantity']?> en stock</span>
                    <img src="<?=$Pr[$i]['src']?>" alt="" > 
                    <div class="content ">

                        <div class="row">
                            <div class="details">
                                <span><strong><?=$Pr[$i]['Title'] ?></strong></span>
                                <p>de <u><?=$Pr[$i]['Author'] ?></u> (<?=$Pr[$i]['Year'] ?>)

                                </p>
                                <div class="CombienDiv right">
                                    <button class="session-title my-2 " <?php if(!$okconnectey) { ?> onclick="location.href = 'sign.php'" <?php } 
                    else {?>onclick="addPanier(<?=$i?>,'<?=$Pr[$i]['Quantity']?>')" <?php }?> > <u>Ajouter au panier</u></button>  
                                    <div class="session justify-content-center my-2  "> 

                                        <div class="plus-minus"> 
                                            <button id="session-minus" class="session-signe" onclick="moin(<?=$i?>)" >–</button>
                                            <input id="nbQteCommande<?=$i?>" type="number" class="session-time mx-2" value="0" disabled>
                                            <button id="session-plus" class="session-signe" onclick="plus(<?=$i?>,<?=$max?>)">+</button> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="price">$<?=$Pr[$i]['Price']?></div>
                        </div>
                    </div>
                </div>
                <?php if($i % 3 == 2) {?> </div> <?php } ?>
                <?php $i++; ?>

                <?php 

                }; ?>

            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <?php require_once('php/footer.php'); ?>

        <script type="text/javascript">
            var LePanierSESSION = <?php if(!$okMonPanierEstVide) {echo json_encode($_SESSION['user_panier']); } else {echo "null";}?>;
            var LaBoutique = <?php echo json_encode($Produits);?>;
            var codeCat = <?php echo json_encode($CodeCat);?>;
            var LaCat = <?php echo json_encode($LaCat);?>;
            console.log(LePanierSESSION);
            console.log(LaBoutique,codeCat);

            if(LePanierSESSION){
                window.onload = function() {
                    CalculAffPrixTotal();
                }
            }

            function majQteVarPanier(key,newQte,ajouterNewP = false) {


                if(!ajouterNewP) {
                    console.log("majVarPanier",key,newQte);
                    LePanierSESSION[key]['quantity'] = newQte; 
                } else { // 
                    if(!LePanierSESSION){
                        LePanierSESSION = {};
                    }
                    p = {
                        "id": LaBoutique[LaCat][key.substr(1)]['id'],
                        "title": LaBoutique[LaCat][key.substr(1)]['Title'],
                        "type": LaCat,
                        "quantity": newQte,
                        "key": key
                    }
                    console.log(p);
                    LePanierSESSION[key] = p;
                }

            }
        </script>

        <script type="text/javascript" src="js/notif.js"> </script>
        <script>
            function createNotificationDelay(attenteSec,message,type,okClickPanier) {
                setTimeout(function() {
                    createNotification(message,type,okClickPanier);

                },1000*attenteSec);
            }
        </script>
        <script type="text/javascript"  src="js/boutique.js"> </script>
        <script>
            var AfficherTextActualiserPage = true;
            majCountPan();
            function goToSendPanierPHP(key,qte) {
                var xmlhttp = new XMLHttpRequest();

                let ou = "sendToPanier.php?key=";

                ou += key; // c'est la clé
                ou += '&qte=';
                ou += qte;

                console.log("go",ou);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

            }  

            function majCountPan() {


                if(LePanierSESSION) {
                    let k = Object.keys(LePanierSESSION).length;
                    document.getElementsByClassName('item-count')[0].innerHTML = k;
                    return k;
                } else {
                    document.getElementsByClassName('item-count')[0].innerHTML = "0";
                    return 0;
                }



            }

            function addPanier(key,max) {

                let qte = parseInt(document.getElementById("nbQteCommande"+key).value);
                let qteDejaPanier = 0;



                if (qte > 0){
                    console.log("addPanier***");

                    // si le panier n'est pas vide
                    if(LePanierSESSION) {
                        let listeProduitsPan = Object.keys(LePanierSESSION); // produits du panier
                        // si le bail est deja dans le panier
                        if (listeProduitsPan.includes((codeCat+key))) {
                            // on recupère la quantité deja la
                            qteDejaPanier = parseInt(LePanierSESSION[(codeCat+key)]['quantity']);
                        } else { // n'est pas dans le panier
                            majQteVarPanier((codeCat+key),qte,true);


                        }
                    } else {
                        console.log("sache que le panier est vide");
                        majQteVarPanier((codeCat+key),qte,true);

                        console.log(  LePanierSESSION,"mtn je l'ai rempli");
                    }





                    if(qte + qteDejaPanier <= max){
                        createNotification('<b>"' + LaBoutique[LaCat][key]['Title'] +'"</b>' + " x " + qte + " a été ajouté au panier",1,1);

                        goToSendPanierPHP((codeCat+key),qte);


                        plus2((codeCat+key),max,qte); // maj les quantité dans le modal panier


                    } else {
                        createNotification("Il n'y a que " + max + " - <b>'" + LaBoutique[LaCat][key]['Title'] +"'</b> en stock.. ",-1);
                    }


                    majCountPan();
                } else {
                    createNotification(" ",-1);
                }

                console.log("LePanierSESSION après ajout",LePanierSESSION);
            }
        </script>
        <script type="text/javascript" src="js/modal.js"></script>
        <script>

            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btnModal = document.getElementById("myBtnModal");


            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];


            if(btnModal && modal){
                // When the user clicks the button, open the modal 
                btnModal.onclick = function() {
                    modal.style.display = "block";
                    if(majCountPan() == 0 ) {
                        if(AfficherTextActualiserPage){
                            createNotificationDelay(4,"Actualiser la page pour voir les modifications faîtes au panier",0);
                            AfficherTextActualiserPage = false;
                        }

                    }
                }
                // When the user clicks on <span> (x), close the modal
                if(span){
                    span.onclick = function() {
                        modal.style.display = "none";
                    }
                }
                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }


            }



            function CalculAffPrixTotal() {
                console.log("calculTotal");
                let s = 0;

                let listeProduits = Object.keys(LePanierSESSION);

                for(let i = 0; i < listeProduits.length; i++) {
                    p = LePanierSESSION[listeProduits[i]];
                    id = p['key'].substring(1);

                    let cc = "";
                    switch(p['key'][0]) {
                        case 'a' : cc = "albums";break;
                        case 't' : cc = "tableaux";break;
                        case 'm' : cc = "mode";break;
                    }

                    s +=  p['quantity']*LaBoutique[cc][id]['Price'];
                }

                document.getElementById("prixTotalPan").innerHTML = "$"+s;

            }


            function plus2(id,max,qte = 1,directToSendPanier = false) { 
                console.log("plus2",directToSendPanier);
                let input = document.getElementById("nbQtePanier"+id);

                if(input){
                    console.log("max =",max);
                    console.log("if",parseInt(input.value) + qte,(input.value + qte < max ));

                    if(parseInt(input.value) + qte <= max) {
                        let x = parseInt(input.value);
                        document.getElementById("nbQtePanier"+id).value = x+qte;

                        if(directToSendPanier) {

                            goToSendPanierPHP(id,qte); 
                        }

                        majQteVarPanier(id,x+qte); 
                        CalculAffPrixTotal()


                    } else {
                        createNotification("Il n'y a que " + max + " <b>'" + LaBoutique[LaCat][id.substr(1)]['Title'] +"'</b> en stock.. ",-1,1);
                    }
                }



            }
            function moin2(id) {
                let input = document.getElementById("nbQtePanier"+id);
                if(input){
                    if(input.value > 1) {
                        let x = parseInt(input.value);
                        document.getElementById("nbQtePanier"+id).value = x-1;


                        CalculAffPrixTotal();
                    } 
                }
            }
            function removePanier(key) {
                console.log("removePanier",key);

                console.log("***");
                var xmlhttp = new XMLHttpRequest();
                let ou = "removeToPanier.php?key=";
                ou += key;

                console.log(ou,key);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

                // suprimer la div
                let elem = document.getElementById("item-"+key);
                elem.parentNode.removeChild(elem);

                createNotification(" <b>'" + LePanierSESSION[key]['title'] +"'</b>'" + " a été supprimer du panier",1,1);

                delete LePanierSESSION[key];
                CalculAffPrixTotal();
                majCountPan();



            }



        </script>
        <script type="text/javascript" src="js/navbar.js"> </script>


    </body>
</html>
