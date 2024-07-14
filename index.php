<?php get_header(); ?>

<div class="photo-posts">
    <?php
    // Requête pour récupérer les photos
    $args = array(
        'post_type' => 'photos', // Type de contenu personnalisé
        'posts_per_page' => 1, // Nombre de posts par page
    );
    $photo_query = new WP_Query($args);

    // Boucle pour afficher les photos
    if ($photo_query->have_posts()) :
        while ($photo_query->have_posts()) : $photo_query->the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php
                // Affichage de l'image à la une
                if (has_post_thumbnail()) {
                    the_post_thumbnail('full', array('class' => 'featured-image'));
                }
                ?>
            </article>
            <?php
        endwhile;
        wp_reset_postdata();
    else :
        echo '<p>Aucune photo trouvée.</p>'; // Message si aucune photo n'est trouvée
    endif;
    ?>
</div>

<div class="filters">
    <select id="categorie-filter">
        <option value="">Choisir une catégorie</option>
        <?php
        // Récupération des catégories pour les filtres
        $categories = get_terms('categorie');
        foreach ($categories as $category) {
            echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
        }
        ?>
    </select>

    <select id="format-filter">
        <option value="">Choisir un format</option>
        <?php
        // Récupération des formats pour les filtres
        $formats = get_terms('format');
        foreach ($formats as $format) {
            echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
        }
        ?>
    </select>

    <select id="sort-filter">
        <option value="DESC">Plus récent au plus ancien</option>
        <option value="ASC">Plus ancien au plus récent</option>
    </select>
</div>

<div id="photo-gallery" class="photo-gallery">
    <!-- Les articles seront chargés ici par AJAX -->
</div>

<button id="load-more">Charger plus</button>

<?php get_footer(); ?>
