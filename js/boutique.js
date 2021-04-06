/**************************************************************/
/***************************** AFFICHAGE QTE ETIQUETTE STOCK */


var inputAffichageQte = document.getElementById('affqte'); 
showQte(inputAffichageQte);

function showQte(input) {
    let liste = document.getElementsByClassName("quantiteBay");
    let contents = document.getElementsByClassName("content");

    if(input.checked) {
        console.log("cach&eacute;");
        for(let i = 0; i < liste.length; i++) {
            console.log(liste[i]);
            liste[i].style.display = "none";
            //  contents[i].classList.add("bottombottom1");
        }
    } else {
        console.log("visible");
        for(let i = 0; i < liste.length; i++) {
            console.log(liste[i]);
            liste[i].style.display = "inline";
            //   contents[i].classList.remove("bottombottom1");
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
    console.log(input);
    if(parseInt(input.value) < max) {
        let x = parseInt(input.value);
        input.value = x+1;
    } else {
        console.log("*");
        createNotification("Vous ne pouvez pas en prendre plus.. ",0,0);
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

// *** ajouter au panier SESSION PHP
function goToSendPanierPHP(key,qte) {
    var xmlhttp = new XMLHttpRequest();

    let ou = "sendToPanier.php?key=";

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

    let ou = "removeToPanier.php?key=";

    ou += key; // c'est la clé

    if(OkDiminu) {
        ou += '&diminu=1';
    }

    console.log("go",ou);
    xmlhttp.open("GET",ou,true);
    xmlhttp.send();

}  

// *** BTN Card ajouter au panier  (key est enfaite l'id)
function addPanier(key,max) {

    let qte = parseInt(document.getElementById("nbQteCommande"+key).value);
    let qteDejaPanier = 0;



    if (qte > 0){

        // faut actualiser chakal
        if(AfficherTextActualiserPage){
            createNotificationDelay(4,"Actualiser la page pour voir les modifications faîtes au panier",0);
            AfficherTextActualiserPage = false;
        }



        console.log("addPanier***");

        // si le panier n'est pas vide
        if(LePanierSESSION) {
            let listeProduitsPan = Object.keys(LePanierSESSION); // produits du panier
            // si le bail est deja dans le panier
            if (listeProduitsPan.includes((codeCat+key))) {
                // on recupère la quantité deja la
                qteDejaPanier = parseInt(LePanierSESSION[(codeCat+key)]['quantity']);
            } else { // n'est pas dans le panier
                majQteVarPanier((codeCat+key),qte,true);


            }
        } else {
            console.log("sache que le panier est vide");
            majQteVarPanier((codeCat+key),qte,true);

            console.log(  LePanierSESSION,"mtn je l'ai rempli");
        }





        if(qte + qteDejaPanier <= max){
            createNotification('<b>"' + LaBoutique[LaCat][key]['Title'] +'"</b>' + " x " + qte + " a été ajouté au panier",1,1);

            goToSendPanierPHP((codeCat+key),qte);


            plus2((codeCat+key),max,qte); // maj les quantité dans le modal panier


        } else {
            createNotification("Il n'y a que " + max + " - <b>'" + LaBoutique[LaCat][key]['Title'] +"'</b> en stock.. ",-1);
        }


        majCountPan();
    } else {
        createNotification(" ",-1);
    }

    console.log("LePanierSESSION après ajout",LePanierSESSION);
}