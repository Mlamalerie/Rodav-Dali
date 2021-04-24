<?php
include_once("varSession.inc.php");


if(!$okconnectey) {
    header("Location: index.php");
    exit;
} else if (empty($_SESSION['user_panier'])) {
    header("Location: index.php");
    exit;

} else {
    $email = $_SESSION['user_email'];
}

$_SESSION['ici_index_bool'] =  false;
$_SESSION['ici_contact_bool'] = false;
$_SESSION['ici_sign_bool'] =  false;

if(!empty($_POST)){
    $icon = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>";

    //******************************** S'inscrire
    if(isset($_POST['GoValid'])) {

        extract($_POST);
        $ok = true;

        $prenomnom = (String) trim($prenomnom);
        $villepays = (String) trim($villepays);
        $adresse = (String) trim($adresse);
        $email = (String) strtolower(trim($email));




        //*** Verification du prenomnom
        if(empty($prenomnom)) { // si vide
            $ok = false;
            $err_prenomnom = $icon." Veuillez renseigner ce champ !";

        } 
        else if (strlen($prenomnom) < 3) {

            $ok = false;
            $err_prenomnom = $icon." Ce pseudo est trop petit !";
        }
        else if (ctype_digit($prenomnom)) {

            $ok = false;
            $err_prenomnom = $icon." Vous êtes obligé de mettre au moins une lettre dans votre pseudo";
        }

        else if (substr_count($prenomnom, ' ') >= 5) {

            $ok = false;
            $err_prenomnom = $icon." Votre pseudo ne doit pas contenir beaucoup d'espace la";
        }
        else if (strlen($prenomnom) > 35) {

            $ok = false;
            $err_prenomnom = $icon." Ce pseudo est trop grand ! Vous avez ".(strlen($prenomnom) - 35)." caractère(s) en trop";
        }

        //*** Verification du mail
        if(empty($email)) { // si vide
            $ok = false;
            $err_email = $icon. " Veuillez renseigner ce champ !";

        } 
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si invalide
            $ok = false;
            $err_email = $icon. " Adresse e-mail invalide !";

        } 

        //*** Verification adresse

        if(empty($adresse)) { // si le champ mot de passe est vide
            $ok = false;
            $err_adresse =  $icon." Veuillez renseigner ce champ !";

        }  

        //*** Verification villepays

        if(empty($villepays)) { // si le champ mot de passe est vide
            $ok = false;
            $err_villepays =  $icon." Veuillez renseigner ce champ !";

        } 



        if($ok) {
            $date = date("Y-m-d H:i:s"); 



            foreach($_SESSION['user_panier'] as $pa){
                $req = $BDD->prepare("INSERT INTO commande (commande_produit_id,commande_quantity,commande_user_id,commande_date, commande_prenom_nom,commande_adresse, commande_ville_pays) 
                VALUES (?, ?, ?, ?, ?, ?, ?)"); 
                $req->execute(array($pa['produit_id'],$pa['produit_quantity'],$_SESSION['user_id'],$date, $prenomnom,$adresse,$villepays ) );


                $req = $BDD->prepare("DELETE FROM panier WHERE panier_produit_id = ? AND panier_user_id = ? "); 
                $req->execute(array($pa['produit_id'],$_SESSION['user_id']));
            }

            header("Location: bravo.php?n=3");
            exit;

        } else {
            //echo "ERROR";
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
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/validCommande.css">
        <link rel="stylesheet" href="css/footer.css">


        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title> Valider Commande | Rodav Dalí • Web Site</title>

    </head>
    <body onload="check()"> 


        <div id="toasts"></div> <!--  NOTIFICICATION -->
        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>



        <div class="container right-panel-active " id="container">


            <div class="form-container sign-up-container">
                <form action="" method="post">


                    <span disabled class="btnCom ghost" id="voirPanier">Voir mon Panier ~ $<span id="prixTotalBtn">0.00</span> </span>


                    <h1 class="title">Ma Commande • Veuillez remplir vos coordonnées</h1>



                    <input class="iptCom" onkeyup="check()" type="text" name="prenomnom" id="prenomnom" placeholder="Prenom Nom" value="<?php if(isset($prenomnom)){ echo $prenomnom;} ?>"/>
                    <span id="error-prenomnom" class="error"> <?php if(isset($err_prenomnom)) echo $err_prenomnom?></span>

                    <input class="iptCom" onkeyup="check()" type="email" name="email" id="email" placeholder="Email"  value="<?php if(isset($email)){ echo $email;} ?>"/>
                    <span id="error-email" class="error"><?php if(isset($err_email) && isset($okVeutSinscrire)) echo $err_email?></span>

                    <input class="iptCom" onkeyup="check()" type="text" name="adresse" id="adresse" placeholder="Adresse Postal " value="<?php if(isset($adresse)){ echo $adresse;} ?>"/>
                    <span id="error-adresse" class="error"> <?php if(isset($err_adresse)) echo $err_adresse?></span>

                    <input class="iptCom" onkeyup="check()" type="text" name="villepays" id="villepays" placeholder="Ville, Pays" value="<?php if(isset($villepays)){ echo $villepays;} ?>"/>
                    <span id="error-villepays" class="error"> <?php if(isset($err_villepays)) echo $err_villepays?></span>




                    <button class="btnCom" type="submit" name="GoValid" value="1">Valider ma Commande</button>
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

        <script>
            // Get the button that opens the modal
            var voirPanier = document.getElementById("voirPanier");
            voirPanier.onclick = function() {
                modal.style.display = "block";
           
            }

        </script>
        <script type="text/javascript" src="js/validCommande.js"> </script>

        <script src="js/navbar.js"> </script>

    </body>
</html>