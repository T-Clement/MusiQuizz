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