<?php
include_once("varSession.inc.php");
$_SESSION['ici_index_bool'] = false;
$_SESSION['ici_contact_bool'] = true;
$_SESSION['ici_sign_bool'] = false;

include("php/sendMail.php");

$icon = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>";

if(!empty($_POST)){


    extract($_POST);
    $ok = true;

    //*** Saisies 
    $prenom = (String) trim($prenom);

    $nom = (String) trim($nom);

    $sexe = (String) trim($sexe);

    $datenaissance = (String) trim($datenaissance);

    $email = (String) trim($email);
    $sujet = (String) trim($sujet);
    $message = (String) trim($message);
    $metiers = (int) $metiers;

    //*** Verification du prenom

    if(empty($prenom)) { // si vide
        $ok = false;
    } 
    else if (!ctype_alpha(implode("",explode(' ',$prenom)))) {
        $ok = false;
    }

    //*** Verification du prenom
    if(empty($nom)) { // si vide
        $ok = false;
    } 
    else if (!ctype_alpha(implode("",explode(' ',$nom)))) {
        $ok = false;
    }

    //*** Verification du sexe

    if(empty($sexe)) { // si vide
        $ok = false;
    } else if (($sexe != 'M') && ($sexe != 'F') && ($sexe != 'X')) {
        $ok = false;
        $err_sexe = $icon." '$sexe' ERREUR SEXE";
    }

    //*** Verification du metier
    if(empty($metiers)) { // si vide
        $ok = false;
    } else if (($metiers != -1) && ($metiers != 0) && ($metiers != 1) && ($metiers != 2) && ($metiers != 3)) {
        $err_metiers = $icon." '$metiers' ERREUR METIERS... {-1,0,1,2,3}";
        $ok = false;
    }

    //*** Verification du date
    if(empty($datenaissance)) { // si vide
        $ok = false;
        $err_datenaissance = $icon." ERREUR CASE VIDE";
    } else {
        $dateuh = explode('-',$datenaissance);
        if (count($dateuh) != 3)  {
            $ok = false;
            $err_datenaissance = $icon." ERREUR RESPECTER FORMAT jj/mm/aaaa ";
        } else if (!ctype_digit($dateuh[1]) || !ctype_digit($dateuh[2]) ||  !ctype_digit($dateuh[0]) ) {
            $ok = false;
            $err_datenaissance = $icon." ERREUR RESPECTER FORMAT NB ENTIER jj/mm/aaaa ";
        } else if (!checkdate($dateuh[1], $dateuh[2], $dateuh[0])) {
            $ok = false;
            $err_datenaissance = $icon." ERREUR RESPECTER FORMAT jj/mm/aaaa";
        } 


    }

    //*** Verification du mail
    if(empty($email)) { // si vide
        $ok = false;
        $err_email = $icon. "Veuillez renseigner ce champ !";

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si invalide
        $ok = false;
        $err_email = $icon. "Adresse e-mail invalide !";

    }


    //*** Verification du sujet
    if(empty($sujet)) { // si vide
        $ok = false;
    } else if(strlen($sujet) > 125) {
        $ok = false;
        $err_sujet = $icon." Erreur sujet est trop long !";
    }

    //*** Verification du message
    if(empty($message)) { // si vide
        $ok = false;
    } 


    /**** ENVOIE */
    if($ok) {

        $ok = sendMailContact($prenom,$nom,$sexe,$datenaissance,$metiers,$email,$sujet,$message);

        if($ok){
            header('Location: bravo.php?n=1');
            exit;
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
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/buttonmagique.css">

        <link rel="stylesheet" href="css/contact.css">
        <link rel="stylesheet" href="css/notif.css">
        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title>Nous contacter ? | Rodav Dalí • Web Site</title>
    </head>
    <body>

        <div id="toasts"></div> <!--  NOTIFICICATION -->
        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>
        <!-- ===== WALL ===== -->
        <div class="banner"></div>
        <!-- ===== CORPS ===== -->
        <div class="about text-white">

            <!-- ===== MENU GAUCHE ===== -->
            <?php require_once('php/menugauche.php'); 
            /*
            $prenom = "Mlamali";
            $nom = "Mlamali";
            $datenaissance = "2020-04-02";
            $sujet = "wi";
            $message = "xx xxxxxx";*/
            ?>


            <div class="content content-right">

                <div class="box">
                    <div><h2 >CONTACTEZ NOUS  <i class="fas fa-envelope"></i></h2></div>
                    <form action="" id="formContact" method="post" autocomplete="off" >
                        <div class="">
                            <input id="prenom" name="prenom" onkeyup="check()" type="text" placeholder="Saisir votre prénom" value="<?php if(isset($prenom)){echo $prenom;}?>" style="grid-column: 2">
                            <div class="error error-prenom" > </div>
                            <input id="nom" name="nom" onkeyup="check()" type="text" placeholder="Saisir votre nom" value="<?php if(isset($nom)){echo $nom;}?>" style="grid-column: 4">
                            <div class="error error-nom" >  </div>

                        </div>


                        <div class="divSexe" style="grid-column: 2">


                            <input onchange="check()" name="sexe" type="radio" id="inputM" value="M" <?php if(isset($sexe) && ($sexe == "M")){echo "checked";}?>><label for="inputM" >♂️ Homme</label>
                            <input onchange="check()" name="sexe" type="radio" id="inputF" value="F" <?php if(isset($sexe) && ($sexe == "F")){echo "checked";}?>><label for="inputF">♀ Femme</label>
                            <input onchange="check()" name="sexe" type="radio" id="inputX" value="X" <?php if(isset($sexe) && ($sexe == "X")){echo "checked";} else echo "checked"?>><label for="inputM" >Autre</label>

                            <div class="error error-sexe" > <?php if(isset($err_sexe)) echo $err_sexe?> </div>
                        </div>
                        <!--                        <div class="">-->

                        <label for="datenaissance">Date de naissance</label>
                        <input onkeyup="check()" onchange="check()" type="date" id="datenaissance" name="datenaissance" value="<?php if(isset($datenaissance)){echo $datenaissance;}?>" >
                        <div class="error error-datenaissance" > <?php if(isset($err_datenaissance)) echo $err_datenaissance?> </div>
                        <!--                        </div>-->

                        <select id="metiers" name="metiers">

                            <option value="-1">Sans emploi</option>
                            <option value="0">🧑🏾‍🎨 Artiste (musicien, chanteur, peintre, graphiste, ect..) </option>
                            <option value="1">🦾 Ingénieur diplomé</option>
                            <option value="2">📚 Etudiant</option>
                            <option value="3">🤷🏾‍♀️ Autre</option>
                        </select>
                        <div class="error error-metiers" > <?php if(isset($err_metiers)) echo $err_metiers?> </div>

                        <input onkeyup="check()" id="email" name="email" type="email" placeholder="Saisir votre adresse email" value="<?php if(isset($email)){echo $email;} else if($okconnectey) {echo $_SESSION["user_email"];}?>">
                        <div class="error error-mail" >  <?php if(isset($err_email)) echo $err_email?></div>

                        <input id="sujet" name="sujet" onkeyup="check()" type="text" placeholder="Sujet du message" value="<?php if(isset($sujet)){echo $sujet;}?>">
                        <div class="error errorsujet" >  <?php if(isset($err_sujet)) echo $err_sujet?></div>
                        <textarea id="message" name="message" onkeyup="check()" placeholder="Tapez votre message...."><?php if(isset($message)){echo $message;}?></textarea>
                        <button id="btnSEND" disabled>veuillez remplir toute les cases <i class="fas fa-exclamation-triangle"></i></button>

                    </form>
                </div>

            </div>
        </div>
        <!-- ===== FOOTER ===== -->

        <?php require_once('php/footer.php'); ?>      

        <script src="js/notif.js"> </script>
        
        
        <script src="js/contact.js"> </script>

        <script src="js/navbar.js"> </script>
        <script src="js/boutique.js"> </script>

        <script src="js/modal.js"> </script>



    </body>
</html>
