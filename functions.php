<?php

add_theme_support('post-thumbnails');
// Add custom styles and scripts
// Add custom taxonomy for map points
function create_taxonomy() {
    register_taxonomy(
        'map-point-category',
        array('map-point'),
        array(
            'label' => __('Map Point Category'),
            'rewrite' => array('slug' => 'map-point-category'),
            'capabilities' => array(
                'assign_terms' => 'list_users',
                'edit_terms' => 'list_users',
                'manage_terms' => 'list_users',
                'delete_terms' => 'list_users',
            ),
            'public' => true,
            'show_in_rest' => true,
            'query_var' => true
            )
        );
}

add_action('init', 'create_taxonomy');

// Create custom post types for mapping theme
function create_posttype() {
    register_post_type( 'map-point',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Map Points' ),
                'singular_name' => __( 'Map Point' )
            ),
            'supports' => array(
                'title',
                'editor',
                'thumbnail',
                'comments',
                'revisions',
                'custom-fields'
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'map-point'),
            'taxonomies' => array('map-point-category'),
            'show_in_rest' => true
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

//Add lat/long custom fields to REST API

add_action('rest_api_init', function(){
    $object_type = 'post';
    $latLngArgs = array( // Validate and sanitize the meta value.
        // Note: currently (4.7) one of 'string', 'boolean', 'integer',
        // 'number' must be used as 'type'. The default is 'string'.
        'type'         => 'string',
        // Shown in the schema for the meta key.
        'description'  => 'A meta key associated with a string meta value.',
        // Return a single value of the type.
        'single'       => true,
        // Show in the WP REST API response. Default: false.
        'show_in_rest' => true,
    );
    register_meta( $object_type, 'latitude', $latLngArgs );
    register_meta( $object_type, 'longitude', $latLngArgs );
});

function map_tool_add_scripts () {

    wp_register_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css');
    wp_enqueue_style('bootstrap');

    wp_enqueue_style( 'style', get_stylesheet_uri() );

    wp_register_style('font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css');
    wp_enqueue_style('font_awesome');


    wp_register_style('leaflet_css', 'https://unpkg.com/leaflet@1.2.0/dist/leaflet.css');
    wp_enqueue_style('leaflet_css');

    wp_register_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', null, null, true);
    wp_enqueue_script('popper');

    wp_register_script('jQuery3','https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', null, null, true);
    wp_enqueue_script('jQuery3');

    wp_register_script('bootstrap_js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', null, null, true);
    wp_enqueue_script('bootstrap_js');

    wp_register_script('leaflet_js', 'https://unpkg.com/leaflet@1.2.0/dist/leaflet.js', null, null, true);
    wp_enqueue_script('leaflet_js');

    //Here we need to load some different scripts for different templates
    if ( !is_front_page() ){
        wp_register_script('theme_js', get_template_directory_uri() . '/js/app.js', null, null, true );
        wp_enqueue_script('theme_js');
    }

    if ( is_page_template('add-point.php')){
        wp_register_script('add_page_js', get_template_directory_uri() . '/js/add-point.js', null, null, true );
        wp_enqueue_script('add_page_js');
    }

    if ( is_page_template('points.php')){
        wp_register_script('map_points_js', get_template_directory_uri() . '/js/map-points.js', null, null, true );
        wp_enqueue_script('map_points_js');
    }

    if ( is_singular('map-point') ){
        wp_register_script('single_map_point', get_template_directory_uri() . '/js/single-map-point.js', null, null, true );
        wp_enqueue_script('single_map_point');
    }

    if ( is_page_template('map.php')){
        wp_register_script('map_js', get_template_directory_uri() . '/js/map.js', null, null, true );
        wp_enqueue_script('map_js');
    }

    if ( is_tax()){
        wp_register_script('cat_js', get_template_directory_uri() . '/js/category.js', null, null, true );
        wp_enqueue_script('cat_js');
    }

}

add_action( 'wp_enqueue_scripts', 'map_tool_add_scripts' );

?>