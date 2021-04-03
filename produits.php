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
        $CodeCat = 'a';

    } else {
        header('HTTP/1.0 404 Not Found');
        exit;
    }


} else {

    //    header('Location: index.php');
    header('Location: produits.php?cat=albums');

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


        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title><?= ucfirst($LaCat)?> | Rodav Dalí • Web Site</title>

    </head>
    <body >

        <input type="hidden" id="CodeCat" value="<?= $CodeCat ?>">

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
                $LaCat = "albums";

                $Pr = $Produits[$LaCat];
                $i = 0;

                while($i < count($Pr)) {


                ?>



                <?php if($i % 3 == 0) {?>  <!-- ===== LIGNE ===== --> <div class="wrapper"> <?php } ?>

                <div class="card">

                    <img src="<?=$Pr[$i]['src']?>" alt="" > 
                    <div class="content ">
                        <div class="row">
                            <div class="details">
                                <span><strong><?=$Pr[$i]['Title'] ?><span class="quantiteBay">[<?=$Pr[$i]['Quantity']?> en stock]</span></strong></span>
                                <p>de <u><?=$Pr[$i]['Author'] ?></u> (<?=$Pr[$i]['Year'] ?>)

                                </p>
                                <div class="CombienDiv right">
                                    <button class="session-title my-2 " <?php if(!$okconnectey) { ?> onclick="location.href = 'sign.php'" <?php } 
                    else {?>onclick="addPanier(<?=$i?>)" <?php }?> > <u>Ajouter au panier</u></button>  
                                    <div class="session justify-content-center my-2  "> 

                                        <div class="plus-minus"> 
                                            <button id="session-minus" class="session-signe" onclick="moin(<?=$i?>)" >–</button>
                                            <input id="nbQteCommande<?=$i?>" type="number" class="session-time mx-2" value="0" disabled>
                                            <button id="session-plus" class="session-signe" onclick="plus(<?=$i?>,<?=$Pr[$i]['Quantity'] ?>)">+</button> 
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
        <script>
            function addPanier(key) {
                let qte = parseInt(document.getElementById("nbQteCommande"+key).value);

                if (qte > 0){
                    console.log("ajoutPanier");
                    var xmlhttp = new XMLHttpRequest();
                    let codeCat = document.getElementById("CodeCat").value;


                    let ou = "sendToPanier.php?key=";
                    ou += codeCat;
                    ou += key;
                    ou += '&qte=';
                    ou += key;

                    console.log(ou,key,qte);
                    xmlhttp.open("GET",ou,true);
                    xmlhttp.send();
                }
            }

        </script>
        <script type="text/javascript" src="js/boutique.js"> </script>
        <script type="text/javascript" src="js/navbar.js"> </script>
        <script type="text/javascript" src="js/modal.js"> </script>

    </body>
</html>
