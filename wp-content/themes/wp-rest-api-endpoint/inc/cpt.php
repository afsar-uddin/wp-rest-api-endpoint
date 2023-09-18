<?php 

// Register Custom Post Type
function custom_notion_post_type() {
    $labels = array(
        'name'                  => _x( 'Notions', 'Post Type General Name', 'jptradingfzc' ),
        'singular_name'         => _x( 'Notion', 'Post Type Singular Name', 'jptradingfzc' ),
        'menu_name'             => __( 'Notions', 'jptradingfzc' ),
        'all_items'             => __( 'All Notions', 'jptradingfzc' ),
        'add_new'               => __( 'Add New', 'jptradingfzc' ),
        'add_new_item'          => __( 'Add New Notion', 'jptradingfzc' ),
        'edit_item'             => __( 'Edit Notion', 'jptradingfzc' ),
        'new_item'              => __( 'New Notion', 'jptradingfzc' ),
        'view_item'             => __( 'View Notion', 'jptradingfzc' ),
        'search_items'          => __( 'Search Notions', 'jptradingfzc' ),
        'not_found'             => __( 'No Notions found', 'jptradingfzc' ),
        'not_found_in_trash'    => __( 'No Notions found in Trash', 'jptradingfzc' ),
        'parent_item_colon'     => __( 'Parent Notion:', 'jptradingfzc' ),
        'menu_name'             => __( 'Notions', 'jptradingfzc' ),
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable' => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'          => true,
        'rewrite'               => array( 'slug' => 'notion' ),
        'capability_type'    => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'      => 5,
        'show_in_nav_menus'     => true,
        'show_in_admin_bar'     => true,
        'menu_icon'             => 'dashicons-cart',
        'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'taxonomies'         => array('notion_cat' ),
        'show_in_rest'       => true
    );

    register_post_type( 'notion', $args );
}
add_action( 'init', 'custom_notion_post_type', 0 );

// Register Custom Taxonomy
function custom_notion_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Notion Categories', 'Taxonomy General Name', 'jptradingfzc' ),
        'singular_name'              => _x( 'Notion Category', 'Taxonomy Singular Name', 'jptradingfzc' ),
        'menu_name'                  => __( 'Notion Categories', 'jptradingfzc' ),
        'all_items'                  => __( 'All Categories', 'jptradingfzc' ),
        'parent_item'                => __( 'Parent Category', 'jptradingfzc' ),
        'parent_item_colon'          => __( 'Parent Category:', 'jptradingfzc' ),
        'new_item_name'              => __( 'New Category Name', 'jptradingfzc' ),
        'add_new_item'               => __( 'Add New Category', 'jptradingfzc' ),
        'edit_item'                  => __( 'Edit Category', 'jptradingfzc' ),
        'update_item'                => __( 'Update Category', 'jptradingfzc' ),
        'separate_items_with_commas' => __( 'Separate categories with commas', 'jptradingfzc' ),
        'search_items'               => __( 'Search Categories', 'jptradingfzc' ),
        'add_or_remove_items'        => __( 'Add or remove categories', 'jptradingfzc' ),
        'choose_from_most_used'      => __( 'Choose from the most used categories', 'jptradingfzc' ),
    );

    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'rewrite'                    => array( 'slug' => 'notion_cat' ),
    );

    register_taxonomy( 'notion_cat', array( 'notion' ), $args );
}
add_action( 'init', 'custom_notion_taxonomy', 0 );
