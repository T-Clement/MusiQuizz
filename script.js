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



// A TESTER

// const playlist2  = {
//     name: "Années 2000",
//     songs: [
//         { Artiste: "Daft Punk", Titre: "One More Time" },
//         { Artiste: "Pep's", Titre: "Liberta" },
//         { Artiste: "U2", Titre: "Beautiful Day" },
//         { Artiste: "OutKast", Titre: "Hey Ya!" },
//         { Artiste: "Eminem", Titre: "Lose Yourself" },
//         { Artiste: "Britney Spears", Titre: "Oops!... I Did It Again" },
//         { Artiste: "Coldplay", Titre: "Clocks" },
//         { Artiste: "Nelly", Titre: "Hot in Herre" },
//         { Artiste: "Avril Lavigne", Titre: "Complicated" },
//         { Artiste: "Justin Timberlake", Titre: "Cry Me a River" },
//         { Artiste: "The White Stripes", Titre: "Seven Nation Army" },
//         { Artiste: "Beyoncé", Titre: "Crazy in Love" },
//         { Artiste: "Linkin Park", Titre: "In the End" },
//         { Artiste: "Gorillaz", Titre: "Feel Good Inc." },
//         { Artiste: "Shakira", Titre: "Whenever, Wherever" },
//         { Artiste: "Kanye West", Titre: "Stronger" },
//         { Artiste: "Nelly Furtado", Titre: "Promiscuous" },
//         { Artiste: "Maroon 5", Titre: "This Love" },
//         { Artiste: "Rihanna", Titre: "Umbrella" },
//         { Artiste: "The Killers", Titre: "Mr. Brightside" },
//         { Artiste: "Green Day", Titre: "American Idiot" }
//     ]
// }


//TEST si JSON

// const playlistJSON = JSON.stringify(playlist2);
// console.log((playlistJSON));
// const playlistDATA = JSON.parse(playlistJSON);
// console.log(`${playlistDATA.songs[0]["Artiste"]} - ${playlistDATA.songs[0]["Titre"]}`);
// const playlistDATA = JSON.parse(JSON.stringify(playlist2));
// const playlistDATASongs = playlistDATA.songs;
// console.log("TEST : " + playlistDATASongs);






//----------------------------------------------------------------------------------

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
 */
function pickSongsFromPlaylist (object, array) {
    for (let i = 0; i < 4; i++) {
        // put random index in variable
        let randomIndex = getRandomIndex(0, object.songs.length);
        // select a random song in object
        let randomSongFromObject = object.songs[randomIndex];


        // check if randomSong is already in roundChoices
            // see to write it in another way
        if (array.includes(randomSongFromObject)) {
            i--;
        } else {
            // to avoid the [ Object Object ]
            // array.push(`${randomSongFromObject.Artiste} - ${randomSongFromObject.Titre}`);
            array.push(randomSongFromObject);
        }
    }
}





// isInArray -> faire un return de i--, sinon push mais en dehors de la fonction, elle fait juste un true/false

// function checkIfInArray(array, randomSong, counter) {
//     if (array.includes(randomSong)) {
//         counter--;
//     } else {
//         array.push(randomSong)
//     }
// }


//-----------------------------------------------------------------------------------
// initialize an empty array
const roundChoices = [];

// put 4 songs in this array                        // peut-être plutôt faire 1 song choisie random où j'importe tout et ensuite 3 autrse poour du remplissage, pour limiter le nombre de requêtes
pickSongsFromPlaylist(playlist, roundChoices);
console.log(roundChoices);


// choose randomResponse 
let correctResponse = roundChoices[getRandomIndex(0, roundChoices.length - 1)];
correctResponse = Object.values(correctResponse).join(' - ');
console.log("La réponse correcte est : " + correctResponse);




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
console.log(document.querySelectorAll(".js-button-responses"));
const scorePath = document.getElementById("score");

// ----------------------------
// Put responses in buttons

const buttons = document.querySelectorAll(".js-button-responses");
buttons.forEach(function(button, index) {
    // button.innerText = `${playlist.songs[index].Artiste} - ${playlist.songs[index].Titre}`;
    // button.innerText = JSON.stringify(roundChoices[index]);
    button.innerText = Object.values(roundChoices[index]).join(' - ');
});





// ------------------------------------------------
// Add color appropriate to user response



extractResponses.addEventListener("click", function(event) {
    console.log(event, event.target);
    // trigger color change only if button clicked
    if (event.target.tagName != "BUTTON") return;
    
    // change color of button
    if (event.target.innerText != correctResponse) {
        event.target.style.backgroundColor = "red";
        console.log("TEST faux: " + document.querySelectorAll(".js-button-responses"));
    }
    else {
        event.target.style.backgroundColor = "green";
        getScore();
        console.log("TEST vrai: " + document.querySelectorAll(".js-button-responses"));
    };
    console.log(event.target.innerText);
    // disable buttons after click
    buttons.forEach(function (button) {
        button.setAttribute("disabled", true);
    })
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
        // set disabled on buttons to avoid clicking it again
        buttons.forEach(function (button) {
            button.setAttribute("disabled", true);
        })
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

