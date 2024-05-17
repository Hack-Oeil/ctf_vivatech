/*!
* Start Bootstrap - Resume v7.0.6 (https://startbootstrap.com/theme/resume)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-resume/blob/master/LICENSE)
*/
//
// Scripts
// 

document.addEventListener('DOMContentLoaded', event => {

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

    if(document.querySelector("#flag-toast") != null) {
        document.querySelector("#flag-toast").addEventListener('dblclick', (event) => {
            event.currentTarget.classList.remove('show');
        })
    }

    if(document.querySelector("#flag-goto") != null) {
        document.querySelector("#flag-goto").addEventListener('dblclick', (event) => {
            event.currentTarget.classList.remove('show');
        })
    }
});
