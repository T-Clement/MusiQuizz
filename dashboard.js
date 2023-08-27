const deleteUserBtn = document.querySelector(".js-delete-account");
const idUser = document.querySelector(".js-delete-id-user").value;


deleteUserBtn.addEventListener("click", function (event) {
    event.preventDefault();
    console.log(deleteUserBtn);
    console.log(idUser);
    if(!(confirm('Cette suppression est définitive et sans retour en arrière possible. Cliquez sur OK pour continuer'))) return;

    deleteUserData(idUser).then((apiResponse) => {
        if (!apiResponse.result) {
            console.error("Problème rencontré, le json renvoit false");
            return;
        }
        // console.log(apiResponse.result);
        // console.log(apiResponse.msg);
        alert(apiResponse.msg);

        // use of replace to not allow going back to history, it's not possible 
        //when clicking on navigator back button to going back to that page
        window.location.replace("./index.php");
    });
});

function deleteUserData(userId) {
    const data = {
      action: "deleteUserDatas",
      idUser: userId,
    //   token: tokenDom,
      
    };
    return callAPI("POST", data);
  }


async function callAPI(method, data) {
    try {
      const response = await fetch("actions/delete-account.php", {
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