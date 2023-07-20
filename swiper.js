const swiper = new Swiper('.swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: false,
  
    // Navigation arrows
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  
    breakpoints: {
        480: {
            slidesPerView: 1,
            spaceBetween: 50
        },
        770: {
            slidesPerView: 2,
            spaceBetween: 80
        },
        1028: {
            slidesPerView: 3,
            spaceBetween: 50
        }
        
    }
  });


  swiper.navigation.update();