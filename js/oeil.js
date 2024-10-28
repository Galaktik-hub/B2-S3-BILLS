var inputPassword = document.getElementById("inputPassword");
var inputNewPwd = document.getElementById("new_mdp");
var inputRepeatPwd = document.getElementById("repeatmdp");

var oeilLogin = document.querySelector(".oeil-login");
var oeilNew = document.querySelector(".oeil-new");
var oeilRepeat = document.querySelector(".oeil-repeat");

if (oeilLogin && inputPassword) {
    oeilLogin.addEventListener("click", function () {
        inputPassword.type = (inputPassword.type === "password") ? "text" : "password";
    });
}
if (oeilNew && inputNewPwd) {
    oeilNew.addEventListener("click", function() {
        inputNewPwd.type = (inputNewPwd.type === "password") ? "text" : "password";
    });
}

if (oeilRepeat && inputRepeatPwd) {
    oeilRepeat.addEventListener("click", function() {
        inputRepeatPwd.type = (inputRepeatPwd.type === "password") ? "text" : "password";
    });
}