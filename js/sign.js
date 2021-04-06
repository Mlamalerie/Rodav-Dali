 const signUpButton = document.getElementById('signUp');
            const signInButton = document.getElementById('signIn');
            const container = document.getElementById('container');

            signUpButton.addEventListener('click', () => {
                container.classList.add("right-panel-active");
            });

            signInButton.addEventListener('click', () => {
                container.classList.remove("right-panel-active");
            });


            const iemail = document.getElementById("iemail");
            const cemail = document.getElementById("cemail");

            const ipseudo = document.getElementById("ipseudo");

            const ipassword = document.getElementById("ipassword");
            const ipassword2 = document.getElementById("ipassword2");

            const cpassword = document.getElementById("cpassword");


            const erroripseudo = document.getElementById("error-ipseudo");
            const erroriemail = document.getElementById("error-iemail");
            const errorcemail = document.getElementById("error-cemail");
            const erroripassword = document.getElementById("error-ipassword");
            const errorcpassword = document.getElementById("error-cpassword");
            const erroripassword2 = document.getElementById("error-ipassword2");

            const regExpMail = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            const regExpAlphaNum = /^[A-Za-z0-9_.-]+$/;

            const icon =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" ;

            var delay1Sec = 1000; //1 second


            function check(){
                setTimeout(function() { 
                    /**** verif email */
                    console.log(okMailExisteDeja, MailDeja);
                    if(iemail.value.trim().length == 0) {
                        //erroriemail.style.display = "none";
                        iemail.style.border = "none";

                    } 
                    else {
                        if(!iemail.value.trim().match(regExpMail)){ // si c'est pas bon

                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#e74c3c";

                            erroriemail.style.display = "block";
                            erroriemail.innerHTML = icon + "Veuillez saisir une adresse mail correct (exemple : said@gmail.com) !";
                            console.log("email");
                            //btn.style.display = "none";
                        } else if (okMailExisteDeja && iemail.value.trim() == MailDeja) {
                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#e74c3c";

                            erroriemail.style.display = "block";
                            erroriemail.innerHTML = icon + " Un compte a déjà été créer avec cet email !";
                        }

                        else {
                            iemail.style.border = "solid 1.5px"
                            iemail.style.borderColor = "#3ce763";
                            erroriemail.style.display = "none";
                        }
                    }

                    /**** verif email CONNEXION */
                    if(cemail.value.trim().length == 0) {
                        //errorcemail.style.display = "none";
                        cemail.style.border = "none";

                    } 
                    else {
                        if(!cemail.value.trim().match(regExpMail)){ // si c'est pas bon

                            cemail.style.border = "solid 1.5px"
                            cemail.style.borderColor = "#e74c3c";

                            errorcemail.style.display = "block";
                            errorcemail.innerHTML = icon + "Adresse mail incorrect !";
                            console.log("email");
                            //btn.style.display = "none";
                        } else {
                            cemail.style.border = "none";
                            errorcemail.style.display = "none";
                        }
                    }

                    /**** verif MOT DE PASSE CONNEXION */
                    if(cpassword.value.length == 0) {

                        cpassword.style.border = "none";

                    } 
                    else {
                        cpassword.style.border = "none";
                        errorcpassword.style.display = "none";

                    }

                    /**** verif pseudo */
                    if(ipseudo.value.trim().length == 0) {
                        // erroripseudo.style.display = "none";
                        ipseudo.style.border = "none";

                    } 
                    else if(ipseudo.value.trim().length < 3 || ipseudo.value.trim().length > 30 ) {

                        ipseudo.style.border = "solid 1.5px"
                        ipseudo.style.borderColor = "#e74c3c";
                        erroripseudo.style.display = "block";
                        erroripseudo.innerHTML = icon + "Veuillez saisir un pseudo de taille résonable [3-30] !";

                    } 
                    else {
                        if(!ipseudo.value.trim().match(regExpAlphaNum)){ // si c'est pas bon

                            ipseudo.style.border = "solid 1.5px"
                            ipseudo.style.borderColor = "#e74c3c";

                            erroripseudo.style.display = "block";
                            erroripseudo.innerHTML = icon + "Caractère autorisés : lettres chiffres _ - .";

                            //btn.style.display = "none";
                        } else {
                            ipseudo.style.border = "solid 1.5px"
                            ipseudo.style.borderColor = "#3ce763";

                            erroripseudo.style.display = "none";
                        }
                    }

                    /**** verif mot de passe */
                    let mdp1rouge = false;
                    if(ipassword.value.length == 0 ) {
                        //erroripassword.style.display = "none";
                        ipassword.style.border = "none";

                    } 
                    else if(ipassword.value.length < 4  ) {

                        ipassword.style.border = "solid 1.5px"
                        ipassword.style.borderColor = "#e74c3c";
                        erroripassword.style.display = "block";
                        erroripassword.innerHTML = icon + "Veuillez saisir un mot de passe plus long !";
                        mdp1rouge = true;

                    }  else {
                        ipassword.style.border = "solid 1.5px"
                        ipassword.style.borderColor = "#3ce763";
                        erroripassword.style.display = "block";
                        erroripassword.style.display = "none";
                    }

                    /**** verif mot de passe 2 */
                    if(ipassword2.value.length == 0 ) {
                        erroripassword2.style.display = "none";
                        ipassword2.style.border = "none";

                    } else if(mdp1rouge ) {
                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#e74c3c";
                        erroripassword2.style.display = "block";
                        erroripassword2.style.display = "none";

                    }
                    else if( ipassword2.value != ipassword.value  ) {

                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#e74c3c";
                        erroripassword2.style.display = "block";
                        erroripassword2.innerHTML = icon + "Veuillez bien saisir 2 fois le même mot de passe !";

                    }  else {
                        ipassword2.style.border = "solid 1.5px"
                        ipassword2.style.borderColor = "#3ce763";
                        erroripassword2.style.display = "block";
                        erroripassword2.style.display = "none";
                    }

                }, delay1Sec*2);

            }

            function seConnecter() {
                if(iemail.value.length > 0) {
                    cemail.value = iemail.value;

                } 
                if(ipassword.value.length > 0) {
                    cpassword.value = ipassword.value;

                } 
                check();

            }
            function sInscrire() {
                if(cemail.value.length > 0) {
                    iemail.value = cemail.value;

                } 
                if(cpassword.value.length > 0) {
                    ipassword.value = cpassword.value;

                } 
                check();

            }
