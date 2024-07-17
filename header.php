<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container-header">
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
            </a>
        </div>
        <div class="menu-toggle">☰</div> <!-- Icône du menu burger -->
        <nav class="site-navigation">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class'     => 'navigation',
            ));
            ?>
            <a href="#" id="acontact-link" class="btn-contact-acceuil">Contact</a>
        </nav>
    </div>
</header>
