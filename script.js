const formButtons = document.querySelectorAll(".form-btn");
console.log(formButtons);

const forms = document.querySelectorAll(".js-form");
console.log(forms);

formButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        const form =  document.querySelector("[data-form=" + this.dataset.btn + "]");
        button.classList.toggle("btn-clicked");
        // form.classList.toggle("form-active");
        // fonction de détection
        // contain classList
        // if contain -> toggle
        if(form.classList.contains(".form-active")) {
            // form.classList.toggl
        } else {
            
        }
       
    })
});





const passwordInput = document.querySelectorAll(".js-password");
console.log(passwordInput);
// element to toggle password visibility
const passwordVisibility = document.querySelector(".js-password-visibility");

// toggle hidden visibility

passwordVisibility.addEventListener("click", function() {
    if(passwordInput[0].type === "password") {
        passwordInput[0].type = "text";
        passwordVisibility.textContent = "Cacher";
    } else {
        passwordInput[0].type = "password";
        passwordVisibility.textContent = "Montrer";
    }
}); 


