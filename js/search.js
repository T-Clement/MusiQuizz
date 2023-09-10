const table = document.querySelector(".js-search-table");
const search = document.querySelector('.js-search');


// beginning -> all infos, if input -> request with input, if return to empty input-> return of all infos 










search.addEventListener("keyup", async function(e) {
    console.log(e.target.value);
    const response = await callAPI("POST", {
        action: 'search',
        request: e.target.value
    });
    console.table(response.datas);
    table.innerHTML = response;
});



console.log(table);





// const 


const tbody = document.createElement("tbody");









async function callAPI(method, data) {
    try {
        const response = await fetch("actions/search.php", {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        return response.json();

    }
    catch (error) {
        console.error('error')
    }
}