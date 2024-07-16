<?php
/**
 * Enregistre les styles du thème.
 */
function motaphoto_enqueue_styles() {
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'motaphoto_enqueue_styles');

/**
 * Initialisation des fonctionnalités du thème.
 */
function custom_theme_setup() {
    add_theme_support('menus'); // Activation du support des menus
    register_nav_menu('primary', 'Menu principal'); // Enregistrement du menu principal
}
add_action('after_setup_theme', 'custom_theme_setup');

/**
 * Enregistre les scripts du thème et localise l'URL pour les requêtes AJAX.
 */
function enqueue_custom_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    wp_enqueue_script('jquery');
    wp_enqueue_script('custom-functions', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    wp_localize_script('custom-functions', 'ajax_params', array(
        'ajaxurl' => admin_url('admin-ajax.php') // Localisation de l'URL AJAX
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

/**
 * Fonction AJAX pour charger les photos selon les filtres appliqués.
 */
function load_photos() {
    $paged = $_POST['page'] ? $_POST['page'] : 1;
    $categorie = $_POST['categorie'];
    $format = $_POST['format'];
    $sort = $_POST['sort'] ? $_POST['sort'] : 'date'; // S'assure que 'sort' est par défaut sur 'date'
    $order = $_POST['order'] ? $_POST['order'] : 'ASC'; // Gérer l'ordre de tri ('ASC' ou 'DESC')

    $args = array(
        'post_type' => 'photos',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date', // Tri par date de publication
        'order' => $sort // Utiliser l'ordre fourni par la requête AJAX
    );

    if ($categorie) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $categorie
        );
    }

    if ($format) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format
        );
    }

    $photo_query = new WP_Query($args);

    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('photo-item'); ?>>
                <div class="photo-wrapper">
                    <?php
                    if (has_post_thumbnail()) {
                        the_post_thumbnail('full', array('class' => 'gallery-image'));
                    }
                    $reference = get_field('reference');
                    $categories = get_the_terms(get_the_ID(), 'categorie');
                    $category_names = wp_list_pluck($categories, 'name');
                    ?>
                    <div class="overlay">
                        <a href="<?php the_permalink(); ?>" class="icon-eye">
                            <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_eye.png" alt="Détails de la vue">
                        </a>
                        <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" class="icon-fullscreen"
                            data-lightbox="gallery"
                            data-reference="<?php echo esc_attr($reference); ?>"
                            data-category="<?php echo esc_attr(implode(', ', $category_names)); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_fullscreen.png" alt="Plein écran">
                        </a>
                    </div>
                    <div class="photo-info">
                        <span class="photo-title"><?php the_title(); ?></span>
                        <span class="photo-category"><?php echo esc_html(implode(', ', $category_names)); ?></span>
                    </div>
                </div>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_load_photos', 'load_photos');
add_action('wp_ajax_nopriv_load_photos', 'load_photos');

/**
 * Enregistre les scripts de Lightbox et applique des options.
 */
function custom_theme_scripts() {
    wp_enqueue_style('lightbox-css', get_template_directory_uri() . '/css/lightbox.min.css');
    wp_enqueue_script('lightbox-js', get_template_directory_uri() . '/js/lightbox.min.js', array('jquery'), '2.11.3', true);
    wp_add_inline_script('lightbox-js', 'lightbox.option({
        "resizeDuration": 200,
        "wrapAround": true
    })');
}
add_action('wp_enqueue_scripts', 'custom_theme_scripts');
