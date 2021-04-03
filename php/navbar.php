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
            <?php if(!$okconnectey) {?> 
            <li><a href="sign.php" class="buttons-magique user-btn"><i class="fas fa-user"></i></a></li> <?php } else { ?>

            <li>


                <a href="#" class="desktop-link buttons-magique "><i class="fas fa-user"></i></a>


                <input type="checkbox" id="show-features">
                <label for="show-features"><i class="fas fa-user"></i><?= $_SESSION['user_pseudo']; ?> </label>
                <ul class="ululul">

                    <li class="sub-link-hover"><a href="deconnexion.php">Déconnexion <i class="fas fa-power-off"></i></a></li>


                </ul>
            </li>
            <li> <span class="labelPseudo" for="show-features"><?= $_SESSION['user_pseudo']; ?> </span></li>
            <?php } ?>

            <!--
<div class="icon menu-btn">
<i class="fas fa-bars"></i>
</div>
-->

            <li>
                <div class="cart-nav">
                    <div class="icon">
                        <button class="myBtnModal">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Cart</span>

                        </button>

                    </div>
                    <div class="item-count">10</div>

                </div>
            </li> 
        </ul>


    </div>
</nav>


<!-- The Modal -->
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h2>Modal Header</h2>
        </div>
        <div class="modal-body">



            <p>Some text in the Modal Body</p>
            <p>Some other text...</p>

        </div>

    </div>

</div>


