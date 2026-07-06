<?php
/**
 * Quantum Mentor World — Custom Admin Filters
 *
 * Implements dropdown filters at the top of custom post type list tables.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. RENDER DROPDOWNS IN RESTRICT MANAGE POSTS
// ============================================================
add_action( 'restrict_manage_posts', 'qmw_admin_render_filters' );

function qmw_admin_render_filters( $post_type ) {
    // ── Global Filters: Status, Priority, Verified (applicable to resources) ──
    $resource_cpts = array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools' );
    
    if ( in_array( $post_type, $resource_cpts, true ) ) {
        // Resource Status Filter
        qmw_output_filter_dropdown( 'filter_resource_status', 'Resource Status', array(
            'Active'     => 'Active',
            'Updated'    => 'Updated',
            'Deprecated' => 'Deprecated',
            'Removed'    => 'Removed',
        ) );

        // Content Priority Filter
        qmw_output_filter_dropdown( 'filter_admin_priority', 'Priority', array(
            'Normal'   => 'Normal',
            'Featured' => 'Featured',
            'Trending' => 'Trending',
            'Popular'  => 'Popular',
        ) );

        // Verified Toggle Filter
        qmw_output_filter_dropdown( 'filter_admin_verified', 'Verification', array(
            '1' => 'Verified Only',
            '0' => 'Pending Review Only',
        ) );
    }

    // ── CPT-Specific Filters ──
    if ( 'software' === $post_type ) {
        // Platform
        qmw_output_filter_dropdown( 'filter_software_platform', 'Platform', array(
            'Windows' => 'Windows',
            'Mac'     => 'macOS',
            'Linux'   => 'Linux',
            'Android' => 'Android',
            'iPhone'  => 'iPhone / iOS',
            'Web'     => 'Web / Browser',
        ) );
        // License
        qmw_output_filter_dropdown( 'filter_software_license', 'License', array(
            'Open Source'      => 'Open Source',
            'Freeware'         => 'Freeware',
            'Free Trial'       => 'Free Trial',
            'Public Domain'    => 'Public Domain',
            'Creative Commons' => 'Creative Commons',
        ) );
    }

    elseif ( 'themes_plugins' === $post_type ) {
        // Platform
        qmw_output_filter_dropdown( 'filter_tp_platform', 'Platform', array(
            'WordPress'   => 'WordPress',
            'WooCommerce' => 'WooCommerce',
            'Shopify'     => 'Shopify',
            'Elementor'   => 'Elementor',
        ) );
        // Type
        qmw_output_filter_dropdown( 'filter_tp_type', 'Type', array(
            'Theme'     => 'Theme',
            'Plugin'    => 'Plugin',
            'Extension' => 'Extension',
            'Addon'     => 'Add-on',
        ) );
    }

    elseif ( 'games' === $post_type ) {
        // Platform
        qmw_output_filter_dropdown( 'filter_game_platform', 'Platform', array(
            'Windows' => 'Windows',
            'Mac'     => 'macOS',
            'Linux'   => 'Linux',
            'Android' => 'Android',
            'iOS'     => 'iOS',
            'Browser' => 'Browser',
        ) );
        // Genre
        qmw_output_filter_dropdown( 'filter_game_genre', 'Genre', array(
            'Action'      => 'Action',
            'Adventure'   => 'Adventure',
            'Puzzle'      => 'Puzzle',
            'Racing'      => 'Racing',
            'Strategy'    => 'Strategy',
            'Educational' => 'Educational',
        ) );
    }

    elseif ( 'books' === $post_type ) {
        // Language
        qmw_output_filter_dropdown( 'filter_book_lang', 'Language', array(
            'English' => 'English',
            'Urdu'    => 'Urdu',
            'Arabic'  => 'Arabic',
            'Spanish' => 'Spanish',
            'French'  => 'French',
        ) );
        // Book Type
        qmw_output_filter_dropdown( 'filter_book_type', 'Access Type', array(
            'Free'          => 'Free',
            'Public Domain' => 'Public Domain',
            'Open Access'   => 'Open Access',
        ) );
    }

    elseif ( 'watch' === $post_type ) {
        // Content Type
        qmw_output_filter_dropdown( 'filter_watch_type', 'Content Type', array(
            'Movie'       => 'Movie',
            'Course'      => 'Online Course',
            'Anime'       => 'Anime',
            'Donghua'     => 'Donghua',
            'Tutorial'    => 'Tutorial Series',
            'Documentary' => 'Documentary',
        ) );
    }

    elseif ( 'tools' === $post_type ) {
        // Tool Type
        qmw_output_filter_dropdown( 'filter_tool_type', 'Tool Category', array(
            'File Converter' => 'File Converter',
            'PDF Tool'       => 'PDF Tool',
            'Image Tool'     => 'Image Tool',
            'Video Tool'     => 'Video Tool',
            'Text Tool'      => 'Text Tool',
            'AI Tool'        => 'AI Tool',
            'SEO Tool'       => 'SEO Tool',
            'Developer Tool' => 'Developer Tool',
        ) );
        // Access Type
        qmw_output_filter_dropdown( 'filter_tool_access', 'Access Type', array(
            'Built-in Tool'     => 'Built-in Tool',
            'External Tool'     => 'External Tool',
            'Downloadable Tool' => 'Downloadable Tool',
        ) );
    }

    elseif ( 'github_repos' === $post_type ) {
        // Difficulty Level
        qmw_output_filter_dropdown( 'filter_repo_difficulty', 'Difficulty', array(
            'Beginner'     => 'Beginner',
            'Intermediate' => 'Intermediate',
            'Advanced'     => 'Advanced',
        ) );
        // Priority
        qmw_output_filter_dropdown( 'filter_admin_priority', 'Priority', array(
            'Normal'   => 'Normal',
            'Featured' => 'Featured',
            'Trending' => 'Trending',
            'Popular'  => 'Popular',
        ) );
    }

    elseif ( 'news' === $post_type ) {
        // Priority
        qmw_output_filter_dropdown( 'filter_admin_priority', 'Priority', array(
            'Normal'   => 'Normal',
            'Featured' => 'Featured',
            'Trending' => 'Trending',
            'Popular'  => 'Popular',
        ) );
    }
}

/**
 * Output helper to render select dropdowns
 */
function qmw_output_filter_dropdown( $param_name, $label, $options ) {
    $current_val = isset( $_GET[ $param_name ] ) ? sanitize_text_field( $_GET[ $param_name ] ) : '';
    
    echo '<select name="' . esc_attr( $param_name ) . '" id="' . esc_attr( $param_name ) . '">';
    echo '  <option value="">— Show All ' . esc_html( $label ) . ' —</option>';
    foreach ( $options as $val => $name ) {
        printf(
            '<option value="%s" %s>%s</option>',
            esc_attr( $val ),
            selected( $current_val, (string) $val, false ),
            esc_html( $name )
        );
    }
    echo '</select>';
}

// ============================================================
// 2. PARSE AND APPLY META FILTERS IN PRE_GET_POSTS
// ============================================================
add_action( 'pre_get_posts', 'qmw_admin_apply_filters_to_query' );

function qmw_admin_apply_filters_to_query( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen ) {
        return;
    }

    $cpts = array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' );
    if ( ! in_array( $screen->post_type, $cpts, true ) ) {
        return;
    }

    $meta_query = array();

    // ── Global fields ──
    if ( ! empty( $_GET['filter_resource_status'] ) ) {
        $meta_query[] = array(
            'key'     => 'resource_status',
            'value'   => sanitize_text_field( $_GET['filter_resource_status'] ),
            'compare' => '=',
        );
    }

    if ( ! empty( $_GET['filter_admin_priority'] ) ) {
        $meta_query[] = array(
            'key'     => 'admin_priority',
            'value'   => sanitize_text_field( $_GET['filter_admin_priority'] ),
            'compare' => '=',
        );
    }

    if ( isset( $_GET['filter_admin_verified'] ) && $_GET['filter_admin_verified'] !== '' ) {
        $meta_query[] = array(
            'key'     => 'admin_verified',
            'value'   => sanitize_text_field( $_GET['filter_admin_verified'] ),
            'compare' => '=',
        );
    }

    // ── CPT fields ──
    if ( 'software' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_software_platform'] ) ) {
            $meta_query[] = array(
                'key'     => 'software_platform',
                'value'   => sanitize_text_field( $_GET['filter_software_platform'] ),
                'compare' => 'LIKE', // since checkbox array
            );
        }
        if ( ! empty( $_GET['filter_software_license'] ) ) {
            $meta_query[] = array(
                'key'     => 'software_license',
                'value'   => sanitize_text_field( $_GET['filter_software_license'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'themes_plugins' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_tp_platform'] ) ) {
            $meta_query[] = array(
                'key'     => 'tp_platform',
                'value'   => sanitize_text_field( $_GET['filter_tp_platform'] ),
                'compare' => '=',
            );
        }
        if ( ! empty( $_GET['filter_tp_type'] ) ) {
            $meta_query[] = array(
                'key'     => 'tp_type',
                'value'   => sanitize_text_field( $_GET['filter_tp_type'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'games' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_game_platform'] ) ) {
            $meta_query[] = array(
                'key'     => 'game_platform',
                'value'   => sanitize_text_field( $_GET['filter_game_platform'] ),
                'compare' => 'LIKE',
            );
        }
        if ( ! empty( $_GET['filter_game_genre'] ) ) {
            $meta_query[] = array(
                'key'     => 'game_genre_field',
                'value'   => sanitize_text_field( $_GET['filter_game_genre'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'books' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_book_lang'] ) ) {
            $meta_query[] = array(
                'key'     => 'book_language_field',
                'value'   => sanitize_text_field( $_GET['filter_book_lang'] ),
                'compare' => '=',
            );
        }
        if ( ! empty( $_GET['filter_book_type'] ) ) {
            $meta_query[] = array(
                'key'     => 'book_type',
                'value'   => sanitize_text_field( $_GET['filter_book_type'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'watch' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_watch_type'] ) ) {
            $meta_query[] = array(
                'key'     => 'watch_type',
                'value'   => sanitize_text_field( $_GET['filter_watch_type'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'tools' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_tool_type'] ) ) {
            $meta_query[] = array(
                'key'     => 'tool_type_field',
                'value'   => sanitize_text_field( $_GET['filter_tool_type'] ),
                'compare' => '=',
            );
        }
        if ( ! empty( $_GET['filter_tool_access'] ) ) {
            $meta_query[] = array(
                'key'     => 'tool_access_type',
                'value'   => sanitize_text_field( $_GET['filter_tool_access'] ),
                'compare' => '=',
            );
        }
    }

    elseif ( 'github_repos' === $screen->post_type ) {
        if ( ! empty( $_GET['filter_repo_difficulty'] ) ) {
            $meta_query[] = array(
                'key'     => 'repo_difficulty',
                'value'   => sanitize_text_field( $_GET['filter_repo_difficulty'] ),
                'compare' => '=',
            );
        }
    }

    // Set meta query if any meta filters exist
    if ( ! empty( $meta_query ) ) {
        $query->set( 'meta_query', $meta_query );
    }
}
