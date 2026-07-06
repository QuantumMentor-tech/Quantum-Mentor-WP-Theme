<?php
/**
 * Quantum Mentor World — Admin Notices
 *
 * Implements helpful, non-intrusive warnings on edit screens for custom post types
 * to encourage complete listings (SEO, safety checks, verified sources).
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook to show admin notices on post editor screen
add_action( 'admin_notices', 'qmw_admin_display_content_warnings' );

function qmw_admin_display_content_warnings() {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || 'post' !== $screen->base ) {
        return;
    }

    $cpts = array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' );
    if ( ! in_array( $screen->post_type, $cpts, true ) ) {
        return;
    }

    $post_id = get_the_ID();
    if ( ! $post_id ) {
        return;
    }

    $warnings = array();

    // 1. Missing Featured Image
    if ( ! has_post_thumbnail( $post_id ) ) {
        $warnings[] = 'This resource is missing a <strong>Featured Image</strong> (Icon, Cover, or Poster). A default fallback placeholder will be rendered on the frontend.';
    }

    // 2. Missing SEO Fields
    $seo_title = get_post_meta( $post_id, 'seo_title', true );
    $seo_desc = get_post_meta( $post_id, 'seo_meta_description', true );
    if ( empty( $seo_title ) ) {
        $warnings[] = 'Recommended: <strong>SEO Title</strong> is empty. The regular post title will be used as fallback.';
    }
    if ( empty( $seo_desc ) ) {
        $warnings[] = 'Recommended: <strong>Meta Description</strong> is missing. This metadata is highly recommended for search rankings.';
    }

    // 3. Verification & Safety Checked Status (not applicable to standard posts/news)
    $resource_cpts = array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools' );
    if ( in_array( $screen->post_type, $resource_cpts, true ) ) {
        $verified = get_post_meta( $post_id, 'admin_verified', true );
        $safety = get_post_meta( $post_id, 'admin_safety_checked', true );
        $source = get_post_meta( $post_id, 'admin_source_confirmed', true );

        if ( ! $verified ) {
            $warnings[] = '⚠️ This resource is <strong>not marked as Verified</strong>. Please review legal status and toggle ON in the Admin sidepanel.';
        }
        if ( ! $safety ) {
            $warnings[] = '🛡️ This resource is <strong>not marked as Safety Checked</strong>. Verify that files/links are malware-free.';
        }
        if ( ! $source ) {
            $warnings[] = '🔗 The source URL for this resource is <strong>not confirmed as Official</strong>.';
        }
    }

    // ── CPT-Specific URL Security Checks ──
    $url_fields = array(
        'software'       => array( 'software_official_url', 'software_download_url' ),
        'themes_plugins' => array( 'tp_official_url', 'tp_download_url' ),
        'games'          => array( 'game_official_url', 'game_download_url' ),
        'books'          => array( 'book_official_url', 'book_download_url' ),
        'watch'          => array( 'watch_official_url' ),
        'tools'          => array( 'tool_url', 'tool_download_url' ),
    );

    if ( isset( $url_fields[ $screen->post_type ] ) ) {
        foreach ( $url_fields[ $screen->post_type ] as $field ) {
            $url = get_post_meta( $post_id, $field, true );
            if ( ! empty( $url ) ) {
                // Check if secure
                if ( strpos( strtolower( $url ), 'https://' ) !== 0 ) {
                    $warnings[] = sprintf( '⚠️ Unsafe URL format: The field <code>%s</code> does not use a secure HTTPS protocol (<code>%s</code>). Outbound links should use HTTPS.', esc_html( $field ), esc_html( $url ) );
                }
            } else {
                // If official URL is completely empty
                if ( strpos( $field, 'official' ) !== false || strpos( $field, 'tool_url' ) !== false ) {
                    $warnings[] = sprintf( 'Missing mandatory <strong>Official Source URL</strong> (field: <code>%s</code>).', esc_html( $field ) );
                }
            }
        }
    }

    // ── Watch Specific checks ──
    if ( 'watch' === $screen->post_type ) {
        $legal_note = get_post_meta( $post_id, 'watch_legal_note', true );
        if ( empty( $legal_note ) ) {
            $warnings[] = '⚠️ Missing <strong>Legal Permission Note</strong>. For embedded videos, you must supply a compliance confirmation note.';
        }

        // Check if episodic watch content has episodes
        $watch_type = get_post_meta( $post_id, 'watch_type', true );
        $episodic_types = array( 'Course', 'Anime', 'Donghua', 'Tutorial' );
        if ( in_array( $watch_type, $episodic_types, true ) ) {
            $episodes = get_post_meta( $post_id, 'watch_episodes', true ); // ACF returns length or repeater array
            if ( empty( $episodes ) ) {
                $warnings[] = 'This episodic content is set as ' . esc_html( $watch_type ) . ' but has no items in the <strong>Episode List</strong>.';
            }
        }
    }

    // ── Render Notices ──
    if ( ! empty( $warnings ) ) {
        echo '<div class="notice notice-warning is-dismissible">';
        echo '  <p><strong>Quantum Mentor Listing Audit Checklist:</strong></p>';
        echo '  <ul style="list-style-type:disc; margin-left:20px;">';
        foreach ( $warnings as $warning ) {
            echo '    <li style="margin-bottom:4px;">' . wp_kses_post( $warning ) . '</li>';
        }
        echo '  </ul>';
        echo '</div>';
    }
}
