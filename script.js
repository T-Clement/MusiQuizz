// playlist data
const playlist = {
    name: "Années 2000",
    songs: [
        { Artiste: "Daft Punk", Titre: "One More Time" },
        { Artiste: "Pep's", Titre: "Liberta" },
        { Artiste: "U2", Titre: "Beautiful Day" },
        { Artiste: "OutKast", Titre: "Hey Ya!" },
        { Artiste: "Eminem", Titre: "Lose Yourself" },
        { Artiste: "Britney Spears", Titre: "Oops!... I Did It Again" },
        { Artiste: "Coldplay", Titre: "Clocks" },
        { Artiste: "Nelly", Titre: "Hot in Herre" },
        { Artiste: "Avril Lavigne", Titre: "Complicated" },
        { Artiste: "Justin Timberlake", Titre: "Cry Me a River" },
        { Artiste: "The White Stripes", Titre: "Seven Nation Army" },
        { Artiste: "Beyoncé", Titre: "Crazy in Love" },
        { Artiste: "Linkin Park", Titre: "In the End" },
        { Artiste: "Gorillaz", Titre: "Feel Good Inc." },
        { Artiste: "Shakira", Titre: "Whenever, Wherever" },
        { Artiste: "Kanye West", Titre: "Stronger" },
        { Artiste: "Nelly Furtado", Titre: "Promiscuous" },
        { Artiste: "Maroon 5", Titre: "This Love" },
        { Artiste: "Rihanna", Titre: "Umbrella" },
        { Artiste: "The Killers", Titre: "Mr. Brightside" },
        { Artiste: "Green Day", Titre: "American Idiot" }
    ]
}

/**
 * This function generate a random number between 2 parameters. 
 * The min and max are included as possible values.
 * 
 * @param {number} min 
 * @param {number} max 
 * 
 * @return - return a random index between 0 and the length of the array
 */
function getRandomIndex (min, max) {
    return  Math.floor(Math.random() * (max - min + 1)) + min;
}


/**
 * This function use a random index to run through the playlist and select 4 randoms songs and push in a new array
 * @param {object} object - the pl 
 */
function pickSongsFromPlaylist (object) {
    for (let i = 0; i < 4; i++) {
        let randomIndex = getRandomIndex(0, object.songs.length);
        roundChoices.push(object.songs[randomIndex]);
    }
}

// initialize an empty array
const roundChoices = [];
// put 4 songs in this array
pickSongsFromPlaylist(playlist);
console.log(roundChoices);




//-----------------------------------------------------------------------//



// doit être en asynchrone pour obliger l'import avant de charger les autres scripts
// import playlist from "./json";



// async function importPlaylist() {
//     try {
//         const playlistJSON = await import('./json.js');
//         const playlist = JSON.parse(playlistJSON.default);
//         // document.querySelector(".js-playlist-name").innerText = playlist.name;
//         return playlist
//         // console.log(playlist);
//     } catch (error) {
//         console.error("Une erreur s'est produite lors du chargement: ", error);
//     }
// }

// const playlist = importPlaylist();
// console.log(playlist);




//-------------------------------------------------------------------//





document.querySelector(".js-playlist-name").innerText = playlist.name;

// console.log(playlist);
// console.log(playlist.songs);
        
        
        
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
// fill the bar at the beginning
progressBarValue.style.width = "100%";
const timer = setInterval(() => {
    
        timerCounter--;
        displayProgressBar();
        timerDOM.innerText = timerCounter;
        console.log(timerCounter);
    
    if (timerCounter === 0) {
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

