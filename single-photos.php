<?php get_header(); ?>

<div id="primary">
    <div class="titre-photo-container">
        <div class="titre-container">
            <h2><?php the_title(); ?></h2>
            <!-- Afficher le champ "Référence" -->
            <p><strong>Référence :</strong> <?php the_field('reference'); ?></p>

            <?php 
            // Afficher les termes de la taxonomie "Catégories"
            $categories = get_the_terms( get_the_ID(), 'categorie' );
            if ( !empty($categories) && !is_wp_error($categories) ) {
                $categorie_names = wp_list_pluck($categories, 'name');
                echo '<p><strong>Catégorie :</strong> ' . implode(', ', $categorie_names) . '</p>';
            }
            ?>

            <?php 
            // Afficher les termes de la taxonomie "Formats"
            $formats = get_the_terms( get_the_ID(), 'format' );
            if ( !empty($formats) && !is_wp_error($formats) ) {
                $format_names = wp_list_pluck($formats, 'name');
                echo '<p><strong>Format :</strong> ' . implode(', ', $format_names) . '</p>';
            }
            ?>
            <!-- Afficher le champ "Type" -->
            <p><strong>Type :</strong> <?php the_field('type'); ?></p>
            <p><strong>Année :</strong> <?php the_field('annee'); ?></p>
        </div>
        <!-- Afficher la photo associée -->
        <div class="photo-container">
          <?php 
            if (has_post_thumbnail()) : // Vérifier si le post a une image mise en avant
                the_post_thumbnail('full', array('class' => 'photo-image')); // Afficher l'image mise en avant
            else :
                echo '<p>No featured image found.</p>'; // Message si aucune image mise en avant n'est trouvée
            endif;
        ?>
    </div>

    </div><!-- Fin de la classe titre-photo-container -->

    <div class="contact">
        <!-- Bloc à gauche -->
        <div class="contact-interesse">
            <p>Cette photo vous intéresse ? </p>
            <button class="btn" id="contact-link" data-photo-id="<?php the_ID(); ?>" data-reference="<?php the_field('reference'); ?>">
                Contact
            </button>
        </div>
        <!-- Bloc à droite -->
        <div class="nav-links">
            <?php 
            // lien vers le post précédent
            $prev_post = get_previous_post();
            if ($prev_post) :
                $prev_image = get_field('photo', $prev_post->ID); // Récupérer l'image du post précédent
                $prev_thumbnail = $prev_image ? $prev_image['sizes']['thumbnail'] : get_the_post_thumbnail_url($prev_post->ID, 'thumbnail');
            ?>
                <a href="<?php echo get_permalink($prev_post->ID); ?>" class="navigation-link prev-link" data-thumbnail="<?php echo $prev_thumbnail; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/flechegauche.png" alt="Flèche gauche">
                    <div class="thumbnail-preview prev-thumbnail">
                        <img src="<?php echo esc_url($prev_thumbnail); ?>" alt="Miniature précédente">
                    </div>
                </a>
            <?php endif; ?>
            
            <?php 
            // lien vers le post suivant
            $next_post = get_next_post();
            if ($next_post) :
                $next_image = get_field('photo', $next_post->ID); // Récupérer l'image du post suivant
                $next_thumbnail = $next_image ? $next_image['sizes']['thumbnail'] : get_the_post_thumbnail_url($next_post->ID, 'thumbnail');
            ?>
                <a href="<?php echo get_permalink($next_post->ID); ?>" class="navigation-link next-link" data-thumbnail="<?php echo $next_thumbnail; ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/flechedroite.png" alt="Flèche droite">
                    <div class="thumbnail-preview next-thumbnail">
                        <img src="<?php echo esc_url($next_thumbnail); ?>" alt="Miniature suivante">
                    </div>
                </a>
            <?php endif; ?>
        </div>
    </div><!-- Fin du bloc de contact -->

    <!-- Bloc des photos apparentées -->
    
</div> <!-- #primary -->

<!-- Bloc des photos apparentées -->
<div class="related-titre">
    <h3>vous aimerez aussi</h3>
</div>
<div class="related-photos">
    <?php
    $categories = get_the_terms(get_the_ID(), 'categorie');
    if ($categories && !is_wp_error($categories)) {
        $category_ids = wp_list_pluck($categories, 'term_id');
        $related_args = array(
            'post_type' => 'photos',
            'posts_per_page' => 2, // Limite à deux photos
            'post__not_in' => array(get_the_ID()), // Exclure la photo courante
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'term_id',
                    'terms' => $category_ids,
                ),
            ),
        );

        $related_query = new WP_Query($related_args);

        if ($related_query->have_posts()) : 
            while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                <div class="related-photo-item">
                    <div class="photo-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('full', array('class' => 'photo-image')); ?>
                            <div class="overlay">
                                <a href="<?php the_permalink(); ?>" class="icon-eye">
                                    <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_eye.png" alt="Voir les détails">
                                </a>
                                <a href="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" class="icon-fullscreen" data-lightbox="related-gallery" data-title="<?php the_title(); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/css/images/Icon_fullscreen.png" alt="Plein écran">
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else : 
            echo '<p>Aucune photo similaire trouvée.</p>';
        endif;
    }
    ?>
</div>
<?php get_footer(); ?>
<style>

@media (max-width: 768px) {
    .titre-photo-container {
        display: flex;
        flex-direction: column-reverse;
        justify-content: space-between;
        width: 265px;
        }
    #primary {
        margin: 0px 55px;
    }
    .titre-container {
        width: 100%;
        padding:50px
    } 
    .photo-container {
    width: 100%;
    }
    .contact-interesse{
        flex-direction: column;
        width:100%;
    }
    .contact-interesse .btn{
        margin-left: 0;
    }
    .nav-links{
        display: none;
    }
    .related-titre {
    margin: 0 ;
    display: flex;
    justify-content: center;
    }
    .related-photos {
    display: flex;
    flex-direction: column;
    margin: 30px 40px;
    gap: 10px;
    }
    .related-photos > div {
    width: 100%;
    height: 280px;
    }
}
</style>