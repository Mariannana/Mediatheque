const booksElement = document.querySelector(".books")
const searchBar = document.querySelector(".search_bar")

let allBooksInStore = null;

getAllBooksFromJSON();
// setTimeout(()=>{
// },300);


searchButton.addEventListener("click", onSearch)

function onSearch() {
    let filtredArray = filterBooks(allBooksInStore, searchBar.value);
    displayBooks(filtredArray);
}

function getAllBooksFromJSON() {
    fetch("books.json")
    .then((response)=>{
        return response.json();
    })
    .then((books)=>{
        console.log(books);
        allBooksInStore = books;
        displayBooks(allBooksInStore);
    });
}

function filterBooks(books, toSearch) {
    toSearch = toSearch.toLowerCase();
    return books.filter(book => book.auteur.toLowerCase().includes(toSearch) || book.titre.toLowerCase().includes(toSearch));
}

function filterBooksById(books, id) {
    return books.filter(book => book.id === id)
}


function displayBooks(books) {
    let gridInnerHTML = "";
    books.forEach(book => {
        gridInnerHTML += `
            <div id=${book.id} class="allBooks">
                <br>
                <h2>${book.titre}</h2>
                <br>
                <p>${book.auteur}</p>
                <img id="img" src=${book.image} alt=${book.titre}>
            </div>
        `;
    });
    booksElement.innerHTML = gridInnerHTML;
}


booksElement.addEventListener("click", displayOnebook)
function displayOnebook(event){
    //console.log(event);
    let bookElt = event.target.closest(".allBooks");
    let id;
    if (bookElt) id = bookElt.id;
    else return;
    console.log(id);
    let book = filterBooksById(allBooksInStore, parseInt(id))[0];
    console.log(book);
    let otherinnerHTML = "";
        otherinnerHTML += `
        <div>
        <h2>${book.titre}</h2>
        <br>
        <h3>Auteur:</h3><p> ${book.auteur}</p>
        <h3>Date de parution:</h3><p> ${book.annee}</p>
        <br> 
        <h3> En bref:</h3><p> ${book.resume}</p>
        <br>
        <img id="img" src=${book.image} alt=${book.titre}>
        <br>
        <button class ="buttonResa" href"form.php">Réservez-moi!</button>
        </div>
        ` ;
    let detail = document.querySelector(".detail");
    console.log(detail);
    detail.innerHTML = otherinnerHTML;




    const reservation = document.querySelector(".buttonResa")

    reservation.addEventListener("click", displayForm)
    
    function displayForm(){
        let forminnerHTML = ""; 
        forminnerHTML += `
        <form id="formReservation" method="post" enctype="multipart/form-data">
            <label for="nom">Nom :</label>    
            <input type="text" name="nom" id="nom">
            <br> 
            <label for="prenom">Prénom :</label>    
            <input type="text" name="prenom" id="prenom">
            <br>      
            <label for="mail">Email :</label> 
            <input type="text" name="mail" id="mail">
            <br>       
            <button type="submit" name="submit">Go réserver !</button>
        </form>
        ` ;
                        
       let formContainer = document.querySelector(".form");
       formContainer.innerHTML = forminnerHTML;
    //     /////////////////////////////////////////////////////

    //     // Intercepter la soumission du formulaire
        const reservationForm = document.getElementById("formReservation");
        console.log(reservationForm);
        const buttonFormulaire = reservationForm.querySelector("button");

         reservationForm.addEventListener("submit", function(event) {
             event.preventDefault(); // Empêcher la soumission du formulaire

             const formData = new FormData(reservationForm);
             formData.append("id_livre", "2")  // Récupérer les données du formulaire
             formData.append("submit", "");
             console.log([...formData.entries()]);

      //        Envoyer les données à un fichier PHP 
             fetch("http://localhost/TP_Mediatheque/addreservation.php", {
                 method: 'POST',
                 body: formData
             })
             .then(response => {
                 console.log(response);
                 return response.json();
    //              Traiter la réponse si nécessaire
             })
             .then(data=>{
                console.log(data);
             })
             .catch(error => {
                 console.error(error);
             });
         });
        }
    }



            







