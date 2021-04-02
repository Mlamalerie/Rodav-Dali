<?php
session_start();
$_SESSION['ici_index_bool'] = true;
$_SESSION['ici_contact_bool'] = false;

header( "refresh:3;url=index.php" );

?>


<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href=" css/okSended.css">
        
        <link rel="icon" href="img/icon.ico" />

        <!-- ===== BOX ICONS ===== -->
        <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>

        <title>C'est bon ! | Rodav Dalí</title>
    </head>
    <body onload="Loading()">
      
     
       <img src="img/valided.png" alt="ok" class="center" width="50">
        <div class="container"><p class="mess">Votre message a bien été envoyé</p></div>
        
        <div id="cover" class="cover">
		<div id="loading" class="ui-circle-loading">
			<ul class="animate">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</div>
      
    </body>
</html>
