<?php

require "php/PHPMailer/PHPMailer.php";
use PHPMailer\PHPMailer\PHPMailer;

function ConvertMetier($i) {
    switch($i) {
        case 0 : return "Artiste (musicien, chanteur, peintre, graphiste, ect..)"; break;
        case 1 : return "Ingénieur diplomé"; break;
        case 2 : return "Etudiant"; break;
        case 3 : return "Autre"; break;
        default : return "Sans emploi"; 
    }

}

function ConvertSexe($i) {
    switch($i) {
        case "X" : return "Autre"; break;
        case "M" : return "Homme"; break;
        case "F" : return "Femme"; break;
        default : return "Autre"; 
    }

}

function sendMailContact($prenom,$nom,$sexe,$datenaissance,$metier,$email,$sujet,$message) {
    //*** Saisies 
    $prenom = (String) trim($prenom);

    $nom = (String) trim($nom);

    $sexe = (String) ConvertSexe(trim($sexe));

    $datenaissance = (String) trim($datenaissance);

    $email = (String) trim($email);
    $sujet = (String) trim($sujet);
    $message = (String) trim($message);
    $metier = (String) ConvertMetier($metier);
    
    $ok = true;
    
    require_once "php/PHPMailer/PHPMailer.php";
    require_once "php/PHPMailer/SMTP.php";
    require_once "php/PHPMailer/Exception.php";

    $BODY = "Prénom : $prenom<br>";
    $BODY .= "Nom : $nom<br>";
    $BODY .= "Sexe : $sexe<br>";
    $BODY .= "Date Naissance : $datenaissance<br>";
    $BODY .= "Métier : $metier<br><br>";
    $BODY .= "Email : $email<br>";
    $BODY .= "Sujet : $sujet<br>";
    $BODY .= "Message : $message<br>";


    $mail = new PHPMailer(true);

    $alert = '';
    
    try {

        //*** personal
        $myEmail = "rodavdali@gmail.com";
        $myPassword = "saidzamani";


        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $myEmail; // Gmail address which you want to use as SMTP server
        $mail->Password = $myPassword; // Gmail address Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = '587';

        $mail->setFrom( $myEmail); // Gmail address which you used as SMTP server
        $mail->addAddress( $myEmail); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

        $mail->isHTML(true);
        $mail->Subject = 'Message Received (Contact Page)';
        $mail->Body = "<h3>$BODY</h3>";

        $mail->send();
        $alert = '<div class="alert-success">
                 <span>Message Sent! Thank you for contacting us.</span>
                </div>';
    }
    catch (Exception $e){
            $ok = true;
        $alert = '<div class="alert-error">
                <span>'.$e->getMessage().'</span>
              </div>';
    }
    
    return $ok;

}



?>
