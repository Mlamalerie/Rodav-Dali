function showQte(input) {
    let liste = document.getElementsByClassName("quantiteBay");
    
    if(input.checked) {
        console.log("caché");
        for(let i = 0; i < liste.length; i++) {
            console.log(liste[i]);
            liste[i].style.display = "none";
        }
    } else {
        console.log("visible");
        for(let i = 0; i < liste.length; i++) {
            console.log(liste[i]);
            liste[i].style.display = "inline";
        }
    }
}