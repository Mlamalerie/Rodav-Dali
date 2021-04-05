console.log("*");
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




function plus2(id,max,qte = 1) {
    let input = document.getElementById("nbQtePanier"+id);
    if(input.value + qte < max) {
        let x = parseInt(input.value);
        input.value = x+qte;
    } else {
        createNotification('<b>"' + nom +'"</b>' + " x " + qte + " n'a pas été ajouté au panier",-1,1);
    }
}
function moin2(id) {
    let input = document.getElementById("nbQtePanier"+id);
    if(input.value > 1) {
        let x = parseInt(input.value);
        input.value = x-1;
    } 
}
function removePanier(key,nom) {
    console.log("removePanier",key);

    console.log("***");
    var xmlhttp = new XMLHttpRequest();
    let codeCat = document.getElementById("CodeCat").value;


    let ou = "removeToPanier.php?key=";
    ou += key;

    console.log(ou,key);
    xmlhttp.open("GET",ou,true);
    xmlhttp.send();

    createNotification('"' + nom +'"' + " a été supprimer du panier",1,1);

}

