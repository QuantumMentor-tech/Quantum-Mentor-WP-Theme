<?php
/**
 * Quantum Mentor World — Performance & Speed Optimizations
 *
 * Implements:
 * - Script defer/async loading
 * - Native lazy loading for images
 * - Custom image sizes for all CPTs
 * - Database query optimization
 * - Heartbeat API throttling
 * - Revision limiting
 * - DNS prefetch for external resources
 * - Preconnect headers for Google Fonts
 * - Remove query strings from static assets (cache-busting)
 * - Disable embed/oEmbed for performance
 * - Disable self-pingbacks
 *
 * @package Quantum_Mentor_World
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. DEFER MAIN JAVASCRIPT
// ============================================================
/**
 * Adds defer attribute to the theme's main script.
 * This prevents render-blocking and improves page load score.
 */
function qmw_defer_scripts( $tag, $handle, $src ) {
    $defer_handles = array( 'quantum-mentor-main-script' );

    if ( in_array( $handle, $defer_handles, true ) ) {
        return '<script src="' . esc_url( $src ) . '" defer="defer"></script>' . "\n";
    }

    return $tag;
}
add_filter( 'script_loader_tag', 'qmw_defer_scripts', 10, 3 );

// ============================================================
// 2. NATIVE LAZY LOADING FOR ALL IMAGES
// ============================================================
add_filter( 'wp_lazy_loading_enabled', '__return_true' );

/**
 * Add loading="lazy" to all images that don't already have it,
 * and add decoding="async" for better performance.
 */
function qmw_add_lazy_loading_to_images( $content ) {
    if ( is_admin() || empty( $content ) ) {
        return $content;
    }

    // Add loading="lazy" and decoding="async" if missing
    $content = preg_replace_callback(
        '/<img([^>]+)>/i',
        function ( $matches ) {
            $img_tag = $matches[0];
            if ( strpos( $img_tag, 'loading=' ) === false ) {
                $img_tag = str_replace( '<img ', '<img loading="lazy" decoding="async" ', $img_tag );
            }
            return $img_tag;
        },
        $content
    );

    return $content;
}
add_filter( 'the_content', 'qmw_add_lazy_loading_to_images' );

// ============================================================
// 3. REGISTER CUSTOM IMAGE SIZES FOR ALL CPTs
// ============================================================
/**
 * These sizes are used by theme templates for optimal display.
 * Prevents WordPress from using oversized images.
 */
function qmw_register_image_sizes() {
    // General archive card thumbnail
    add_image_size( 'qmw-card',        400, 260, true );

    // Software / Tool icon (square)
    add_image_size( 'qmw-icon',        160, 160, true );

    // Book / Game cover (portrait)
    add_image_size( 'qmw-cover',       300, 450, true );

    // Watch poster (portrait)
    add_image_size( 'qmw-poster',      300, 440, true );

    // Watch / News hero banner (wide)
    add_image_size( 'qmw-banner',     1280, 480, true );

    // Open Graph / Social share image
    add_image_size( 'qmw-og',         1200, 630, true );

    // Single page featured image (16:9)
    add_image_size( 'qmw-featured',    900, 506, true );

    // Screenshot / gallery thumbnail
    add_image_size( 'qmw-screenshot',  600, 400, true );
}
add_action( 'after_setup_theme', 'qmw_register_image_sizes' );

// ============================================================
// 4. LIMIT POST REVISIONS
// ============================================================
/**
 * Limit stored revisions to 5 per post to reduce database bloat.
 * Can also be set in wp-config.php:
 * define( 'WP_POST_REVISIONS', 5 );
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
    define( 'WP_POST_REVISIONS', 5 );
}

// ============================================================
// 5. THROTTLE WORDPRESS HEARTBEAT API
// ============================================================
/**
 * The Heartbeat API polls the server every 15 seconds by default.
 * This uses a lot of server resources. Throttle it on the frontend
 * and slow it down in the admin.
 */
function qmw_throttle_heartbeat( $settings ) {
    if ( is_admin() ) {
        $settings['interval'] = 60; // Once per minute in admin
    } else {
        $settings['interval'] = 120; // Every 2 minutes on frontend
    }
    return $settings;
}
add_filter( 'heartbeat_settings', 'qmw_throttle_heartbeat' );

// Disable heartbeat on frontend entirely (not needed)
add_action( 'init', function () {
    if ( ! is_admin() ) {
        wp_deregister_script( 'heartbeat' );
    }
} );

// ============================================================
// 6. DISABLE EMBEDS / oEMBED
// ============================================================
/**
 * WordPress oEmbed allows other sites to embed your posts.
 * It also loads an extra script. Disable it to save resources.
 * Watch content uses direct embed URLs instead.
 */
function qmw_disable_embeds() {
    // Remove oEmbed discovery links from <head>
    remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
    remove_action( 'wp_head', 'wp_oembed_add_host_js' );

    // Remove REST API oEmbed endpoint
    remove_action( 'rest_api_init', 'wp_oembed_register_route' );

    // Disable the oEmbed filter
    remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

    // Remove oEmbed-related JS
    add_filter( 'embed_oembed_discover', '__return_false' );
}
add_action( 'init', 'qmw_disable_embeds' );

// ============================================================
// 7. DISABLE SELF-PINGBACKS
// ============================================================
/**
 * Prevents WordPress from creating pingbacks when linking
 * internally to your own posts (wastes resources).
 */
function qmw_disable_self_pingbacks( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link ) {
        if ( strpos( $link, $home ) === 0 ) {
            unset( $links[ $l ] );
        }
    }
}
add_action( 'pre_ping', 'qmw_disable_self_pingbacks' );

// ============================================================
// 8. REMOVE QUERY STRINGS FROM STATIC ASSETS
// ============================================================
/**
 * Removes ?ver= from CSS/JS URLs for better CDN and proxy caching.
 * Some CDNs refuse to cache URLs with query strings.
 */
function qmw_remove_query_strings( $src ) {
    // Only run on frontend
    if ( is_admin() ) {
        return $src;
    }

    if ( strpos( $src, '?ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }

    return $src;
}
add_filter( 'script_loader_src', 'qmw_remove_query_strings', 15 );
add_filter( 'style_loader_src',  'qmw_remove_query_strings', 15 );

// ============================================================
// 9. DNS PREFETCH & PRECONNECT FOR PERFORMANCE
// ============================================================
/**
 * Adds <link rel="preconnect"> and <link rel="dns-prefetch"> tags
 * for external domains used by this theme.
 */
function qmw_add_preconnect_tags() {
    // Google Fonts — loaded in enqueue.php
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";

    // YouTube embeds (Watch CPT)
    echo '<link rel="dns-prefetch" href="//www.youtube.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.youtube-nocookie.com">' . "\n";

    // GitHub (for repo links and avatars)
    echo '<link rel="dns-prefetch" href="//github.com">' . "\n";

    // Internet Archive (for open-source media)
    echo '<link rel="dns-prefetch" href="//archive.org">' . "\n";
}
add_action( 'wp_head', 'qmw_add_preconnect_tags', 1 );

// ============================================================
// 10. DATABASE OPTIMIZATION — CLEAR TRANSIENTS ON SAVE
// ============================================================
/**
 * Clears cached query transients when any CPT post is saved.
 * Ensures featured/trending sections always show fresh content.
 */
function qmw_clear_cache_on_save( $post_id ) {
    // Don't run on autosave
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    $cached_transients = array(
        'qmw_homepage_featured',
        'qmw_homepage_trending',
        'qmw_homepage_popular',
        'qmw_software_featured',
        'qmw_games_featured',
        'qmw_watch_featured',
        'qmw_books_featured',
        'qmw_news_featured',
        'qmw_tools_featured',
        'qmw_repos_featured',
    );

    foreach ( $cached_transients as $transient ) {
        delete_transient( $transient );
    }
}
add_action( 'save_post', 'qmw_clear_cache_on_save' );

// ============================================================
// 11. DISABLE UNUSED DASHBOARD WIDGETS (ADMIN PERFORMANCE)
// ============================================================
function qmw_remove_dashboard_widgets() {
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'qmw_remove_dashboard_widgets' );

// ============================================================
// 12. OPTIMIZE WP_QUERY — DEFAULT FIELDS ONLY WHEN NEEDED
// ============================================================
/**
 * Filters non-main queries on archive pages to only fetch
 * needed post fields (ID and title), reducing memory usage.
 * Full post objects are fetched when the template needs them.
 */
function qmw_optimize_archive_queries( $query ) {
    if ( is_admin() || $query->is_main_query() ) {
        return;
    }

    // For sidebar or widget queries — only get IDs
    if ( $query->get( 'qmw_ids_only' ) ) {
        $query->set( 'fields', 'ids' );
        $query->set( 'no_found_rows', true ); // Skip counting total rows
        $query->set( 'update_post_meta_cache', false );
        $query->set( 'update_post_term_cache', false );
    }
}
add_action( 'pre_get_posts', 'qmw_optimize_archive_queries' );

// ============================================================
// 13. WEEKLY SCHEDULED DATABASE OPTIMIZATION CRON
// ============================================================
add_action( 'wp', 'qmw_schedule_db_cleanup' );

function qmw_schedule_db_cleanup() {
    if ( ! wp_next_scheduled( 'qmw_database_clean_cron' ) ) {
        wp_schedule_event( time(), 'weekly', 'qmw_database_clean_cron' );
    }
}

add_action( 'qmw_database_clean_cron', 'qmw_optimize_database' );

function qmw_optimize_database() {
    global $wpdb;

    // 1. Delete post revisions older than 5
    $post_ids = $wpdb->get_col( "SELECT ID FROM $wpdb->posts WHERE post_type NOT IN ('revision', 'attachment')" );
    if ( ! empty( $post_ids ) ) {
        foreach ( $post_ids as $post_id ) {
            $revisions = wp_get_post_revisions( $post_id, array( 'order' => 'ASC' ) );
            if ( count( $revisions ) > 5 ) {
                $delete_count = count( $revisions ) - 5;
                $i = 0;
                foreach ( $revisions as $revision ) {
                    if ( $i < $delete_count ) {
                        wp_delete_post_revision( $revision->ID );
                    }
                    $i++;
                }
            }
        }
    }

    // 2. Delete spam and trash comments
    $wpdb->query( "DELETE FROM $wpdb->comments WHERE comment_approved IN ('spam', 'trash')" );

    // 3. Delete expired transients
    $wpdb->query( $wpdb->prepare(
        "DELETE FROM $wpdb->options WHERE option_name LIKE %s AND option_value < %d",
        '_transient_timeout_%',
        time()
    ) );

    // 4. Delete orphaned metadata
    $wpdb->query( "DELETE pm FROM $wpdb->postmeta pm LEFT JOIN $wpdb->posts wp ON wp.ID = pm.post_id WHERE wp.ID IS NULL" );
    $wpdb->query( "DELETE um FROM $wpdb->usermeta um LEFT JOIN $wpdb->users wu ON wu.ID = um.user_id WHERE wu.ID IS NULL" );
    $wpdb->query( "DELETE cm FROM $wpdb->commentmeta cm LEFT JOIN $wpdb->comments wc ON wc.comment_ID = cm.comment_id WHERE wc.comment_ID IS NULL" );

    // 5. Optimize core tables
    $tables = $wpdb->get_col( "SHOW TABLES LIKE '" . $wpdb->prefix . "%'" );
    if ( ! empty( $tables ) ) {
        foreach ( $tables as $table ) {
            $wpdb->query( "OPTIMIZE TABLE $table" );
        }
    }
}
