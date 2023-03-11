console.log('test');
const burgerIcon = document.querySelector('#burgerIcon');
const mobileMenu = document.querySelector('#mobileMenu');
burgerIcon.addEventListener('click', function(){
    burgerIcon.classList.toggle('open');
    mobileMenu.classList.toggle('open2');
});