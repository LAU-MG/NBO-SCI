<?php
// Fonction pour ajouter un nouveau menu "Biens" dans la colonne de gauche

function ajouter_menu_biens() {
    add_menu_page(
        'biens',            // Titre de l'onglet
        'biens',            // Texte dans le menu
        'manage_options',   // Capabilité requise pour voir ce menu
        'biens',            // Slug du menu
        'afficher_page_biens', // Callback pour afficher la page
        'dashicons-admin-home', // Icône du menu (voir https://developer.wordpress.org/resource/dashicons/)
        30                   // Position du menu dans la colonne de gauche
    );
}

// Callback pour afficher la page du menu "Biens"
function afficher_page_biens() {
    // Affichez ici le contenu de la page du menu "Biens"
    echo '<h1>Page des biens</h1>';
}

// Action pour ajouter le menu "Biens"
add_action('admin_menu', 'ajouter_menu_biens');
