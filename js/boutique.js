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

function plus(key,max) {

    let input = document.getElementById("nbQtePanier"+key);
    if(input.value < max) {
        let x = parseInt(input.value);
        input.value = x+1;
    } else {
        console.log("*");
        createNotification("Vous ne pouvez pas en prendre plus.. ",0,0);
    }
}
function moin(key) {
    let input = document.getElementById("nbQtePanier"+key);
    if(input.value > 0) {
        let x = parseInt(input.value);
        input.value = x-1;
    } 
}

function addPanier(key,nom,max) {
    console.log("addPanier",key);
    let qte = parseInt(document.getElementById("nbQteCommande"+key).value);

    if (qte > 0){
        console.log("***");
        var xmlhttp = new XMLHttpRequest();
        let codeCat = document.getElementById("CodeCat").value.trim();


        let ou = "sendToPanier.php?key=";
        ou += codeCat;
        ou += key; // c'est l'id ça en vrai
        ou += '&qte=';
        ou += qte;

        console.log(ou,key,qte);
        xmlhttp.open("GET",ou,true);
        xmlhttp.send();

        plus2(key,max,qte); // maj les quantité dans le panier
        createNotification('<b>"' + nom +'"</b>' + " x " + qte + " a été ajouté au panier",1,1);

    } else {
        createNotification("0.. ",-1,0);
    }
}