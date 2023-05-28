
var swiper = new Swiper(".customer-reviews .mySwiper", {
  slidesPerView: 3,
  spaceBetween: 32,
  navigation: {
    nextEl: ".customer-reviews  .swiper-button-next",
    prevEl: ".customer-reviews  .swiper-button-prev",
  },
  loop: true,
  pagination: {
    el: ".customer-reviews  .swiper-pagination",
    clickable: true,
  },
  breakpoints: {
    // when window width is >= 320px
    320: {
      slidesPerView: 1,
    },
    // when window width is >= 480px
    650: {
      slidesPerView: 2,
    },
    // when window width is >= 640px
    1200: {
      slidesPerView: 3,
    }
  }
});
