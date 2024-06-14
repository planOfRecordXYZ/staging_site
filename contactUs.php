<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-82V2S6H6LG"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-82V2S6H6LG', {
            'cookie_flags': 'SameSite=None;Secure'
        });
    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan of Record</title>
    <link rel="icon" type="image/x-icon" href="./assets/favicon_io/favicon.ico">

    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="./main.js" defer></script>
    <link rel="stylesheet" href="./css/normalize.css">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/mobile.css">

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script type="text/javascript">
        (function() {
            emailjs.init('L1EhWtLXMdt9Wu3W0');
        })();
    </script>
    <script type="text/javascript">
        window.onload = function() {
            const emailNotice = document.getElementById('emailSubmitNotice');
            const contactForm = document.getElementById('contactForm');
            contactForm.addEventListener('submit', function(event) {
                event.preventDefault();
                this.contact_number.value = Math.random() * 100000 | 0;
                emailjs.sendForm("service_9alek42","template_rol5epn", this)
                    .then(function() {
                        console.log('SUCCESS!');
                        emailNotice.innerHTML = "<span>Thank you! We'll get back to you shortly</span>";
                        emailNotice.style.display = 'block';
                        document.getElementById('contactForm').scrollIntoView();
                    }, function(error) {
                        console.log('FAILED...', error);
                        emailNotice.innerHTML = "<span>Oops! Something went wrong, please try again.</span>";
                        emailNotice.style.display = 'block';
                        document.getElementById('contactForm').scrollIntoView();
                    });
            });
        }
    </script>
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

    <section class="contactpage">
        <div class="fade-overlay"></div>
        <div class="three-column">
            <div class="about-title">
                <h2>Say Hi</h2>
            </div>
            <div class="contactform grid-span-2">
                <form id="contactForm">
                    <p>Looking for a creative studio to help you rebrand or enhance the experience of your brand? Let’s chat.</p>
                    <p id="emailSubmitNotice" class="email-submit-notice"></p>
                    <input type="hidden" name="contact_number">
                    <fieldset>
                        <textarea rows="11" name="message"></textarea>
                    </fieldset>
                    <div class="form-grid">
                        <fieldset>
                            <input type="email" name="user_email" placeholder="Email*" required>
                        </fieldset>
                        <fieldset>
                            <input type="tel" name="user_phone" placeholder="Phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}">
                        </fieldset>
                        <fieldset>
                            <input type="text" name="user_name" placeholder="Name">
                        </fieldset>
                    </div>
                    <div class="form-submit">
                        <input type="submit" value="Submit">
                    </div>
                </form>
            </div>
        </div>
        <div class="three-column">
            <div></div>
            <div class="contactemail">
                <p class="secondary-title">Contact</p>
                <div class="info">
                    <p class="secondary-title"><a href="mailto:info@planofrecord.xyz" target="_blank">info@planofrecord.xyz</a></p>
                </div>
            </div>
        </div>
    </section>

    <?php include('reusable/footer.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('#menuToggle');
            const mobileMenu = document.querySelector('.mobile-menu');
            const closeToggle = document.querySelector('#closeToggle');

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    mobileMenu.classList.toggle('closed');
                });
            }

            if (closeToggle) {
                closeToggle.addEventListener('click', function() {
                    mobileMenu.classList.add('closed');
                });
            }
        });
    </script>
</body>
</html>
