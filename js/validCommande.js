prixTotalPanier();
function prixTotalPanier() {
    console.log("calculTotal");
    let s = 0;

    if(LePanierSESSION){
        let listeProduits = Object.keys(LePanierSESSION);

        for(let i = 0; i < listeProduits.length; i++) {
            p = LePanierSESSION[listeProduits[i]];

            s +=  parseInt(p['q']) * parseFloat(p['produit_price']);
        }


        document.getElementById("prixTotalBtn").innerHTML = s.toFixed(2);
    }

}


function afficherModal(){ 
    modal.style.display = "block";
}



const prenomnom = document.getElementById("prenomnom");
const adresse = document.getElementById("adresse");
const villepays = document.getElementById("villepays");
const email = document.getElementById("email");

const erroremail = document.getElementById("error-email");
const errorprenomnom= document.getElementById("error-prenomnom");
const erroradresse= document.getElementById("error-adresse");
const errorvillepays= document.getElementById("error-villepays");




const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
const regExpAlphaNum = /^[A-Za-z0-9_.-]+$/;
const regExpAlpha = /^[A-Za-z'\s-]+$/;

const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" ;



function check(){
    setTimeout(function() { 
        /**** verif email */

        if(email.value.trim().length == 0) {
            //erroremail.style.display = "none";
            email.style.border = "none";

        } 
        else {
            if(!email.value.trim().match(regExpMail)){ // si c'est pas bon

                email.style.border = "solid 1.5px"
                email.style.borderColor = "#e74c3c";

                erroremail.style.display = "block";
                erroremail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
                console.log("email");
                //btn.style.display = "none";
            } else if (okMailExisteDeja && email.value.trim() == MailDeja) {
                email.style.border = "solid 1.5px"
                email.style.borderColor = "#e74c3c";

                erroremail.style.display = "block";
                erroremail.innerHTML = icon + " Un compte a déjà été créer avec cet email !";
            }

            else {
                email.style.border = "solid 1.5px"
                email.style.borderColor = "#3ce763";
                erroremail.style.display = "none";
            }
        }


        /**** verifprenomnom */
        if(prenomnom.value.trim().length == 0) {
            //errorprenomnom.style.display = "none";
            prenomnom.style.border = "none";

        } 
        else if(prenomnom.value.trim().length < 3 || prenomnom.value.trim().length > 30 ) {

            prenomnom.style.border = "solid 1.5px"
            prenomnom.style.borderColor = "#e74c3c";
            errorprenomnom.style.display = "block";
            errorprenomnom.innerHTML = icon + "Veuillez saisir un prenom et un nom de taille résonable (entre 3 et 30) ["+ prenomnom.value.trim().length +"] !";

        } 
        else {
            if(!prenomnom.value.trim().match(regExpAlpha)){ // si c'est pas bon

                prenomnom.style.border = "solid 1.5px"
                prenomnom.style.borderColor = "#e74c3c";

                errorprenomnom.style.display = "block";
                errorprenomnom.innerHTML = icon + "Caractère autorisés : lettres ' -";

                //btn.style.display = "none";
            } else {
                prenomnom.style.border = "solid 1.5px"
                prenomnom.style.borderColor = "#3ce763";

                errorprenomnom.style.display = "none";
            }
        }

        /**** verif adresse */
        if(adresse.value.trim().length == 0) {
            //  erroradresse.style.display = "none";
            adresse.style.border = "none";

        } 
        else if(adresse.value.trim().length < 3 || adresse.value.trim().length > 75 ) {

            adresse.style.border = "solid 1.5px"
            adresse.style.borderColor = "#e74c3c";
            erroradresse.style.display = "block";
            erroradresse.innerHTML = icon + "Veuillez saisir une adresse de taille résonable (entre 3 et 75) ["+ adresse.value.trim().length +"] !";

        } 
        else {

            adresse.style.border = "solid 1.5px"
            adresse.style.borderColor = "#3ce763";

            erroradresse.style.display = "none";

        }

        /**** verif villepays */
        if(villepays.value.trim().length == 0) {
            // errorvillepays.style.display = "none";
            villepays.style.border = "none";

        } 
        else if(villepays.value.trim().length < 3 || villepays.value.trim().length > 50 ) {

            villepays.style.border = "solid 1.5px"
            villepays.style.borderColor = "#e74c3c";
            errorvillepays.style.display = "block";
            errorvillepays.innerHTML = icon + "Veuillez saisir une ville et un pays de taille résonable (entre 3 et 50) ["+ villepays.value.trim().length +"] !";

        } 
        else {

            villepays.style.border = "solid 1.5px"
            villepays.style.borderColor = "#3ce763";

            errorvillepays.style.display = "none";

        }

    }, delay1Sec*2);

}

