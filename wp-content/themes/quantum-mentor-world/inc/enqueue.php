<?php
/**
 * Quantum Mentor World — Script & Style Enqueueing
 *
 * Loads:
 *  1. Google Fonts — Inter (body) + Outfit (display/headings)
 *  2. Main theme stylesheet — assets/css/main.css
 *  3. Main theme JavaScript — assets/js/main.js (deferred via performance.php)
 *  4. AJAX localisation — quantum_search_params object for live search
 *
 * Font strategy:
 *  - Fonts are loaded via WordPress wp_enqueue_style() (not @import in CSS)
 *  - display=swap ensures text is visible while fonts load
 *  - Preconnect tags added by performance.php for speed
 *
 * Cache busting:
 *  - Theme files use QMW_VERSION constant
 *  - Third-party assets use null version
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function qmw_enqueue_assets() {

    // ── 1. Google Fonts: Inter (400–700) + Outfit (500–800) ──────────────────
    // Inter: body text — highly readable, modern sans-serif
    // Outfit: headings/display — bold, futuristic tech aesthetic
    wp_enqueue_style(
        'qmw-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap',
        array(),
        null // null = no version, prevents ver= query string (Google Fonts manages its own cache)
    );

    // ── 2. Main Theme Stylesheet ──────────────────────────────────────────────
    wp_enqueue_style(
        'qmw-main-style',
        QMW_THEME_URI . '/assets/css/main.css',
        array( 'qmw-google-fonts' ), // Depend on fonts to load fonts first
        QMW_VERSION
    );

    // ── 3. Main Theme JavaScript ──────────────────────────────────────────────
    // Loaded in footer (true), deferred via performance.php filter.
    // Handles: mobile menu, search overlay, back-to-top, dark/light mode,
    //          FAQ accordions, lightbox, AJAX live search.
    wp_enqueue_script(
        'qmw-main-script',
        QMW_THEME_URI . '/assets/js/main.js',
        array(), // No dependencies (vanilla JS, no jQuery needed)
        QMW_VERSION,
        true  // Load in footer
    );

    // ── 4. AJAX Live Search Localisation ─────────────────────────────────────
    // Passes PHP data to JavaScript safely via wp_localize_script().
    // The nonce ensures only authenticated requests reach the AJAX handler.
    wp_localize_script(
        'qmw-main-script',
        'quantum_search_params',
        array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'quantum_search_nonce' ),
            'home_url' => esc_url( home_url( '/' ) ),
            'theme_uri'=> esc_url( QMW_THEME_URI ),
            'is_rtl'   => is_rtl() ? '1' : '0',
        )
    );

    // ── 5. Comment Reply Script (only on singular posts with comments) ────────
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

}
add_action( 'wp_enqueue_scripts', 'qmw_enqueue_assets' );


// ── 6. Admin-only styles & scripts ──────────────────
function qmw_admin_enqueue_assets( $hook ) {
    // Enqueue admin-specific stylesheet
    wp_enqueue_style(
        'qmw-admin-style',
        QMW_THEME_URI . '/assets/css/admin.css',
        array(),
        QMW_VERSION
    );

    // Enqueue admin-specific JS
    wp_enqueue_script(
        'qmw-admin-script',
        QMW_THEME_URI . '/assets/js/admin.js',
        array(),
        QMW_VERSION,
        true
    );

    // Inline CSS to improve ACF admin field readability (only on edit pages)
    if ( in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
        wp_add_inline_style(
            'wp-admin',
            '
            /* QMW Admin: Improve ACF tab visibility */
            .acf-tab-wrap .acf-tab-button {
                background: #1e293b !important;
                color: #94a3b8 !important;
                border: 1px solid #334155 !important;
                font-size: 12px !important;
            }
            .acf-tab-wrap .acf-tab-button.active {
                background: #7c3aed !important;
                color: #fff !important;
                border-color: #7c3aed !important;
            }
            /* QMW Admin: Highlight required fields */
            .acf-required { color: #ef4444 !important; }
            /* QMW Admin: Admin Controls group in sidebar — wider label */
            .acf-postbox .acf-field .acf-label label { font-weight: 600; }
            '
        );
    }
}
add_action( 'admin_enqueue_scripts', 'qmw_admin_enqueue_assets' );
