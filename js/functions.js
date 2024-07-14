jQuery(document).ready(function($) {
    let page = 1;
    let loading = false;

    function loadPosts() {
        if (loading) return;
        loading = true;
        $('#loading-indicator').show();

        const data = {
            action: 'load_photos',
            page: page,
            categorie: $('#categorie-filter').val(),
            format: $('#format-filter').val(),
            sort: $('#sort-filter').val()
        };

        $.ajax({
            url: ajax_params.ajaxurl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#loading-indicator').hide();
                if (response) {
                    $('#photo-gallery').append(response);
                    page++;
                    loading = false;
                } else {
                    $('#load-more').hide();
                }
            }
        });
    }

    $('#load-more').on('click', function() {
        loadPosts();
    });

    $('#categorie-filter, #format-filter, #sort-filter').on('change', function() {
        $('#photo-gallery').html('');
        page = 1;
        loadPosts();
    });

    // Initial load
    loadPosts();
});

// single
jQuery(document).ready(function($) {
    var modal = $('#contactModal');
    var btn = $('#contact-link');
    var span = $('.close')[0];

    // Quand l'utilisateur clique sur le bouton, ouvrir la modale
    btn.on('click', function(event) {
        event.preventDefault();
        var reference = "<?php the_field('reference'); ?>"; // Récupérer la valeur de la référence
        modal.css('display', 'block');
        
        // Ajouter la référence au champ "Réf PHOTO" du formulaire Contact Form 7
        document.querySelector('[name="your-subject"]').value = reference;
    });

    // Quand l'utilisateur clique sur la croix, fermer la modale
    span.onclick = function() {
        modal.css('display', 'none');
    };

    // Quand l'utilisateur clique en dehors de la modale, fermer la modale
    window.onclick = function(event) {
        if (event.target == modal[0]) {
            modal.css('display', 'none');
        }
    };

    // Gérer l'affichage des miniatures au survol des flèches
    var prevLink = $('.prev-link');
    var nextLink = $('.next-link');
    var prevThumbnail = prevLink.find('.prev-thumbnail');
    var nextThumbnail = nextLink.find('.next-thumbnail');

    prevLink.hover(
        function() {
            prevThumbnail.css('display', 'block');
        },
        function() {
            prevThumbnail.css('display', 'none');
        }
    );

    nextLink.hover(
        function() {
            nextThumbnail.css('display', 'block');
        },
        function() {
            nextThumbnail.css('display', 'none');
        }
    );
});

