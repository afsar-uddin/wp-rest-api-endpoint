<?php 

// add_action('rest_api_init', 'nwt_rest_api_init');
// function nwt_rest_api_init() {

//     // Products
//     register_rest_route('nwt/api/v1', '/products', array(
//         'methods' => WP_REST_Server::READABLE,
//         'callback' => 'nwt_product_rest_api',
//         'permission_callback' => '__return_true'
//     ));
// }

// // callback product
// function nwt_product_rest_api() {
//     // query
//     $args_product_query = array(
//         'post_type' => array('product'),
//         'post_status' => array('publish'),
//         'posts_per_page' => -1,
//         'nopaging' => true,
//         'order' => 'DESC',
//         'orderby' => 'date',
//     );

//     $product_query = new WP_Query($args_product_query);

//     if ($product_query->have_posts()) {

//         $counter = 0;

//         $products = [];

//         while ($product_query->have_posts()) {

//             $product_query->the_post();

//             $products[$counter] = [
//                 // 'metadata'           => get_post_meta(get_the_ID(), 'slider_link', true),
//                 'product_title'        => get_the_title(),
//                 'product_id'           => get_the_ID(),
//                 'product_imageURL'     => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '',
//                 // 'metadataBrowse'     => get_post_meta(get_the_ID(), 'slider_link_target', true),
//             ];

//             $counter++;
//         }

//         return rest_ensure_response($products);
//     } else {

//         return new WP_Error('not-found', esc_html__('No slider found.', 'gamingresourceshelper'), array('status' => 404));
//     }
//     wp_reset_postdata();
// }


add_action('rest_api_init', 'nwt_rest_api_init');
function nwt_rest_api_init() {
    // Products
    register_rest_route('nwt/api/v1', '/products', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'nwt_product_rest_api',
        'permission_callback' => '__return_true'
    ));
}

// callback product
function nwt_product_rest_api($id) {
    // query
    $args_product_query = array(
        'post_type' => array('product'),
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'nopaging' => true,
        'order' => 'DESC',
        'orderby' => 'date',
    );

    // var_dump($args_product_query);

    $taxonomy = 'product_cat';

    if(isset($id['category_id'])) {
        $args_product_query['tax_query'] = [
            [

                'taxonomy'  => $taxonomy,

                'field'     => 'term_id',

                'terms'     => $id['category_id']

            ]
        ];
    }

    
    $product_query = new WP_Query($args_product_query);
    
    
    if ($product_query->have_posts()) {
        $counter = 0;
        $products = array();

        // category
        $product_id = get_the_ID();
        $product_categories = wp_get_post_terms($product_id, 'product_cat');

        $category_names = array();

        foreach ($product_categories as $category) {
            $category_names[] = $category->name;
        }

        var_dump($category_names);
        
        while ($product_query->have_posts()) {
            $product_query->the_post();

            $products[$counter] = array(
                'product_title' => get_the_title(),
                'product_id' => get_the_ID(),
                'product_imageURL' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '',
                'product_cat' => $category_names,
            );

            $counter++;
        }

        wp_reset_postdata();

        return rest_ensure_response($products);
    } else {
        wp_reset_postdata();

        return new WP_Error('not-found', esc_html__('No products found.', 'gamingresourceshelper'), array('status' => 404));
    }
}
