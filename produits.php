<?php

include_once("varSession.inc.php");
$weCatExiste = false;

$_SESSION['ici_index_bool'] = false;
$_SESSION['ici_contact_bool'] = false;

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
                            WHERE ? = produit_cat");

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
                    <?php if($okconnectey && $okuserADMIN){ ?>
                    <button id="modifierBay" onclick=" window.location.replace('editProduit.php?id=<?=$Pr[$i]['produit_id'] ?>')"> Editer <i class="fas fa-pen"></i></button>

                    <?php }?>       
                    <img src="<?=$Pr[$i]['produit_src']?>" alt="" > 
                    <div class="content ">

                        <div class="row">
                            <div class="details">
                                <span><strong><?=$Pr[$i]['produit_title'] ?></strong></span>
                                <p>de <u><?=$Pr[$i]['produit_author'] ?></u> (<?=$Pr[$i]['produit_year'] ?>)
                                    <br>
                                    <small class="ref"><i><b>ref : <?= $LaCat ?><?=$Pr[$i]['produit_id']?></b></i></small>
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


        <script type="text/javascript"  src="js/boutique.js"> </script>

        <script type="text/javascript" src="js/modal.js"> </script>
       
        <script type="text/javascript" src="js/navbar.js"> </script>


    </body>
</html>
