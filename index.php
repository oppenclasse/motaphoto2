<?php get_header(); ?>
<h1 class="visually-hidden">Mota Photo</h1>

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
        $reference = get_field('reference');
        $categories = get_the_terms(get_the_ID(), 'categorie');
        $categorie_names = $categories ? wp_list_pluck($categories, 'name') : [];
        $data_category = esc_attr(implode(', ', $categorie_names));
        the_post_thumbnail('full', array('class' => 'featured-image', 'data-reference' => $reference, 'data-category' => $data_category));
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
        <option value="">catégorie</option>
        <?php
        // Récupération des catégories pour les filtres
        $categories = get_terms('categorie');
        foreach ($categories as $category) {
            echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
        }
        ?>
    </select>

    <select id="format-filter">
        <option value="">format</option>
        <?php
        // Récupération des formats pour les filtres
        $formats = get_terms('format');
        foreach ($formats as $format) {
            echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
        }
        ?>
    </select>

    <select id="year-sort-filter">
        <option value="DESC">Plus récent au plus ancien</option>
        <option value="ASC">Plus ancien au plus récent</option>
    </select>
</div>

<div id="photo-gallery" class="photo-gallery">
    <!-- Les articles seront chargés ici par AJAX -->
</div>

<button id="load-more">Charger plus</button>
<style>
/* Style par défaut du menu déroulant */
select {
    width: 100%;
    padding: 8px;
    background-color: white; /* Fond blanc par défaut */
    border: 1px solid #ccc;
    border-radius: 4px;
    cursor: pointer;
}

/* Style au survol des options */
select option:hover {
    background-color: #FFD6D6; /* Fond rose au survol */
}

/* Style pour un select ayant une option sélectionnée */
.select-colored {
    background-color: #E00000; /* Fond rouge lorsque une option est sélectionnée */
    color: white; /* Texte blanc pour une meilleure lisibilité */
}


</style>
<script>
jQuery(document).ready(function($) {
    // Détecte les changements sur les éléments <select>
    $('select').on('change', function() {
        if (this.value) { // Vérifie si une valeur est sélectionnée
            $(this).addClass('select-colored'); // Applique la classe pour changer la couleur de fond
        } else {
            $(this).removeClass('select-colored'); // Retire la classe si aucune option n'est sélectionnée
        }
    });

    // Applique le style de survol au survoler les options
    $('select option').on('mouseenter', function() {
        $(this).css('background-color', '#FFD6D6'); // Fond rose au survol
    }).on('mouseleave', function() {
        $(this).css('background-color', ''); // Retire le style de survol
    });
});

</script>
<?php get_footer(); ?>
