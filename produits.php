<?php

include_once("varSession.inc.php");
$weCatExiste = false;

$_SESSION['ici_index_bool'] = false;
$_SESSION['ici_contact_bool'] = false;

$_GET['cat'] = "albums";

if(isset($_GET['cat']) && !empty($_GET['cat'])) {


    $LaCat = (String) $_GET['cat'];


    /*** Verif la Cat */
    $req = $BDD->prepare("SELECT categorie_id
                            FROM categorie
                            WHERE categorie_title = ?");
    $req->execute(array($LaCat));
    $verif_cat = $req->fetch();

    $weCatExiste = true;
    if(!isset($verif_cat['categorie_id'])) {
        $weCatExiste = false;

    } else {
        $CodeCat = (int) $verif_cat['categorie_id'];
    }

    // si la cat est valide
    if ($weCatExiste) {
        $req = $BDD->prepare("SELECT * FROM produit
                            WHERE ? = produit_cat  
                           ");

        $req->execute(array($CodeCat));
        $Produits = $req->fetchAll();


    } else {
        header('HTTP/1.0 404 Not Found');
        exit;
    }


} else {
    header('Location:index.php');
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

                $Pr = $Produits;
                $i = 0;


                while($i < count($Pr)) {
                    $max = (int) $Pr[$i]['produit_quantity'];

                    $key = $Pr[$i]['produit_id'];
                    if($okconnectey && !$okMonPanierEstVide ){

                        // si le produit est deja dans le panier
                        if(in_array($key,array_keys($_SESSION["user_panier"]))) {
                            $q = (int) $_SESSION["user_panier"][$key]['q'];
                            $max -= $q; // la quantité max a ajouté est diminué
                        }
                    }

                ?>



                <?php if($i % 3 == 0) {?>  <!-- ===== LIGNE ===== --> <div class="wrapper"> <?php } ?>

                <div class="card">
                    <span class="quantiteBay"><span class="billeQte"><?=$Pr[$i]['produit_quantity']?></span> en stock</span>
                    <img src="<?=$Pr[$i]['produit_src']?>" alt="" > 
                    <div class="content ">

                        <div class="row">
                            <div class="details">
                                <span><strong><?=$Pr[$i]['produit_title'] ?></strong></span>
                                <p>de <u><?=$Pr[$i]['produit_author'] ?></u> (<?=$Pr[$i]['produit_year'] ?>)

                                </p>
                                <div class="CombienDiv right">
                                    <button class="session-title my-2 " <?php if(!$okconnectey) { ?> onclick="location.href = 'sign.php'" <?php } 
                    else {?>onclick="addPanier(<?=$Pr[$i]['produit_id']?>,'<?=$Pr[$i]['produit_quantity']?>')" <?php }?> > <u>Ajouter au panier</u></button>  
                                    <div class="session justify-content-center my-2  "> 

                                        <div class="plus-minus"> 
                                            <button id="session-minus" class="session-signe" onclick="moin(<?=$Pr[$i]['produit_id']?>)" >–</button>
                                            <input id="nbQteCommande<?=$Pr[$i]['produit_id']?>" type="number" class="session-time mx-2" value="0" disabled>
                                            <button id="session-plus" class="session-signe" onclick="plus(<?=$Pr[$i]['produit_id']?>,<?=$max?>)">+</button> 
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="price">$<?=floatval($Pr[$i]['produit_price'])?></div>
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

        <script type="text/javascript" src="js/notif.js"> </script>

        <!--        <script type="text/javascript"  src="js/boutique.js"> </script>-->
        <script>
            /**************************************************************/
            /***************************** AFFICHAGE QTE ETIQUETTE STOCK */


            var inputAffichageQte = document.getElementById('affqte'); 
            showQte(inputAffichageQte);

            function showQte(input) {

                if(input){
                    let liste = document.getElementsByClassName("quantiteBay");
                    let contents = document.getElementsByClassName("content");

                    if(input.checked) {

                        for(let i = 0; i < liste.length; i++) {

                            liste[i].style.display = "none";
                            //  contents[i].classList.add("bottombottom1");
                        }
                    } else {

                        for(let i = 0; i < liste.length; i++) {

                            liste[i].style.display = "inline";
                            //   contents[i].classList.remove("bottombottom1");
                        }
                    }
                }
            }

            /**************************************************************/
            /***************************** BTN + - CARD */
            function plus(key,max) {
                console.log("plus("+key + "," + max + ")");
                //  if(!okConnect){
                //      createNotificationDelay(2,"Connectez-vous pour pouvoir ajouter au panier ",0);
                //  }
                let input = document.getElementById("nbQteCommande"+key);

                if(parseInt(input.value) < max) {
                    let x = parseInt(input.value);
                    input.value = x+1;
                } else {
                    console.log("*");
                    createNotification("Vous avez déjà tous mis dans votre panier... ",0,0);
                }
            }

            function moin(key) {
                let input = document.getElementById("nbQteCommande"+key);
                if(parseInt(input.value) > 0) {
                    let x = parseInt(input.value);
                    input.value = x-1;
                } 
            }


            var AfficherTextActualiserPage = true;
            var AfficherTextConnecteToiChkl = true;

            /**************************************************************/
            /***************************** PANIER */

            // *** ajouter au panier SESSION PHP
            function goToSendPanierPHP(key,qte) {
                var xmlhttp = new XMLHttpRequest();

                let ou = "sendToPanierBDD.php?key=";

                ou += key; // c'est la clé
                ou += '&qte=';
                ou += qte;

                console.log("go",ou);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

            }  
            // *** retirer du panier SESSION PHP
            function goToRemovePanierPHP(key,OkDiminu = false) {
                var xmlhttp = new XMLHttpRequest();

                let ou = "removeToPanierBDD.php?key=";

                ou += key; // c'est la clé

                if(OkDiminu) {
                    ou += '&diminu=1';
                }

                console.log("go",ou);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

            }  


            // *** Mise a jour de la var js LePanierSESSION, modification qté ou ajout d'un nv produit
            function majQteVarPanier(key,newQte) {
                console.log("majVarPanier",key,newQte);

                let listeProduitsPan = Object.keys(LePanierSESSION);

                // si le bail est deja dans le panier
                if (listeProduitsPan.includes(key))  { 
                    LePanierSESSION[key]['q'] = newQte; 
                } else { // ajouter nouveau produit
                    if(!LePanierSESSION){
                        LePanierSESSION = {};
                    }
                    p = {
                        "produit_id": key,
                        "produit_title": LaBoutique[key]['produit_title'],
                        "produit_price": LaBoutique[key]['produit_price'],
                        "produit_src": LaBoutique[key]['produit_src'],
                        "produit_author": LaBoutique[key]['produit_author'],
                        "q": newQte
                    }
                    console.log(p);
                    LePanierSESSION[key] = p;
                }

            }

            // *** BTN Card ajouter au panier  (key est enfaite l'id)
            function addPanier(key,max) {

                let qte = parseInt(document.getElementById("nbQteCommande"+key).value);
                let qteDejaPanier = 0;


                if (qte > 0){ 

                    console.log("addPanier***");

                    let actualiserSvpEh = false;
                    // si le panier n'est pas vide
                    if(LePanierSESSION) {
                        let listeProduitsPan = Object.keys(LePanierSESSION); // produits du panier
                        // si le bail est deja dans le panier
                        if (listeProduitsPan.includes(key)) {

                            // on recupère la quantité deja dans le panier
                            qteDejaPanier = parseInt(LePanierSESSION[key]['q']);
                        } 
                        
                        if(!LePanierSESSION[key]) {
                            actualiserSvpEh = true;
                        }
                    } else {
                         actualiserSvpEh = true;
                    }

                    // faut actualiser chakal, si 
                    if(AfficherTextActualiserPage && actualiserSvpEh){
                        createNotificationDelay(4,"Actualiser la page pour voir les modifications faîtes au panier",0);
                        AfficherTextActualiserPage = false;
                    }

                    /* BDD Panier */
                    if(qte + qteDejaPanier <= max){ // si la quantité voulu ajout + la qte deja dans le panier est bien possible
                        createNotification('<b>"' + LaBoutique[key]['produit_title'] +'"</b>' + " x " + qte + " a été ajouté au panier",1,1);

                        plus2(key,max,qte); // maj les quantité dans le modal panier

                    } else {
                        createNotification("Il n'y a que " + max + " - <b>'" + LaBoutique[key]['produit_title'] +"'</b> en stock.. ",-1);
                    }


                    majCountPan();
                } 
                else { // si la quantité est inf à 0
                    createNotification("Veuillez augmenter la quantité pour l'ajouter au panier",-1);
                }

                console.log("LePanierSESSION après ajout",LePanierSESSION);
            }


        </script>
        <!--        <script type="text/javascript" src="js/modal.js"> </script>-->
        <script>
            var AfficherTextVaTePromenerFrr = true;

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
                    CalculAffPrixTotal();
                    if(majCountPan() == 0 ) {
                        if(AfficherTextVaTePromenerFrr){
                            createNotificationDelay(4,"Votre panier est vide.. promenez vous dans la boutique et ajouter des articles...",0);
                            AfficherTextVaTePromenerFrr = false;
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


            // *** Met a jour la petite vignette rouge = nb de produit dans le panier
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

            // *** Met a jour le prix total du panier dans le modal
            CalculAffPrixTotal();
            function CalculAffPrixTotal() {
                console.log("calculTotal");
                let s = 0;

                if(LePanierSESSION){
                    let listeProduits = Object.keys(LePanierSESSION);

                    for(let i = 0; i < listeProduits.length; i++) {
                        p = LePanierSESSION[listeProduits[i]];

                        s +=  parseInt(p['q']) * parseFloat(p['produit_price']);
                    }


                    document.getElementById("prixTotalPan").innerHTML = "$"+s;
                }

            }

            // *** BTN + du modal, ajoute une qte sur le modal, et directement a la bdd si voulu
            function plus2(id,max,qte = 1) { 
                console.log("plus2");
                let input = document.getElementById("nbQtePanier"+id);

                if(input){
                    console.log("max =",max);
                    console.log("parseInt(input.value) =",parseInt(input.value));
                    console.log("qte =",qte);
                    console.log("if",parseInt(input.value) + qte,(input.value + qte < max ));

                    if(parseInt(input.value) + qte <= max) {
                        let x = parseInt(input.value);
                        document.getElementById("nbQtePanier"+id).value = x+qte;

                        goToSendPanierPHP(id,qte); 

                        majQteVarPanier(id,x+qte); 
                        CalculAffPrixTotal()


                    } else {
                        createNotification("Il n'y a que " + max + " <b>'" + LePanierSESSION[id]['produit_title'] +"'</b> en stock.. ",-1,1);
                    }
                } else {
                    goToSendPanierPHP(id,qte); 
                }



            }

            function removePanier(key) {
                console.log("removePanier",key);

                console.log("***");

                goToRemovePanierPHP(key);
                // suprimer la div
                let elem = document.getElementById("item-"+key);
                elem.parentNode.removeChild(elem);

                createNotification(" <b>'" + LePanierSESSION[key]['produit_title'] +"'</b>'" + " a été supprimer du panier",1,1);

                delete LePanierSESSION[key];
                CalculAffPrixTotal();
                majCountPan();

            }
            // *** BTN - du modal
            function moin2(id) {
                let input = document.getElementById("nbQtePanier"+id);
                if(input){

                    if(input.value > 1) {
                        console.log("moins2()",id,"we");
                        let x = parseInt(input.value);
                        document.getElementById("nbQtePanier"+id).value = x-1;

                        goToRemovePanierPHP(id,true);
                        majQteVarPanier(id,x-1); 
                        CalculAffPrixTotal();
                    } 
                }
            }


        </script>
        <script type="text/javascript" src="js/navbar.js"> </script>


    </body>
</html>
