
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

// Génération des évènements
let eventsContainer = document.querySelector('#eventsContainer');
function generateEventHTML(evenement) {
  let eventDiv = document.createElement('div');
  eventDiv.classList.add('row', 'mb-5');

  let div1 = document.createElement('div');
  div1.classList.add('col');

  let img = document.createElement('img');
  img.classList.add('rounded');
  img.setAttribute('src', evenement.img_cover);
  img.setAttribute('alt', '');

  let div2 = document.createElement('div');
  div2.classList.add('col', 'd-flex', 'flex-column', 'justify-content-between');

  let div3 = document.createElement('div');
  div3.classList.add('row');

  let div4 = document.createElement('div');
  div4.classList.add('col');

  let titre = document.createElement('h3');
  titre.textContent = evenement.nom;

  let div5 = document.createElement('div');
  div5.classList.add('col');

  let date = document.createElement('p');
  date.textContent = evenement.date;

  let description = document.createElement('p');
  description.textContent = evenement.description;

  let places = document.createElement('p');
  places.textContent = evenement.nb_places;

  // Ajout des éléments dans la structure HTML
  div5.appendChild(date);
  div4.appendChild(titre);
  div3.appendChild(div4);
  div3.appendChild(div5);
  div3.appendChild(description);
  div3.appendChild(places);
  div2.appendChild(div3);
  div1.appendChild(img);
  eventDiv.appendChild(div1);
  eventDiv.appendChild(div2);
  eventsContainer.appendChild(eventDiv);
}

// Requête vers fichier PHP pour obtenir mes évènements
async function getEventData(num) {
  try {
    let response = await fetch('functions/eventAlphabeticalOrder.php?ao=' + num);
    let data = await response.json();
    return data;
  } catch (error) {
    console.error(error);
  }
}

// Ecoute du choix fait sur le menu déroulant, le switch dépend de la valeur de e.target.value
let selectDate = document.querySelector('#selectDate');
let evenements;
let eventData;
selectDate.addEventListener('change', async e => {
  eventsContainer.innerHTML = "";
  let order = e.target.value;
  switch (order) {
    case '1':
      evenements = JSON.parse(JSON.stringify(await getEventData(1), null, 2));
      break;
    case '2':
      evenements = JSON.parse(JSON.stringify(await getEventData(2), null, 2));
      break;
    default:
      console.log('Abonbadakor');
  }
  for (let i = 0; i < evenements.length; i++) {
    let evenement = evenements[i];
    generateEventHTML(evenement);
  }
});
