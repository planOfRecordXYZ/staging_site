
document.addEventListener("DOMContentLoaded", () => {
	console.log('we made it🎉');

	window.setTimeout(function() {
		document.querySelector('.fade-overlay').classList.add('faded')
	  }, 230);
	
	  window.setTimeout(function() {
		document.querySelector('iframe').style.transform = 'scale(1)'
	  }, 1000);

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

	closeButton.addEventListener('click', function(){
		mobileMenu.classList.add('closed');
	})

	menuToggle.addEventListener('click', function(){
		mobileMenu.classList.remove('closed');
	})
})

