function showQte(input) {
    let liste = document.getElementsByClassName("quantiteBay");
    let contents = document.getElementsByClassName("content");
    
    if(input.checked) {
        console.log("caché");
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

function plus(id,max) {
    let input = document.getElementById("nbQteCommande"+id);
    if(input.value < max) {
        let x = parseInt(input.value);
        input.value = x+1;
    }
}
function moin(id) {
    let input = document.getElementById("nbQteCommande"+id);
    if(input.value > 0) {
         let x = parseInt(input.value);
        input.value = x-1;
    }
}