<?php
/**
 * Thème Parent pour l'Immobilier
 * Fonctions du thème parent.
 */

 function enqueue_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_bootstrap');

// Enqueue parent theme styles
function parent_theme_styles() {
    // Enqueue parent theme stylesheet
    wp_enqueue_style('parent-style', get_template_directory_uri().'/style.css');
}
add_action('wp_enqueue_scripts', 'parent_theme_styles');

// Chargement de Carbon Fields
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action('after_setup_theme', 'crb_load');
function crb_load() {
    \Carbon_Fields\Carbon_Fields::boot();
}

// Ajoutez vos propres fonctions personnalisées ici

// Ajoutez la prise en charge des modèles de page personnalisés
add_theme_support('page-templates');
require('fields.php');

// Enregistrement du type de post personnalisé "Bien Immobilier"
function custom_post_type_bien_immobilier() {
    $labels = array(
        'name'                  => _x( 'Biens immobiliers', 'Post Type General Name', 'text_domain' ),
        'singular_name'         => _x( 'Bien immobilier', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'             => __( 'Biens immobiliers', 'text_domain' ),
    );
    $args = array(
        'label'                 => __( 'Tous les Bien immobilier', 'text_domain' ),
        'description'           => __( 'Tous les Biens immobiliers', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array(), // Liste vide pour ne pas afficher d'interface d'édition
        'hierarchical'          => false,
        'public'                => false, 
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_rest'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-home',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => true, 
        'publicly_queryable'    => false, 
        'capability_type'       => 'post',
    );
    register_post_type( 'bien_immobilier', $args );
}
add_action( 'init', 'custom_post_type_bien_immobilier', 0 );

// Enregistrement de la taxonomie "Type de bien"
function enregistrer_taxonomy_type_bien() {
    $labels = array(
        'name' => __( 'Types de biens' ),
        'singular_name' => __( 'Type de bien' ),
        'menu_name' => __( 'Types de biens' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'type_bien' ), // Slug utilisé dans l'URL
    );
    register_taxonomy( 'type_bien', array( 'post' ), $args );
}
add_action( 'init', 'enregistrer_taxonomy_type_bien' );  
