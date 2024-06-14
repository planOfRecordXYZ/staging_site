<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-82V2S6H6LG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-82V2S6H6LG');

  
</script>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Plan of Record</title>
	<link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">

	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta http-equiv="Expires" content="0"/>


	<script src="./main.js"></script>
	<link rel="stylesheet" href="./css/normalize.css">
	<link rel="stylesheet" href="./css/styles.css">
	<link rel="stylesheet" href="./css/mobile.css">
</head>
<body>
	<div class="basketball desktop-only"><img src="./assets/cursor.png" alt=""></div>
	<?php include('reusable/nav.php');?>

	<section class="mobile-menu mobile-only closed">
		<ul class="mobile-only">
			<li><a href="./index.php">Plan of Record</a></li>
			<li id="closeToggle" class="menu-toggle"><a href="#"><img src="./assets/close.png" alt=""></a></li>
		</ul>
		<ul>
			<li><a href="./index.php">Plan of Record</a></li>
			<li><a href="./projects.php">Index</a></li>
			<li><a href="./about.html">About</a></li>
			<li><a href="./approach.html">Approach</a></li>
			<li><a href="./contactUs.html">Contact</a></li>
		</ul>
	</section>

  <section class="approachpage">
  	<div class="fade-overlay"></div>
  	<div class="approach-title">
  		<h2>Our approach is playful and experimental. <br> We prioritize strategic thinking and conceptually driven work.</h2>
  	</div>
  	<div class="about-pillars">
  		<div class="services three-column">
  			<div>
  				<p class="secondary-title">Clients</p>
  				<p>We collaborate with individuals and organizations who have a purpose, sharing a common drive for meaningful causes and ideas.</p>
  				<p>We work in, but are not restricted to these industries:</p>
  				<ul>
  					<li>Arts & Culture</li>
  					<li>Consumer Tech</li>
  					<li>FinTech</li>
  					<li>Education</li>
  					<li>Healthcare</li>
  					<li>Hospitality</li>
  					<li>Media</li>
  					<li>Non-Profit</li>
  					<li>Startup</li>
  				</ul>
  			</div>
  			<div>
  				<p class="secondary-title">Capabilities</p>
  				<p>As technology continues to shape industries, it's imperative for businesses to embrace the digital landscape as the foundation of their visual identity. </p>
  				<p>We blend design expertise with technology, to help brands create meaningful, unique brand experiences.</p>
  			</div>
  			<div>
  				<p class="secondary-title">Collaborators</p>
  				<p>We collaborate with a network of strategists, type designers, illustrators, developers and copywriters to deliver projects across multiple disciplines and media.</p>
  			</div>
  		</div>
  	</div>

  </section>

  <?php include('reusable/footer.php'); ?>

	<script>
    document.addEventListener("DOMContentLoaded", () => {
      window.setTimeout(function() {
      	console.log('overlay add fade')
        document.querySelector('.fade-overlay').classList.add('faded')
      }, 230);
    });
  </script>
	
</body>
</html>