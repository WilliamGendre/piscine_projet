// on récupère tous les faux boutons
const deleteButtons = document.querySelectorAll('.falseDelete');

// Pour chaque bouton récupérer
deleteButtons.forEach((deleteButton => {
        // On créer un évènement (ici se sera un clique)
        deleteButton.addEventListener('click', () =>{
            // lorsque l'on clique sûr les faux boutons, le vrai bouton de suppression
            // apparaitra dans une fenètre popup qui été jusque là caché avec un "display: none"
            const popup = deleteButton.nextElementSibling;
            popup.style.display = 'block';
        })
    }
))



let burgerHeader = document.querySelector('#menuBurgerHeader');
let menuHeader = document.querySelector('#navMenu');
let profil = document.querySelector('#profil');
let connexion=document.querySelector('#userconnexion');

burgerHeader.addEventListener('click', ()=>{
    menuHeader.classList.toggle('active');
})

profil.addEventListener('click', ()=>{
    connexion.classList.toggle('active');
})

let burgerFooter = document.querySelector('#menuBurgerFooter');
let menuFooter = document.querySelector('#menuFooter');

burgerFooter.addEventListener('click', ()=>{
    menuFooter.classList.toggle('active');
})