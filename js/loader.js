var myVar;

function Loading() {
    myVar = setTimeout(showPage, 2000);
}

function showPage() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("leBody").style.display = "block";
}