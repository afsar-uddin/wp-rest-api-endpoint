<?php 


add_action('rest_api_init', 'nwt_rest_api_init');
function nwt_rest_api_init() {
    // notions post list
    register_rest_route('nwt/api/v1', '/notions', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'nwt_notion_rest_api',
        'permission_callback' => '__return_true'
    ));

    // notion product detail rout
    register_rest_route('nwt/api/v1', '/notion/(?P<id>\d+)', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'nwt_notion_detail_rest_api',
        'permission_callback' => '__return_true'
    ));

    //  notion category list
    register_rest_route('nwt/api/v1', '/notions-categories', array(
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'nwt_notion_cat_rest_api',
        'permission_callback' => '__return_true'
    ));
}

// callback notion
function nwt_notion_rest_api($id) {
    // query
    $args_notion_query = array(
        'post_type' => array('notion'),
        'post_status' => array('publish'),
        'posts_per_page' => -1,
        'nopaging' => true,
        'order' => 'DESC',
        'orderby' => 'date',
    );

    // var_dump($args_notion_query);

    $taxonomy = 'notion_cat';

    if(isset($id['category_id'])) {
        $args_notion_query['tax_query'] = [
            [
                'taxonomy'  => $taxonomy,
                'field'     => 'term_id',
                'terms'     => $id['category_id']
            ]
        ];
    }

    $notion_query = new WP_Query($args_notion_query);
    
    if ($notion_query->have_posts()) {
        $counter = 0;
        $notions = array();

        // category
        $notion_id = get_the_ID();
        $notion_categories = wp_get_post_terms($notion_id, 'notion_cat');

        $category_names = array();

        foreach ($notion_categories as $category) {
            $category_names[] = $category->name;
        }

        
        while ($notion_query->have_posts()) {
            $notion_query->the_post();
            
            $notion_categories = wp_get_post_terms(get_the_ID(), 'notion_cat');
            $category_names = array();
            $notion_detail_post_url = get_permalink(get_the_ID());

            // ic_var_dump($notion_detail_post_url);
        
            foreach ($notion_categories as $category) {
                $category_names[] = $category->name;
            }

            $notions[$counter] = array(
                'notion_title' => get_the_title(),
                'notion_id' => get_the_ID(),
                'notion_imageURL' => has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '',
                'notion_cat' => $category_names,
                'notion_detail_link' => $notion_detail_post_url
            );

            $counter++;
        }

        wp_reset_postdata();

        return rest_ensure_response($notions);
    } else {
        wp_reset_postdata();

        return new WP_Error('not-found', esc_html__('No notions found.', 'gamingresourceshelper'), array('status' => 404));
    }
}

// callback notion detail 
function nwt_notion_detail_rest_api($request) {
    $notion_detail = [];

    $params = $request->get_params();
    $notion_id = $params['id'];
    $notion_post = get_post($notion_id);

    if(empty($notion_post)) {
        return new WP_Error( 'notion_not_found', 'Notion post not found', array( 'status' => 404 ) );
    }

    $featured_image_url = get_the_post_thumbnail_url( $notion_post, 'full' ); 


    $notion_detail = array(
        'notion_id' => $notion_post->ID,
        'notion_title' => $notion_post->post_title,
        'notion_content' => $notion_post->post_content,
        'notion_img_url' => $featured_image_url,
    );

    return rest_ensure_response($notion_detail);


    // ic_var_dump($notion_post);

   

}

// callback notions categories
function nwt_notion_cat_rest_api() {
    $taxonomy = 'notion_cat';

    $get_notions_term = array(
        'taxonomy' => $taxonomy,
        'hide_empty' => true,
        'parent' => 0
    );

    $notion_categories = get_terms($get_notions_term);

    $counter = 0;
    $categories = [];

    if(!empty($notion_categories) && !is_wp_error($notion_categories)) : 

        foreach($notion_categories as $cat_index => $cat_item):

            $notion_cat_thumb_id = get_term_meta($cat_item->term_id, 'cat_thumbnail', true);
            $notion_cat_thumb_id_url = $notion_cat_thumb_id ? wp_get_attachment_image_url($notion_cat_thumb_id, 'full') : '';
            $term_link = get_term_link($cat_item->term_id, $taxonomy);

            // ic_var_dump($term_link);

            // get_term_description($cat_item->term_id, $taxonomy);

            $categories[$counter] = [
                'cat_id' => $cat_item->term_id,
                'cat_name' => $cat_item->name,
                'cat_slug' => $cat_item->slug,
                'cat_description' => $cat_item->description,
                'cat_thumb' => $notion_cat_thumb_id_url,
                'cat_link' => $term_link
            ];
            $counter++;           
        endforeach;
    endif;
    
    if ($categories) {
        return rest_ensure_response($categories);
    } else {
        return new WP_Error('not-found', esc_html__('No categories found.', 'gamingresourceshelper'), array('status' => 404));
    }


}
