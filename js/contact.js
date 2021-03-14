const email = document.getElementById("email");
const prenom = document.getElementById("prenom");
const nom = document.getElementById("nom");
const sexeM = document.getElementById("inputM");
const sexeF = document.getElementById("inputF");
const date = document.getElementById("datenaissance");
const sujet = document.getElementById("sujet");
const message = document.getElementById("message");

const erroremail = document.querySelector(".error-mail");
const errorprenom = document.querySelector(".error-prenom");
const errornom = document.querySelector(".error-nom");
const btnSEND = document.querySelector("#btnSEND");
btnSEND.style.fontSize = "0.8rem";


const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
const regExpAlpha = /^[A-Za-z\s]+$/;

const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" 
var okSEND = true;

function isValidDate(dateString)
{
    // First check for the pattern
    var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

    if(!regex_date.test(dateString))
    {
        return false;
    }

    // Parse the date parts to integers
    var parts   = dateString.split("-");
    var day     = parseInt(parts[2], 10);
    var month   = parseInt(parts[1], 10);
    var year    = parseInt(parts[0], 10);

    // Check the ranges of month and year
    if(year < 1000 || year > 3000 || month == 0 || month > 12)
    {
        return false;
    }

    var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

    // Adjust for leap years
    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
    {
        monthLength[1] = 29;
    }

    // Check the range of the day
    return day > 0 && day <= monthLength[month - 1];
}
function check(){
    console.log("check");
    okSEND = true;

    /**** verif email */
    if(email.value.length == 0) {
        erroremail.style.display = "none";
        email.style.border = "none";
        okSEND =false;console.log("email");
        email.classList.add("clignote");
    } 
    else {
        email.classList.remove("clignote");

        if(!email.value.match(regExpMail)){ // si c'est pas bon

            email.style.border = "solid 1px"
            email.style.borderColor = "#e74c3c";

            erroremail.style.display = "block";
            erroremail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
            okSEND =false;
            console.log("email");
            //btn.style.display = "none";
        } else {
            erroremail.style.display = "none";
            email.style.border = "none"
        }
    }

    /**** verif prenom */
    if(prenom.value.trim().length == 0) {
        errorprenom.style.display = "none";
        prenom.style.border = "none"
        okSEND =false;console.log("prenom");
        prenom.classList.add("clignote");

    } else {
        prenom.classList.remove("clignote");

        if(!prenom.value.match(regExpAlpha)){ // si c'est pas bon
            console.log("*-");
            prenom.style.border = "solid 1px"
            prenom.style.borderColor = "#e74c3c";

            errorprenom.style.display = "block";
            errorprenom.innerHTML = icon + "Veuillez saisir un prenom correct (des lettres uniquement)!";
            okSEND =false;console.log("prenom");
            //btn.style.display = "none";
        } else {
            console.log("++-");
            errorprenom.style.display = "none";
            prenom.style.border = "none"
        }
    }

    /**** verif nom */
    if(nom.value.trim().length == 0) {
        errornom.style.display = "none";
        nom.style.border = "none";
        okSEND =false;
        console.log("nom");  nom.classList.add("clignote");
    } else {
        nom.classList.remove("clignote");

        if(!nom.value.match(regExpAlpha)){ // si c'est pas bon
            console.log("*-");
            nom.style.border = "solid 1px"
            nom.style.borderColor = "#e74c3c";

            errornom.style.display = "block";
            errornom.innerHTML = icon + "Veuillez saisir un nom correct (des lettres uniquement)!";
            okSEND =false;console.log("nom");
            //btn.style.display = "none";
        } else {
            errornom.style.display = "none";
            nom.style.border = "none";
        }
    }

    /**** verif sexe */
    if(!sexeM.checked && !sexeF.checked) {
        okSEND = false;
        console.log("sexe");
        sexeM.classList.add("clignote");
        sexeF.classList.add("clignote");

    } else {
        sexeM.classList.remove("clignote");
        sexeF.classList.remove("clignote");
    }


    /**** verif sujet */
    if(sujet.value.trim().length == 0) {
        okSEND = false;
        console.log("sujet");  sujet.classList.add("clignote");
    } else {
        sujet.classList.remove("clignote");
    }

    /**** verif message */
    if(message.value.trim().length == 0) {
        okSEND = false; console.log("message");  message.classList.add("clignote");
    } else{
        message.classList.remove("clignote");
    }

    /**** verif date */
    if(!isValidDate(date.value) ) {
        console.log(date.value,"###data pas bon");
        okSEND = false;
        date.classList.add("clignote");
    } else{
        console.log(date.value,"### tout est bon");
        date.classList.remove("clignote");
    }

    console.log(date.value,"***********",isValidDate(date.value));
    if(okSEND) {
        btnSEND.style.display = "block";
        btnSEND.setAttribute("class","buttons-magique");
        btnSEND.style.fontSize = "1.1rem";
        btnSEND.innerHTML = "ENVOYER !";
        btnSEND.removeAttribute("disabled");
        btnSEND.setAttribute("onclick","submitForm()")
      
        console.log("if%");
    } 
    else{
        console.log("else%");
        btnSEND.setAttribute("class"," ");
        btnSEND.innerHTML = "veuillez remplir toute les cases <i class='fas fa-exclamation-triangle'></i>";
        btnSEND.style.fontSize = "0.8rem";
        btnSEND.setAttribute("disabled");  
        btnSEND.removeAttribute("onclick");

    }
}

function submitForm() {
    
    let f = document.getElementById("formContact");
    console.log(f)
    f.submit()
}
