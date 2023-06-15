const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    breakpoints: {
        1920: {
            slidesPerView: 3,
            spaceBetween: 80
        },
        1028: {
            slidesPerView: 3,
            spaceBetween: 50
        },
        480: {
            slidesPerView: 1,
            spaceBetween: 50
        }
    }

  });
  