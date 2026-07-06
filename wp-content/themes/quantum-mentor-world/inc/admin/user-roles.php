<?php
/**
 * Quantum Mentor World — User Roles & Permissions Setup
 *
 * Registers the user roles and manages granular custom capabilities.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register custom roles on activation/init
add_action( 'init', 'qmw_seed_user_roles' );

function qmw_seed_user_roles() {
    // 1. Content Manager Role
    // Can manage all content types but cannot touch themes, plugins, users, settings
    add_role( 'qmw_content_manager', 'Content Manager', array(
        'read'                      => true,
        'upload_files'              => true,
        
        // Software CPT / Post capability maps
        'edit_posts'                => true,
        'edit_others_posts'         => true,
        'edit_published_posts'      => true,
        'publish_posts'             => true,
        'delete_posts'              => true,
        'delete_others_posts'       => true,
        'delete_published_posts'    => true,
        'delete_private_posts'      => true,
        'edit_private_posts'        => true,
        'read_private_posts'        => true,

        // Pages CPT maps
        'edit_pages'                => true,
        'edit_others_pages'         => true,
        'edit_published_pages'      => true,
        'publish_pages'             => true,
        'delete_pages'              => true,
        'delete_others_pages'       => true,
        'delete_published_pages'    => true,
        'delete_private_pages'      => true,
        'edit_private_pages'        => true,
        'read_private_pages'        => true,

        // Common meta capability requirements
        'manage_categories'         => true,
        'moderate_comments'         => true,
    ) );

    // 2. Quantum Editor Role
    // Can edit News, Books, Watch Content, and GitHub Repos
    add_role( 'qmw_editor', 'Quantum Editor', array(
        'read'                      => true,
        'upload_files'              => true,
        'edit_posts'                => true,
        'edit_others_posts'         => true,
        'edit_published_posts'      => true,
        'publish_posts'             => true,
        'delete_posts'              => true,
        'delete_others_posts'       => true,
        'delete_published_posts'    => true,
        'delete_private_posts'      => true,
        'edit_private_posts'        => true,
        'read_private_posts'        => true,

        'edit_pages'                => true,
        'edit_others_pages'         => true,
        'edit_published_pages'      => true,
        'publish_pages'             => true,
        'delete_pages'              => true,
        'delete_others_pages'       => true,
        'delete_published_pages'    => true,
        
        'manage_categories'         => true,
        'moderate_comments'         => true,
    ) );

    // 3. Quantum Contributor Role
    // Can suggest drafts only, cannot publish directly
    add_role( 'qmw_contributor', 'Quantum Contributor', array(
        'read'                      => true,
        'edit_posts'                => true,
        'delete_posts'              => true,
    ) );

    // 4. Quantum Subscriber Role
    // Can save favorites, comment, submit suggests
    add_role( 'qmw_subscriber', 'Quantum Subscriber', array(
        'read'                      => true,
    ) );
}

/**
 * Hook to dynamically filter capabilities (map_meta_cap)
 * Restricts editor role to news, books, watch, github_repos, post, page only.
 * Disables contributor publishing privileges on CPTs.
 */
add_filter( 'map_meta_cap', 'qmw_map_meta_caps_for_custom_roles', 10, 4 );

function qmw_map_meta_caps_for_custom_roles( $caps, $cap, $user_id, $args ) {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return $caps;
    }

    // Administrators have full access
    if ( in_array( 'administrator', $user->roles, true ) ) {
        return $caps;
    }

    // ── 1. restrict qmw_editor to Allowed CPTs ──
    if ( in_array( 'qmw_editor', $user->roles, true ) ) {
        $allowed_post_types = array( 'news', 'books', 'watch', 'github_repos', 'post', 'page' );
        $post_type = '';

        if ( ! empty( $args ) ) {
            $post_id = $args[0];
            if ( is_numeric( $post_id ) ) {
                $post_type = get_post_type( $post_id );
            }
        } else {
            // General actions on editor screen
            if ( is_admin() ) {
                if ( isset( $_GET['post_type'] ) ) {
                    $post_type = sanitize_text_field( $_GET['post_type'] );
                } elseif ( isset( $_POST['post_type'] ) ) {
                    $post_type = sanitize_text_field( $_POST['post_type'] );
                } elseif ( function_exists( 'get_current_screen' ) ) {
                    $screen = get_current_screen();
                    if ( $screen ) {
                        $post_type = $screen->post_type;
                    }
                }
            }
        }

        // If post type is determined, verify editor has access
        if ( ! empty( $post_type ) && ! in_array( $post_type, $allowed_post_types, true ) ) {
            // Revoke permission
            $caps = array( 'do_not_allow' );
        }
    }

    // ── 2. restrict qmw_contributor from Publishing ──
    if ( in_array( 'qmw_contributor', $user->roles, true ) ) {
        $publish_caps = array( 'publish_posts', 'publish_pages' );
        if ( in_array( $cap, $publish_caps, true ) ) {
            $caps = array( 'do_not_allow' );
        }
    }

    return $caps;
}

/**
 * Remove admin bar and redirect dashboard for subscribers / contributors
 */
add_action( 'after_setup_theme', 'qmw_restrict_subscriber_dashboard_access' );

function qmw_restrict_subscriber_dashboard_access() {
    if ( ! is_admin() ) {
        return;
    }

    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return;
    }

    // Redirect subscribers to home or profile page if accessing dashboard
    if ( current_user_can( 'qmw_subscriber' ) || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'manage_options' ) ) ) {
        wp_safe_redirect( home_url( '/profile/' ) );
        exit;
    }
}

add_action( 'wp_after_admin_bar_render', 'qmw_hide_admin_bar_for_subscribers' );

function qmw_hide_admin_bar_for_subscribers() {
    if ( current_user_can( 'qmw_subscriber' ) || ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'manage_options' ) ) ) {
        show_admin_bar( false );
    }
}
