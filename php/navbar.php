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
                        <?php if(!$okconnectey) {?>  <li><a href="sign.php" class="buttons-magique">Connexion</a></li> <?php } else { ?> <li><a href="deconnexion.php" class="buttons-magique">Deconnexion</a></li> <?php } ?>
                       
                    </ul>
                    <div class="icon menu-btn">
                        <i class="fas fa-bars"></i>
                    </div>
                    <!--
<div class="cart-nav">
<div class="icon">
<i class="fas fa-shopping-cart"></i>
<span>Cart</span>
</div>
<div class="item-count">10</div>
</div>
-->
                </div>
            </nav>
    