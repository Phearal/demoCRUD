let deleteEventBtn = document.querySelector('#deleteEventBtn');
// let eventBtns = document.querySelectorAll('.trash');
let eventBtns = document.querySelectorAll('.trash').addEventListener('click', event => {
    console.log(eventBtns.dataset.id);
  })