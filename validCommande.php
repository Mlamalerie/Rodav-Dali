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
                $req = $BDD->prepare("INSERT INTO commande (commande_produit_id,commande_quantity,commande_user_id,commande_date) VALUES (?, ?, ?, ?)"); 
                $req->execute(array($pa['produit_id'],$pa['produit_quantity'],$_SESSION['user_id'],$date ) );


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


                    <button class="btnCom ghost" id="voirPanier" onclick="afficherModal()">Voir mon Panier ~ $<span id="prixTotalBtn">0.00</span> </button>


                    <h1 class="title">Ma Commande • Veuillez remplir vos coordonnées</h1>
                 


                    <input class="iptCom" onkeyup="check()" type="text" name="prenomnom" id="prenomnom" placeholder="Prenom Nom" value="<?php if(isset($prenomnom)){ echo $prenomnom;} ?>"/>
                    <span id="error-prenomnom" class="error"> <?php if(isset($err_prenomnom)) echo $err_prenomnom?></span>

                    <input class="iptCom" onkeyup="check()" type="email" name="email" id="email" placeholder="Email"  value="<?php if(isset($email)){ echo $email;} ?>"/>
                    <span id="error-email" class="error"><?php if(isset($err_email) && isset($okVeutSinscrire)) echo $err_email?></span>

                    <input class="iptCom" onkeyup="check()" type="text" name="adresse" id="adresse" placeholder="Adresse Postal " value="<?php if(isset($adresse)){ echo $adresse;} ?>"/>
                    <span id="error-adresse" class="error"> <?php if(isset($err_adresse)) echo $err_adresse?></span>

                    <input class="iptCom" onkeyup="check()" type="text" name="villepays" id="villepays" placeholder="Ville, Pays" value="<?php if(isset($ville)){ echo $ville;} ?>"/>
                    <span id="error-villepays" class="error"> <?php if(isset($err_ville)) echo $err_ville?></span>




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

        <script > 
            prixTotalPanier();
            function prixTotalPanier() {
                console.log("calculTotal");
                let s = 0;

                if(LePanierSESSION){
                    let listeProduits = Object.keys(LePanierSESSION);

                    for(let i = 0; i < listeProduits.length; i++) {
                        p = LePanierSESSION[listeProduits[i]];

                        s +=  parseInt(p['q']) * parseFloat(p['produit_price']);
                    }


                    document.getElementById("prixTotalBtn").innerHTML = s.toFixed(2);
                }

            }


            function afficherModal(){ 
                modal.style.display = "block";
            }



            const prenomnom = document.getElementById("prenomnom");
            const adresse = document.getElementById("adresse");
            const villepays = document.getElementById("villepays");
            const email = document.getElementById("email");

            const erroremail = document.getElementById("error-email");
            const errorprenomnom= document.getElementById("error-prenomnom");
            const erroradresse= document.getElementById("error-adresse");
            const errorvillepays= document.getElementById("error-villepays");




            const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            const regExpAlphaNum = /^[A-Za-z0-9_.-]+$/;
            const regExpAlpha = /^[A-Za-z'\s-]+$/;

            const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" ;



            function check(){
                setTimeout(function() { 
                    /**** verif email */

                    if(email.value.trim().length == 0) {
                        //erroremail.style.display = "none";
                        email.style.border = "none";

                    } 
                    else {
                        if(!email.value.trim().match(regExpMail)){ // si c'est pas bon

                            email.style.border = "solid 1.5px"
                            email.style.borderColor = "#e74c3c";

                            erroremail.style.display = "block";
                            erroremail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
                            console.log("email");
                            //btn.style.display = "none";
                        } else if (okMailExisteDeja && email.value.trim() == MailDeja) {
                            email.style.border = "solid 1.5px"
                            email.style.borderColor = "#e74c3c";

                            erroremail.style.display = "block";
                            erroremail.innerHTML = icon + " Un compte a déjà été créer avec cet email !";
                        }

                        else {
                            email.style.border = "solid 1.5px"
                            email.style.borderColor = "#3ce763";
                            erroremail.style.display = "none";
                        }
                    }


                    /**** verifprenomnom */
                    if(prenomnom.value.trim().length == 0) {
                        //errorprenomnom.style.display = "none";
                        prenomnom.style.border = "none";

                    } 
                    else if(prenomnom.value.trim().length < 3 || prenomnom.value.trim().length > 30 ) {

                        prenomnom.style.border = "solid 1.5px"
                        prenomnom.style.borderColor = "#e74c3c";
                        errorprenomnom.style.display = "block";
                        errorprenomnom.innerHTML = icon + "Veuillez saisir un prenom et un nom de taille résonable (entre 3 et 30) ["+ prenomnom.value.trim().length +"] !";

                    } 
                    else {
                        if(!prenomnom.value.trim().match(regExpAlpha)){ // si c'est pas bon

                            prenomnom.style.border = "solid 1.5px"
                            prenomnom.style.borderColor = "#e74c3c";

                            errorprenomnom.style.display = "block";
                            errorprenomnom.innerHTML = icon + "Caractère autorisés : lettres ' -";

                            //btn.style.display = "none";
                        } else {
                            prenomnom.style.border = "solid 1.5px"
                            prenomnom.style.borderColor = "#3ce763";

                            errorprenomnom.style.display = "none";
                        }
                    }

                    /**** verif adresse */
                    if(adresse.value.trim().length == 0) {
                      //  erroradresse.style.display = "none";
                        adresse.style.border = "none";

                    } 
                    else if(adresse.value.trim().length < 3 || adresse.value.trim().length > 75 ) {

                        adresse.style.border = "solid 1.5px"
                        adresse.style.borderColor = "#e74c3c";
                        erroradresse.style.display = "block";
                        erroradresse.innerHTML = icon + "Veuillez saisir une adresse de taille résonable (entre 3 et 75) ["+ adresse.value.trim().length +"] !";

                    } 
                    else {

                        adresse.style.border = "solid 1.5px"
                        adresse.style.borderColor = "#3ce763";

                        erroradresse.style.display = "none";

                    }

                    /**** verif villepays */
                    if(villepays.value.trim().length == 0) {
                       // errorvillepays.style.display = "none";
                        villepays.style.border = "none";

                    } 
                    else if(villepays.value.trim().length < 3 || villepays.value.trim().length > 50 ) {

                        villepays.style.border = "solid 1.5px"
                        villepays.style.borderColor = "#e74c3c";
                        errorvillepays.style.display = "block";
                        errorvillepays.innerHTML = icon + "Veuillez saisir une ville et un pays de taille résonable (entre 3 et 50) ["+ villepays.value.trim().length +"] !";

                    } 
                    else {

                        villepays.style.border = "solid 1.5px"
                        villepays.style.borderColor = "#3ce763";

                        errorvillepays.style.display = "none";

                    }

                }, delay1Sec*2);

            }



        </script>
        <script src="js/navbar.js"> </script>

    </body>
</html>