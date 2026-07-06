<?php
/**
 * Single Software Related Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();
$categories = wp_get_post_terms( $post_id, 'software_category', array( 'fields' => 'ids' ) );
$platforms = get_field( 'software_platform', $post_id );
$license = get_field( 'software_license', $post_id );

// 1. Initial Attempt: Match Category, Platform, or License
$args = array(
    'post_type'      => 'software',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$tax_query = array();
if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
    $tax_query[] = array(
        'taxonomy' => 'software_category',
        'field'    => 'term_id',
        'terms'    => $categories,
    );
}
if ( ! empty( $tax_query ) ) {
    $args['tax_query'] = $tax_query;
}

$meta_query = array( 'relation' => 'OR' );
$has_meta = false;

if ( ! empty( $platforms ) && is_array( $platforms ) ) {
    $has_meta = true;
    foreach ( $platforms as $p ) {
        $meta_query[] = array(
            'key'     => 'software_platform',
            'value'   => $p,
            'compare' => 'LIKE',
        );
    }
}

if ( ! empty( $license ) ) {
    $has_meta = true;
    $meta_query[] = array(
        'key'     => 'software_license',
        'value'   => $license,
        'compare' => '=',
    );
}

if ( $has_meta ) {
    $args['meta_query'] = $meta_query;
}

$related_query = new WP_Query( $args );
$post_ids_collected = array( $post_id );

// 2. Fallback: If less than 4 posts found, supplement with same category posts
if ( $related_query->post_count < 4 ) {
    $posts_needed = 4 - $related_query->post_count;
    
    // Track already collected IDs to avoid duplicates
    if ( $related_query->have_posts() ) {
        foreach ( $related_query->posts as $p ) {
            $post_ids_collected[] = $p->ID;
        }
    }

    $fallback_args = array(
        'post_type'      => 'software',
        'posts_per_page' => $posts_needed,
        'post__not_in'   => $post_ids_collected,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
        $fallback_args['tax_query'] = array(
            array(
                'taxonomy' => 'software_category',
                'field'    => 'term_id',
                'terms'    => $categories,
            ),
        );
    }

    $fallback_query = new WP_Query( $fallback_args );
    
    // Combine queries if there are results
    if ( $fallback_query->have_posts() ) {
        $merged_posts = array_merge( $related_query->posts, $fallback_query->posts );
        $related_query->posts = $merged_posts;
        $related_query->post_count = count( $merged_posts );
        
        foreach ( $fallback_query->posts as $p ) {
            $post_ids_collected[] = $p->ID;
        }
    }
}

// 3. Last Fallback: If still less than 4, fetch any recent software
if ( $related_query->post_count < 4 ) {
    $posts_needed = 4 - $related_query->post_count;
    
    $final_args = array(
        'post_type'      => 'software',
        'posts_per_page' => $posts_needed,
        'post__not_in'   => $post_ids_collected,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    $final_query = new WP_Query( $final_args );
    
    if ( $final_query->have_posts() ) {
        $merged_posts = array_merge( $related_query->posts, $final_query->posts );
        $related_query->posts = $merged_posts;
        $related_query->post_count = count( $merged_posts );
    }
}

// If no posts at all, return
if ( ! $related_query->have_posts() ) {
    return;
}
?>

<section class="software-related-section mb-8" style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
    <h3 class="section-title mb-6" style="font-size: 22px;"><?php esc_html_e( 'Related Software', 'quantum-mentor-world' ); ?></h3>
    
    <div class="grid grid-cols-mobile-1 grid-tablet-2 grid-desktop-4 gap-6">
        <?php 
        // Reset query loop data for loop integration
        global $post;
        foreach ( $related_query->posts as $post ) :
            setup_postdata( $post );
            get_template_part( 'template-parts/cards/software-card' );
        endforeach; 
        wp_reset_postdata(); 
        ?>
    </div>
</section>
