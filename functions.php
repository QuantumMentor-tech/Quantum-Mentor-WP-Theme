<?php
/**
 * Quantum Mentor Theme functions and definitions
 *
 * @package Quantum_Mentor_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * 1. Theme Setup
 */
function quantum_mentor_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Switch default core markup for search form, comment form, etc. to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Enable Custom Logo Support
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ) );
}
add_action( 'after_setup_theme', 'quantum_mentor_theme_setup' );

/**
 * 2. Enqueue Scripts and Styles
 */
function quantum_mentor_theme_scripts() {
    // Enqueue Google Fonts (Outfit & Inter)
    wp_enqueue_style( 'quantum-mentor-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@500;600;700;800&display=swap', array(), null );

    // Enqueue Main Stylesheet (Vanilla CSS Design System)
    wp_enqueue_style( 'quantum-mentor-style', get_stylesheet_uri(), array(), '1.0.0' );
    wp_enqueue_style( 'quantum-mentor-global', get_template_directory_uri() . '/assets/css/global.css', array( 'quantum-mentor-style' ), '1.0.0' );

    // Enqueue Frontend Javascript (Menu logic, interactive card events)
    wp_enqueue_script( 'quantum-mentor-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );

    // Enqueue AJAX Live Search Script
    wp_enqueue_script( 'quantum-mentor-search', get_template_directory_uri() . '/assets/js/search-ajax.js', array(), '1.0.0', true );

    // Localize search script for AJAX variables
    wp_localize_script( 'quantum-mentor-search', 'quantum_search_params', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'quantum_search_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'quantum_mentor_theme_scripts' );

/**
 * 3. Register Custom Post Types (CPTs)
 */
function quantum_mentor_register_cpts() {
    $cpts = array(
        'software' => array(
            'single'   => 'Software',
            'plural'   => 'Software',
            'menu_icon'=> 'dashicons-desktop',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'software',
        ),
        'themes_plugins' => array(
            'single'   => 'Theme & Plugin',
            'plural'   => 'Themes & Plugins',
            'menu_icon'=> 'dashicons-admin-plugins',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'themes-plugins',
        ),
        'games' => array(
            'single'   => 'Game',
            'plural'   => 'Games',
            'menu_icon'=> 'dashicons-games',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'games',
        ),
        'books' => array(
            'single'   => 'Book',
            'plural'   => 'Books',
            'menu_icon'=> 'dashicons-book-alt',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'books',
        ),
        'watch' => array(
            'single'   => 'Watch Item',
            'plural'   => 'Watch Content',
            'menu_icon'=> 'dashicons-video-alt3',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'watch',
        ),
        'tools' => array(
            'single'   => 'Tool',
            'plural'   => 'Online Tools',
            'menu_icon'=> 'dashicons-admin-tools',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'tools',
        ),
        'news' => array(
            'single'   => 'News Article',
            'plural'   => 'AI & Tech News',
            'menu_icon'=> 'dashicons-megaphone',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'news',
        ),
        'github_repos' => array(
            'single'   => 'GitHub Repo',
            'plural'   => 'GitHub Repos',
            'menu_icon'=> 'dashicons-networking',
            'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'author' ),
            'slug'     => 'github-repos',
        ),
    );

    foreach ( $cpts as $slug => $cpt ) {
        $labels = array(
            'name'               => _x( $cpt['plural'], 'post type general name', 'quantum-mentor' ),
            'singular_name'      => _x( $cpt['single'], 'post type singular name', 'quantum-mentor' ),
            'menu_name'          => _x( $cpt['plural'], 'admin menu', 'quantum-mentor' ),
            'name_admin_bar'     => _x( $cpt['single'], 'add new on admin bar', 'quantum-mentor' ),
            'add_new'            => _x( 'Add New', $slug, 'quantum-mentor' ),
            'add_new_item'       => __( 'Add New ' . $cpt['single'], 'quantum-mentor' ),
            'new_item'           => __( 'New ' . $cpt['single'], 'quantum-mentor' ),
            'edit_item'          => __( 'Edit ' . $cpt['single'], 'quantum-mentor' ),
            'view_item'          => __( 'View ' . $cpt['single'], 'quantum-mentor' ),
            'all_items'          => __( 'All ' . $cpt['plural'], 'quantum-mentor' ),
            'search_items'       => __( 'Search ' . $cpt['plural'], 'quantum-mentor' ),
            'not_found'          => __( 'No ' . strtolower($cpt['plural']) . ' found.', 'quantum-mentor' ),
            'not_found_in_trash' => __( 'No ' . strtolower($cpt['plural']) . ' found in Trash.', 'quantum-mentor' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => $cpt['slug'] ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => $cpt['menu_icon'],
            'supports'           => $cpt['supports'],
            'show_in_rest'       => true, // Block Editor and REST API support
        );

        register_post_type( $slug, $args );
    }
}
add_action( 'init', 'quantum_mentor_register_cpts' );

/**
 * 4. Register Custom Taxonomies
 */
function quantum_mentor_register_taxonomies() {
    $taxonomies = array(
        'software_category' => array(
            'single'    => 'Software Category',
            'plural'    => 'Software Categories',
            'post_type' => array( 'software' ),
        ),
        'software_tag' => array(
            'single'    => 'Software Tag',
            'plural'    => 'Software Tags',
            'post_type' => array( 'software' ),
        ),
        'theme_plugin_category' => array(
            'single'    => 'Theme & Plugin Category',
            'plural'    => 'Theme & Plugin Categories',
            'post_type' => array( 'themes_plugins' ),
        ),
        'theme_plugin_tag' => array(
            'single'    => 'Theme & Plugin Tag',
            'plural'    => 'Theme & Plugin Tags',
            'post_type' => array( 'themes_plugins' ),
        ),
        'game_category' => array(
            'single'    => 'Game Category',
            'plural'    => 'Game Categories',
            'post_type' => array( 'games' ),
        ),
        'game_tag' => array(
            'single'    => 'Game Tag',
            'plural'    => 'Game Tags',
            'post_type' => array( 'games' ),
        ),
        'book_category' => array(
            'single'    => 'Book Category',
            'plural'    => 'Book Categories',
            'post_type' => array( 'books' ),
        ),
        'book_tag' => array(
            'single'    => 'Book Tag',
            'plural'    => 'Book Tags',
            'post_type' => array( 'books' ),
        ),
        'watch_category' => array(
            'single'    => 'Watch Category',
            'plural'    => 'Watch Categories',
            'post_type' => array( 'watch' ),
        ),
        'watch_tag' => array(
            'single'    => 'Watch Tag',
            'plural'    => 'Watch Tags',
            'post_type' => array( 'watch' ),
        ),
        'tool_category' => array(
            'single'    => 'Tool Category',
            'plural'    => 'Tool Categories',
            'post_type' => array( 'tools' ),
        ),
        'tool_tag' => array(
            'single'    => 'Tool Tag',
            'plural'    => 'Tool Tags',
            'post_type' => array( 'tools' ),
        ),
        'news_category' => array(
            'single'    => 'News Category',
            'plural'    => 'News Categories',
            'post_type' => array( 'news' ),
        ),
        'news_tag' => array(
            'single'    => 'News Tag',
            'plural'    => 'News Tags',
            'post_type' => array( 'news' ),
        ),
        'repo_category' => array(
            'single'    => 'GitHub Repo Category',
            'plural'    => 'GitHub Repo Categories',
            'post_type' => array( 'github_repos' ),
        ),
        'repo_tag' => array(
            'single'    => 'GitHub Repo Tag',
            'plural'    => 'GitHub Repo Tags',
            'post_type' => array( 'github_repos' ),
        ),
    );

    foreach ( $taxonomies as $slug => $tax ) {
        $labels = array(
            'name'              => _x( $tax['plural'], 'taxonomy general name', 'quantum-mentor' ),
            'singular_name'     => _x( $tax['single'], 'taxonomy singular name', 'quantum-mentor' ),
            'search_items'      => __( 'Search ' . $tax['plural'], 'quantum-mentor' ),
            'all_items'         => __( 'All ' . $tax['plural'], 'quantum-mentor' ),
            'parent_item'       => __( 'Parent ' . $tax['single'], 'quantum-mentor' ),
            'parent_item_colon' => __( 'Parent ' . $tax['single'] . ':', 'quantum-mentor' ),
            'edit_item'         => __( 'Edit ' . $tax['single'], 'quantum-mentor' ),
            'update_item'       => __( 'Update ' . $tax['single'], 'quantum-mentor' ),
            'add_new_item'      => __( 'Add New ' . $tax['single'], 'quantum-mentor' ),
            'new_item_name'     => __( 'New ' . $tax['single'] . ' Name', 'quantum-mentor' ),
            'menu_name'         => __( $tax['plural'], 'quantum-mentor' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => str_replace('_', '-', $slug) ),
            'show_in_rest'      => true,
        );

        register_taxonomy( $slug, $tax['post_type'], $args );
    }
}
add_action( 'init', 'quantum_mentor_register_taxonomies' );

/**
 * 4.1. Auto-Seed Custom Taxonomy Categories
 */
function quantum_mentor_seed_categories() {
    if ( get_option( 'quantum_mentor_categories_seeded' ) ) {
        return;
    }

    $seeding_data = array(
        'software_category' => array(
            'Windows', 'Mac', 'Linux', 'Android', 'iPhone', 'AI Apps', 'Utilities', 'Security', 'Productivity', 'Developer Tools'
        ),
        'theme_plugin_category' => array(
            'WordPress Themes', 'WordPress Plugins', 'WooCommerce', 'Shopify', 'Hostinger', 'GoDaddy', 'Blogger Templates'
        ),
        'game_category' => array(
            'PC Games', 'Mobile Games', 'Browser Games', 'Open Source Games', 'Educational Games', 'Action', 'Adventure', 'Puzzle', 'Racing'
        ),
        'book_category' => array(
            'Educational', 'Religious', 'Programming', 'Business', 'Novels', 'AI', 'Freelancing', 'Marketing', 'History', 'Science'
        ),
        'watch_category' => array(
            'Movies', 'Courses', 'Anime', 'Donghua', 'Tutorials', 'Documentaries'
        ),
        'tool_category' => array(
            'File Converter', 'PDF Tools', 'Image Tools', 'Video Tools', 'Text Tools', 'AI Tools', 'SEO Tools', 'Developer Tools'
        ),
        'news_category' => array(
            'AI News', 'Software News', 'Games News', 'OS News', 'Themes News', 'Tools News', 'Movies News', 'Anime News'
        ),
        'repo_category' => array(
            'AI', 'Web Development', 'Mobile Development', 'Python', 'JavaScript', 'Automation', 'SEO', 'Marketing', 'WordPress', 'Security'
        ),
    );

    foreach ( $seeding_data as $taxonomy => $terms ) {
        foreach ( $terms as $term ) {
            if ( ! term_exists( $term, $taxonomy ) ) {
                wp_insert_term( $term, $taxonomy );
            }
        }
    }

    update_option( 'quantum_mentor_categories_seeded', 1 );
}
add_action( 'admin_init', 'quantum_mentor_seed_categories' );


/**
 * 5. Live AJAX Search Implementation
 */
function quantum_ajax_live_search() {
    // Verify security nonce
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'quantum_search_nonce' ) ) {
        wp_send_json_error( 'Forbidden', 403 );
    }

    $query = isset( $_POST['query'] ) ? sanitize_text_field( $_POST['query'] ) : '';

    if ( empty( $query ) ) {
        wp_send_json_success( array() );
    }

    $args = array(
        'post_type'      => array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'news', 'tools', 'github_repos' ),
        'posts_per_page' => 8,
        's'              => $query,
    );

    $search_query = new WP_Query( $args );
    $results = array();

    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            $thumbnail = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );
            if ( ! $thumbnail ) {
                // Fallback placeholder gradient image structure
                $thumbnail = 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80"><rect width="80" height="80" fill="%231E293B"/><text x="50%" y="55%" dominant-baseline="middle" text-anchor="middle" fill="%2300D4FF" font-family="Outfit" font-size="24">QM</text></svg>';
            }

            // Capitalize CPT name for beautiful badge display
            $cpt_obj = get_post_type_object( get_post_type() );
            $cpt_label = $cpt_obj ? $cpt_obj->labels->singular_name : 'Resource';

            $results[] = array(
                'id'        => get_the_ID(),
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'thumbnail' => $thumbnail,
                'type'      => $cpt_label,
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $results );
}
add_action( 'wp_ajax_quantum_live_search', 'quantum_ajax_live_search' );
add_action( 'wp_ajax_nopriv_quantum_live_search', 'quantum_ajax_live_search' );

/**
 * 6. Security Hardening
 */
// Disable XML-RPC to prevent brute force and DDoS attacks
add_filter( 'xmlrpc_enabled', '__return_false' );

// Remove generator meta tags (hides WordPress version)
remove_action( 'wp_head', 'wp_generator' );

// Add custom security headers
function quantum_add_security_headers( $headers ) {
    if ( ! is_admin() ) {
        $headers['X-Frame-Options']           = 'SAMEORIGIN';
        $headers['X-Content-Type-Options']     = 'nosniff';
        $headers['X-XSS-Protection']           = '1; mode=block';
        $headers['Content-Security-Policy']    = "default-src 'self' https: data: 'unsafe-inline' 'unsafe-eval'; frame-src 'self' https://www.youtube.com https://player.vimeo.com https://*.github.com;";
        $headers['Referrer-Policy']            = 'no-referrer-when-downgrade';
    }
    return $headers;
}
add_filter( 'wp_headers', 'quantum_add_security_headers' );

// Helper function to safely output video embed HTML codes
function quantum_get_safe_embed( $embed_code ) {
    $allowed_html = array(
        'iframe' => array(
            'src'             => true,
            'width'           => true,
            'height'          => true,
            'frameborder'     => true,
            'allowfullscreen' => true,
            'scrolling'       => true,
            'class'           => true,
            'id'              => true,
            'style'           => true,
            'allow'           => true,
        ),
    );
    return wp_kses( $embed_code, $allowed_html );
}

/**
 * 7. Dynamic JSON-LD Schema Generator
 */
function quantum_render_json_ld_schema() {
    if ( ! is_singular() ) {
        return;
    }

    global $post;
    $post_id = $post->ID;
    $post_type = get_post_type($post_id);

    $schema = array();

    switch ( $post_type ) {
        case 'software':
            $version   = get_post_meta( $post_id, 'software_version', true );
            $license   = get_post_meta( $post_id, 'software_license', true );
            $platforms = get_post_meta( $post_id, 'software_platform', true );
            $operating_system = is_array( $platforms ) ? implode( ', ', $platforms ) : $platforms;

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => 'SoftwareApplication',
                'name'                => get_the_title( $post_id ),
                'operatingSystem'     => ! empty( $operating_system ) ? esc_html( $operating_system ) : 'Windows, macOS, Linux, Android, iOS',
                'applicationCategory' => 'EducationalApplication',
                'softwareVersion'     => ! empty( $version ) ? esc_html( $version ) : '1.0.0',
                'offers'              => array(
                    '@type'         => 'Offer',
                    'price'         => '0.00',
                    'priceCurrency' => 'USD',
                ),
            );
            break;

        case 'watch':
            $release_year = get_post_meta( $post_id, 'watch_release_year', true );
            $genre_terms  = wp_get_post_terms( $post_id, 'watch_genre', array( 'fields' => 'names' ) );
            $genres       = ! is_wp_error( $genre_terms ) ? implode( ', ', $genre_terms ) : 'Educational';

            $schema = array(
                '@context'    => 'https://schema.org',
                '@type'       => 'VideoObject',
                'name'        => get_the_title( $post_id ),
                'description' => get_the_excerpt( $post_id ),
                'thumbnailUrl'=> get_the_post_thumbnail_url( $post_id, 'large' ),
                'uploadDate'  => get_the_date( 'c', $post_id ),
                'genre'       => esc_html( $genres ),
            );
            if ( ! empty( $release_year ) ) {
                $schema['dateCreated'] = esc_html( $release_year );
            }
            break;

        case 'books':
            $author_terms = wp_get_post_terms( $post_id, 'book_author', array( 'fields' => 'names' ) );
            $author       = ! is_wp_error( $author_terms ) && ! empty( $author_terms ) ? $author_terms[0] : 'Educational Mentor';

            $schema = array(
                '@context' => 'https://schema.org',
                '@type'    => 'Book',
                'name'     => get_the_title( $post_id ),
                'author'   => array(
                    '@type' => 'Person',
                    'name'  => esc_html( $author ),
                ),
                'bookFormat' => 'https://schema.org/EBook',
            );
            break;

        case 'github_repos':
            $lang_terms = wp_get_post_terms( $post_id, 'repo_language', array( 'fields' => 'names' ) );
            $language   = ! is_wp_error( $lang_terms ) && ! empty( $lang_terms ) ? $lang_terms[0] : 'JavaScript';
            $repo_url   = get_post_meta( $post_id, 'repo_url', true );

            $schema = array(
                '@context'       => 'https://schema.org',
                '@type'          => 'SoftwareSourceCode',
                'name'           => get_the_title( $post_id ),
                'programmingLanguage' => esc_html( $language ),
            );
            if ( ! empty( $repo_url ) ) {
                $schema['codeRepository'] = esc_url( $repo_url );
            }
            break;
    }

    if ( ! empty( $schema ) ) {
        echo "\n" . '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'quantum_render_json_ld_schema' );

/**
 * 8. Programmatic ACF Fields Registration
 */
require_once get_template_directory() . '/inc/acf-fields.php';
