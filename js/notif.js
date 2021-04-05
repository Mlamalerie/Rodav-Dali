const iconError =  "<i class='fas fa-times-circle'></i>" ;
const iconBellek =  "<i class='fa fa-exclamation-triangle' aria-hidden='true'></i>" ;
const iconSuccess =  "<i class='fas fa-check-circle' aria-hidden='true'></i>" ;
const toasts = document.getElementById('toasts');
const delay1Sec = 1000; 
function createNotification(message,type,okClickPanier = 0) {
    let icon = "";
    switch (type){
        case -1 :  icon = iconError; classType = 'error'; break;
        case 0 :  icon = iconBellek; classType = 'bellek';break;
        case 1 :  icon = iconSuccess; classType = 'success'; break;

    }



    const notif = document.createElement('div');

    if(okClickPanier) {
        notif.onclick = function() {

            document.getElementById("myModal").style.display = "block";

        }

    } 
    notif.classList.add('toast');
    notif.classList.add(classType);
    notif.innerHTML =  message + " " + icon  ;
    toasts.appendChild(notif);
    setTimeout(() => {
        notif.remove();
    }, delay1Sec*5);
}


function createNotificationDelay(attenteSec,message,type,okClickPanier) {
    setTimeout(function() {
        createNotification(message,type,okClickPanier);

    },delay1Sec*attenteSec);
}

