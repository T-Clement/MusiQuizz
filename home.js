// console.log("coucou");
// const anchors = document.querySelectorAll('.js-anchor');
// console.log(anchors);
// anchors.forEach((anchor) => {
//     anchor.addEventListener("click", (e) => {
//         console.log(e.target.dataset.id);
//     })
// })
const anchorsImg = document.querySelectorAll('.js-img');
// console.log(anchorsImg);
anchorsImg.forEach((anchorImg) => {
    anchorImg.addEventListener("click", (e) => {
        const a = e.target.parentElement;
        console.log(a.dataset.id);
        getDATAS(a.dataset.id)
            .then((apiResponse) => {
                if(!apiResponse.result) {
                    console.error('Problème rencontré, le json renvoit false');
                    return;
                }

                console.log(apiResponse);
                localStorage.setItem('playlistDATAJSON', JSON.stringify(apiResponse));
                window.location.href = `index.php?room=${a.dataset.id}`;
            })
    })
})



function getDATAS(idRoom) {
    const data = {
        action: 'select',
        idRoom: idRoom
    }
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
    } catch(error) {
        console.error("Unable to load datas from the server : " + error);
    }
}