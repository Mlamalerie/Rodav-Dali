<?php
include_once("varSession.inc.php");

if(!$okconnectey) {
    header("Location: index.php");
    exit;
} else {
    $email = $_SESSION['user_email'];
}

$_SESSION['ici_index_bool'] =  false;
$_SESSION['ici_contact_bool'] = false;
$_SESSION['ici_sign_bool'] = true;

if(!empty($_POST)){
    $icon = "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>";

    //******************************** S'inscrire
    if(isset($_POST['GoSignUp'])) {
        $okVeutSinscrire = true;
        extract($_POST);
        $ok = true;

        $pseudo = (String) trim($pseudo);

        $email = (String) strtolower(trim($email));

        $password = (String) trim($password);
        $password2 = (String) trim($password2);


        //*** Verification du pseudo
        if(empty($pseudo)) { // si vide
            $ok = false;
            $err_pseudo = $icon." Veuillez renseigner ce champ !";

        } 
        else if (strlen($pseudo) < 3) {

            $ok = false;
            $err_pseudo = $icon." Ce pseudo est trop petit !";
        }
        else if (ctype_digit($pseudo)) {

            $ok = false;
            $err_pseudo = $icon." Vous êtes obligé de mettre au moins une lettre dans votre pseudo";
        }

        else if (substr_count($pseudo, ' ') >= 1) {

            $ok = false;
            $err_pseudo = $icon." Votre pseudo ne doit pas contenir d'espace";
        }
        else if (strlen($pseudo) > 25) {

            $ok = false;
            $err_pseudo = $icon." Ce pseudo est trop grand ! Vous avez ".(strlen($pseudo) - 25)." caractère(s) en trop";
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
        else { // ensuite on verifie si ce mail a déja été pris
            $okDejaMailExiste = false;


            $req = $BDD->prepare("SELECT user_id
                            FROM user
                            WHERE user_email = ? 
                                ");
            $req->execute(array($email));
            $user = $req->fetch();


            //var_dump($lesEmails);
            if(isset($user['user_id'])) {
                $ok = false;
                //print_r($email);
                $okDejaMailExiste = true;

            }     

        }

        //*** Verification du mot de passe

        if(empty($password)) { // si le champ mot de passe est vide
            $ok = false;
            $err_password =  $icon." Veuillez renseigner ce champ !";

        } 

        if(empty($password2) && $ok) { // si le champ mot de passe est vide
            $ok = false;
            $err_password2 =  $icon." Veuillez renseigner ce champ !";

        } else if(strlen($password) < 4) { // si le champ mot de passe est vide
            $ok = false;
            $err_password =  $icon." Ce mot de passe est trop petit ! ";

        } else if ($password != $password2 && $ok){
            $ok = false;
            $err_password2 =  $icon." Vous n'avez pas rentré le même mot de passe !";
        }


        if($ok) {
            $date = date("Y-m-d H:i:s"); 
            $password = crypt($password, '$6$rounds=5000$grzgirjzgrpzhte95grzegruoRZPrzg8$');

            // preparer requete INSERT
            $req = $BDD->prepare("INSERT INTO user (user_pseudo, user_email, user_password, user_dateinscription) VALUES (?, ?, ?, ?)"); 

            $req->execute(array($pseudo,$email,$password,$date));

            // recuperer l'id
            $req = $BDD->prepare("SELECT user_id FROM user 
            WHERE user_pseudo = ? AND user_email = ? ");  
            $req->execute(array($pseudo,$email)); $u = $req->fetch();

            $_SESSION['user_id'] = $u['user_id'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_pseudo'] =  $pseudo;

            header("Location: bravo.php?n=2");
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
        <link rel="stylesheet" href="css/validCommande.css">
  <link rel="stylesheet" href="css/style.css">

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

                    <button class="ghost" id="voirPanier" onclick="afficherModal()">Voir mon Panier </button>


                    <h1 class="title">Ma Commande</h1>


                    <input onkeyup="check()" type="text" name="prenomnom" id="prenomnom" placeholder="Prenom Nom" value="<?php if(isset($prenomnom)){ echo $prenomnom;} ?>"/>
                    <span id="error-prenomnom" class="error"> <?php if(isset($err_prenomnom)) echo $err_prenomnom?></span>

                    <input onkeyup="check()" type="email" name="email" id="iemail" placeholder="Email"  value="<?php if(isset($email)){ echo $email;} ?>"/>
                    <span id="error-email" class="error"><?php if(isset($err_email) && isset($okVeutSinscrire)) echo $err_email?></span>

                    <input onkeyup="check()" type="text" name="adresse" id="adresse" placeholder="Adresse Postal " value="<?php if(isset($adresse)){ echo $adresse;} ?>"/>
                    <span id="error-adresse" class="error"> <?php if(isset($err_adresse)) echo $err_adresse?></span>

                    <input onkeyup="check()" type="text" name="ville" id="ville" placeholder="Ville, Pays" value="<?php if(isset($ville)){ echo $ville;} ?>"/>
                    <span id="error-ville" class="error"> <?php if(isset($err_ville)) echo $err_ville?></span>




                    <button type="submit" name="GoValid" value="1">Valider mon Panier</button>
                </form>
            </div>

        </div>

        <script>

            var okMailExisteDeja = <?php if(isset($okDejaMailExiste) && $okDejaMailExiste){ echo 1;} else {echo 0;}  ?>;
            var MailDeja = <?php if(isset($email)){ echo "'".$email."'";} else {echo "'x'";} ?>;
        </script>

        <script src="js/modal.js"> </script>
        <script > 
            
            function afficherModal(){ 
            modal.style.display = "block";
            }
        </script>
        <script src="js/navbar.js"> </script>

    </body>
</html>