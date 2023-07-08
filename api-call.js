 

//get the room id value in url
url = new URL(window.location.href);
const roomId = url.searchParams.get("room");
// console.log(roomId);

if (url.searchParams.has("room")) {
    getDATAS(roomId).then((apiResponse) => {
        if (!apiResponse.result) {
            console.error("Problème rencontré, le json renvoit false");
            return;
        }

        console.log(apiResponse);
        // return apiResponse;
        localStorage.setItem("playlistDATAJSON", JSON.stringify(apiResponse));
    });
}

function getDATAS(idRoom) {
    const data = {
        action: "select",
        idRoom: idRoom,
    };
    // why GET is not working ?
    // alternative -> the infos in the api.php url such as for example :
    // let url = "api.php?action=select&idRoom=" + encodeURIComponent(data.idRoom);
    // and fetch this url with no body because it's a GET method
    return callAPI("POST", data);
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