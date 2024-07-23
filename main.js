
document.addEventListener("DOMContentLoaded", () => {
	// console.log('we made it🎉');

	// window.setTimeout(function() {
	// 	document.querySelector('.fade-overlay').classList.add('faded')
	//   }, 230);
	
	//   window.setTimeout(function() {
	// 	document.querySelector('iframe').style.transform = 'scale(1)'
	//   }, 1000);

	 // Check if the fade-overlay element exists before adding the faded class
	 const fadeOverlay = document.querySelector('.fade-overlay');
	 if (fadeOverlay) {
		 window.setTimeout(function() {
			 fadeOverlay.classList.add('faded');
		 }, 230);
	 }
 
	 // Check if the iframe element exists before setting the style
	 const iframe = document.querySelector('iframe');
	 if (iframe) {
		 window.setTimeout(function() {
			 iframe.style.transform = 'scale(1)';
		 }, 1000);
	 }

// Hover effect for background text in homepage
// Select all elements with the class 'hover-effect'
const hoverElements = document.querySelectorAll('.hover-effect');

// Loop through each element and add event listeners for mouseenter and mouseleave events
hoverElements.forEach(element => {
    // Add event listener for mouseenter event
    element.addEventListener('mouseenter', () => {
        // Add a class 'hovered' when mouse enters
        element.classList.add('hovered');
    });

    // Add event listener for mouseleave event
    element.addEventListener('mouseleave', () => {
        // Remove the class 'hovered' when mouse leaves
        element.classList.remove('hovered');
    });
});


	let cursor = document.querySelector('.basketball');
// Scripting for the basketball cursor
	document.onmousemove = function(e) { 
	    let x= e.clientX;
	    let y= e.clientY;

	    cursor.style.left= x+'px';
	    cursor.style.top= y+'px';
	};

	const closeButton = document.getElementById('closeToggle');
	const mobileMenu = document.querySelector('.mobile-menu');
	const menuToggle = document.getElementById('menuToggle');

	// closeButton.addEventListener('click', function(){
	// 	mobileMenu.classList.add('closed');
	// })

	// Check if closeButton exists before adding the event listener
    if (closeButton) {
        closeButton.addEventListener('click', function(){
            if (mobileMenu) {
                mobileMenu.classList.add('closed');
            }
        });
    } else {
        // console.warn("Element with ID 'closeToggle' not found on this page");
    }

	// menuToggle.addEventListener('click', function(){
	// 	mobileMenu.classList.remove('closed');
	// })

	if (menuToggle) {
        menuToggle.addEventListener('click', function(){
            if (mobileMenu) {
                mobileMenu.classList.remove('closed');
            }
        });
    } else {
        // console.warn("Element with ID 'menuToggle' not found on this page");
    }
})

