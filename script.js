// playlist data
const playlist = {
    name: "Années 2000",
    songs: [
        {Artiste: "Daft Punk", Titre: "One More Time"},
        {Artiste: "Pep's", Titre: "Liberta"},
        {Artiste: "U2", Titre: "Beautiful Day"},
        {Artiste: "OutKast", Titre: "Hey Ya!"}
    ]
}

document.querySelector(".js-playlist-name").innerText = playlist.name;

console.log(playlist);
console.log(playlist.songs);
        
        
        
//-----------------------------------------------
// Define path in DOM

const extractResponses = document.querySelector(".list");
const progressBarValue = document.querySelector(".js-progress-value");
console.log(extractResponses);
const scorePath = document.getElementById("score");

// ----------------------------
// Put responses in buttons

const buttons = document.querySelectorAll(".js-button-responses");
buttons.forEach(function(button, index) {
    button.innerText = `${playlist.songs[index].Artiste} - ${playlist.songs[index].Titre}`;
});





// ------------------------------------------------
// Add color appropriate to user response

const correctResponse = "Daft Punk - One More Time";

extractResponses.addEventListener("click", function(event) {
    console.log(event, event.target);
    // trigger color change only if button clicked
    if (event.target.tagName != "BUTTON") return;
    
    // change color of button
    if (event.target.innerText != correctResponse) {
        event.target.style.backgroundColor = "red";
    }
    else {
        event.target.style.backgroundColor = "green";
        getScore();
    };
    console.log(event.target.innerText);
});



//------ Timer Section

let timerCounter = 10;
const timerDOM = document.getElementById("timer");
// full the bar at he beginning
progressBarValue.style.width = "100%";
const timer = setInterval(() => {
    if (timerCounter > 0) {
        timerCounter--;
        displayProgressBar();
        timerDOM.innerText = timerCounter;
        console.log(timerCounter);
    }
    else {
        clearInterval(timer);
    } 
}, 1000);

// --- ProgressBar function

function displayProgressBar () {
    progressBarValue.style.width = `${timerCounter * 10}%`;
}

// -----------------------------------------
// score calcul 

function getScore () {
    let responseScore = Math.round(1000 - ((Date.now() - now) / 10));
    scorePath.textContent = responseScore;
}
// use Date.now()
const now = Date.now();

