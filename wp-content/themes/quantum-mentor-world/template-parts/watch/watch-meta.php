<?php
/**
 * Single Watch Content — Sidebar Meta / Specs Card
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;

$watch_type   = get_field( 'watch_type', $post_id );
$genre        = get_field( 'watch_genre_field', $post_id );
$language     = get_field( 'watch_language_field', $post_id );
$release_year = get_field( 'watch_release_year_field', $post_id );
$status       = get_field( 'watch_status_field', $post_id );

$verified       = get_field( 'verified_resource', $post_id );
$official_conf  = get_field( 'official_source_confirmed', $post_id );
$safety_checked = get_field( 'safety_checked', $post_id );

// Fallbacks for safety status fields
if ( $verified === null )       { $verified = true; }
if ( $official_conf === null )  { $official_conf = true; }
if ( $safety_checked === null ) { $safety_checked = true; }

$formatted_date = get_the_modified_date( get_option( 'date_format' ), $post_id );

// Status color map
$status_colors = array(
    'Completed' => '#22C55E', // green
    'Ongoing'   => '#3B82F6', // blue
    'Upcoming'  => '#A855F7', // purple
    'Paused'    => '#F59E0B', // amber
);
$status_color = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : '#94A3B8';

// Taxonomy terms
$watch_cats = get_the_terms( $post_id, 'watch_category' );
$watch_tags = get_the_terms( $post_id, 'watch_tag' );
?>

<!-- ============================================================
     WATCH META SIDEBAR CARD
     ============================================================ -->
<aside class="watch-meta-card glass-card p-6" aria-label="<?php esc_attr_e( 'Watch Information Details', 'quantum-mentor-world' ); ?>">

    <h2 class="watch-meta-heading">
        <?php esc_html_e( 'Media Information', 'quantum-mentor-world' ); ?>
    </h2>

    <ul class="watch-spec-list" role="list">

        <?php if ( ! empty( $watch_type ) ) : ?>
        <li class="watch-spec-item">
            <span class="watch-spec-label">📁 <?php esc_html_e( 'Content Type', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value"><?php echo esc_html( $watch_type ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $genre ) ) : ?>
        <li class="watch-spec-item">
            <span class="watch-spec-label">🎭 <?php esc_html_e( 'Genre', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value"><?php echo esc_html( $genre ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $language ) ) : ?>
        <li class="watch-spec-item">
            <span class="watch-spec-label">🌐 <?php esc_html_e( 'Language', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value"><?php echo esc_html( $language ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $release_year ) ) : ?>
        <li class="watch-spec-item">
            <span class="watch-spec-label">🗓️ <?php esc_html_e( 'Release Year', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value"><?php echo esc_html( $release_year ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $status ) ) : ?>
        <li class="watch-spec-item">
            <span class="watch-spec-label">📡 <?php esc_html_e( 'Status', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value">
                <span style="display:inline-flex; align-items:center; gap:5px; padding: 2px 10px; border-radius:999px; background-color:<?php echo esc_attr( $status_color ); ?>20; color:<?php echo esc_attr( $status_color ); ?>; font-size:11px; font-weight:700; border:1px solid <?php echo esc_attr( $status_color ); ?>40;">
                    <?php echo esc_html( $status ); ?>
                </span>
            </span>
        </li>
        <?php endif; ?>

        <li class="watch-spec-item" style="border-bottom: none;">
            <span class="watch-spec-label">🔄 <?php esc_html_e( 'Last Updated', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value">
                <time datetime="<?php echo esc_attr( get_the_modified_date( 'Y-m-d', $post_id ) ); ?>">
                    <?php echo esc_html( $formatted_date ); ?>
                </time>
            </span>
        </li>

    </ul>

    <!-- Category Tags -->
    <?php if ( ! empty( $watch_cats ) && ! is_wp_error( $watch_cats ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="watch-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Watch Categories', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $watch_cats as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tags -->
    <?php if ( ! empty( $watch_tags ) && ! is_wp_error( $watch_tags ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="watch-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Tags', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $watch_tags as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</aside>

<!-- Verification Badge -->
<div class="watch-verify-card glass-card p-4" aria-label="<?php esc_attr_e( 'Trust & Verification Badge', 'quantum-mentor-world' ); ?>">
    <div style="display: flex; flex-direction: column; gap: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
            <span style="font-size: 26px; flex-shrink: 0;">✅</span>
            <div>
                <p style="font-size: 13px; font-weight: 700; color: var(--success); margin-bottom: 2px;"><?php esc_html_e( 'Verified Embed Stream', 'quantum-mentor-world' ); ?></p>
                <p class="small-text" style="font-size: 11px; line-height: 1.5;"><?php esc_html_e( 'Creator-approved or public legally licensed content.', 'quantum-mentor-world' ); ?></p>
            </div>
        </div>

        <?php if ( $verified ) : ?>
        <div class="watch-trust-check">
            <span class="watch-trust-dot"></span>
            <span><?php esc_html_e( 'Verified Resource', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $official_conf ) : ?>
        <div class="watch-trust-check">
            <span class="watch-trust-dot"></span>
            <span><?php esc_html_e( 'Official Source Confirmed', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $safety_checked ) : ?>
        <div class="watch-trust-check">
            <span class="watch-trust-dot"></span>
            <span><?php esc_html_e( 'Safety & Link Integrity Checked', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
