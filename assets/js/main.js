let deleteEventBtn = document.querySelector('#deleteEventBtn');
let eventBtns = document.querySelectorAll('.trash');

for(let eventBtn of eventBtns){
  eventBtn.addEventListener("click", function(){
    deleteEventBtn.href = "./deleteEvent.php?id=" + eventBtn.dataset.id;
  });
}
