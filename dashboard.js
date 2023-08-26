const deleteUserBtn = document.querySelector(".js-delete-account");
const idUser = document.querySelector(".js-delete-id-user").value;


deleteUserBtn.addEventListener("click", function (event) {
    event.preventDefault();
    console.log(deleteUserBtn);
    console.log(idUser);

    deleteUserData(idUser).then((apiResponse) => {
        if (!apiResponse.result) {
            console.error("Problème rencontré, le json renvoit false");
            return;
        }

        console.log(apiResponse.result);
        console.log(apiResponse.msg);
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