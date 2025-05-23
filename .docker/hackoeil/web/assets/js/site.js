"use strict";



/*Responsive Navigation*/
$("#nav-mobile").html($("#nav-main").html());
$("#nav-trigger span").on("click",function() {
	if ($("nav#nav-mobile ul").hasClass("expanded")) {
		$("nav#nav-mobile ul.expanded").removeClass("expanded").slideUp(250);
		$(this).removeClass("open");
	} else {
		$("nav#nav-mobile ul").addClass("expanded").slideDown(250);
		$(this).addClass("open");
	}
});

$("#nav-mobile").html($("#nav-main").html());
$("#nav-mobile ul a").on("click",function() {
	if ($("nav#nav-mobile ul").hasClass("expanded")) {
		$("nav#nav-mobile ul.expanded").removeClass("expanded").slideUp(250);
		$("#nav-trigger span").removeClass("open");
	}
});

/* Sticky Navigation */
if (!!$.prototype.stickyNavbar) {
	$('#header').stickyNavbar();
}

$('#content').waypoint(function (direction) {
	if (direction === 'down') {
		$('#header').addClass('nav-solid fadeInDown');
	}
	else {
		$('#header').removeClass('nav-solid fadeInDown');
	}
});

function scrollTop() {
	document.addEventListener('scroll', (e) => {
		let scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
		if(scrollTop > 500) { document.getElementById('scrollUp').style.display = "block"; }
		else { document.getElementById('scrollUp').style.display = "none"; }
	});

	document.getElementById('scrollUp').addEventListener('click', (e) => {
		e.preventDefault();
		window.scrollTo(0, document.getElementById("wrapper").offsetTop);
	});
}

document.addEventListener('DOMContentLoaded', () => {
	/* Video Lightbox */
	if (!!$.prototype.simpleLightboxVideo) {
		$('.video').simpleLightboxVideo();		
	}
	$('#status').fadeOut(); // will first fade out the loading animation
	$('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
	$('body').delay(350).css({'overflow-y': 'visible'});


	if (typeof WOW == 'function') new WOW().init();

	scrollTop();
	setTimeout(()=>window.scrollTo(0, 1), 100);
});
