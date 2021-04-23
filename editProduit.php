<?php
include_once("varSession.inc.php");


if(!$okconnectey || !$okuserADMIN) {
    header("Location: index.php");
    exit;
} 

$_SESSION['ici_index_bool'] =  false;
$_SESSION['ici_contact_bool'] = false;
$_SESSION['ici_sign_bool'] = false;

$_GET['id'] = 25;
if( !empty($_GET) ){
    $ok = true;
    extract($_GET);
    $id = (int) $id;

    /*** Verif la clé du produit */
    $req = $BDD->prepare("SELECT *
                            FROM produit
                            WHERE produit_id = ?");
    $req->execute(array($id));
    $verif_p = $req->fetch();

    if(!isset($verif_p) || empty($verif_p)) {
        header('HTTP/1.0 404 Not Found');
        exit();

    } else {
        $basep_id = (String) $verif_p['produit_id'];
        $basep_title = (String) $verif_p['produit_title'];
        $basep_author = (String) $verif_p['produit_author'];
        $basep_year = (int) $verif_p['produit_year'];
        $basep_cat = (int) $verif_p['produit_cat'];
        $basep_price = (float) $verif_p['produit_price'];
        $basep_quantity = (int) $verif_p['produit_quantity'];
        $basep_src = (String) $verif_p['produit_src'];


    }

} else {
    header('HTTP/1.0 404 Not Found');
    exit();

}

if(!empty($_POST)){
    $icon = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>";

    //******************************** S'inscrire
    if(isset($_POST['GoValid'])) {

        extract($_POST);
        $ok = true;

        $p_title = (String) trim( $p_title);
        $p_author = (String) trim( $p_author);
        $p_year = (int) $p_year;
        $p_cat = (int) $p_cat;
        $p_quantity = (int) $p_quantity;
        $p_price = (float) $p_price;


        //*** Verification du title
        $oktitlenotsame = false;
        if($basep_title != $p_title) {
            $oktitlenotsame =  true;
            if(empty($p_title)) {
                $ok = false; 
                $err_p_title = "Veuillez renseigner ce champ !"; 

            }  else if (strlen($p_title) < 2) {

                $ok = false;
                $err_p_title = $icon." Ce titre est trop petit !";
            }

            else if (strlen($p_title) > 25) {

                $ok = false;
                $err_p_title = $icon." Ce titre est trop grand ! Vous avez ".(strlen($p_title) - 25)." caractère(s) en trop";
            }

        }

        //*** Verification du author
        $okauthornotsame = false;
        if($basep_author != $p_author) {
            $okauthornotsame =  true;
            if(empty($p_author)) {
                $ok = false; 
                $err_p_author = "Veuillez renseigner ce champ !"; 

            }  else if (strlen($p_author) < 2) {

                $ok = false;
                $err_p_author = $icon." Ce nom d'autheur est trop petit !";
            }

            else if (strlen($p_author) > 25) {

                $ok = false;
                $err_p_author = $icon." Ce nom d'autheur est trop grand ! Vous avez ".(strlen($p_author) - 25)." caractère(s) en trop";
            }

        }

        //*** Verification year
        $okyearnotsame = false;
        if($basep_year != $p_year){
            $okyearnotsame =  true;
            //*** Verification du Année
            if(empty($p_year)) {
                $ok = false;
                $err_p_year = "Veuillez renseigner ce champ !";  

            } else {
                // depasse la date de ajd
            }
        }

        //*** Verification quantity
        $okquantitynotsame = false;
        if($basep_quantity != $p_quantity){
            $okquantitynotsame =  true;
            // Verification du Prix
            if(empty($p_quantity)) {
                $ok = false;
                $err_p_quantity = "Veuillez renseigner ce champ !"; 
            } else if( $p_quantity < 0) {
                $ok = false;
                $err_p_quantity = "Veuillez saisir une quantité positif"; 
            }
        }


        //*** Verification price
        $okpricenotsame = false;
        if($basep_price != $p_price){
            $okpricenotsame =  true;
            // Verification du Prix
            if(empty($p_price)) {
                $ok = false;
                $err_p_price = "Veuillez renseigner ce champ !"; 
            } else if( $p_price < 0 || 50000 < $p_price) {
                $ok = false;
                $err_p_price = "Veuillez saisir un prix entre 1 et 50000 !"; 
            }
        }

        //*** Verification cat

        $okcatnotsame = false;
        if($basep_cat != $p_cat){
            $okcatnotsame =  true;
            //*** Verification du Genre
            $req = $BDD->prepare("SELECT categorie_title 
                            FROM categorie
                            WHERE categorie_id = ?");
            $req->execute(array($p_cat));
            $verif_cat = $req->fetch();

            if(empty($p_cat)) {
                $ok = false;
                $err_p_cat = "Veuillez renseigner ce champ !"; 

            } else if($p_cat == -1){
                $ok = false;
                $err_p_cat = "oh !";
            }
            else if(!isset($verif_cat['categorie_title'])){ // si 
                $ok = false;
                $err_p_cat = "Veuillez renseigner ce champ !";
            }
        }


        if($ok) {
            echo "<script> createNotification('Vos modifications ont bien étés enregistrées',1); </script>";


            // preparer requete insertion
            $req = $BDD->prepare("UPDATE produit SET produit_title = ?, produit_author = ?, produit_year = ?, produit_quantity = ?, produit_price = ?, produit_cat = ? WHERE produit_id = ?"); 

            $req->execute(array($p_title,$p_author,$p_year,$p_quantity,$p_price,$p_cat,$basep_id));

            if($oktitlenotsame) {$basep_title = $p_title;}
            if($okauthornotsame) {$basep_author = $p_author;}
            if($okyearnotsame) {$basep_year = $p_year;}
            if($okquantitynotsame) {$basep_quantity = $p_quantity;}
            if($okcatnotsame) {$basep_cat = $p_cat;}
            if($okpricenotsame) {$basep_price = $p_price;}


        } else {
            echo "not ok";
        }
    }

}




?>



<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->

        <link rel="stylesheet" href="css/buttonmagique.css">
        <link rel="stylesheet" href="css/editProduit.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/footer.css">

        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title> Edit ~ <?=$basep_title?> - <?=$basep_author?> | Rodav Dalí </title>

    </head>
    <body onload="check()"> 


        <div id="toasts"></div> <!--  NOTIFICICATION -->
        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>



        <div class="container right-panel-active " id="container">


            <div class="form-container sign-up-container">
                <form action="" method="post">




                    <h1 class="title">Edit</h1>
                    <img src="<?=$basep_src?>" alt="">

                    <input class="iptEdit" onkeyup="check()" type="text" name="p_title" id="p_title" placeholder="Titre" value="<?php if(isset($basep_title)){ echo $basep_title;} ?>"/>
                    <span id="error-p_title" class="error"> <?php if(isset($err_p_title)) echo $err_p_title?></span>

                    <input class="iptEdit" onkeyup="check()" type="text" name="p_author" id="p_author" placeholder="Auteur" value="<?php if(isset($basep_author)){ echo $basep_author;} ?>"/>
                    <span id="error-p_author" class="error"> <?php if(isset($err_p_author)) echo $err_p_author?></span>

                    <input class="iptEdit" onchange="check()" type="number" name="p_year" id="p_year" placeholder="Année de création" value="<?php if(isset($basep_year)){ echo $basep_year;} ?>"/>
                    <span id="error-p_year" class="error"> <?php if(isset($err_p_year)) echo $err_p_year?></span> 

                    <input class="iptEdit" onchange="check()"  min="1" max="2000" type="number" name="p_quantity" id="p_quantity" placeholder="Quantité" value="<?php if(isset($basep_quantity)){ echo $basep_quantity;} ?>"/>
                    <span id="error-p_quantity" class="error"> <?php if(isset($err_p_quantity)) echo $err_p_quantity?></span>

                    <input class="iptEdit" onchange="check()"  min="1" max="50000" step=0.05 type="number" name="p_price" id="p_price" placeholder="Prix" value="<?php if(isset($basep_price)){ echo $basep_price;} ?>"/>
                    <span id="error-p_price" class="error"> <?php if(isset($err_p_price)) echo $err_p_price?></span>


                    <?php
    $req = $BDD->prepare("SELECT * FROM categorie WHERE categorie_id = ? ");
                        $req->execute(array($basep_cat));
                        $voir_cat = $req->fetch();

                        $req = $BDD->prepare("SELECT * FROM categorie WHERE categorie_id <> ?  ORDER BY categorie_title ASC");
                        $req->execute(array($basep_cat));
                        $voir_autres_cat = $req->fetchAll();


                    ?>

                    <select class="iptEdit" id='p_cat' name="p_cat" class="">

                        <option value="<?= $voir_cat['categorie_id'] ?>"> <?= mb_strtoupper($voir_cat['categorie_title']) ?> </option>

                        <?php  foreach( $voir_autres_cat as $vp) { ?>     
                        <option value="<?= $vp['categorie_id'] ?>"> <?= mb_strtoupper($vp['categorie_title']) ?> </option>
                        <?php  } ?>
                    </select>




                    <button class="btnEdit" type="submit" name="GoValid" value="1">Enregistrer modification</button>
                </form>
            </div>

        </div>

        <script>

            var okMailExisteDeja = <?php if(isset($okDejaMailExiste) && $okDejaMailExiste){ echo 1;} else {echo 0;}  ?>;
            var MailDeja = <?php if(isset($email)){ echo "'".$email."'";} else {echo "'x'";} ?>;
        </script>

        <!-- ===== FOOTER ===== -->
        <?php require_once('php/footer.php'); ?>


        <script type="text/javascript" src="js/notif.js"> </script>

        <script type="text/javascript"  src="js/boutique.js"> </script>

        <script type="text/javascript" src="js/modal.js"> </script>
        <script src="js/navbar.js"> </script>

    </body>
</html>