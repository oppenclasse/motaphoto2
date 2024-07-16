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
            <a href="#" id="acontact-link" class="btn-contact-acceuil">Contact</a>
        </nav>
    </div>
</header>

<style>
    .btn-contact-acceuil{
        display: flex;
        align-items: center;
        margin-left:40px;

}
    .btn-contact-acceuil:hover{
        font-weight: bold;
    }
    .menu-toggle{
        display: none;
    }
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
    .site-navigation ul{
        margin-top:0;
        justify-content: flex-start;
    }
    .site-navigation ul li{
        margin: 0 0 30px 0;
    }
    .btn-contact-acceuil{
    width: 193PX;
    margin: 0;
    height: 50px;
    display: flex;
    justify-content: center;
    color: white;
    font-size: 44px;
}
    .menu-menu-principal-container{
        height:150px;
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
    .modal-content {
        width: 90%; /* Plus large pour les petits écrans */
        margin: 20% auto; /* Ajuste le pourcentage pour positionner la modal plus haut ou plus bas */
        padding: 10px; /* Moins de padding pour économiser de l'espace */
    }

    /* Optionnel: Si tu souhaites aussi réduire la taille du texte */
    .modal-content p, .modal-content label, .modal-content input, .modal-content textarea {
        font-size: 14px; /* Réduit la taille de la police */
    }


/* Assure-toi que la modal elle-même couvre tout l'écran pour bloquer le contenu derrière */
.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
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
