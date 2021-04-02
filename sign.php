<?php
session_start();
include_once("varSession.inc.php");


$addpseudo = "Mlali";
$addemail = "aef@";
$addPass = "123";
$newUser = ["pseudo" => $addpseudo, "email" => $addemail, "password" => $addPass];


function writeXMLFile($nomFichier,$data) {

    $xml = new SimpleXMLElement('<?xml version="1.0"?><data-users/>');

    foreach($data as $u) {
        $user = $xml->addChild('user');
        $user->addChild('pseudo', $u['pseudo']);
        $user->addChild('email',  $u['email']);
        $user->addChild('password',  $u['password']);
    }

    $res = $xml->asXML();
    $res=str_replace('><',">    \n<",$res);
    $bytes = file_put_contents($nomFichier,$res);
}

function readXMLFile($fic) {
    if (file_exists($fic)) {
        $data = simplexml_load_file($fic);
        return @json_decode(@json_encode($data),1);;
    } else {
        exit("Echec lors de l\'ouverture du fichier $fic.");
    }

}


function addNewUser($newUser){
    // Recup les users dansun tableaux
    $data = readXMLFile("users.xml");
    // ajouter le new user au tableau
    $data['user'][] = $newUser;
    // creer un fichier xml avec le nouveau tab
    writeXMLFile("users.xml",$data['user']);

}


//addNewUser($newUser);


?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/sign.css">


        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->

        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title> = Inscription | Rodav Dalí • Web Site</title>

    </head>
    <body >



        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>

        <div class="container right-panel-active">
            <!-- Sign Up -->
            <div class="container__form container--signup">
                <form action="#" class="form" id="form1">
                    <h2 class="form__title">Inscription</h2>
                    <input type="text" placeholder="Pseudo" class="input" name="pseudo"/>
                    <input type="email" placeholder="Email" class="input" name="email" />
                    <input type="password" placeholder="Mot de passe" class="input" name="password"/>
                    <input type="password2" placeholder="Ratapez votre mot de passe" class="input" name="password2"/>
                    <button class="btn">S'inscrire</button>
                </form>
            </div>

            <!-- Sign In -->
            <div class="container__form container--signin">
                <form action="#" class="form" id="form2">
                    <h2 class="form__title">Connexion</h2>
                    <input type="email" placeholder="Email" class="input" />
                    <input type="password" placeholder="Mot de passe" class="input" />
                    <!--                    <a href="#" class="link">Forgot your password?</a>-->
                    <button class="btn">Se connecter</button>
                </form>
            </div>

            <!-- Overlay -->
            <div class="container__overlay">
                <div class="overlay">
                    <div class="overlay__panel overlay--left">
                        <button class="btn" id="signIn">Se connecter</button>
                    </div>
                    <div class="overlay__panel overlay--right">
                        <button class="btn" id="signUp">S'inscrire</button>
                    </div>
                </div>
            </div>
        </div>




        <script src="js/sign.js"> </script>
        <script src="js/navbar.js"> </script>

    </body>
</html>
