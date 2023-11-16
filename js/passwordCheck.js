const registerForm = document.getElementById("registerForm");
const password = document.getElementById("passwordRegister");
const passwordConfirm = document.getElementById("passconfirmRegister");


passwordConfirm.addEventListener("input", function () {
    if (password.value !== passwordConfirm.value) {
        passwordConfirm.setCustomValidity("Passwords do not match");
    } else {
        passwordConfirm.setCustomValidity("");
    }

})
registerForm.addEventListener("submit", function(e) {
    if (!passwordConfirm.checkValidity()) {
        e.preventDefault();
    }

})