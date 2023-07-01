/*get locaStorage Json and clear localStorage */
let getData = localStorage.getItem("playlistDATAJSON");
// localStorage.removeItem("playlistDATAJSON");
const playlistDATA = JSON.parse(getData);
console.log(playlistDATA);

// to use for the game loop and transitions
const rounds = 10; // nombre de rounds d'une partie
const roundDuration = 10;   // durée d'un round
const waitBetweenRound = 5; // temps d'attente entre les rounds

let partyScore = 0;
let arrayOfSongs = [];
let currentRound = 1;

//------------------------------------------------------------------

/**
 * This function generate a random number between 2 parameters. 
 * The max value is not include as possible value.
 * 
 * @param {number} min - value 0 to start at begining of index
 * @param {number} max - length of array
 * 
 * @return - return a random index between 0 and the length of the array
 */
function getRandomIndex (min, max) {
    return  Math.floor(Math.random() * (max - min)) + min;
}


/**
 * This function use a random index to run through the playlist and select 4 randoms songs and push in a new array
 * @param {object} object - full data of playlist
 * @return {array} - return array with 4 picked songs 
 */
function pickSongsFromPlaylist (object) {
    // let arrayOfSongs = [];
    for (let i = 0; i < 4; i++) {
        // put random index in variable
        let randomIndex = getRandomIndex(0, object.tracks.length);
        // select a random song in object
        let randomSongFromObject = object.tracks[randomIndex];
        // check if randomSong is already in array
        if(arrayOfSongs.includes(randomSongFromObject)) {
            i--;
        } else {
            // to avoid the [ Object Object ]
            arrayOfSongs.push(randomSongFromObject);
        }
    }
    return arrayOfSongs;
}



const userChoice = [];
// put 4 songs in this array
    // peut-être plutôt faire 1 song choisie random où j'importe tout et ensuite 3 autrse poour du remplissage, pour limiter le nombre de requêtes
let roundChoices = pickSongsFromPlaylist(playlistDATA);                        
console.log(roundChoices);
// console.log(roundChoices[0][0].artist + " - " + roundChoices[0][1].track);


// choose randomResponse 
let correctResponse = roundChoices[getRandomIndex(0, roundChoices.length)];
console.log("La réponse correcte est : " + correctResponse[0].artist + " - " + correctResponse[1].track);
// put response in string to compare it
let correctResponseInString = correctResponse[0].artist + " - " + correctResponse[1].track;
console.log(correctResponseInString);

let beginingOfRound = Date.now();

document.querySelector(".js-playlist-name").innerText = playlistDATA.playlistName;


//-----------------------------------------------
// Define path in DOM
const currentRoundDOM = document.querySelector(".current-round");
const totalRoundDOM = document.querySelector(".total-round");
const extractResponses = document.querySelector(".list");
const progressBarValue = document.querySelector(".js-progress-value");
console.log(extractResponses);
console.log(document.querySelectorAll(".js-button-responses"));
const scorePath = document.getElementById("score");

// ----------------------------

// Put values in round hint section / span
currentRoundDOM.innerText = currentRound;
totalRoundDOM.innerText = rounds;

const buttons = document.querySelectorAll(".js-button-responses");
buttons.forEach(function(button, index) {
    // button.innerText = `${playlist.songs[index].Artiste} - ${playlist.songs[index].Titre}`;
    // button.innerText = JSON.stringify(roundChoices[index]);
    button.innerText = `${roundChoices[index][0]["artist"]} - ${roundChoices[index][1]["track"]}`;
});


// ------------------------------------------------
// Add color appropriate to user response

extractResponses.addEventListener("click", function(event) {
    console.log(event, event.target);
    
    // put button innerText in userChoice
    userChoice.push(event.target.innerText);
    console.log("Le choix de l'utilisateur est : " + userChoice);
    
    
    // trigger color change only if button clicked
    if (event.target.tagName != "BUTTON") return;
    
    // change color of button
    if (event.target.innerText != correctResponseInString) {
        event.target.style.backgroundColor = "red";
        console.log("TEST faux: " + document.querySelectorAll(".js-button-responses"));
    }
    else {
        event.target.style.backgroundColor = "green";
        let now = Date.now();
        scorePath.textContent = updateScore(partyScore, beginingOfRound, now);
        console.log("TEST vrai: " + document.querySelectorAll(".js-button-responses"));
    };
    console.log(event.target.innerText);
    // disable buttons after click
    buttons.forEach(function (button) {
        button.setAttribute("disabled", true);
    })
});


//---------------------------------- Timer Section

let barWidth = 100;
let roundCountDown = 10;

let userResponseTime;

const timerDOM = document.getElementById("timer");
// fill the bar at the beginning
progressBarValue.style.width = "100%";
console.log("Valeur de la progressBar : " + progressBarValue);


const timer = setInterval(() => {
        
        roundCountDown--;
        barWidth = updateProgressBarValue(barWidth);
        progressBarValue.style.width = `${barWidth}%`;
        console.log("Log de la valeur de barwidth : "  + barWidth);
        timerDOM.innerText = roundCountDown;
        console.log(roundCountDown);
        // if cliqué, clearInterval

    // if countDown is over    
    if (roundCountDown === 0) {
        clearInterval(timer);
        // set disabled on buttons to avoid clicking it again
        buttons.forEach(function (button) {
            button.setAttribute("disabled", true);
            // add green color as hint of correct response to show user
            if(button.textContent == correctResponse) {
                button.style.backgroundColor = "green";
            }
        })
    }
}, 1000);



// --- ProgressBar function
/**
 * add inline css to display progression of counter
 */
function updateProgressBarValue (barWidth) {
    barWidth = barWidth - 10;
    console.log("Dans la fonction : " + barWidth);
    return barWidth
    // progressBarValue.style.width = `${barWidth}%`;
}

// -----------------------------------------
//---------------------------------------------


// score calcul 
/**
 * function who update the score of the user if correct response choosen
 * @param {int} partyScore current score of the player
 * @returns score updated with the points earned in the round
 */
function updateScore (partyScore, beginingOfRound, now) {
    let responseScore = Math.round(1000 - ((now - beginingOfRound) / 10));
    partyScore += responseScore;
    return partyScore
}