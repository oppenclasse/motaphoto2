<?php get_header(); ?>

<div class="photo-posts">
    <?php
    // Requête pour récupérer toutes les photos
    $args = array(
        'post_type' => 'photos', // Type de contenu personnalisé
        'posts_per_page' => -1, // Récupère tous les posts
    );
    $photo_query = new WP_Query($args);

    // Vérifiez s'il y a des photos
    if ($photo_query->have_posts()) :
        // Récupérez tous les posts dans un tableau
        $photos = $photo_query->posts;
        // Sélectionnez une photo aléatoire
        $random_photo = $photos[array_rand($photos)];

        // Préparez les données de la photo aléatoire
        setup_postdata($random_photo);
        ?>
<article id="post-<?php echo $random_photo->ID; ?>" <?php post_class('photo-article', $random_photo->ID); ?>>
    <?php
    // Affichage de l'image à la une de la photo aléatoire
    if (has_post_thumbnail($random_photo->ID)) {
        $reference = get_field('reference', $random_photo->ID);
        $categories = get_the_terms($random_photo->ID, 'categorie');
        $categorie_names = $categories ? wp_list_pluck($categories, 'name') : [];
        $data_category = esc_attr(implode(', ', $categorie_names));
        echo get_the_post_thumbnail($random_photo->ID, 'full', array('class' => 'featured-image', 'data-reference' => $reference, 'data-category' => $data_category));
    }
    ?>
    <!-- Ajout de l'image PNG en tant que titre -->
    <div class="title-header">
        <img src="<?php echo get_template_directory_uri(); ?>/images/Titre-header.png" alt="PHOTOGRAPHE EVENT">
    </div>
</article>
        <?php
        // Réinitialisez les données de post
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>'; // Message si aucune photo n'est trouvée
    endif;
    ?>
</div>

<div class="filters">
    <select class="custom-select" id="categorie-filter">
        <option value="">catégorie</option>
        <?php
        // Récupération des catégories pour les filtres
        $categories = get_terms('categorie');
        foreach ($categories as $category) {
            echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
        }
        ?>
    </select>

    <select class="custom-select" id="format-filter">
        <option value="">format</option>
        <?php
        // Récupération des formats pour les filtres
        $formats = get_terms('format');
        foreach ($formats as $format) {
            echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
        }
        ?>
    </select> 

    <select class="custom-select" id="year-sort-filter">
        <option value="DESC">Plus récent au plus ancien</option>
        <option value="ASC">Plus ancien au plus récent</option>
    </select>
</div>

<div id="photo-gallery" class="photo-gallery">
    <!-- Les articles seront chargés ici par AJAX -->
</div>

<button id="load-more">Charger plus</button>


<?php get_footer(); ?>
