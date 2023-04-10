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
    switch (filterType) {
        case 'ao':
            response = await fetch('functions/eventAlphabeticalOrder.php?ao=' + num);
            data = await response.json();
            return data;
        case 'date':
            response = await fetch('functions/eventAlphabeticalOrder.php?date=' + num);
            data = await response.json();
            return data;  
        }
}

// Ecoute du choix fait sur le menu déroulant Alphabetical Order (AO), le switch dépend de la valeur de e.target.value
let selectDate = document.querySelector('#selectDate');
let selectAO = document.querySelector('#selectAO');
let evenements;
let eventData;
selectAO.addEventListener('change', async e => {
  eventsContainer.innerHTML = "";
  let order = e.target.value;
  switch (order) {
    case '1':
      selectDate.value = '-- Choisir --';
      evenements = JSON.parse(JSON.stringify(await getEventData(1, "ao"), null, 2));
      break;
    case '2':
      selectDate.value = '-- Choisir --';
      evenements = JSON.parse(JSON.stringify(await getEventData(2, "ao"), null, 2));
      break;
    default:
      document.location.reload();
  }
  for (let i = 0; i < evenements.length; i++) {
    let evenement = evenements[i];
    generateEventHTML(evenement);
  }
});

// Ecoute du choix fait sur le menu déroulant Date, le switch dépend de la valeur de e.target.value
selectDate.addEventListener('change', async e => {
  eventsContainer.innerHTML = "";
  let order = e.target.value;
  switch (order) {
    case '1':
      selectAO.value = '-- Choisir --';
      evenements = JSON.parse(JSON.stringify(await getEventData(1, "date"), null, 2));
      break;
    case '2':
      selectAO.value = '-- Choisir --';
      evenements = JSON.parse(JSON.stringify(await getEventData(2, "date"), null, 2));
      break;
    default:
      document.location.reload();
  }
  for (let i = 0; i < evenements.length; i++) {
    let evenement = evenements[i];
    generateEventHTML(evenement);
  }
});