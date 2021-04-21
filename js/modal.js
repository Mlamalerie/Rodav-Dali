var AfficherTextVaTePromenerFrr = true;

// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btnModal = document.getElementById("myBtnModal");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];


if(btnModal && modal){
    // When the user clicks the button, open the modal 
    btnModal.onclick = function() {
        modal.style.display = "block";
        CalculAffPrixTotal();
        if(majCountPan() == 0 ) {
            if(AfficherTextVaTePromenerFrr){
                createNotificationDelay(4,"Votre panier est vide.. promenez vous dans la boutique et ajouter des articles...",0);
                AfficherTextVaTePromenerFrr = false;
            }

        }
    }
    // When the user clicks on <span> (x), close the modal
    if(span){
        span.onclick = function() {
            modal.style.display = "none";
        }
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }


}


// *** Met a jour la petite vignette rouge = nb de produit dans le panier
function majCountPan() {


    if(LePanierSESSION) {
        let k = Object.keys(LePanierSESSION).length;
        document.getElementsByClassName('item-count')[0].innerHTML = k;
        return k;
    } else {
        document.getElementsByClassName('item-count')[0].innerHTML = "0";
        return 0;
    }



}

// *** Met a jour le prix total du panier dans le modal
CalculAffPrixTotal();
function CalculAffPrixTotal() {
    console.log("calculTotal");
    let s = 0;

    if(LePanierSESSION){
        let listeProduits = Object.keys(LePanierSESSION);

        for(let i = 0; i < listeProduits.length; i++) {
            p = LePanierSESSION[listeProduits[i]];

            s +=  parseInt(p['q']) * parseFloat(p['produit_price']);
        }


        document.getElementById("prixTotalPan").innerHTML = "$"+s;
    }

}

// *** BTN + du modal, ajoute une qte sur le modal, et directement a la bdd si voulu
function plus2(id,max,qte = 1) { 
    console.log("plus2");
    let input = document.getElementById("nbQtePanier"+id);

    if(input){
        console.log("max =",max);
        console.log("parseInt(input.value) =",parseInt(input.value));
        console.log("qte =",qte);
        console.log("if",parseInt(input.value) + qte,(input.value + qte < max ));

        if(parseInt(input.value) + qte <= max) {
            let x = parseInt(input.value);
            document.getElementById("nbQtePanier"+id).value = x+qte;

            goToSendPanierPHP(id,qte); 

            majQteVarPanier(id,x+qte); 
            CalculAffPrixTotal()


        } else {
            createNotification("Il n'y a que " + max + " <b>'" + LePanierSESSION[id]['produit_title'] +"'</b> en stock.. ",-1,1);
        }
    } else {
        goToSendPanierPHP(id,qte); 
    }



}

function removePanier(key) {
    console.log("removePanier",key);

    console.log("***");

    goToRemovePanierPHP(key);
    // suprimer la div
    let elem = document.getElementById("item-"+key);
    elem.parentNode.removeChild(elem);

    createNotification(" <b>'" + LePanierSESSION[key]['produit_title'] +"'</b>'" + " a été supprimer du panier",1,1);

    delete LePanierSESSION[key];
    CalculAffPrixTotal();
    majCountPan();

}
// *** BTN - du modal
function moin2(id) {
    let input = document.getElementById("nbQtePanier"+id);
    if(input){

        if(input.value > 1) {
            console.log("moins2()",id,"we");
            let x = parseInt(input.value);
            document.getElementById("nbQtePanier"+id).value = x-1;

            goToRemovePanierPHP(id,true);
            majQteVarPanier(id,x-1); 
            CalculAffPrixTotal();
        } 
    }
}
