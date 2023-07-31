

//---------------------------------------
//---------------------------------------
//---------------------------------------

// Remove the current elements of the page to display the templates

const elementsToRemove = document.querySelectorAll(".section-player, .js-list");
elementsToRemove.forEach((element) => {
  console.log(element + "supprimé");
  element.remove();
});
//---------------------------------------

const templateGameDataPlayer = document.getElementById("datas-player-game");
const clone = templateGameDataPlayer.content.cloneNode(true);

clone.querySelector(".party-score").textContent = 7000;

const containerDataPlayer = document.querySelector(".container");

const bestScore = clone.querySelector(".party-bestscore");
console.log(bestScore);
bestScore.textContent = "Ton meilleur score: " + 8000;

containerDataPlayer.appendChild(clone);

//-----------------------------------------
//-----------------------------------------
//-----------------------------------------

const rankingTemplate = document.getElementById("datas-ranking");
const cloneRanking = rankingTemplate.content.cloneNode(true);

const rankingList = cloneRanking.querySelector(".ranking-list");
// const rankin

url = new URL(window.location.href);
const roomIdForRanking = url.searchParams.get("room");
async function displayRanking() {
  console.warn("getRanking");
  try {
    const rankingFromDatabase = await getRoomRanking(
      roomIdForRanking,
      tokenDom
    );

    console.log(rankingFromDatabase.ranking);
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

// console.warn("getRanking");
// const rankingFromDatabase = getRoomRanking(roomIdForRanking, tokenDom).then(apiResponse => {
//     console.warn(apiResponse);
// });
// console.warn(rankingFromDatabase);

function getRoomRanking(roomIdForRanking, tokenDom) {
  datas = {
    action: "getRanking",
    idRoom: roomIdForRanking,
    token: tokenDom,
  };
  return callAPI("POST", datas);
}

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
displayRanking();









// const tabButtons = document.querySelectorAll(".js-display-btn");
// console.log(tabButtons);

// const tabs = document.querySelectorAll(".js-tab-display");
// console.log(tabs);

// tabButtons.forEach(function (button) {
//   button.addEventListener("click", function () {
//     console.log(this);

//     // target the form linked to button clicked
//     const tabToActivate = document.querySelector(
//       "[data-tab-content=" + this.dataset.btn + "]"
//     );

//     // if wanted form already has active class, do nothing
//     if (tabToActivate.classList.contains("active")) return;

//     // remove .active / displaying to current active form
//     const activeTab = document.querySelector(".js-tab-display.active");
//     if (activeTab) {
//       activeTab.classList.remove("active");
//     }

//     // active the form linked to btn clicked
//     tabToActivate.classList.add("active");

//     // change btn active of btns
//     tabButtons.forEach(function (btn) {
//       // toggle btn-active if btn === button, else remove the class to the others buttons
//       btn.classList.toggle("btn-active", btn === button);
//     });
//   });
// });



// ... Le code de clonage des templates et d'ajout des éléments ...

// Fonction pour gérer le toggle des onglets
function setupTabButtons() {
    const tabButtons = document.querySelectorAll(".js-display-btn");
    console.log(tabButtons);
  
    const tabs = document.querySelectorAll(".js-tab-display");
    console.log(tabs);
  
    tabButtons.forEach(function (button) {
      button.addEventListener("click", function () {
        console.log(this);
  
        // target the form linked to button clicked
        const tabToActivate = document.querySelector(
          "[data-tab-content=" + this.dataset.btn + "]"
        );
  
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
          btn.classList.toggle("btn-active", btn === button);
        });
      });
    });
  }
  
  // Appeler la fonction pour initialiser les écouteurs d'événements après le clonage des templates
  setupTabButtons();
  