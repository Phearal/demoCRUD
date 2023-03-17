let eventBtns = document.querySelectorAll('.trashEvent');
let placeBtns = document.querySelectorAll('.trashPlace');

let deleteContentBtn = document.querySelector('#deleteContentBtn');
let modalTitle = document.querySelector('.modalTitle');
let modalText = document.querySelector('.modalText');

for(let eventBtn of eventBtns){
  eventBtn.addEventListener("click", function(){
    deleteContentBtn.href = "./deleteEvent.php?id=" + eventBtn.dataset.id;
    modalTitle.textContent = "Supprimer l'évènement ?";
    modalText.textContent = "L'évènement sera perdu.";
  });
}

for(let placeBtn of placeBtns){
  placeBtn.addEventListener("click", function(){
    deleteContentBtn.href = "./deletePlace.php?id=" + placeBtn.dataset.id;
    modalTitle.textContent = "Supprimer le lieu ?";
    modalText.textContent = "Le lieu sera perdu.";
  });
}
