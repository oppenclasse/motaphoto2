<?php
// Ce code PHP est conçu pour être utilisé dans un thème WordPress. Il inclut des fonctions pour charger des styles et des scripts, gérer des menus, et créer une fonctionnalité AJAX pour charger des images en fonction de filtres. Il montre également comment intégrer et personnaliser Lightbox pour l'affichage de galeries d'images.
/**
 * Enregistre les styles du thème.
 */
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri()); // Charge le fichier CSS principal du thème.
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles'); // Ajoute l'action à WordPress pour exécuter cette fonction lors du chargement des scripts.

/**
 * Initialisation des fonctionnalités du thème.
 */
function custom_theme_setup() {
    add_theme_support('menus'); // Permet au thème de supporter les menus
    register_nav_menu('primary', 'Menu principal'); // Enregistre un menu nommé 'Menu principal' dans WordPress
}
add_action('after_setup_theme', 'custom_theme_setup'); // Exécute la fonction au moment de l'initialisation du thème.

/**
 * Enregistre les scripts du thème et localise l'URL pour les requêtes AJAX.
 */
function enqueue_custom_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri()); // Charge le style CSS du thème.
    wp_enqueue_script('jquery'); // Charge jQuery.
    wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true); // Charge un script personnalisé qui dépend de jQuery.
    wp_localize_script('custom-scripts', 'ajax_params', array(
        'ajaxurl' => admin_url('admin-ajax.php') // Fournit l'URL AJAX à utiliser dans les scripts.
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts'); // Attache cette fonction au hook WordPress pour charger les scripts.

/**
 * Fonction AJAX pour charger les photos selon les filtres appliqués.
 */
function load_photos() {
    $paged = $_POST['page'] ? $_POST['page'] : 1; // Détermine la page actuelle ou par défaut à la première page.
    $categorie = $_POST['categorie']; // Récupère le filtre de catégorie depuis la requête AJAX.
    $format = $_POST['format']; // Récupère le filtre de format depuis la requête AJAX.
    $sort = $_POST['sort'] ? $_POST['sort'] : 'date'; // Définit le critère de tri, par défaut sur 'date'.
    $order = $_POST['order'] ? $_POST['order'] : 'ASC'; // Définit l'ordre du tri, par défaut sur 'ASC'.

    $args = array(
        'post_type' => 'photos', // Spécifie le type de post à récupérer.
        'posts_per_page' => 8, // Limite le nombre de posts par page à 8.
        'paged' => $paged, // Pagination.
        'orderby' => 'date', // Tri par date.
        'order' => $sort // Utilise l'ordre fourni par la requête AJAX.
    );

    if ($categorie) {
        $args['tax_query'][] = array( // Filtre supplémentaire pour la catégorie.
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        );
    }

    if ($format) {
        $args['tax_query'][] = array( // Filtre supplémentaire pour le format.
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }

    $photo_query = new WP_Query($args); // Crée une nouvelle requête WP avec les arguments spécifiés.

    if ($photo_query->have_posts()) : // Vérifie s'il y a des posts à afficher.
        while ($photo_query->have_posts()) : $photo_query->the_post(); // Boucle sur les posts disponibles.
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('photo-item'); ?>> <!-- Affiche chaque photo dans un article. -->
                <div class="photo-wrapper">
                    <?php
                    if (has_post_thumbnail()) { // Vérifie si la photo a une image à la une.
                        the_post_thumbnail('full', array('class' => 'gallery-image')); // Affiche l'image à la une.
                    }
                    ?>
                    <?php
                    $ref = get_field('reference'); // Récupère la référence personnalisée de la photo.
                    $category_names = wp_list_pluck(get_the_terms(get_the_ID(), 'categorie'), 'name'); // Récupère les noms des catégories.
                    $ref_and_cat = '<span>' . esc_attr($ref) . '</span> <span>' . esc_attr(implode(', ', $category_names)) . '</span>'; // Combine la référence et les catégories pour l'affichage.
                    ?>
                    <div class="overlay">
                        <a href="<?php the_permalink(); ?>" class="icon-eye">
                            <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_eye.png" alt="Détails de la vue">
                        </a>
                        <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" class="icon-fullscreen"
                            data-lightbox="gallery"
                            data-reference="<?php echo $ref_and_cat; ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_fullscreen.png" alt="Plein écran">
                        </a>
                    </div>
                    <div class="photo-info">
                        <span class="photo-title"><?php the_title(); ?></span> <!-- Affiche le titre de la photo. -->
                        <span class="photo-category"><?php echo esc_html(implode(', ', $category_names)); ?></span> <!-- Liste les catégories de la photo. -->
                    </div>
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata(); // Réinitialise les données de la requête.
    else :
        echo '<p>Aucune photo trouvée.</p>'; // Message si aucune photo n'est trouvée.
    endif;

    wp_die(); // Termine la requête AJAX correctement.
}
add_action('wp_ajax_load_photos', 'load_photos'); // Ajoute l'action AJAX pour les utilisateurs connectés.
add_action('wp_ajax_nopriv_load_photos', 'load_photos'); // Ajoute l'action AJAX pour les utilisateurs non connectés.

/**
 * Enregistre les scripts de Lightbox et applique des options.
 */
function custom_theme_scripts() {
    wp_enqueue_style('lightbox-css', get_template_directory_uri() . '/css/lightbox.min.css'); // Charge le CSS pour Lightbox.
    wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/js/lightbox.min.js', array('jquery'), '2.11.3', true); // Charge le JavaScript pour Lightbox.
    wp_add_inline_script('lightbox-js', 'lightbox.option({
        "resizeDuration": 200,
        "wrapAround": true
    })'); // Configure les options de Lightbox.
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts'); // Attache cette fonction au hook WordPress pour charger les scripts de Lightbox.
