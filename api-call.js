// mutualiser ID room et ID playlist ? Ou pas car si ID playlist bouge / supprime, tout est cassé.
const playlistID = "1306931615";
const urlAPI = "https://api.deezer.com/playlist/" + playlistID;


async function waitingForResponse() {
    try {
    const response = await fetch(urlAPI);
    const playlistDATA = await response.json();
    console.table(playlistDATA);
    } catch(error) {
    console.error("Unable to load playlist data from API : " + error);
    }
}


waitingForResponse();
// ne marche pas parce que la requête est faite dans le navigateur, côté serveur avec PHP c'est OK





// For example, URLSearchParams.get() will return the first value associated with the given search parameter:

// const product = urlParams.get('product')
// console.log(product);
// // shirt
