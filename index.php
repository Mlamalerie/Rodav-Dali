<?php
session_start();
$_SESSION['ici_index_bool'] = true;
$_SESSION['ici_contact_bool'] = false;

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href=" css/style.css">
        <link rel="stylesheet" href=" css/buttonmagique.css">
        <link rel="stylesheet" href=" css/loader.css">
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
        <corps id="leBody" style="display: none">
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
                <div class="content-left">


                    <div class="sidebar">

                        <h1 class="text-shadow text-point">Nos produits</h1>


                        <a href="albums.html"><span class="amenuactive ">Albums</span> 💽</a>
                        <a href="tableaux.html">Tableaux 🎨</a>
                        <a href="dress.html">Mode 🧦</a>


                        <h2 class="text-shadow ">  ---</h2>
                        <a href="contact.html">Nous contacter 👈🏾</a>
                    </div>
                </div>
                <div class="content descriptionsite">
                    <div class="title">Bienvenue sur Rodav Dalí !</div>
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
            <footer>

                <div class="bottom">
                    <center class="bg-dark2">

                        <span class="credit social-group">

                            <a href="mailto:contact@rodavdali.com"  target="_blank"><span class="text-white socialicon mr-2 mh-l"><i class="fa fa-envelope" aria-hidden="true"></i></span></a> 
                            <a href="https://www.instagram.com/rodavdali"  target="_blank"><span class="text-white socialicon mr-2"><i class="fab fa-instagram"></i></span></a> 


                            <a href="https://wa.me/33634165910"  target="_blank"><span class="text-white socialicon mh-r"><i class="fas fa-phone-square-alt"></i></span></a> 

                        </span>

                    </center >
                    <center class="bg-dark">
                        <span class="credit">

                            By 
                            <a href="https://www.linkedin.com/in/mlamalisaidsalimo"  target="_blank"><span class="text-white">Mlamali SAID SALIMO</span></a> 
                            and 
                            <a href="https://www.linkedin.com/in/redouane-zamani-041184200"  target="_blank"><span class="text-white">Redouane ZAMANI</span></a>


                        </span>
                        <span class="far fa-copyright"></span><span> 2021 All rights reserved.</span>
                    </center>
                </div>

            </footer>
        </corps>
        <script src="js/navbar.js"> </script>
        <script src="js/loader.js"> </script>


    </body>
</html>
