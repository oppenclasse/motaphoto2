<footer class="site-footer">
    <div class="container">
        <nav class="footer-navigation">
            <ul>
                <li><a href="<?php echo home_url('/mentions-legales'); ?>">Mentions légales</a></li>
                <li><a href="<?php echo home_url('/vie-privee'); ?>">Vie privée</a></li>
            </ul>
        </nav>
        <p class="rights">Tous droits réservés </p>
    </div>
</footer>


<!-- Modale de contact -->
<div id="contactModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form action="" method="post">
            <label for="name">Nom:</label>
            <input type="text" id="name" name="name">
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email">
            <label for="reference">Réf. Photo (optionnel):</label>
            <input type="text" id="reference" name="reference">
            <label for="message">Message:</label>
            <textarea id="message" name="message"></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>
<style>
    .site-footer {
    background-color: #fff; /* Définir la couleur de fond en blanc */
    height: 40px; /* Hauteur fixe de 40px */
    display: flex; /* Utiliser Flexbox pour le layout */
    align-items: center; /* Centrer les éléments verticalement */
    justify-content: center; /* Centrer les éléments horizontalement */
    padding: 0 10px; /* Un peu de padding sur les côtés */
    box-sizing: border-box; /* Inclut le padding et la bordure dans la largeur et la hauteur */
}
.footer-navigation ul {

    padding: 0; /* Enlève le padding par défaut des listes */
    margin: 0; /* Enlève la marge par défaut des listes */
    display: flex; /* Utiliser Flexbox dans la liste */
}
.container{
    display:flex;
    align-items: center;
}

.footer-navigation ul {
    list-style-type: none; /* Enlève les puces des listes */
    padding: 0; /* Enlève le padding par défaut des listes */
    margin: 0; /* Enlève la marge par défaut des listes */
    display: flex; /* Utiliser Flexbox dans la liste */
    
}

.footer-navigation li {
    margin-right: 20px; /* Ajoute de la marge à droite de chaque lien */
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var modal = document.getElementById('contactModal');
    var closeBtn = document.getElementsByClassName('close')[0];

    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
