const body = document.getElementsByName("body");
console.log(body);
const navbar = document.getElementsByClassName("navbar")[0];
const menuBtn = document.getElementsByClassName("menu-btn")[0];
const cancelBtn = document.getElementsByClassName("cancel-btn")[0];
  
console.log(body,"#",navbar,menuBtn,cancelBtn);


menuBtn.onclick = ()=>{
    navbar.classList.add("show");
    menuBtn.classList.add("hide");
    body.classList.add("disabled");
}
cancelBtn.onclick = ()=>{
    body.classList.remove("disabled");
    navbar.classList.remove("show");
    menuBtn.classList.remove("hide");
}
window.onscroll = ()=>{
    this.scrollY > 20 ? navbar.classList.add("sticky") : navbar.classList.remove("sticky");
}