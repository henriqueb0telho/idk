const pswrdField = document.querySelector(".form input[type='password']"),
toogleBtn = document.querySelector(".form .field i");

toogleBtn.onclick = ()=>{
    if(pswrdField.type == "password"){
        pswrdField.type = "text";
        toogleBtn.classList.add("active");
    } else {
        pswrdField.type = "password";
        toogleBtn.classList.remove("active");
    }
}