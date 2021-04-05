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

    header('Location: index.php');
    // header('Location: produits.php?cat=albums');

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
        <input type="hidden" id="CodeCat" value="<?= $CodeCat ?>">
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
                    if($okconnectey){

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
                    else {?>onclick="addPanier(<?=$i?>,'<?=$Pr[$i]['Title']?>','<?=$Pr[$i]['Quantity']?>')" <?php }?> > <u>Ajouter au panier</u></button>  
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

        <script type="text/javascript" src="js/notif.js"> </script>
        <script type="text/javascript"  src="js/boutique.js"> </script>
        <script type="text/javascript" src="js/modal.js"></script>
        <script type="text/javascript" src="js/navbar.js"> </script>


    </body>
</html>
