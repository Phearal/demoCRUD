// Initialisation des variables
let selectDate = document.querySelector('#selectDate');
let selectAO = document.querySelector('#selectAO');
let evenements;
let eventData;

const searchbtn = document.querySelector('#searchBtn');
const searchBar = document.querySelector('#searchBar');

let eventsContainer = document.querySelector('#eventsContainer');

// Génération des évènements
function generateEventHTML(evenement) {
  let eventDiv = document.createElement('div');
  eventDiv.classList.add('row', 'mb-5', 'event');

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
  date.textContent = "Date : " + evenement.date;

  let description = document.createElement('p');
  description.textContent = evenement.description;

  let places = document.createElement('p');
  places.textContent = "Nombre de places : " + evenement.nb_places;

  let div6 = document.createElement('div');
  div6.classList.add('justify-content-between');

  let aDetails = document.createElement('a');
  aDetails.textContent = "Voir en détail";
  aDetails.classList.add('btn', 'btn-secondary');
  aDetails.role = "button";
  aDetails.href = "detailsEvenement.php?id=" + evenement.id_evenement;

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
  div6.appendChild(aDetails);
  div2.appendChild(div6);
  eventsContainer.appendChild(eventDiv);
}

// Requête vers fichier PHP pour obtenir mes évènements, le switch permet de savoir si on requête par ordre alphabétique ou par date
let response;
let data;
async function getEventData(num, filterType) {
  eventsContainer.innerHTML = "";

  if (!isNaN(num)) {

    switch (filterType) {
      case 'ao':
        selectDate.value = '-- Choisir --';
        response = await fetch('functions/eventAlphabeticalOrder.php?ao=' + num);
        data = await response.json();
        break;
      case 'date':
        selectAO.value = '-- Choisir --';
        response = await fetch('functions/eventDateOrder.php?date=' + num);
        data = await response.json();
        break;
    }

    evenements = JSON.parse(JSON.stringify(data));

    for (let i = 0; i < evenements.length; i++) {
      let evenement = evenements[i];
      generateEventHTML(evenement);
    }

    keyWordFilter(new MouseEvent('click'));
    
  } else {
    document.location.reload();
  }
}

// Ecoute du choix fait sur le menu déroulant Alphabetical Order (AO), le switch dépend de la valeur de e.target.value
selectAO.addEventListener('change', async e => {
  let order = e.target.value;
  await getEventData(order, "ao");
});

// Ecoute du choix fait sur le menu déroulant Date, le switch dépend de la valeur de e.target.value
selectDate.addEventListener('change', async e => {
  let order = e.target.value;
  await getEventData(order, "date");
});

searchbtn.addEventListener('click', keyWordFilter);
function keyWordFilter(e){
  e.preventDefault();
  let term = searchBar.value;
  let allEvents = document.querySelectorAll('.event');
  let eventTitles = document.querySelectorAll('.event h3');
  for (let i = 0 ; i < eventTitles.length ; i++){
    if (eventTitles[i].innerText.includes(term)) {
      allEvents[i].style.display = "flex";
    } else {
      allEvents[i].style.display = "none";
    }
  }
}