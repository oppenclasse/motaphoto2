<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
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
        </nav>
    </div>
</header>

<style>
@media (max-width: 768px) {
    .container-header{
        justify-content: space-between;
        margin-left: 20px;
        height: 72px;
    }
    .logo {
        width: 138px; /* Ajustez la taille du logo sur mobile */
    }
    .logo img {
        width: 100%; /* Assure que l'image du logo est responsive */
    }
    .site-navigation {
        display: none; /* Cache la navigation principale sur mobile */
       
        height: 100vh; /* Pleine hauteur */
        position: fixed; /* Fixe le menu sur l'écran */
        top: 115px;
        left: 0;
        background-color: #E00000; /* Fond rouge */
        justify-content: center;
        align-items: center;
        flex-direction: column; /* Alignement vertical des liens */
        z-index: 1000; /* S'assure que le menu est au-dessus des autres éléments */
    }
    .navigation{
        display:flex;
        flex-direction:column;
        width: 220px;
        height: 200px;
        font-size:44px;
        color: #FFFFFF;
        padding-left:0;
        align-items: center;
    }
    .navigation a{
        color:#FFFFFF;
    }
    .site-navigation.active {
        display: flex; /* Affiche la navigation lorsque le menu est actif */
    }
    .menu-toggle {
        display: block; /* Affiche l'icône du menu burger */
        position: absolute;
        top: 65px; /* Positionne l'icône */
        right: 45px;
        cursor: pointer; /* Indique qu'il est cliquable */
        z-index: 1001; /* S'assure que l'icône est au-dessus du menu */
        font-size: x-large;
    }
    .menu-toggle.close {
        content: '✖'; /* Icône de fermeture */
    }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.querySelector('.menu-toggle');
        var navigation = document.querySelector('.site-navigation');

        toggle.addEventListener('click', function () {
            navigation.classList.toggle('active');
            toggle.textContent = toggle.textContent === '☰' ? '✖' : '☰'; // Change l'icône
        });
    });
</script>
