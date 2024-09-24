var oeil = document.getElementById("oeil")
var inputPassword = document.getElementById("inputPassword")


oeil.addEventListener("click", function(){

    if(inputPassword.type == "password"){
        inputPassword.type = "text";
    }
    else{
        inputPassword.type = "password";
    }
    
})

console.log(inputPassword)