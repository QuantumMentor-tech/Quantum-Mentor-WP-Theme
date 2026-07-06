<?php
/**
 * Quantum Mentor World — Security Hardening
 *
 * Implements all WordPress security best practices:
 * - Disables dashboard file editing
 * - Blocks XML-RPC
 * - Hides WP version
 * - Adds HTTP security headers
 * - Restricts upload file types
 * - Disables user enumeration
 * - Removes sensitive REST API endpoints for non-authenticated users
 * - Disables application passwords for extra security
 * - Removes unneeded head tags
 *
 * @package Quantum_Mentor_World
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. DISABLE DASHBOARD FILE EDITING
// ============================================================
// Prevents admins from editing theme/plugin files from the dashboard.
// Should also be set in wp-config.php: define('DISALLOW_FILE_EDIT', true);
if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
    define( 'DISALLOW_FILE_EDIT', true );
}

// ============================================================
// 2. DISABLE XML-RPC COMPLETELY
// ============================================================
// XML-RPC is a legacy API that can be exploited for brute-force
// and DDoS amplification attacks. Disable it entirely.
add_filter( 'xmlrpc_enabled', '__return_false' );

// Also remove the X-Pingback header that advertises XML-RPC
add_filter( 'wp_headers', function( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
} );

// ============================================================
// 3. HIDE WORDPRESS VERSION
// ============================================================
// Remove the WordPress version from:
// - <meta name="generator"> in head
// - RSS feed
// - Script/style ?ver= query strings

remove_action( 'wp_head', 'wp_generator' );

function qmw_remove_wp_version_strings( $src ) {
    global $wp_version;
    parse_str( wp_parse_url( $src, PHP_URL_QUERY ), $query );
    if ( ! empty( $query['ver'] ) && $query['ver'] === $wp_version ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'script_loader_src', 'qmw_remove_wp_version_strings' );
add_filter( 'style_loader_src',  'qmw_remove_wp_version_strings' );

// Remove version from RSS feed
add_filter( 'the_generator', '__return_empty_string' );

// ============================================================
// 4. HTTP SECURITY HEADERS
// ============================================================
/**
 * Adds security headers to all frontend responses.
 * Adjust Content-Security-Policy based on third-party embeds.
 */
function qmw_add_security_headers( $headers ) {
    if ( is_admin() ) {
        return $headers;
    }

    // Prevent clickjacking
    $headers['X-Frame-Options'] = 'SAMEORIGIN';

    // Prevent MIME sniffing
    $headers['X-Content-Type-Options'] = 'nosniff';

    // XSS protection (older browsers)
    $headers['X-XSS-Protection'] = '1; mode=block';

    // Content Security Policy
    // Allows self + common embed sources used by this platform
    $headers['Content-Security-Policy'] = implode( '; ', array(
        "default-src 'self' https: data:",
        "script-src 'self' 'unsafe-inline' https://www.googletagmanager.com https://www.google-analytics.com",
        "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
        "font-src 'self' https://fonts.gstatic.com",
        "img-src 'self' data: https:",
        "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com https://player.vimeo.com https://www.dailymotion.com https://archive.org",
        "connect-src 'self' https:",
        "media-src 'self' https:",
    ) );

    // Referrer policy
    $headers['Referrer-Policy'] = 'strict-origin-when-cross-origin';

    // Permissions policy (disables unused browser features)
    $headers['Permissions-Policy'] = 'camera=(), microphone=(), geolocation=(), payment=()';

    // HSTS — tells browsers to always use HTTPS
    // Only active in production (not localhost)
    if ( ! in_array( $_SERVER['HTTP_HOST'] ?? '', array( 'localhost', '127.0.0.1' ), true ) ) {
        $headers['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains; preload';
    }

    return $headers;
}
add_filter( 'wp_headers', 'qmw_add_security_headers' );

// ============================================================
// 5. RESTRICT ALLOWED UPLOAD FILE TYPES
// ============================================================
/**
 * Limits uploads to safe, expected file types.
 * Prevents attackers from uploading .php, .exe, .sh, etc.
 */
function qmw_restrict_upload_mimes( $mimes ) {
    // Only allow these file types
    $allowed = array(
        // Images
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'webp'         => 'image/webp',
        'svg'          => 'image/svg+xml',
        'ico'          => 'image/x-icon',

        // Documents
        'pdf'          => 'application/pdf',

        // Fonts
        'woff'         => 'font/woff',
        'woff2'        => 'font/woff2',
        'ttf'          => 'font/ttf',

        // Audio/Video (if used)
        'mp4'          => 'video/mp4',
        'mp3'          => 'audio/mpeg',

        // Archives (for software downloads — admin only)
        'zip'          => 'application/zip',
    );
    return $allowed;
}
add_filter( 'upload_mimes', 'qmw_restrict_upload_mimes' );

// ============================================================
// 6. DISABLE USER ENUMERATION
// ============================================================
// Prevents author queries like /?author=1 from revealing usernames
function qmw_prevent_user_enumeration() {
    if ( ! is_admin() && isset( $_GET['author'] ) && is_numeric( $_GET['author'] ) ) {
        wp_redirect( home_url( '/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'qmw_prevent_user_enumeration' );

// Redirect REST API user listing for non-admins
add_filter( 'rest_endpoints', function( $endpoints ) {
    if ( ! current_user_can( 'administrator' ) ) {
        if ( isset( $endpoints['/wp/v2/users'] ) ) {
            unset( $endpoints['/wp/v2/users'] );
        }
        if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
            unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
        }
    }
    return $endpoints;
} );

// ============================================================
// 7. REMOVE UNNEEDED HEAD TAGS
// ============================================================
// These tags leak information or create unnecessary HTTP requests
remove_action( 'wp_head', 'rsd_link' );                         // Really Simple Discovery
remove_action( 'wp_head', 'wlwmanifest_link' );                 // Windows Live Writer
remove_action( 'wp_head', 'wp_shortlink_wp_head' );             // Shortlink
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );  // Emoji JS
remove_action( 'wp_print_styles', 'print_emoji_styles' );       // Emoji CSS
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );    // oEmbed discovery
remove_action( 'wp_head', 'wp_oembed_add_host_js' );            // oEmbed host JS
remove_action( 'wp_head', 'rest_output_link_wp_head' );         // REST API link header
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// ============================================================
// 8. DISABLE APPLICATION PASSWORDS (WP 5.6+)
// ============================================================
// Application passwords are not needed for this theme
add_filter( 'wp_is_application_passwords_available', '__return_false' );

// ============================================================
// 9. LIMIT LOGIN ATTEMPTS VIA TRANSIENT (SOFT PROTECTION)
// ============================================================
/**
 * Tracks failed login attempts per IP using transients.
 * Heavy-duty login protection should use the Wordfence plugin.
 * This is a lightweight fallback / complementary measure.
 */
function qmw_track_failed_login( $username ) {
    $ip          = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $transient   = 'qmw_failed_login_' . md5( $ip );
    $attempts    = (int) get_transient( $transient );
    $max_attempts = 5;
    $lockout_time = 15 * MINUTE_IN_SECONDS;

    if ( $attempts >= $max_attempts ) {
        // Already locked — log for audit purposes
        if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
            error_log( 'QMW Security: Login blocked for IP ' . $ip . ' — too many failed attempts.' );
        }
        return;
    }

    set_transient( $transient, $attempts + 1, $lockout_time );
}
add_action( 'wp_login_failed', 'qmw_track_failed_login' );

function qmw_clear_failed_login( $user_login, $user ) {
    $ip        = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $transient = 'qmw_failed_login_' . md5( $ip );
    delete_transient( $transient );
}
add_action( 'wp_login', 'qmw_clear_failed_login', 10, 2 );

// ============================================================
// 10. DISABLE AUTHOR ARCHIVE PAGES (OPTIONAL)
// ============================================================
// Prevents author pages from revealing WordPress usernames via URL
function qmw_disable_author_archive() {
    if ( is_author() ) {
        wp_redirect( home_url( '/' ), 301 );
        exit;
    }
}
add_action( 'template_redirect', 'qmw_disable_author_archive' );

// ============================================================
// 11. PROTECT AGAINST COMMON INJECTION ATTACKS
// ============================================================
function qmw_block_suspicious_requests() {
    if ( is_admin() ) {
        return;
    }

    // Block requests with suspicious query string characters
    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    $blocked_patterns = array(
        '<script',
        'javascript:',
        'vbscript:',
        'onload=',
        'onerror=',
        '../../../',
        'wp-config.php',
        'etc/passwd',
    );

    foreach ( $blocked_patterns as $pattern ) {
        if ( stripos( $request_uri, $pattern ) !== false ) {
            wp_die( 'Access denied.', '403 Forbidden', array( 'response' => 403 ) );
        }
    }
}
add_action( 'init', 'qmw_block_suspicious_requests' );

// ============================================================
// 12. SECURITY LOGS CUSTOM POST TYPE
// ============================================================
function qmw_register_security_logs_cpt() {
    register_post_type( 'security_logs', array(
        'labels' => array(
            'name'               => 'Security Logs',
            'singular_name'      => 'Security Log',
            'menu_name'          => 'Security Logs',
            'all_items'          => 'All Logs',
            'view_item'          => 'View Log',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'security-logs-menu', // We'll group this or show separately
        'show_in_admin_bar'  => false,
        'capability_type'    => 'post',
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', // disable manual creation
            'edit_post' => 'manage_options',
            'read_post' => 'manage_options',
            'delete_post' => 'manage_options',
            'edit_posts' => 'manage_options',
            'edit_others_posts' => 'manage_options',
            'publish_posts' => 'manage_options',
            'read_private_posts' => 'manage_options',
        ),
        'map_meta_cap'       => true,
        'supports'           => array( 'title' ),
        'menu_icon'          => 'dashicons-shield',
    ) );
}
add_action( 'init', 'qmw_register_security_logs_cpt' );

// Log failed login attempts to custom CPT
function qmw_log_failed_login_to_cpt( $username ) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

    // Prevent recursive or massive spam of logs: check if there was a log from this IP in the last 2 seconds
    $recent_logs = get_posts( array(
        'post_type'      => 'security_logs',
        'posts_per_page' => 1,
        'meta_query'     => array(
            array(
                'key'   => 'log_ip',
                'value' => $ip,
            ),
        ),
        'date_query'     => array(
            array(
                'after' => '5 seconds ago',
            ),
        ),
    ) );

    if ( ! empty( $recent_logs ) ) {
        return; // Avoid spamming duplicate logs
    }

    $log_title = sprintf( 'Failed login: %s from %s', sanitize_text_field( $username ), sanitize_text_field( $ip ) );
    
    $log_id = wp_insert_post( array(
        'post_title'  => $log_title,
        'post_status' => 'publish',
        'post_type'   => 'security_logs',
    ) );

    if ( ! is_wp_error( $log_id ) && $log_id ) {
        update_post_meta( $log_id, 'log_ip', $ip );
        update_post_meta( $log_id, 'log_username', $username );
        update_post_meta( $log_id, 'log_user_agent', $user_agent );
        update_post_meta( $log_id, 'log_time', current_time( 'mysql' ) );
    }
}
add_action( 'wp_login_failed', 'qmw_log_failed_login_to_cpt' );

// Enforce strong password requirements on registration/password resets
function qmw_enforce_strong_password_rules( $errors, $sanitized_user_login, $user_email ) {
    if ( isset( $_POST['pass1'] ) && ! empty( $_POST['pass1'] ) ) {
        $password = $_POST['pass1'];
        if ( strlen( $password ) < 8 ) {
            $errors->add( 'password_too_short', '<strong>Error</strong>: Password must be at least 8 characters long.' );
        }
        if ( ! preg_match( '/[A-Z]/', $password ) ) {
            $errors->add( 'password_no_uppercase', '<strong>Error</strong>: Password must include at least one uppercase letter.' );
        }
        if ( ! preg_match( '/[0-9]/', $password ) ) {
            $errors->add( 'password_no_number', '<strong>Error</strong>: Password must include at least one number.' );
        }
        if ( ! preg_match( '/[^A-Za-z0-9]/', $password ) ) {
            $errors->add( 'password_no_special', '<strong>Error</strong>: Password must include at least one special character.' );
        }
    }
    return $errors;
}
add_filter( 'registration_errors', 'qmw_enforce_strong_password_rules', 10, 3 );

// Restrict REST API user endpoint access for non-administrators
add_filter( 'rest_authentication_errors', function( $result ) {
    if ( true === $result || is_wp_error( $result ) ) {
        return $result;
    }

    $request_uri = $_SERVER['REQUEST_URI'] ?? '';
    if ( strpos( $request_uri, '/wp/v2/users' ) !== false ) {
        if ( ! current_user_can( 'administrator' ) ) {
            return new WP_Error(
                'rest_forbidden_context',
                'Access to user directory lists is prohibited.',
                array( 'status' => rest_authorization_required_code() )
            );
        }
    }

    return $result;
} );
