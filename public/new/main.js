//Search Bar
let searchBtn = document.querySelector('#search-btn');
let searchBar = document.querySelector('.search-bar-container');

//Login Form
let formBtn = document.querySelector('#login-btn');
let loginForm = document.querySelector('.login-form-container');
let formClose = document.querySelector('#form-close');

// Menu Use For Phone
let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');

// Video Btn
let videoBtn = document.querySelectorAll('.vid-btn');

//Click X to close Search Bar
window.onscroll = () =>{
    searchBtn.classList.remove('fa-times');
    searchBar.classList.remove('active');
    menu.classList.remove('fa-times');
    navbar.classList.remove('active');
    loginForm.classList.remove('active');
}

//Active the Menu For Phone
menu.addEventListener('click', () =>{
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
});

//Active the Search Bar
// searchBtn.addEventListener('click', () =>{
//     searchBtn.classList.toggle('fa-times');
//     searchBar.classList.toggle('active');
// });

// //Active the Login Form
// formBtn.addEventListener('click', () =>{
//     loginForm.classList.toggle('active');
// });

formClose.addEventListener('click', () => {
    loginForm.classList.remove('active');
});

videoBtn.forEach(btn => {
    btn.addEventListener('click', ()=>{
        document.querySelector('.controls .active').classList.remove('active');
        btn.classList.add('active');
        let src = btn.getAttribute('data-src');
        document.querySelector('#video-slider').src = src;
    });
});
