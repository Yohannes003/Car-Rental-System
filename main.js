let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

menu.onclick = () => {
    menu.classList.toggle('bx-x');
    navbar.classList.toggle('active');
};

window.onscroll = () => {
    menu.classList.remove('bx-x');
    navbar.classList.remove('active');    
};

const sr = ScrollReveal({
    distance: '60px',
    duration: 2500,
    delay: 400,
    reset: true
});


sr.reveal('.text', { delay: 200, origin: 'top' });
sr.reveal('.heading', {delay: 100, origin:'top'})
sr.reveal('.guide-container', {delay: 200, origin:'top'})
sr.reveal('.guide-container .box', {delay: 200, origin:'right'})
sr.reveal('.cars-container .box', {delay: 200, origin:'bottom'})
sr.reveal('.about-text', {delay:200, origin:'right'})
sr.reveal('.about-img', {delay:200, origin:'left'})
sr.reveal('.reviews-container .box', {delay:200, origin:'bottom'})





