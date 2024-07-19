<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character set and viewport settings -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Title of the web page -->
    <title>Plan of Record</title>
    
    <!-- Favicon for the web page -->
    <link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">
    
    <!-- Linking external JavaScript file -->
    <script src="./main.js"></script>
    
    <!-- Linking external CSS files -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./css/mobile.css">
</head>
<style>
    .socials a:hover {
         color: var(--secondary-font-color) !important;
     }
</style>
<body>
    <!-- Decorative image displayed only on desktop -->
    <div class="basketball desktop-only">
        <img src="./assets/cursor.png" alt="" width="24px">
    </div>
    
    <!-- Including navigation bar from an external PHP file -->
    <?php include('reusable/nav.php');?>
    <section class="mobile-menu mobile-only closed">
		<ul class="mobile-only">
			<li><a href="./index.php">Plan of Record</a></li>
			<li id="closeToggle" class="menu-toggle"><a href="#"><img src="./assets/close.png" alt=""></a></li>
		</ul>
		<ul class="mobile-navitems">
			<li><a href="./index.php">Home</a></li>
			<li><a href="./projects.php">Index</a></li>
			<li><a href="./about.php">About</a></li>
			<li><a href="./approach.php">Approach</a></li>
			<li><a href="./contactUs.php">Contact</a></li>
		</ul>
	</section>

    <!-- Main content section of the homepage -->
    <section class="homepage">
        <!-- Background text styling -->
        <div class="background-text">
            <span class="plan">Pl<span class="hover-effect">a</span><span class="hover-effect">n</span></span>
            <span class="of">o<span class="hover-effect">f</span></span>
            <span class="record">R<span class="hover-effect">e</span>cord</span>
        </div>

        <!-- Introductory block with text and images -->
        <div class="intro-block">
            <!-- Introductory Video For Mobile Only -->
             <div class="intro-video project-image mobile-only">
             <a href="#">
                <video muted autoplay loop src="assets/PoR_Reel.mp4"></video>
            </a>
             </div>
            <!-- Introductory paragraph about the design studio -->
            <p class="PoR-intro">Plan of Record is a Toronto-based design studio specializing in brand identity and experiences. </p>
            
            <!-- Container for project and design images -->
            <div class="images">
                <!-- First project -->
                <div class="project-1">
                    <div class="project1 project-image">
                        <a href="#">
                            <video muted autoplay loop src="assets/HPH_MotionPoster_WebsiteVersion.mp4"></video>
                        </a>
                    </div>
                    <div class="project-desc">
                        <p>Harvard Public Health</p>
                        <p class="description">A brand toolkit unifying HPH's identity across all touch points.</p>
                    </div>
                    
                </div>

                <!-- First design -->
                <div class="design-1">
                    <a href="https://studio-standard.co/products/haus-006?_pos=1&_psq=haus+006&_ss=e&_v=1.0&variant=39701638611083">
                        <img src="./assets/Haus.png" alt="Haus">
                    </a>
                    <div class="project-desc">
                        <p>Barrister Tom Ellicott </p>
                        <p class="description">Dotting his i's, and crossing his t's</p>
                    </div>
                    <br>
                </div>
            </div>

            <!-- Second row of projects and designs -->
            <div class="row-2">
                <div class="design-1 mobile-project1">
                    <div class="project-image project-2">
                        <img src="./assets/screen.png" alt="design1">
                    </div>
                    <div class="project-desc">
                        <p>RAIA Beauty</p>
                        <p class="description">Empowering confidence for women with eczema</p>
                    </div>
                </div>
                <div class="design-1 project3-mobile">
                    <div class="project-image project-3">
                        <img src="./assets/screen.png" alt="design1">
                    </div>
                    <div class="project-desc desc3-mobile">
                        <p>Dommary Farms</p>
                        <p class="description">Branding a sustainable micro-farming community</p>
                    </div>
                    
                </div>
                <div class="design-1 extra-gap">
                    <div class="project-image project-3">
                        <img src="./assets/screen.png" alt="design1">
                    </div>
                    <div class="project-desc">
                        <p>Asseto</p>
                        <p class="description">Software to automate Brand Asset Creation</p>
                    </div>
                </div>
            </div>

            <!-- Third row of projects -->
            <div class="row-3">
                <div class="design-1 design3-mobile">
                    <div class="project-image project-4">
                        <img src="./assets/NOW.png" alt="design1">
                    </div>
                    <div class="project-desc">
                        <p>NOW Running</p>
                        <p class="description">Motion-driven brand for active individuals.</p>
                    </div>
                </div>
                <div class="design-1">
                    <div class="project-image project-5">
                        <video muted loop autoplay src="assets/lookAtMe_websiteVersion.mp4"></video>
                    </div>
                </div>
            </div>

            <!-- Fourth row of projects -->
            <div class="row-4">
                <div class="design-1 design4-mobile">
                    <div class="project-image project-6">
                        <video muted loop autoplay src="assets/Amoeba.mp4"></video>
                    </div>
                </div>
                <div class="project-image project-7">
                    <img src="./assets/auburn.png" alt="design1">
                    <div class="design-1 project-desc">
                        <p>Aeva Health</p>
                        <p class="description">A holistic platform for women with autoimmune diseases</p>
                    </div>
                </div>
            </div>
        </div>  
    </section>

    <!-- Including footer from an external PHP file -->
    <?php include('reusable/footer.php');?>

</body>
</html>
