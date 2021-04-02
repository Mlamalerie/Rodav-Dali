<div class="content-left">
<?php if (!$_SESSION['ici_contact_bool']) { ?>
    <div id="app-cover"> <label class="labelStock" for="affqte">Affichage quantité en stock</label><br>
        <div class="row-row">
            <div class="toggle-button-cover">

                <div class="button b2" id="button-13">
                    <input onchange="showQte(this)" onload="showQte(this)" id="affqte" type="checkbox" class="checkbox" >
                    <div class="knobs">
                        <span></span>
                    </div>
                    <div class="layer"></div>

                </div>

            </div>
        </div>
    </div>
<?php } ?>
    <div class="sidebar">

        <h1 class="text-shadow text-point">Nos produits</h1>
        <?php if ($_SESSION['ici_contact_bool']) {$LaCat = "";}; ?>

        <a href="produits.php?cat=albums"><?php if($LaCat == "albums"){ ?> <span class="amenuactive "> <?php }?> Albums<?php if($LaCat == "albums"){ ?> </span><?php }?> 💽</a>
        <a href="produits.php?cat=tableaux"><?php if($LaCat == "tableaux"){ ?> <span class="amenuactive "> <?php }?>Tableaux<?php if($LaCat == "tableaux"){ ?></span><?php }?></a>
        <a href="produits.php?cat=mode"><?php if($LaCat == "mode"){ ?> <span class="amenuactive "> <?php }?>Mode<?php if($LaCat == "mode"){ ?></span><?php }?>🧦</a>


        <h2 class="text-shadow ">  ---</h2>
        <a href="contact.php">Nous contacter 👈🏾</a>
    </div>
</div>
