<?php

include_once("varSession.inc.php");
//if($okconnectey){var_dump($_SESSION);}
$_SESSION['ici_index_bool'] = true;
$_SESSION['ici_contact_bool'] = false;

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/cart.css">
        <link rel="stylesheet" href="css/buttonmagique.css">
        <link rel="stylesheet" href="css/loader.css">
        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title>Rodav Dalí • Web Site</title>
    </head>
    <body onload="Loading()">
        <div id="loader">
            <div id="shadow"></div>
            <div id="box"></div>
        </div>
        <corps id="leBody" style="display: x">
            <!-- ===== NAV BAR ===== -->
            <?php require_once('php/navbar.php'); ?>
            <!-- ===== WALL ===== -->
            <div class="banner"></div>

            <!--
<div class="containerScrool">
<div class="chevron"></div>
<div class="chevron"></div>
<div class="chevron"></div>
<span class="text">défiler vers le bas</span>

</div>

-->
            <div class="scroll-downs">
                <div class="mousey">
                    <div class="scroller"></div>
                </div>
            </div>
            <div class="about text-white">

                <!-- ===== MENU GAUCHE ===== -->
                <?php require_once('php/menugauche.php'); ?>


                <div class="content descriptionsite">
                    <div class="title">Bienvenue ! sur Rodav Dalí !</div>
                    <p class="text-white2">Chez Rodav Dalí, notre but est d’utiliser l’envers des possibles que nous proposes les nouvelles technologies, afin de mettre sur le devant de la scène, des artistes encore trop peu connus du grand publique, et qui, selon nous, démontrent un réel talent et une réelle soif de travail à travers leurs diverses créations. 


                    </p>
                    <p class="text-white2">Sur Rodav Dalí retrouverez différentes formes de conceptions artistiques, qu’elles soient musicales, visuelles, et bien d’autres..</p>
                    <p class="text-white2">
                        Nous permettons aux jeunes artistes de mettre en ventes leurs créations sur notre site, afin de pouvoir leur fournir un tremplin financier dans la commercialisation et l’élaboration de leurs arts.</p>

                    <p>
                        Parcourez dès maintenant notre boutique virtuel en cliquant à gauche ! Bonne découverte !  
                    </p> 

                </div>
            </div>

            <!-- ===== FOOTER ===== -->
            <?php require_once('php/footer.php'); ?>
        </corps>
        <script src="js/navbar.js"> </script>
        <script src="js/modal.js"> </script>
        <script src="js/loader.js"> </script>


    </body>
</html>
