<footer class="site-footer">
    <div class="container-footer">
        <nav class="footer-navigation">
            <ul>
                <li><a href="<?php echo home_url('/mentions-legales'); ?>">Mentions légales</a></li>
                <li><a href="<?php echo get_privacy_policy_url(); ?>">Vie privée</a></li>

            </ul>
        </nav>
        <p class="rights">Tous droits réservés</p>
    </div>
</footer>

<?php get_template_part('template-parts/contact-modal'); ?>  <!-- Inclusion de la modale -->
<?php wp_footer(); ?>
</body>
</html>
