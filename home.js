const token = document.querySelector("[data-token]").dataset.token;
console.log(token);

fetch('save_token.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: 'token=' + encodeURIComponent(token)
})
.then(response => {
    window.location.href = "game.php";
})
.catch(error => {
    console.error("Erreur lors de l'envoi du token : ", error);
})