<?php
/**
 * Quantum Mentor World — Theme Functions & Definitions
 *
 * Bootstraps the custom theme by loading each modular include file
 * from the /inc/ directory in the correct dependency order.
 *
 * Load order:
 *  1. theme-setup.php   — Theme supports, menus, body classes, archive queries
 *  2. enqueue.php       — Scripts, styles, Google Fonts enqueueing
 *  3. custom-post-types.php — CPT, taxonomy, term seeding, admin columns
 *  4. acf-fields.php    — ACF programmatic field group registration
 *  5. helpers.php       — JSON-LD schema, AJAX search handler, utility functions
 *  6. security.php      — WordPress security hardening
 *  7. performance.php   — Speed optimizations, image sizes, cache management
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 * @since   1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// ── Define theme version constant for cache-busting ──────────────────────────
define( 'QMW_VERSION', '1.0.0' );
define( 'QMW_THEME_DIR', get_template_directory() );
define( 'QMW_THEME_URI', get_template_directory_uri() );

// ── Modular theme include loader ──────────────────────────────────────────────
$qmw_includes = array(
    '/inc/theme-setup.php',        // 1. Theme supports, menus, body classes, archive queries
    '/inc/enqueue.php',            // 2. Scripts, styles, Google Fonts
    '/inc/custom-post-types.php',  // 3. CPT, taxonomies, term seeding, admin columns
    '/inc/acf-fields.php',         // 4. ACF programmatic field groups (requires ACF plugin)
    '/inc/helpers.php',            // 5. JSON-LD schema, AJAX handlers, utility functions
    '/inc/security.php',           // 6. WordPress security hardening
    '/inc/performance.php',        // 7. Speed optimizations, image sizes
    '/inc/admin/admin-dashboard.php',
    '/inc/admin/admin-columns.php',
    '/inc/admin/admin-filters.php',
    '/inc/admin/user-roles.php',
    '/inc/admin/submissions.php',
    '/inc/admin/contact-messages.php',
    '/inc/admin/admin-notices.php',
    '/inc/seo.php',
    '/inc/analytics.php',
    '/inc/accessibility.php',
);

foreach ( $qmw_includes as $qmw_file ) {
    $qmw_filepath = QMW_THEME_DIR . $qmw_file;
    if ( file_exists( $qmw_filepath ) ) {
        require_once $qmw_filepath;
    } else {
        // Log missing include files only in debug mode
        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            trigger_error(
                sprintf( 'QMW Theme: Missing include file: %s', esc_html( $qmw_filepath ) ),
                E_USER_NOTICE
            );
        }
    }
}
