let playlistDATA;
let partyScore = 0;
let userBestScore = 0;
const musicPlayer = document.querySelector(".js-musicplayer");
const userId = document.querySelector(".js-game-data").dataset.idUser;
const tokenDom = document.querySelector(".js-game-data").dataset.token;
// const partyData = [{artist: "Truc", track: "bidule", points: 900}];
const partyData = [];
const songsPlayed = [];
//get the room id value in url
url = new URL(window.location.href);
const roomId = url.searchParams.get("room");

// get datas of room in JSON and store it in playlistDATA
// structure :
// - result
// - datas : Object {playlistName, tracks :{[artist, track, preview]}} -> each track is in an array in tracks
if (url.searchParams.has("room")) {
  getDATAS(roomId, userId).then((apiResponse) => {
    if (!apiResponse.result) {
      console.error("Problème rencontré, le json renvoit false");
      return;
    }

    // console.log(apiResponse);
    playlistDATA = apiResponse;
    userBestScore = apiResponse["bestscore"]["bestscore"];

    continueExecution();
  });
}


//getUserBestScore(roomId, userId).then((apiResponseScore) => {
//   if(!apiResponseScore.result) {
//     console.error("Problème rencontré, le json renvoit false");
//     return;
//   }
// }); 

/**
 * This fonction pass a JS object to async function callAPI to get data of the room
 * @param {int} roomId
 * @returns call to api.php to get datas fril
 */
function getDATAS(roomId, userId) {
  const data = {
    action: "select",
    idRoom: roomId,
    idUser: userId
  };
  // why GET is not working ?
  // alternative -> the infos in the api.php url such as for example :
  // let url = "api.php?action=select&idRoom=" + encodeURIComponent(data.idRoom);
  // and fetch this url with no body because it's a GET method
  return callAPI("POST", data);
}

/**
 *
 * @param {int} partyScore - score of the party
 * @param {int} roomId - id from the room in database
 * @returns
 */
function sendGameDataToDatabase(partyScore, roomId, userId) {
  const data = {
    action: "insertScore",
    idRoom: roomId,
    idUser: userId,
    token: tokenDom,
    score: partyScore,
  };
  return callAPI("POST", data);
}



/**
 * This async function takes an HTTP method and a JS Object who is transform in JSON to pass and
 * communicate with api.php page
 * @param {HTTP method} method - HTTP method to pass in api.php
 * @param {Object} data - JS object with the datas
 * @returns - return Promise, need to do a .then() after with response
 */
async function callAPI(method, data) {
  try {
    const response = await fetch("api.php", {
      method: method,
      headers: {
        "Content-type": "application/json",
      },
      body: JSON.stringify(data),
    });
    return response.json();
  } catch (error) {
    console.error("Unable to load datas from the server : " + error);
  }
}

// ------------------------------------------------------------------------------------------------
// ------------------------------------------------------------------------------------------------
//---------------------main function ------------------------------------------------
function continueExecution() {
  // ------------------------------
  // game parameters
  // to use for the game loop and transitions
  const rounds = 2; // number of rounds of game
  const roundDuration = 5; // duration of round
  const waitBetweenRound = 5; // waiting duration between rounds
  // ------------------------------

  // let arrayOfSongs = [];
  let currentRound = 1;

  loadPlaylistTitleInPage();

  // handle all the logic of the game
  // exit function when last round is played
  runRound();

  function runRound() {
    if (currentRound <= rounds) {
      let roundChoices = pickSongsFromJSON(playlistDATA.datas);
    //   console.log(roundChoices);

      // choose randomResponse
      let correctResponse = roundChoices[getRandomIndex(0, roundChoices.length)];
      songsPlayed.push(correctResponse);


      // put response in string to compare it
      let correctResponseInString = correctResponse.artist + " - " + correctResponse.track;
      console.log("%c" + correctResponseInString, "background-color:green; color:white; font-weight: 900");

      displayRoundInfo(currentRound, rounds);
      displayRoundChoices(roundChoices);

      // put in audio src the preview link
      musicPlayer.src = correctResponse.preview;
      musicPlayer.play();

      //
      let beginingOfRound = Date.now();
      handleUserResponse(correctResponseInString, beginingOfRound);

      let roundCountDown = roundDuration;

      // style of progressBar
      const progressBarValue = document.querySelector(".js-progress-value");
      let barWidth = 100;
      progressBarValue.style.width = `${barWidth}%`;

      const timerDOM = document.getElementById("timer");
      const buttons = document.querySelectorAll(".js-button-responses");

      const timer = setInterval(() => {
        roundCountDown--;
        barWidth = updateProgressBarValue(barWidth);
        progressBarValue.style.width = `${barWidth}%`;
        // console.log("Log de la valeur de barwidth : "  + barWidth);
        timerDOM.innerText = roundCountDown;
        // console.log(roundCountDown);

        // if countDown is over, set buttons disable state and display correctResponse
        if (roundCountDown === 0) {
          clearInterval(timer);
          // set disabled on buttons to avoid clicking it again
          disableButtons(buttons);
          showCorrectResponse(buttons, correctResponseInString);

          // waiting time before next round
          setTimeout(() => {
            resetRound();
            currentRound++;
            runRound();
          }, waitBetweenRound * 1000);
        }
      }, 1000);
    } else {
      // return
    //   alert("Partie Terminée");
    //   console.warn(songsPlayed);
    musicPlayer.pause();
      sendGameDataToDatabase(partyScore, roomId, userId);
      // encore une promesse qui récupère tous les scores de tout le monde
      // comparer le meilleur score de l'utilisateur dans cette partie avec celui qu'il a maintenant -> "nouveau meilleur score"
      // ranking with only the best score of each user in te room
      const elementsToRemove = document.querySelectorAll(".section-player, .js-list");
        elementsToRemove.forEach((element) => {
        // console.log(element + "supprimé");
        element.remove();
      });
      const modal = document.querySelector(".js-modal");
      const p = document.createElement("p");
      p.classList.add("modal");
      p.innerHTML = "Partie terminée, merci d'avoir joué !";
      modal.appendChild(p);
      
      setTimeout(() => {
        
        modal.remove();
        displayListOfSongs(songsPlayed);
        displayRanking();
        setupTabButtons();
        
      }, 3000);
      
      // *********************************************************************************
      // ***************************** FONCTION PRINCIPALE *******************************
      // *********************************************************************************





      // Remove the current elements of the page to display the templates


      // const elementsToRemove = document.querySelectorAll(".section-player, .js-list");
      // elementsToRemove.forEach((element) => {
      //   // console.log(element + "supprimé");
      //   element.remove();
      // });
      //---------------------------------------

      const templateGameDataPlayer = document.getElementById("datas-player-game");
      const clone = templateGameDataPlayer.content.cloneNode(true);

      clone.querySelector(".party-score").textContent = partyScore;

      const containerDataPlayer = document.querySelector(".container");

      const bestScore = clone.querySelector(".party-bestscore");
    //   console.log(bestScore);
      bestScore.textContent = "Ton meilleur score: " + userBestScore;

      containerDataPlayer.appendChild(clone);

      //-----------------------------------------
      //-----------------------------------------
      //-----------------------------------------

      const rankingTemplate = document.getElementById("datas-ranking");
      const cloneRanking = rankingTemplate.content.cloneNode(true);

      const rankingList = cloneRanking.querySelector(".ranking-list");

      async function displayRanking() {
        // console.warn("getRanking");
        try {
          const rankingFromDatabase = await getRoomRanking(roomId, tokenDom);

          function getRoomRanking(roomId, tokenDom) {
            datas = {
              action: "getRanking",
              idRoom: roomId,
              token: tokenDom,
            };
            return callAPI("POST", datas);
          }


          rankingFromDatabase.ranking.forEach((player, index) => {
            const li = document.createElement("li");
            li.classList.add("ranking-list-item");
            li.innerHTML = `
                <div class="rank">
                <span> ${index + 1} |</span>
                <span>${player.pseudo_user}</span>
                </div>
                <span>${player.score_max}pts</span>
                `;
            rankingList.appendChild(li);
          });

          containerDataPlayer.appendChild(cloneRanking);
        } catch (error) {
          console.error(error);
        }
      }

      const songListTemplate = document.getElementById("datas-songlist");
      const cloneSongList = songListTemplate.content.cloneNode(true);
      const songList = cloneSongList.querySelector('.song-list');
      function displayListOfSongs(songsPlayed) {
        songsPlayed.forEach(song => {
            const li = document.createElement("li");
            li.classList.add("song-list-item")
            li.innerHTML = `
            <div class="song-data">
                <span class="song-artist">${song.artist}</span>
                <span class="song-track">${song.track}</span>
            </div>
            <span class="song-points js-points-earned">350 pts</span>
            `;
            songList.appendChild(li);
            containerDataPlayer.appendChild(cloneSongList);

        })
      }
      // displayListOfSongs(songsPlayed);
      // displayRanking();
      // setupTabButtons();

      // function to setup toggle of tabs
      function setupTabButtons() {
        const tabButtons = document.querySelectorAll(".js-display-btn");
        // console.log(tabButtons);

        const tabs = document.querySelectorAll(".js-tab-display");
        // console.log(tabs);

        tabButtons.forEach(function (tabButton) {
          tabButton.addEventListener("click", function () {
            // console.log(this);

            // target the form linked to button clicked
            const tabToActivate = document.querySelector("[data-tab-content=" + this.dataset.btn + "]");
            // console.log(tabToActivate);
            // if (!tabToActivate) return; // Sortir de la fonction si l'élément n'existe pas

            // if wanted form already has active class, do nothing
            if (tabToActivate.classList.contains("active")) return;

            // remove .active / displaying to current active form
            const activeTab = document.querySelector(".js-tab-display.active");
            if (activeTab) {
              activeTab.classList.remove("active");
            }

            // active the form linked to btn clicked
            tabToActivate.classList.add("active");

            // change btn active of btns
            tabButtons.forEach(function (btn) {
              // toggle btn-active if btn === button, else remove the class to the others buttons
              btn.classList.toggle("btn-active", btn === tabButton);
            });
          });
        });
      }

      // call the function to initialize event listeners after template add
      setupTabButtons();
    }
  }


  /**
   * This function reset the choices array and the state of the buttons
   */
  function resetRound() {
    // console.log("entrée dans le reset");
    roundChoices = [];
    // console.log(roundChoices);
    // document.querySelector('body').style.backgroundColor = "black";
    const buttons = document.querySelectorAll(".js-button-responses");
    buttons.forEach(function (button) {
      button.style.backgroundColor = ""; // Réinitialiser la couleur du bouton
      button.removeAttribute("disabled"); // Réactiver les boutons
    });
  }

  //------------------------------------------------------------------
  //------------------------------------------------------------------
  //------------------------------------------------------------------
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
  function getRandomIndex(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
  }

  /**
   * This function use a random index to run through the playlist and select 4 randoms songs and push in a new array
   * @param {object} object - full data of playlist
   * @return {array} - return array with 4 picked songs
   */
  function pickSongsFromJSON(object) {
    let arrayOfSongs = [];
    for (let i = 0; i < 4; i++) {
      // put random index in variable
      let randomIndex = getRandomIndex(0, object.tracks.length);
      // select a random song in object
      let randomSongFromObject = object.tracks[randomIndex];
      // check if randomSong is already in array
      if (arrayOfSongs.includes(randomSongFromObject)) {
        i--;
      } else {
        // to avoid the [ Object Object ]
        arrayOfSongs.push(randomSongFromObject);
      }
    }
    return arrayOfSongs;
  }

  /**
   * This function replace in DOM the playlist name
   */
  function loadPlaylistTitleInPage() {
    document.querySelector(".js-playlist-name").innerText =
      playlistDATA.datas.playlistName;
  }

  /**
   * This function replace in DOM the current round number and the number of round of the game
   * @param {int} currentRound
   * @param {int} rounds
   */
  function displayRoundInfo(currentRound, rounds) {
    const currentRoundDOM = document.querySelector(".current-round");
    const totalRoundDOM = document.querySelector(".total-round");
    currentRoundDOM.innerText = currentRound;
    totalRoundDOM.innerText = rounds;
  }
  /**
   *
   * @param {array} roundChoices
   */
  function displayRoundChoices(roundChoices) {
    const buttons = document.querySelectorAll(".js-button-responses");
    buttons.forEach(function (button, index) {
      button.innerText = `${roundChoices[index]["artist"]} - ${roundChoices[index]["track"]}`;
    });
  }

  /**
   * This function get the user response, call update score if correct response is choosen
   * If wrong answer, buttons are disabled and correct answer is shown after and of timer
   * @param {string} correctResponseInString -
   * @param {Date} beginingOfRound - Date.now() of the moment where round begin
   */
  function handleUserResponse(correctResponseInString, beginingOfRound) {


    //---------------------------
    //---------------------------
    // document.addEventListener("keydown", handleKeyPress);

    // /**
    //  * 
    //  * @param {*} event 
    //  */
    // function handleKeyPress(event) {
    //   const key = event.key;
    //   const button = document.querySelector(`[data-key="${key}]`);

    //   // if key correspond to 1, 2, 3 or 4 and button exist, fire click on button
    //   if(["1", "2", "3", "4"].includes(key) && button) {
    //     // button.click();
    //     handleResponse(button);
    //   }
    // }

    //----------------------------
    //----------------------------
    
    const buttons = document.querySelectorAll(".js-button-responses");
    const extractResponses = document.querySelector(".list");
    const userChoice = [];
    const scorePath = document.getElementById("score");

    extractResponses.addEventListener("click", function (event) {
    //   console.log(event, event.target);
    
    // trigger color change only if button clicked
    if (event.target.tagName != "BUTTON") return;



      // put button innerText in userChoice
      userChoice.push(event.target.innerText);


      // change color of button
      if (event.target.innerText != correctResponseInString) {
        event.target.style.backgroundColor = "red";
      } else {
        event.target.style.backgroundColor = "green";
        let now = Date.now();
        partyScore = updateScore(partyScore, beginingOfRound, now, roundDuration);
        scorePath.textContent = partyScore;
      }
      // disable buttons after click
      disableButtons(buttons);
    });
  }

  /**
   * This function disable all the buttons when a response is choosen by the user
   * @param {*} buttons
   */
  function disableButtons(buttons) {
    buttons.forEach(function (button) {
      button.setAttribute("disabled", true);
    });
  }

  /**
   * This function show the correct response by adding green background to the button with the correct answer
   * @param {*} buttons
   * @param {string} correctResponseInString
   */
  function showCorrectResponse(buttons, correctResponseInString) {
    buttons.forEach(function (button) {
      if (button.textContent == correctResponseInString) {
        button.style.backgroundColor = "green";
      }
    });
  }

  // --- ProgressBar function
  /**
   * add inline css to display progression of counter
   */
  function updateProgressBarValue(barWidth) {
    barWidth = barWidth - 10;
    // console.log("UpdateProgress bar fonction : " + barWidth);
    return barWidth;
    // progressBarValue.style.width = `${barWidth}%`;
  }

  /**
   * function who update the score of the user if correct response choosen
   * @param {int} partyScore current score of the player
   * @returns score updated with the points earned in the round
   */
  function updateScore(partyScore, beginingOfRound, now, roundDuration) {
    const maxResponseScore = 1500;
    const timeTaken = now - beginingOfRound;
    console.warn("Temps de réponse: " + timeTaken);
    let responseScore = Math.floor(maxResponseScore - (timeTaken / roundDuration));
    console.error(responseScore);
    console.log("Temps de réponse : " + timeTaken/1000);
    responseScore = Math.max(responseScore, 0);
    partyScore += responseScore;
    return partyScore;
  }
}
