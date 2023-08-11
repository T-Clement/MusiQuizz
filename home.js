if(window.innerWidth < 768) displayBottomNavBar();
addEventListener("resize", (event) => {
    if(window.innerWidth < 768) displayBottomNavBar();
});














function displayBottomNavBar() {

    var lastScrollTop = 0; // This variable will store the top position
    var navbar = document.querySelector('.js-nav'); // Get The NavBar
    var isNavbarVisible = false; // Variable to track the visibility state of the navbar

    var heightOfScreen = window.innerHeight - 83;

    window.addEventListener('scroll', function () {
        // On every scroll, this function will be called
        var scrollTop = window.scrollY || document.documentElement.scrollTop;
        // This line will get the location on scroll
        
        if (scrollTop > lastScrollTop) {
            // If the current position is greater than the previous position, hide the navbar
            if (isNavbarVisible) {
                navbar.style.bottom = window.innerHeight;
                navbar.style.display = "none";
                isNavbarVisible = false;
            }
        } else {
            // Otherwise, show the navbar
            if (!isNavbarVisible) {
                navbar.style.bottom = -heightOfScreen + 'px';
                navbar.style.display = "flex";
                isNavbarVisible = true;
            }
        }

        lastScrollTop = scrollTop; // New Position Stored
    });
}

// if(window.innerWidth < 768) {
//     var lastScrollTop = 0; // This variable will store the top position
//     var navbar = document.querySelector('.js-nav'); // Get The NavBar
//     var isNavbarVisible = false; // Variable to track the visibility state of the navbar

//     var heightOfScreen = window.innerHeight - 83;

//     window.addEventListener('scroll', function () {
//         // On every scroll, this function will be called
//         var scrollTop = window.scrollY || document.documentElement.scrollTop;
//         // This line will get the location on scroll

//         if (scrollTop > lastScrollTop) {
//             // If the current position is greater than the previous position, hide the navbar
//             if (isNavbarVisible) {
//                 navbar.style.bottom = window.innerHeight;
//                 navbar.style.display = "none";
//                 isNavbarVisible = false;
//             }
//         } else {
//             // Otherwise, show the navbar
//             if (!isNavbarVisible) {
//                 navbar.style.bottom = -heightOfScreen + 'px';
//                 navbar.style.display = "flex";
//                 isNavbarVisible = true;
//             }
//         }

//         lastScrollTop = scrollTop; // New Position Stored
//     });

// } 


