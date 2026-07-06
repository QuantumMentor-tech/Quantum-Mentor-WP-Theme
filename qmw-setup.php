<?php
/**
 * Quantum Mentor World — One-Time WordPress Setup Script
 *
 * ══════════════════════════════════════════════════════════════════
 * IMPORTANT INSTRUCTIONS — READ BEFORE RUNNING
 * ══════════════════════════════════════════════════════════════════
 *
 * This script creates:
 *   ✅ All required WordPress pages with correct slugs
 *   ✅ Primary menu with all navigation items
 *   ✅ Footer menu with legal pages
 *   ✅ WordPress site settings (title, tagline, permalinks)
 *   ✅ Assigns front page and blog page
 *   ✅ Disables default WordPress sample content
 *   ✅ Disables user registration
 *
 * HOW TO RUN:
 *   1. Place this file in your WordPress root folder
 *      (same directory as wp-config.php)
 *   2. Visit: https://yoursite.com/qmw-setup.php
 *      OR run via WP-CLI: wp eval-file qmw-setup.php
 *   3. After running successfully, DELETE this file immediately!
 *
 * ⚠️  SECURITY WARNING: Delete this file after running!
 *     This file has no authentication. Delete it immediately.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

// ── Bootstrap WordPress ───────────────────────────────────────────────────────
define( 'ABSPATH_LOADED', true );

$wp_load_paths = array(
    __DIR__ . '/wp-load.php',
    __DIR__ . '/../wp-load.php',
    __DIR__ . '/../../wp-load.php',
);

$wp_loaded = false;
foreach ( $wp_load_paths as $path ) {
    if ( file_exists( $path ) ) {
        require_once $path;
        $wp_loaded = true;
        break;
    }
}

if ( ! $wp_loaded ) {
    die( '❌ Error: Could not find wp-load.php. Place this file in the WordPress root directory.' );
}

// ── Security: Only allow admin users to run this ─────────────────────────────
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( '❌ Error: You must be logged in as an administrator to run this setup script.' );
}

// ── Prevent running twice without reset ──────────────────────────────────────
$already_run = get_option( 'qmw_setup_completed' );

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quantum Mentor World — Setup Script</title>
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0F172A; color: #F8FAFC; padding: 2rem; }
    .container { max-width: 800px; margin: 0 auto; }
    h1 { color: #00D4FF; font-size: 2rem; margin-bottom: 0.5rem; }
    h2 { color: #7C3AED; font-size: 1.2rem; margin: 1.5rem 0 0.5rem; border-bottom: 1px solid #334155; padding-bottom: 0.5rem; }
    .step { background: #1E293B; border-radius: 10px; padding: 1rem 1.5rem; margin: 0.5rem 0; border-left: 4px solid #22C55E; }
    .step.error { border-color: #ef4444; }
    .step.skip  { border-color: #f59e0b; }
    .status { font-size: 13px; color: #94A3B8; margin-top: 4px; }
    .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; }
    .badge.ok    { background: #22C55E; color: #000; }
    .badge.error { background: #ef4444; color: #fff; }
    .badge.skip  { background: #f59e0b; color: #000; }
    .warning { background: #7c3aed20; border: 1px solid #7C3AED; border-radius: 8px; padding: 1rem; margin: 1.5rem 0; }
    footer { margin-top: 2rem; color: #64748B; font-size: 12px; }
</style>
</head>
<body>
<div class="container">
<h1>🚀 Quantum Mentor World — WordPress Setup</h1>
<p style="color:#94A3B8; margin-bottom:1rem;">Running one-time configuration setup...</p>

<?php if ( $already_run ) : ?>
<div class="warning">
    <strong>⚠️ Setup already completed.</strong>
    To run again, manually delete the option <code>qmw_setup_completed</code> from the database,
    or run: <code>wp option delete qmw_setup_completed</code>
</div>
<?php else : ?>

<?php

// ════════════════════════════════════════════════════════
// SECTION 1: SITE SETTINGS
// ════════════════════════════════════════════════════════
echo '<h2>📋 Site Settings</h2>';

$settings = array(
    'blogname'          => 'Quantum Mentor World',
    'blogdescription'   => 'Explore Knowledge, Tools, Software, AI & Digital Resources',
    'permalink_structure' => '/%postname%/',
    'default_comment_status' => 'open',
    'default_ping_status' => 'closed',
    'comments_notify'   => 0,
    'moderation_notify' => 1,
    'users_can_register'=> 0,          // Disable public registration
    'default_role'      => 'subscriber',
    'timezone_string'   => 'Asia/Karachi', // Adjust to owner's timezone
    'date_format'       => 'F j, Y',
    'time_format'       => 'g:i a',
    'start_of_week'     => 1,           // Monday
    'show_on_front'     => 'page',      // Use static front page
    'posts_per_page'    => 18,          // Archive grid: 18 posts per page
    'posts_per_rss'     => 20,
    'thumbnail_size_w'  => 400,
    'thumbnail_size_h'  => 260,
    'thumbnail_crop'    => 1,
    'medium_size_w'     => 600,
    'medium_size_h'     => 400,
    'large_size_w'      => 1024,
    'large_size_h'      => 576,
);

foreach ( $settings as $option => $value ) {
    update_option( $option, $value );
}

// Flush rewrite rules so /%postname%/ permalink works immediately
global $wp_rewrite;
$wp_rewrite->set_permalink_structure( '/%postname%/' );
$wp_rewrite->flush_rules();

echo '<div class="step"><strong>Site title, tagline, permalinks, timezone, image sizes</strong><br><span class="status">All updated successfully. Permalink: <code>/%postname%/</code></span><span class="badge ok" style="float:right;">✅ Done</span></div>';


// ════════════════════════════════════════════════════════
// SECTION 2: DELETE SAMPLE CONTENT
// ════════════════════════════════════════════════════════
echo '<h2>🗑️ Remove Default Sample Content</h2>';

// Delete "Hello world!" post
$hello_world = get_posts( array( 'name' => 'hello-world', 'post_type' => 'post', 'post_status' => 'any', 'numberposts' => 1 ) );
if ( ! empty( $hello_world ) ) {
    wp_delete_post( $hello_world[0]->ID, true );
    echo '<div class="step"><strong>Deleted: "Hello world!" sample post</strong><span class="badge ok" style="float:right;">✅ Done</span></div>';
} else {
    echo '<div class="step skip"><strong>Sample post not found</strong><span class="status">Already deleted or never existed.</span><span class="badge skip" style="float:right;">⏭ Skip</span></div>';
}

// Delete "Sample Page"
$sample_page = get_posts( array( 'name' => 'sample-page', 'post_type' => 'page', 'post_status' => 'any', 'numberposts' => 1 ) );
if ( ! empty( $sample_page ) ) {
    wp_delete_post( $sample_page[0]->ID, true );
    echo '<div class="step"><strong>Deleted: "Sample Page"</strong><span class="badge ok" style="float:right;">✅ Done</span></div>';
} else {
    echo '<div class="step skip"><strong>Sample page not found</strong><span class="badge skip" style="float:right;">⏭ Skip</span></div>';
}

// Delete sample comment
$sample_comment = get_comments( array( 'author_email' => 'wapuu@wordpress.example', 'number' => 1 ) );
if ( ! empty( $sample_comment ) ) {
    wp_delete_comment( $sample_comment[0]->comment_ID, true );
    echo '<div class="step"><strong>Deleted: Sample comment</strong><span class="badge ok" style="float:right;">✅ Done</span></div>';
} else {
    echo '<div class="step skip"><strong>Sample comment not found</strong><span class="badge skip" style="float:right;">⏭ Skip</span></div>';
}


// ════════════════════════════════════════════════════════
// SECTION 3: CREATE REQUIRED PAGES
// ════════════════════════════════════════════════════════
echo '<h2>📄 Create Required Pages</h2>';

$pages = array(
    array(
        'title'   => 'Home',
        'slug'    => 'home',
        'content' => '',
        'template'=> '',
    ),
    array(
        'title'   => 'About Us',
        'slug'    => 'about-us',
        'content' => '<h2>About Quantum Mentor World</h2><p>Quantum Mentor World is a legal educational resource platform for software, books, tools, games, watch content, AI news, and GitHub repositories. We only feature legal, open-source, public-domain, freeware, official, or properly licensed resources.</p>',
        'template'=> '',
    ),
    array(
        'title'   => 'Contact Us',
        'slug'    => 'contact-us',
        'content' => '<h2>Contact Quantum Mentor World</h2><p>Have a question, suggestion, or want to report a broken link? Use the contact form below to reach us.</p>',
        'template'=> '',
    ),
    array(
        'title'   => 'Disclaimer',
        'slug'    => 'disclaimer',
        'content' => '<h2>Disclaimer</h2><p>Quantum Mentor World is a platform dedicated to legal, open-source, public-domain, freeware, official, or properly licensed digital resources. We do not support, promote, or host cracked software, pirated movies, nulled themes, paid course leaks, illegal license keys, or copyrighted files without explicit permission from the rights holder.</p><p>All download links on this website point to official, verified sources. We are not responsible for any changes made to external websites after our review. If you find a link that violates our legal policy, please contact us immediately.</p><p>The information provided on Quantum Mentor World is for educational and informational purposes only. We make no warranties about the completeness, reliability, or accuracy of this information.</p>',
        'template'=> '',
    ),
    array(
        'title'   => 'Privacy Policy',
        'slug'    => 'privacy-policy',
        'content' => '<h2>Privacy Policy</h2><p>This Privacy Policy describes how Quantum Mentor World collects, uses, and shares information about you when you use our website.</p><h3>Information We Collect</h3><p>We may collect information you provide directly to us, such as when you submit a contact form, as well as information collected automatically through your use of our services, such as log data and analytics.</p><h3>How We Use Information</h3><p>We use the information we collect to operate, improve, and promote our services, and to respond to your inquiries.</p><h3>Cookies</h3><p>We use cookies to remember your preferences (such as dark/light theme mode) and to analyze traffic using anonymized analytics tools.</p><h3>Contact Us</h3><p>If you have any questions about this Privacy Policy, please contact us through the Contact Us page.</p>',
        'template'=> '',
    ),
);

$created_pages = array();

foreach ( $pages as $page_data ) {
    // Check if page already exists
    $existing = get_page_by_path( $page_data['slug'], OBJECT, 'page' );

    if ( $existing ) {
        echo '<div class="step skip"><strong>Page already exists: ' . esc_html( $page_data['title'] ) . '</strong> <code>/' . esc_html( $page_data['slug'] ) . '/</code><span class="badge skip" style="float:right;">⏭ Exists</span></div>';
        $created_pages[ $page_data['slug'] ] = $existing->ID;
        continue;
    }

    $page_args = array(
        'post_title'    => $page_data['title'],
        'post_name'     => $page_data['slug'],
        'post_content'  => $page_data['content'],
        'post_status'   => 'publish',
        'post_type'     => 'page',
        'post_author'   => get_current_user_id(),
        'menu_order'    => 0,
        'comment_status'=> 'closed',
    );

    if ( ! empty( $page_data['template'] ) ) {
        $page_args['page_template'] = $page_data['template'];
    }

    $page_id = wp_insert_post( $page_args );

    if ( is_wp_error( $page_id ) ) {
        echo '<div class="step error"><strong>❌ Failed to create: ' . esc_html( $page_data['title'] ) . '</strong><br><span class="status">' . esc_html( $page_id->get_error_message() ) . '</span><span class="badge error" style="float:right;">❌ Error</span></div>';
    } else {
        $created_pages[ $page_data['slug'] ] = $page_id;
        echo '<div class="step"><strong>Created page: ' . esc_html( $page_data['title'] ) . '</strong> <code>/' . esc_html( $page_data['slug'] ) . '/</code> (ID: ' . $page_id . ')<span class="badge ok" style="float:right;">✅ Created</span></div>';
    }
}


// ════════════════════════════════════════════════════════
// SECTION 4: SET HOME PAGE
// ════════════════════════════════════════════════════════
echo '<h2>🏠 Assign Front Page</h2>';

$home_page = get_page_by_path( 'home', OBJECT, 'page' );
if ( $home_page ) {
    update_option( 'page_on_front', $home_page->ID );
    update_option( 'show_on_front', 'page' );
    echo '<div class="step"><strong>Front page set to: "Home" (ID: ' . $home_page->ID . ')</strong><br><span class="status">WordPress now loads the static "Home" page instead of the blog index.</span><span class="badge ok" style="float:right;">✅ Done</span></div>';
} else {
    echo '<div class="step error"><strong>Could not find "Home" page to set as front page.</strong><span class="badge error" style="float:right;">❌ Error</span></div>';
}


// ════════════════════════════════════════════════════════
// SECTION 5: CREATE PRIMARY NAVIGATION MENU
// ════════════════════════════════════════════════════════
echo '<h2>🧭 Create Primary Navigation Menu</h2>';

$primary_menu_name = 'Primary Menu';
$primary_menu_id = wp_get_nav_menu_object( $primary_menu_name );

if ( ! $primary_menu_id ) {
    $primary_menu_id = wp_create_nav_menu( $primary_menu_name );
}

if ( ! is_wp_error( $primary_menu_id ) ) {
    $menu_id = is_object( $primary_menu_id ) ? $primary_menu_id->term_id : $primary_menu_id;

    // Clear existing items
    $existing_items = wp_get_nav_menu_items( $menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    // Primary menu items
    $primary_items = array(
        array( 'title' => 'Home',             'url' => home_url( '/' ),                          'order' => 1 ),
        array( 'title' => 'Software',          'url' => home_url( '/software/' ),                 'order' => 2 ),
        array( 'title' => 'Themes & Plugins',  'url' => home_url( '/themes-plugins/' ),           'order' => 3 ),
        array( 'title' => 'Games',             'url' => home_url( '/games/' ),                    'order' => 4 ),
        array( 'title' => 'News',              'url' => home_url( '/news/' ),                     'order' => 5 ),
        array( 'title' => 'Tools',             'url' => home_url( '/tools/' ),                    'order' => 6 ),
        array( 'title' => 'Books',             'url' => home_url( '/books/' ),                    'order' => 7 ),
        array( 'title' => 'Watch',             'url' => home_url( '/watch/' ),                    'order' => 8 ),
        array( 'title' => 'GitHub Repos',      'url' => home_url( '/github-repos/' ),             'order' => 9 ),
    );

    foreach ( $primary_items as $item ) {
        wp_update_nav_menu_item( $menu_id, 0, array(
            'menu-item-title'   => $item['title'],
            'menu-item-url'     => $item['url'],
            'menu-item-status'  => 'publish',
            'menu-item-type'    => 'custom',
            'menu-item-position'=> $item['order'],
        ) );
    }

    // Assign to theme location
    $locations = get_theme_mod( 'nav_menu_locations', array() );
    $locations['primary_menu'] = $menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    echo '<div class="step"><strong>Primary Menu created with ' . count( $primary_items ) . ' items</strong><br><span class="status">Home, Software, Themes & Plugins, Games, News, Tools, Books, Watch, GitHub Repos</span><span class="badge ok" style="float:right;">✅ Done</span></div>';
} else {
    echo '<div class="step error"><strong>Failed to create Primary Menu</strong><span class="badge error" style="float:right;">❌ Error</span></div>';
}


// ════════════════════════════════════════════════════════
// SECTION 6: CREATE FOOTER MENU
// ════════════════════════════════════════════════════════
echo '<h2>📋 Create Footer Menu</h2>';

$footer_menu_name = 'Footer Menu';
$footer_menu_id   = wp_get_nav_menu_object( $footer_menu_name );

if ( ! $footer_menu_id ) {
    $footer_menu_id = wp_create_nav_menu( $footer_menu_name );
}

if ( ! is_wp_error( $footer_menu_id ) ) {
    $f_menu_id = is_object( $footer_menu_id ) ? $footer_menu_id->term_id : $footer_menu_id;

    $existing_items = wp_get_nav_menu_items( $f_menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    $footer_items = array(
        array( 'title' => 'About Us',       'slug' => 'about-us',       'order' => 1 ),
        array( 'title' => 'Contact Us',     'slug' => 'contact-us',     'order' => 2 ),
        array( 'title' => 'Disclaimer',     'slug' => 'disclaimer',     'order' => 3 ),
        array( 'title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'order' => 4 ),
    );

    foreach ( $footer_items as $item ) {
        $page = get_page_by_path( $item['slug'], OBJECT, 'page' );
        if ( $page ) {
            wp_update_nav_menu_item( $f_menu_id, 0, array(
                'menu-item-title'     => $item['title'],
                'menu-item-object-id' => $page->ID,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $item['order'],
            ) );
        }
    }

    $locations             = get_theme_mod( 'nav_menu_locations', array() );
    $locations['footer_menu'] = $f_menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    echo '<div class="step"><strong>Footer Menu created</strong><br><span class="status">About Us, Contact Us, Disclaimer, Privacy Policy</span><span class="badge ok" style="float:right;">✅ Done</span></div>';
}


// ════════════════════════════════════════════════════════
// SECTION 7: CREATE LEGAL MENU
// ════════════════════════════════════════════════════════
echo '<h2>⚖️ Create Legal Menu</h2>';

$legal_menu_name = 'Legal Menu';
$legal_menu_id   = wp_get_nav_menu_object( $legal_menu_name );

if ( ! $legal_menu_id ) {
    $legal_menu_id = wp_create_nav_menu( $legal_menu_name );
}

if ( ! is_wp_error( $legal_menu_id ) ) {
    $l_menu_id = is_object( $legal_menu_id ) ? $legal_menu_id->term_id : $legal_menu_id;

    $existing_items = wp_get_nav_menu_items( $l_menu_id );
    if ( $existing_items ) {
        foreach ( $existing_items as $item ) {
            wp_delete_post( $item->ID, true );
        }
    }

    $legal_items = array(
        array( 'title' => 'Disclaimer',     'slug' => 'disclaimer' ),
        array( 'title' => 'Privacy Policy', 'slug' => 'privacy-policy' ),
    );

    foreach ( $legal_items as $idx => $item ) {
        $page = get_page_by_path( $item['slug'], OBJECT, 'page' );
        if ( $page ) {
            wp_update_nav_menu_item( $l_menu_id, 0, array(
                'menu-item-title'     => $item['title'],
                'menu-item-object-id' => $page->ID,
                'menu-item-object'    => 'page',
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $idx + 1,
            ) );
        }
    }

    $locations             = get_theme_mod( 'nav_menu_locations', array() );
    $locations['legal_menu'] = $l_menu_id;
    set_theme_mod( 'nav_menu_locations', $locations );

    echo '<div class="step"><strong>Legal Menu created</strong><br><span class="status">Disclaimer, Privacy Policy</span><span class="badge ok" style="float:right;">✅ Done</span></div>';
}


// ════════════════════════════════════════════════════════
// SECTION 8: WORDPRESS HARDENING OPTIONS
// ════════════════════════════════════════════════════════
echo '<h2>🔒 WordPress Hardening Options</h2>';

update_option( 'users_can_register', 0 );     // No public registration
update_option( 'comment_registration', 1 );   // Must be registered to comment
update_option( 'default_ping_status', 'closed' ); // No pingbacks on new posts
update_option( 'default_comment_status', 'open' );
update_option( 'close_comments_for_old_posts', 1 ); // Auto-close old post comments
update_option( 'close_comments_days_old', 365 );
update_option( 'comment_moderation', 1 );     // Hold comments for moderation
update_option( 'comment_max_links', 2 );      // Flag comments with >2 links as spam

echo '<div class="step"><strong>WordPress hardening options updated</strong><br><span class="status">Registration disabled, comments moderated, pingbacks closed, spam protection enabled.</span><span class="badge ok" style="float:right;">✅ Done</span></div>';


// ════════════════════════════════════════════════════════
// SECTION 9: MARK SETUP AS COMPLETE
// ════════════════════════════════════════════════════════
update_option( 'qmw_setup_completed', array(
    'timestamp' => current_time( 'mysql' ),
    'version'   => '1.0.0',
    'by'        => get_current_user_id(),
) );

echo '<h2>✅ Setup Complete!</h2>';
echo '<div class="step"><strong>All setup tasks completed successfully.</strong><br>';
echo '<span class="status">Timestamp: ' . current_time( 'F j, Y — g:i a' ) . '</span>';
echo '<span class="badge ok" style="float:right;">✅ Done</span></div>';

?>

<div class="warning" style="margin-top:2rem;">
    <strong>🚨 IMPORTANT — Delete This File Now!</strong><br><br>
    This setup script has no password protection. Anyone who visits this URL can rerun it.
    <strong>Delete <code>qmw-setup.php</code> from your server immediately.</strong><br><br>
    Via FTP/cPanel: Delete the file from your WordPress root folder.<br>
    Via SSH: <code>rm /path/to/wordpress/qmw-setup.php</code><br>
    Via WP-CLI: <code>wp eval 'unlink(ABSPATH . "qmw-setup.php");'</code>
</div>

<?php endif; ?>

<footer>
    <p>Quantum Mentor World Setup Script v1.0.0 — Built with ❤️ using WordPress APIs</p>
    <p>WordPress Version: <?php echo esc_html( get_bloginfo( 'version' ) ); ?> | PHP: <?php echo esc_html( PHP_VERSION ); ?></p>
</footer>

</div>
</body>
</html>
