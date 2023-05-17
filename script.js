// function getUserChoice() {};

// function checkResponse(correctResponse) {
    //     if (event.target.innerText != correctResponse) {
        //         event.target.style.backgroundColor = "red";
        //     }
        // }
        
const correctResponse = "Artiste 1 - Chanson";
const extractResponses = document.querySelector(".list");

console.log(extractResponses);

extractResponses.addEventListener("click", function(event) {
    console.log(event, event.target);
    // trigger color change only if button clicked
    if (event.target.tagName != "BUTTON") return;

    // change color of 
    if (event.target.innerText != correctResponse) {
        event.target.style.backgroundColor = "red";
    }
    else {
        event.target.style.backgroundColor = "green";
    };
    console.log(event.target.innerText);
});






//------ Timer Section

let timerCounter = 10;
const timerDOM = document.getElementById("timer");

const timer = setInterval(() => {
    if (timerCounter > 0) {
        timerCounter--;
        timerDOM.innerText = timerCounter;
        console.log(timerCounter);
    }
}, 1000);






// --- ProgressBar section

const progressBar = document.querySelector(".progress-bar");
console.log(progressBar);


const progressBarValue = document.querySelector(".progress-bar");
console.log(progressBarValue);


