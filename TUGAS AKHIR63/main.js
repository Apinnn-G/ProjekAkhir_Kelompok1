let header = document.querySelector('header');
let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {
  header.classList.toggle('hadow', window.scrollY > 0);
});

menu.onclick = () => {
  menu.classList.toggle('bx-b');
  navbar.classList.toggle('active');
}
window.onscroll = () => {
  menu.classList.remove('bx-b');
  navbar.classList.remove('active');
}

var swiper = new Swiper(".home", {
      spaceBetween: 30,
      centeredSlides: true,
      autoplay: {
        delay: 5000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      
    });

var swiper = new Swiper(".coming-container", {
    spaceBetween: 20,
    loop: true,
    autoplay: {
        delay: 5500,
        disableOnInteraction: false,
    },
    centeredSlides: false,
    breakpoints: {
        0: {
            slidesPerView: 2,
        },
        568: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 4,
        },
        968: {
            slidesPerView: 5,
        },
    },
});

// Inisialisasi swiper untuk genre
var genreSwiper = new Swiper(".genre-swiper", {
    slidesPerView: 'auto',
    spaceBetween: 20,
    freeMode: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    breakpoints: {
        0: {
            slidesPerView: 2,
        },
        568: {
            slidesPerView: 3,
        },
        768: {
            slidesPerView: 4,
        },
        968: {
            slidesPerView: 5,
        },
    },
});