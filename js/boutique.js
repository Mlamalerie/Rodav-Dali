 /**************************************************************/
            /***************************** AFFICHAGE QTE ETIQUETTE STOCK */


            var inputAffichageQte = document.getElementById('affqte'); 
            showQte(inputAffichageQte);

            function showQte(input) {

                if(input){
                    let liste = document.getElementsByClassName("quantiteBay");
                    let contents = document.getElementsByClassName("content");

                    if(input.checked) {

                        for(let i = 0; i < liste.length; i++) {

                            liste[i].style.display = "none";
                            //  contents[i].classList.add("bottombottom1");
                        }
                    } else {

                        for(let i = 0; i < liste.length; i++) {

                            liste[i].style.display = "inline";
                            //   contents[i].classList.remove("bottombottom1");
                        }
                    }
                }
            }

            /**************************************************************/
            /***************************** BTN + - CARD */
            function plus(key,max) {
                console.log("plus("+key + "," + max + ")");
                //  if(!okConnect){
                //      createNotificationDelay(2,"Connectez-vous pour pouvoir ajouter au panier ",0);
                //  }
                let input = document.getElementById("nbQteCommande"+key);

                if(parseInt(input.value) < max) {
                    let x = parseInt(input.value);
                    input.value = x+1;
                } else {
                    console.log("*");
                    createNotification("Vous avez déjà tous mis dans votre panier... ",0,0);
                }
            }

            function moin(key) {
                let input = document.getElementById("nbQteCommande"+key);
                if(parseInt(input.value) > 0) {
                    let x = parseInt(input.value);
                    input.value = x-1;
                } 
            }


            var AfficherTextActualiserPage = true;
            var AfficherTextConnecteToiChkl = true;

            /**************************************************************/
            /***************************** PANIER */

            // *** ajouter au panier SESSION PHP
            function goToSendPanierPHP(key,qte) {
                var xmlhttp = new XMLHttpRequest();

                let ou = "sendToPanierBDD.php?key=";

                ou += key; // c'est la clé
                ou += '&qte=';
                ou += qte;

                console.log("go",ou);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

            }  
            // *** retirer du panier SESSION PHP
            function goToRemovePanierPHP(key,OkDiminu = false) {
                var xmlhttp = new XMLHttpRequest();

                let ou = "removeToPanierBDD.php?key=";

                ou += key; // c'est la clé

                if(OkDiminu) {
                    ou += '&diminu=1';
                }

                console.log("go",ou);
                xmlhttp.open("GET",ou,true);
                xmlhttp.send();

            }  


            // *** Mise a jour de la var js LePanierSESSION, modification qté ou ajout d'un nv produit
            function majQteVarPanier(key,newQte) {
                console.log("majVarPanier",key,newQte);

                let listeProduitsPan = Object.keys(LePanierSESSION);

                // si le bail est deja dans le panier
                if (listeProduitsPan.includes(key))  { 
                    LePanierSESSION[key]['q'] = newQte; 
                } else { // ajouter nouveau produit
                    if(!LePanierSESSION){
                        LePanierSESSION = {};
                    }
                    p = {
                        "produit_id": key,
                        "produit_title": LaBoutique[key]['produit_title'],
                        "produit_price": LaBoutique[key]['produit_price'],
                        "produit_src": LaBoutique[key]['produit_src'],
                        "produit_author": LaBoutique[key]['produit_author'],
                        "q": newQte
                    }
                    console.log(p);
                    LePanierSESSION[key] = p;
                }

            }

            // *** BTN Card ajouter au panier  (key est enfaite l'id)
            function addPanier(key,max) {

                let qte = parseInt(document.getElementById("nbQteCommande"+key).value);
                let qteDejaPanier = 0;


                if (qte > 0){ 

                    console.log("addPanier***");

                    let actualiserSvpEh = false;
                    // si le panier n'est pas vide
                    if(LePanierSESSION) {
                        let listeProduitsPan = Object.keys(LePanierSESSION); // produits du panier
                        // si le bail est deja dans le panier
                        if (listeProduitsPan.includes(key)) {

                            // on recupère la quantité deja dans le panier
                            qteDejaPanier = parseInt(LePanierSESSION[key]['q']);
                        } 
                        
                        if(!LePanierSESSION[key]) {
                            actualiserSvpEh = true;
                        }
                    } else {
                         actualiserSvpEh = true;
                    }

                    // faut actualiser chakal, si 
                    if(AfficherTextActualiserPage && actualiserSvpEh){
                        createNotificationDelay(4,"Actualiser la page pour voir les modifications faîtes au panier",0);
                        AfficherTextActualiserPage = false;
                    }

                    /* BDD Panier */
                    if(qte + qteDejaPanier <= max){ // si la quantité voulu ajout + la qte deja dans le panier est bien possible
                        createNotification('<b>"' + LaBoutique[key]['produit_title'] +'"</b>' + " x " + qte + " a été ajouté au panier",1,1);

                        plus2(key,max,qte); // maj les quantité dans le modal panier

                    } else {
                        createNotification("Il n'y a que " + max + " - <b>'" + LaBoutique[key]['produit_title'] +"'</b> en stock.. ",-1);
                    }


                    majCountPan();
                } 
                else { // si la quantité est inf à 0
                    createNotification("Veuillez augmenter la quantité pour l'ajouter au panier",-1);
                }

                console.log("LePanierSESSION après ajout",LePanierSESSION);
            }
