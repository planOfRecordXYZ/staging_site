<!-- Common Nav for user view -->
<header>
<?php
    // Get the current script name
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <ul class="desktop-only">
        <li><a href="./index.php" class="<?= $current_page == 'index.php' ? 'active-link' : '' ?>">Plan of Record</a></li>
        <li><a href="./projects.php" class="<?= $current_page == 'projects.php' ? 'active-link' : '' ?>">Index</a></li>
        <li><a href="./about.php" class="<?= $current_page == 'about.php' ? 'active-link' : '' ?>">About</a></li>
        <li><a href="./approach.php" class="<?= $current_page == 'approach.php' ? 'active-link' : '' ?>">Approach</a></li>
        <li><a href="./contactUs.php" class="<?= $current_page == 'contactUs.php' ? 'active-link' : '' ?>">Contact</a></li>
    </ul>

    <ul class="mobile-only">
        <li><a href="./index.php" class="<?= $current_page == 'index.php' ? 'active-link' : '' ?>">Plan of Record</a></li>
        <li id="menuToggle" class="menu-toggle"><a href="#">Menu</a></li>
    </ul>

</header>