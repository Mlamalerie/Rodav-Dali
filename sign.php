<?php
include_once("varSession.inc.php");

if($okconnectey) {
    header("Location: index.php");
    exit;
}



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

        } else if (strlen($pseudo) < 3) {

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
        else if (strlen($pseudo) > 30) {

            $ok = false;
            $err_pseudo = $icon." Ce pseudo est trop grand ! Vous avez ".(strlen($pseudo) - 25)." caractère(s) en trop";
        }

        //*** Verification du mail
        if(empty($email)) { // si vide
            $ok = false;
            $err_email = $icon. " Veuillez renseigner ce champ !";

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si invalide
            $ok = false;
            $err_email = $icon. " Adresse e-mail invalide !";

        } else {
            $okDejaMailExiste = false;
            $lesEmails = array_keys($Data_Users);
            //var_dump($lesEmails);
            if(in_array($email, $lesEmails)) {
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
            
            $panier = array("produit" => array());
            $newUser = ["pseudo" => $pseudo, "email" => $email, "password" => $password,"date_inscription" => $date, "panier" => $panier];

            var_dump($newUser,$Data_Users);

            try {
                addNewUser($newUser,$Data_Users);
            } catch (Exception $e) {
                $ok = false;
                echo "Pb avec l'ajout d'un new User : ",  $e->getMessage(), "\n";
            }
            if($ok){
            $_SESSION['user_email'] = $email;
            $_SESSION['user_pseudo'] =  $pseudo;
            $_SESSION['user_panier'] = $panier;

            header("Location: bravo.php?n=2");
            exit;
            }
        } else {
            echo "ERROR";
        }
    }
    //******************************** Se connecter

    if(isset($_POST['GoSignIn'])) {
        extract($_POST);

        $ok = true;

        $email = (String) strtolower(trim($email));
        $password = (String) trim($password);

        //*** Verification du mail
        if(empty($email)) { // si vide
            $ok = false;
            $err_email = $icon. " Veuillez renseigner ce champ !";

        } 
        else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // si invalide
            $ok = false;
            $err_email = $icon. " Adresse e-mail invalide !";

        } else {

            $okDejaMailExiste = false; // le mail n'est pas dans la bdd

            $lesEmails = array_keys($Data_Users);
            //var_dump($lesEmails);
            if(in_array($email, $lesEmails)) {
                $okDejaMailExiste = true; 
            }  else {
                $err_email = $icon. " Aucun compte trouvé... ";
                $ok = false;
            } 

        }
        if(empty($password)) { // si le champ mot de passe est vide
            $ok = false;
            $err_password = $icon." Veuillez renseigner ce champ !";

        } else {
            // verif si le boug tape le bon mdp
            if($ok) {
                $saisie = crypt($password, '$6$rounds=5000$grzgirjzgrpzhte95grzegruoRZPrzg8$');
                $goodmdp = $Data_Users[$email]['password'];

                if($saisie != $goodmdp) {
                    $ok = false;
                    $err_password = $icon." Mot de passe incorrect. Réessayez !";
                }
            }
        }

        if($ok) {
            echo "OKKK";
            $_SESSION['user_pseudo'] = $Data_Users[$email]['pseudo'];
            $_SESSION['user_email'] = $Data_Users[$email]['email'];


            $_SESSION['user_panier'] = $Data_Users[$email]['panier']['produit'];
            var_dump( $_SESSION['user_panier']);
            if(in_array("id",array_keys($_SESSION['user_panier']))){
                $_SESSION['user_panier'] = [$_SESSION['user_panier']["key"] => ($_SESSION['user_panier'])];
                var_dump( $_SESSION['user_panier']);
            } 
            header("Location: index.php");
            exit;

        } else {
            echo "ERROR connex";
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
        <link rel="stylesheet" href="css/sign.css">


        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title> = Inscription | Rodav Dalí • Web Site</title>

    </head>
    <body onload="check()"> 



        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>

        <div class="container <?php if(isset($okVeutSinscrire)){ ?> right-panel-active <?php } ?>" id="container">
            <div class="form-container sign-up-container">
                <form action="" method="post">
                    <h1 class="title">Créer votre compte</h1>

                    <!--                    <span>or use your email for registration</span>-->
                    <input onkeyup="check()" type="text" name="pseudo" id="ipseudo" placeholder="Pseudo" value="<?php if(isset($pseudo)){ echo $pseudo;} ?>"/>
                    <span id="error-ipseudo" class="error"> <?php if(isset($err_pseudo)) echo $err_pseudo?></span>

                    <input onkeyup="check()" type="email" name="email" id="iemail" placeholder="Email"  value="<?php if(isset($email)){ echo $email;} ?>"/>
                    <span id="error-iemail" class="error"><?php if(isset($err_email) && isset($okVeutSinscrire)) echo $err_email?></span>

                    <input onkeyup="check()" type="password" name="password" id="ipassword"  placeholder="Mot de passe"  value="<?php if(isset($password)){ echo $password;} ?>"/>
                    <span id="error-ipassword" class="error"><?php if(isset($err_password) && isset($okVeutSinscrire)) echo $err_password?></span>

                    <input onkeyup="check()" type="password" name="password2" id="ipassword2"  placeholder="Confirmation mot de passe"  value="<?php if(isset($password2)){ echo $password2;} ?>"/>
                    <span id="error-ipassword2" class="error"><?php if(isset($err_password2)) echo $err_password2?></span>


                    <button type="submit" name="GoSignUp" value="1">S'inscrire</button>
                </form>
            </div>
            <div class="form-container sign-in-container">
                <form action="" method="post">
                    <h1 class="title">Connexion</h1>
                    <input onkeyup="check()" type="email" name="email" id="cemail" placeholder="Email" value="<?php if(isset($email)){ echo $email;} ?>" />
                    <span id="error-cemail" class="error"><?php if(isset($err_email) && !isset($okVeutSinscrire)) echo $err_email?></span>

                    <input onkeyup="check()" type="password" name="password" id="cpassword"  placeholder="Mot de passe" value="<?php if(isset($password)){ echo $password;} ?>" />
                    <span id="error-cpassword" class="error"><?php if(isset($err_password) && !isset($okVeutSinscrire)) echo $err_password?></span>

                    <!--                    <a href="#">Forgot your password?</a>-->
                    <button type="submit" name="GoSignIn" value="2" >Se connecter</button>
                </form>
            </div>
            <div class="overlay-container">
                <div class="overlay">
                    <div class="overlay-panel overlay-left">
                        <h1>Bienvenue !</h1>
                        <p>Veuillez vous connecter avec vos informations personnelles.</p>
                        <button class="ghost" id="signIn" onclick="seConnecter()">Connectez vous</button>
                    </div>
                    <div class="overlay-panel overlay-right">
                        <h1>Nouveau ?</h1>
                        <p>Entrez vos données personnelles et commencez votre voyage avec nous</p>
                        <button class="ghost" id="signUp"  onclick="sInscrire()" >Inscrivez vous</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
            const iemail = document.getElementById("iemail");
            var okMailExisteDeja = <?php if(isset($okDejaMailExiste) && $okDejaMailExiste){ echo 1;} else {echo 0;}  ?>;
            var MailDeja = <?php if(isset($email)){ echo "'".$email."'";} else {echo "'x'";} ?>;
            const cemail = document.getElementById("cemail");

            const ipseudo = document.getElementById("ipseudo");

            const ipassword = document.getElementById("ipassword");
            const ipassword2 = document.getElementById("ipassword2");

            const cpassword = document.getElementById("cpassword");


            const erroripseudo = document.getElementById("error-ipseudo");
            const erroriemail = document.getElementById("error-iemail");
            const errorcemail = document.getElementById("error-cemail");
            const erroripassword = document.getElementById("error-ipassword");
            const errorcpassword = document.getElementById("error-cpassword");
            const erroripassword2 = document.getElementById("error-ipassword2");

            const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            const regExpAlphaNum = /^[A-Za-z0-9_.-]+$/;

            const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" ;

            var delay1Sec = 1000; //1 second


            function check(){
                setTimeout(function() { 
                    /**** verif email */
                    console.log(okMailExisteDeja, MailDeja);
                    if(iemail.value.trim().length == 0) {
                        //erroriemail.style.display = "none";
                        iemail.style.border = "none";

                    } 
                    else {
                        if(!iemail.value.trim().match(regExpMail)){ // si c'est pas bon

                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#e74c3c";

                            erroriemail.style.display = "block";
                            erroriemail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
                            console.log("email");
                            //btn.style.display = "none";
                        } else if (okMailExisteDeja && iemail.value.trim() == MailDeja) {
                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#e74c3c";

                            erroriemail.style.display = "block";
                            erroriemail.innerHTML = icon + " Un compte a déjà été créer avec cet email !";
                        }

                        else {
                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#3ce763";
                            erroriemail.style.display = "none";
                        }
                    }

                    /**** verif email CONNEXION */
                    if(cemail.value.trim().length == 0) {
                        //errorcemail.style.display = "none";
                        cemail.style.border = "none";

                    } 
                    else {
                        if(!cemail.value.trim().match(regExpMail)){ // si c'est pas bon

                            cemail.style.border = "solid 1.5px"
                            cemail.style.borderColor = "#e74c3c";

                            errorcemail.style.display = "block";
                            errorcemail.innerHTML = icon + "Adresse mail incorrect !";
                            console.log("email");
                            //btn.style.display = "none";
                        } else {
                            cemail.style.border = "none";
                            errorcemail.style.display = "none";
                        }
                    }

                    /**** verif MOT DE PASSE CONNEXION */
                    if(cpassword.value.length == 0) {

                        cpassword.style.border = "none";

                    } 
                    else {
                        cpassword.style.border = "none";
                        errorcpassword.style.display = "none";

                    }

                    /**** verif pseudo */
                    if(ipseudo.value.trim().length == 0) {
                        // erroripseudo.style.display = "none";
                        ipseudo.style.border = "none";

                    } 
                    else if(ipseudo.value.trim().length < 3 || ipseudo.value.trim().length > 30 ) {

                        ipseudo.style.border = "solid 1.5px"
                        ipseudo.style.borderColor = "#e74c3c";
                        erroripseudo.style.display = "block";
                        erroripseudo.innerHTML = icon + "Veuillez saisir un pseudo de taille résonable [3-30] !";

                    } 
                    else {
                        if(!ipseudo.value.trim().match(regExpAlphaNum)){ // si c'est pas bon

                            ipseudo.style.border = "solid 1.5px"
                            ipseudo.style.borderColor = "#e74c3c";

                            erroripseudo.style.display = "block";
                            erroripseudo.innerHTML = icon + "Caractère autorisés : lettres chiffres _ - .";

                            //btn.style.display = "none";
                        } else {
                            ipseudo.style.border = "solid 1.5px"
                            ipseudo.style.borderColor = "#3ce763";
                            erroripseudo.style.display = "block";
                            erroripseudo.style.display = "none";
                        }
                    }

                    /**** verif mot de passe */
                    let mdp1rouge = false;
                    if(ipassword.value.length == 0 ) {
                        //erroripassword.style.display = "none";
                        ipassword.style.border = "none";

                    } 
                    else if(ipassword.value.length < 4  ) {

                        ipassword.style.border = "solid 1.5px"
                        ipassword.style.borderColor = "#e74c3c";
                        erroripassword.style.display = "block";
                        erroripassword.innerHTML = icon + "Veuillez saisir un mot de passe plus long !";
                        mdp1rouge = true;

                    }  else {
                        ipassword.style.border = "solid 1.5px"
                        ipassword.style.borderColor = "#3ce763";
                        erroripassword.style.display = "block";
                        erroripassword.style.display = "none";
                    }

                    /**** verif mot de passe 2 */
                    if(ipassword2.value.length == 0 ) {
                        erroripassword2.style.display = "none";
                        ipassword2.style.border = "none";

                    } else if(mdp1rouge ) {
                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#e74c3c";
                        erroripassword2.style.display = "block";
                        erroripassword2.style.display = "none";

                    }
                    else if( ipassword2.value != ipassword.value  ) {

                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#e74c3c";
                        erroripassword2.style.display = "block";
                        erroripassword2.innerHTML = icon + "Veuillez bien saisir 2 fois le même mot de passe!";

                    }  else {
                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#3ce763";
                        erroripassword2.style.display = "block";
                        erroripassword2.style.display = "none";
                    }

                }, delay1Sec*2);

            }

            function seConnecter() {
                if(iemail.value.length > 0) {
                    cemail.value = iemail.value;

                } 
                if(ipassword.value.length > 0) {
                    cpassword.value = ipassword.value;

                } 
                check();

            }
            function sInscrire() {
                if(cemail.value.length > 0) {
                    iemail.value = cemail.value;

                } 
                if(cpassword.value.length > 0) {
                    ipassword.value = cpassword.value;

                } 
                check();

            }


        </script>



        <script src="js/sign.js"> </script>
        <script src="js/navbar.js"> </script>

    </body>
</html>
