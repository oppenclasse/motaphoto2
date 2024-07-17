// Ce code utilise jQuery et AJAX pour charger des publications de manière dynamique en fonction de filtres, gérer des interactions avec des éléments de l'interface utilisateur tels que des modales et des menus.

// Attente que le DOM soit prêt
jQuery(document).ready(function($) {
    let page = 1; // Page initiale pour la pagination
    let loading = false; // Indicateur de chargement

    // Fonction pour charger des publications
    function loadPosts() {
        if (loading) return; // Si déjà en chargement, ne rien faire
        loading = true; // Définir l'état de chargement à vrai
        $('#loading-indicator').show(); // Afficher l'indicateur de chargement

        // Préparer les données à envoyer avec la requête AJAX
        const data = {
            action: 'load_photos',
            page: page,
            categorie: $('#categorie-filter').val(),
            format: $('#format-filter').val(),
            sort: $('#year-sort-filter').val()
        };
        console.log(data); // Afficher les données dans la console

        // Effectuer une requête AJAX
        $.ajax({
            url: ajax_params.ajaxurl,
            type: 'POST',
            data: data,
            success: function(response) {
                $('#loading-indicator').hide(); // Masquer l'indicateur de chargement
                if (response) {
                    $('#photo-gallery').append(response); // Ajouter la réponse à la galerie
                    page++; // Incrémenter le numéro de page
                    loading = false; // Réinitialiser l'état de chargement
                } else {
                    $('#load-more').hide(); // Masquer le bouton charger plus si aucune réponse
                }
            }
        });
    }

    // Gestion du clic sur le bouton 'charger plus'
    $('#load-more').on('click', function() {
        loadPosts();
    });

    // Gestion des changements sur les filtres
    $('#categorie-filter, #format-filter, #year-sort-filter').on('change', function() {
        $('#photo-gallery').html(''); // Effacer le contenu actuel de la galerie
        page = 1; // Réinitialiser la pagination à la première page
        loadPosts(); // Recharger les posts avec les nouveaux filtres
    });
    

    // Chargement initial des posts
    loadPosts();
});

// Gestion des modales et interaction utilisateur
jQuery(document).ready(function($) {
    var modal = $('#contactModal'); // Sélection de la modale
    var btns = $('#contact-link, #acontact-link'); // Sélection des boutons d'ouverture
    var span = $('.close')[0]; // Sélection du bouton de fermeture

    // Ouverture de la modale à partir des boutons
    btns.on('click', function(event) {
        event.preventDefault();
        var reference =  $(this).data('reference'); // Récupération de la référence
        modal.css('display', 'block'); // Affichage de la modale
        
        // Mise à jour du champ sujet dans le formulaire
        document.querySelector('[name="your-subject"]').value = reference;
    });

    // Fermeture de la modale via le bouton de fermeture
    span.onclick = function() {
        modal.css('display', 'none');
    };

    // Fermeture de la modale en cliquant en dehors
    window.onclick = function(event) {
        if (event.target == modal[0]) {
            modal.css('display', 'none');
        }
    };

    // Gestion de l'affichage des miniatures au survol des flèches de navigation
    var prevLink = $('.prev-link');
    var nextLink = $('.next-link');
    var prevThumbnail = prevLink.find('.prev-thumbnail');
    var nextThumbnail = nextLink.find('.next-thumbnail');

    prevLink.hover(
        function() {
            prevThumbnail.css('display', 'block'); // Afficher la miniature précédente
        },
        function() {
            prevThumbnail.css('display', 'none'); // Masquer la miniature précédente
        }
    );

    nextLink.hover(
        function() {
            nextThumbnail.css('display', 'block'); // Afficher la miniature suivante
        },
        function() {
            nextThumbnail.css('display', 'none'); // Masquer la miniature suivante
        }
    );
});
// Script pour améliorer le style de la sélection via le plugin Select2
$(document).ready(function() {
    // Initialiser Select2 pour les sélections personnalisées
    $('.custom-select').select2();

    // Gérer l'ouverture des listes déroulantes
    $('.custom-select').on('select2:open', function() {
        // Marquer l'option sélectionnée lors de l'ouverture
        $('.select2-results__option[aria-selected=true]').addClass('select2-results__option--selected');

        // Ajouter des effets visuels lors du survol des options
        $('.select2-results__option').off('mouseenter').on('mouseenter', function() {
            $('.select2-results__option--selected').addClass('select2-results__option--hovered');
            $(this).addClass('select2-results__option--selected');
        }).off('mouseleave').on('mouseleave', function() {
            $(this).removeClass('select2-results__option--selected');
            $('.select2-results__option--hovered').removeClass('select2-results__option--hovered');
        });

        // Gérer le clic sur les options
        $('.select2-results__option').off('mousedown').on('mousedown', function() {
            $(this).addClass('select2-results__option--clicked');
        }).off('mouseup').on('mouseup', function() {
            $(this).removeClass('select2-results__option--clicked');
        });
    });

    // Gérer la sélection d'options
    $('.custom-select').on('select2:select', function(e) {
        // Nettoyer les options précédemment sélectionnées
        $('.select2-results__option--selected').removeClass('select2-results__option--selected');
        // Marquer la nouvelle option sélectionnée
        $('.select2-results__option[aria-selected=true]').addClass('select2-results__option--selected');
    });
});

// Script pour la gestion des menus mobiles
document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.querySelector('.menu-toggle'); // Bouton de menu
    var navigation = document.querySelector('.site-navigation'); // Navigation du site

    // Basculer la visibilité du menu mobile
    toggle.addEventListener('click', function () {
        navigation.classList.toggle('active'); // Activer/désactiver la navigation
        toggle.textContent = toggle.textContent === '☰' ? '✖' : '☰'; // Changer l'icône du menu
    });
});
