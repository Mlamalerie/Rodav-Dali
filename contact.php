<?php
include_once("varSession.inc.php");
$_SESSION['ici_index_bool'] = false;
$_SESSION['ici_contact_bool'] = true;
include("sendMail.php");

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

        sendMailContact($prenom,$nom,$sexe,$datenaissance,$metiers,$email,$sujet,$message);
        header('Location: bravo.php?n=1');
        exit;
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
        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title>Nous contacter ? | Rodav Dalí • Web Site</title>
    </head>
    <body onload="check()">

        <!-- ===== NAV BAR ===== -->
        <?php require_once('php/navbar.php'); ?>
        <!-- ===== WALL ===== -->
        <div class="banner"></div>
        <!-- ===== CORPS ===== -->
        <div class="about text-white">

            <!-- ===== MENU GAUCHE ===== -->
            <?php require_once('php/menugauche.php'); 
            
            $prenom = "Mlamali";
            $nom = "Mlamali";
            $datenaissance = "2020-04-02";
            $sujet = "wi";
            $message = "xx xxxxxx";
            ?>
            
            
            <div class="content content-right">
                <div class="box"><h2 >CONTACTEZ NOUS  <i class="fas fa-envelope"></i></h2></div>
                <div class="box">
                    
                    <form action="" id="formContact" method="post" autocomplete="off" >
                        <div class="">
                            <input id="prenom" name="prenom" onkeyup="check()" type="text" placeholder="Saisir votre prénom" value="<?php if(isset($prenom)){echo $prenom;}?>" style="grid-column: 2">
                            <div class="error error-prenom" > </div>
                            <input id="nom" name="nom" onkeyup="check()" type="text" placeholder="Saisir votre nom" value="<?php if(isset($nom)){echo $nom;}?>" style="grid-column: 4">
                            <div class="error error-nom" >  </div>

                        </div>


                        <div class="divSexe" style="grid-column: 2">

                            <input onchange="check()" name="sexe" type="radio" id="inputX" value="X" <?php if(isset($sexe) && ($sexe == "X")){echo "checked";} else echo "checked"?>><label for="inputM" >Non binaire</label>
                            <input onchange="check()" name="sexe" type="radio" id="inputM" value="M" <?php if(isset($sexe) && ($sexe == "M")){echo "checked";}?>><label for="inputM" >♂️ Homme</label>
                            <input onchange="check()" name="sexe" type="radio" id="inputF" value="F" <?php if(isset($sexe) && ($sexe == "F")){echo "checked";}?>><label for="inputF">♀ Femme</label>

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
                        <input type="submit">
                    </form>
                </div>

            </div>
        </div>
        <!-- ===== FOOTER ===== -->

        <?php require_once('php/footer.php'); ?>      
        <script>
            const email = document.getElementById("email");
            const prenom = document.getElementById("prenom");
            const nom = document.getElementById("nom");
            const sexeM = document.getElementById("inputM");
            const sexeF = document.getElementById("inputF");
            const sexeX = document.getElementById("inputX");
            const date = document.getElementById("datenaissance");
            const sujet = document.getElementById("sujet");
            const message = document.getElementById("message");

            const erroremail = document.querySelector(".error-mail");
            const errorprenom = document.querySelector(".error-prenom");
            const errornom = document.querySelector(".error-nom");
            const btnSEND = document.querySelector("#btnSEND");
            btnSEND.style.fontSize = "0.8rem";


            const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            const regExpAlpha = /^[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ\s-]+$/;

            const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" 
            var okSEND = true;

            function isValidDate(dateString)
            {
                // First check for the pattern
                var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

                if(!regex_date.test(dateString))
                {
                    return false;
                }

                // Parse the date parts to integers
                var parts   = dateString.split("-");
                var day     = parseInt(parts[2], 10);
                var month   = parseInt(parts[1], 10);
                var year    = parseInt(parts[0], 10);

                // Check the ranges of month and year
                if(year < 1000 || year > 3000 || month == 0 || month > 12)
                {
                    return false;
                }

                var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

                // Adjust for leap years
                if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
                {
                    monthLength[1] = 29;
                }

                // Check the range of the day
                return day > 0 && day <= monthLength[month - 1];
            }
            function check(){
                console.log("check");
                okSEND = true;

                /**** verif email */
                if(email.value.length == 0) {
                    erroremail.style.display = "none";
                    email.style.border = "none";
                    okSEND =false;console.log("email");
                    email.classList.add("clignote");
                } 
                else {
                    email.classList.remove("clignote");

                    if(!email.value.match(regExpMail)){ // si c'est pas bon

                        email.style.border = "solid 1px"
                        email.style.borderColor = "#e74c3c";

                        erroremail.style.display = "block";
                        erroremail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
                        okSEND =false;
                        console.log("email");
                        //btn.style.display = "none";
                    } else {
                        erroremail.style.display = "none";
                        email.style.border = "none"
                    }
                }

                /**** verif prenom */
                if(prenom.value.trim().length == 0) {
                    errorprenom.style.display = "none";
                    prenom.style.border = "none"
                    okSEND =false;console.log("prenom");
                    prenom.classList.add("clignote");

                } else {
                    prenom.classList.remove("clignote");

                    if(!prenom.value.match(regExpAlpha)){ // si c'est pas bon
                        console.log("*-");
                        prenom.style.border = "solid 1px"
                        prenom.style.borderColor = "#e74c3c";

                        errorprenom.style.display = "block";
                        errorprenom.innerHTML = icon + "Veuillez saisir un prenom correct (des lettres uniquement)!";
                        okSEND =false;console.log("prenom");
                        //btn.style.display = "none";
                    } else {
                        console.log("++-");
                        errorprenom.style.display = "none";
                        prenom.style.border = "none"
                    }
                }

                /**** verif nom */
                if(nom.value.trim().length == 0) {
                    errornom.style.display = "none";
                    nom.style.border = "none";
                    okSEND =false;
                    console.log("nom");  nom.classList.add("clignote");
                } else {
                    nom.classList.remove("clignote");

                    if(!nom.value.match(regExpAlpha)){ // si c'est pas bon
                        console.log("*-");
                        nom.style.border = "solid 1px"
                        nom.style.borderColor = "#e74c3c";

                        errornom.style.display = "block";
                        errornom.innerHTML = icon + "Veuillez saisir un nom correct (des lettres uniquement)!";
                        okSEND =false;console.log("nom");
                        //btn.style.display = "none";
                    } else {
                        errornom.style.display = "none";
                        nom.style.border = "none";
                    }
                }

                /**** verif sexe */
                if(!sexeM.checked && !sexeF.checked && !sexeX.checked) {
                    okSEND = false;
                    console.log("sexe");
                    sexeM.classList.add("clignote");
                    sexeF.classList.add("clignote");
                    sexeX.classList.add("clignote");

                } else {
                    sexeM.classList.remove("clignote");
                    sexeF.classList.remove("clignote");
                    sexeX.classList.remove("clignote");
                }


                /**** verif sujet */
                if(sujet.value.trim().length == 0) {
                    okSEND = false;
                    console.log("sujet");  sujet.classList.add("clignote");
                } else {
                    sujet.classList.remove("clignote");
                }

                /**** verif message */
                if(message.value.trim().length == 0) {
                    okSEND = false; console.log("message");  message.classList.add("clignote");
                } else{
                    message.classList.remove("clignote");
                }

                /**** verif date */
                if(!isValidDate(date.value) ) {
                    console.log(date.value,"###data pas bon");
                    okSEND = false;
                    date.classList.add("clignote");
                } else{
                    console.log(date.value,"### tout est bon");
                    date.classList.remove("clignote");
                }

                console.log(date.value,"***********",isValidDate(date.value));
                if(okSEND) {
                    btnSEND.style.display = "block";
                    btnSEND.setAttribute("class","buttons-magique");
                    btnSEND.style.fontSize = "1.1rem";
                    btnSEND.innerHTML = "ENVOYER !";
                    btnSEND.removeAttribute("disabled");
                    btnSEND.setAttribute("type","submit");

                    console.log("if%");
                } 
                else{
                    console.log("else%");
                    btnSEND.setAttribute("class"," ");
                    btnSEND.innerHTML = "veuillez remplir toute les cases <i class='fas fa-exclamation-triangle'></i>";
                    btnSEND.style.fontSize = "0.8rem";
                    if (!btnSEND.disabled) {

                        btnSEND.setAttribute("disabled");
                    }

                    btnSEND.removeAttribute("onclick");

                }
            }

            function submitForm() {

                let f = document.getElementById("formContact");
                console.log(f);
                f.submit();
            }



        </script>

        <script src="js/navbar.js"> </script>
        <script src="js/modal.js"> </script>


    </body>
</html>
