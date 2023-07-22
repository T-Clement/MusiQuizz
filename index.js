const formButtons = document.querySelectorAll(".form-btn");
console.log(formButtons);

const forms = document.querySelectorAll(".js-form");
console.log(forms);

formButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        console.log(this);

        // target the form linked to button clicked
        const formToActivate =  document.querySelector("[data-form=" + this.dataset.btn + "]");

        // if wanted form already has active class, do nothing
        if(formToActivate.classList.contains("active")) return;

        // remove .active / displaying to current active form
        const activeForm = document.querySelector(".js-form.active");
        if(activeForm) {
            activeForm.classList.remove("active");
        }

        // active the form linked to btn clicked
        formToActivate.classList.add("active");

        // change btn active of btns
        formButtons.forEach(function(btn) {
            // toggle btn-active if btn === button, else remove the class to the others buttons
            btn.classList.toggle("btn-active", btn === button);
        })

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


