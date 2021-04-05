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
    if(parseInt(input.value) < max) {
        let x = parseInt(input.value);
        input.value = x+1;
    } else {
        console.log("*");
        createNotification("Vous ne pouvez pas en prendre plus.. ",0,0);
    }
}
function moin(key) {
    let input = document.getElementById("nbQtePanier"+key);
    if(parseInt(input.value) > 0) {
        let x = parseInt(input.value);
        input.value = x-1;
    } 
}
