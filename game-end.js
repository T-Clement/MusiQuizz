const tabButtons = document.querySelectorAll(".js-display-btn");
console.log(tabButtons);

const tabs = document.querySelectorAll(".js-tab-display");
console.log(tabs);

tabButtons.forEach(function(button) {
    button.addEventListener("click", function() {
        console.log(this);

        // target the form linked to button clicked
        const tabToActivate =  document.querySelector("[data-tab-content=" + this.dataset.btn + "]");

        // if wanted form already has active class, do nothing
        if(tabToActivate.classList.contains("active")) return;

        // remove .active / displaying to current active form
        const activeTab = document.querySelector(".js-tab-display.active");
        if(activeTab) {
            activeTab.classList.remove("active");
        }

        // active the form linked to btn clicked
        tabToActivate.classList.add("active");

        // change btn active of btns
        tabButtons.forEach(function(btn) {
            // toggle btn-active if btn === button, else remove the class to the others buttons
            btn.classList.toggle("btn-active", btn === button);
        })

    })
});