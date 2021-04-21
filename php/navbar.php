

<nav class="navbar">
    <div class="content">
        <div class="logo">
            <a href="index.php">Rodav Dalí</a>
        </div>
        <ul class="menu-list">
            <div class="icon cancel-btn">
                <i class="fas fa-times"></i>
            </div>
            <li><a href="index.php">Accueil</a></li>
            <li>
                <a href="#" class="desktop-link text-shadow text-point">Oeuvres</a>
                <input type="checkbox" id="show-features">
                <label for="show-features">Oeuvres</label>
                <ul>
                    <li class="sub-link-hover"><a href="produits.php?cat=albums">Albums 💽</a></li>
                    <li class="sub-link-hover"><a href="produits.php?cat=tableaux">Tableaux 🎨</a></li>
                    <li class="sub-link-hover"><a href="produits.php?cat=mode">Mode 🧦</a></li>

                </ul>
            </li>

            <li><a href="contact.php" >Contact</a></li>
            <?php if(!$okconnectey ) {?> 
            
            <li><a href="sign.php" class="buttons-magique user-btn"  id="RONDUSER"><i class="fas fa-user"></i></a></li> 
            
            
            <?php } else { ?>

            <li>


                <a href="#" class="desktop-link buttons-magique " id="RONDUSER"><i class="fas fa-user"></i></a>


                <input type="checkbox" id="show-features">
                <label for="show-features"><i class="fas fa-user"></i><?= $_SESSION['user_pseudo']; ?> </label>
                <ul class="ululul">
                    <li class="sub-link-hover"><a href="deconnexion.php">Déconnexion <i class="fas fa-power-off"></i></a></li>
                </ul>
            </li>
            <li> <span class="labelPseudo" for="show-features"><?= $_SESSION['user_pseudo']; ?> </span></li>
            <?php } ?>

            <?php if($okconnectey) {?> 
            <li>
                <button id="myBtnModal" class="cart-nav">

                    <div class="icon">

                        <i class="fas fa-shopping-cart"></i>
                        <span>Cart</span>
                    </div>
                    <div class="item-count"><?php if($okMonPanierEstVide) {echo 0;} else { echo count($_SESSION["user_panier"]);}?></div>
                    <div class="item-iconshop"><i class="fas fa-shopping-cart"></i></div>

                </button>
            </li> 
            <?php } ?>
        </ul>
        <div class="icon menu-btn">
            <i class="fas fa-bars"></i>
        </div>

    </div>
</nav>


<?php if($okconnectey) {?> 
<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Mon Panier</h2>
        </div>
        <div class="modal-body">



            <div class="shopping-cart">


                <?php 
    $PrixTotalPan = 0;
    $NbProdPan = 0;


    if($okMonPanierEstVide) { ?>
                <div id="panierVide"><span>Votre panier est vide..</span></div> 
                <?php  } else {

        foreach($_SESSION['user_panier'] as $pan) {
        $max = (int) $pan['produit_quantity'];
            
            $PrixTotalPan += $pan['produit_price']*$pan['q'];
                ?> 
                <!-- Product #1 -->
                <div class="item" id="item-<?=$pan['produit_id']?>">

                    <div class="buttons">
                        <button class="delete-btn" onclick="removePanier('<?=$pan['produit_id']?>')"><i class="fas fa-trash-alt"></i></button>

                    </div>


                    <div class="image">
                        <img class="imgCoverPan" src="<?=$pan['produit_src']?>" alt="" />
                    </div>

                    <div class="description">
                        <span><?=$pan['produit_title']?></span>
                        <span><?=$pan['produit_author']?></span>

                    </div>

                    <div class="quantity">
                        <button class="plus-btn" type="button" name="button" onclick="moin2('<?=$pan['produit_id']?>')" >–</button>
                        <input id="nbQtePanier<?=$pan['produit_id']?>" type="number" class="session-time mx-2" value="<?=$pan['q']?>" disabled>
                        <button class="minus-btn" type="button" name="button" onclick="plus2('<?=$pan['produit_id']?>',<?=$max ?>)">+</button>
                    </div>

                    <div class="total-price">$<?=$pan['produit_price']?></div>
                </div>
                <?php $NbProdPan++; } ?>

                <!-- Title -->
                <div class="titlePanier">
  <button id="btnPasserCommande" onclick="window.location.replace('validCommande.php')">Passer Commande</button>
                    Prix Total : <b id="prixTotalPan"></b>


                </div>

                <?php } ?>
            </div>
        </div>

    </div>

</div>


<?php }?> 