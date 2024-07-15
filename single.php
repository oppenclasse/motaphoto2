<?php get_header(); // Appelle le fichier header.php ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

    <?php
    while ( have_posts() ) : the_post(); // Boucle principale pour afficher le post
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); // Affiche le titre du post ?>
            </header>

            <div class="entry-content">
                <?php
                the_content(); // Affiche le contenu du post

                wp_link_pages( array( // Pagination pour les posts divisés en plusieurs pages
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'textdomain' ),
                    'after'  => '</div>',
                ) );
                ?>
            </div>

            <footer class="entry-footer">
                <?php
                if ( is_single() ) {
                    the_post_navigation(); // Navigation entre les posts (précédent et suivant)
                }
                ?>
            </footer>
        </article>

        <?php
        if ( comments_open() || get_comments_number() ) :
            comments_template(); // Inclut le fichier comments.php si nécessaire
        endif;

    endwhile; // Fin de la boucle
    ?>

    </main>
</div>

<?php get_sidebar(); // Appelle le fichier sidebar.php ?>
<?php get_footer(); // Appelle le fichier footer.php ?>
