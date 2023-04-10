
let eventBtns = document.querySelectorAll('.trashEvent');
let placeBtns = document.querySelectorAll('.trashPlace');
let deleteContentBtn = document.querySelector('#deleteContentBtn');
let modalTitle1 = document.querySelector('.modalTitle1');
let modalText1 = document.querySelector('.modalText1');

let userByEventBtns = document.querySelectorAll('.userByEvent');
let modalTitle2 = document.querySelector('.modalTitle2');
let modalBody2 = document.querySelector('.modal-body2');

for (let eventBtn of eventBtns) {
  eventBtn.addEventListener("click", function () {
    deleteContentBtn.href = "./deleteEvent.php?id=" + eventBtn.dataset.id;
    modalTitle1.textContent = "Supprimer l'évènement " + eventBtn.dataset.id + " ?";
    modalText1.textContent = "L'évènement sera perdu.";
  });
}

for (let placeBtn of placeBtns) {
  placeBtn.addEventListener("click", function () {
    deleteContentBtn.href = "./deletePlace.php?id=" + placeBtn.dataset.id;
    modalTitle1.textContent = "Supprimer le lieu " + placeBtn.dataset.id + " ?";
    modalText1.textContent = "Le lieu sera perdu.";
  });
}

for (let userByEventBtn of userByEventBtns) {
  userByEventBtn.addEventListener("click", function () {
    modalTitle2.textContent = "Utilisateurs inscrits à l'évènement " + userByEventBtn.dataset.id;

    fetch('userByEvent.php?idEvent=' + userByEventBtn.dataset.id) // envoie une requête GET avec l'id de l'événement
      .then(response => response.text())
      .then(data => {
        modalBody2.innerHTML = data; // affiche les utilisateurs dans un élément HTML
      });
  });
}