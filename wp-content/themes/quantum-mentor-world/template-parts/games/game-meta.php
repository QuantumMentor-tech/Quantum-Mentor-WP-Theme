<?php
/**
 * Single Game — Sidebar Meta / Specs Card
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;

$platform       = get_field( 'game_platform', $post_id );
$genre          = get_field( 'game_genre_field', $post_id );
$developer      = get_field( 'game_developer', $post_id );
$license        = get_field( 'game_license', $post_id );
$version        = get_field( 'game_version', $post_id );
$size           = get_field( 'game_size', $post_id );
$status         = get_field( 'game_status', $post_id );
$verified       = get_field( 'verified_resource', $post_id );
$official_conf  = get_field( 'official_source_confirmed', $post_id );
$safety_checked = get_field( 'safety_checked', $post_id );

$last_updated   = get_field( 'game_last_updated', $post_id );
$formatted_date = ! empty( $last_updated )
    ? date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) )
    : get_the_modified_date( get_option( 'date_format' ), $post_id );

// Taxonomy terms
$game_cats = get_the_terms( $post_id, 'game_category' );
$game_tags = get_the_terms( $post_id, 'game_tag' );

// Status color map
$status_colors = array(
    'Active'    => '#22C55E',
    'Updated'   => '#3B82F6',
    'Upcoming'  => '#A855F7',
    'Inactive'  => '#F59E0B',
    'Removed'   => '#EF4444',
);
$status_color = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : '#94A3B8';
?>

<!-- ============================================================
     GAME META SIDEBAR CARD
     ============================================================ -->
<aside class="game-meta-card glass-card p-6" aria-label="<?php esc_attr_e( 'Game Details', 'quantum-mentor-world' ); ?>">

    <h2 class="game-meta-heading">
        <?php esc_html_e( 'Game Information', 'quantum-mentor-world' ); ?>
    </h2>

    <ul class="game-spec-list" role="list">

        <?php if ( ! empty( $developer ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">🧑‍💻 <?php esc_html_e( 'Developer', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value"><?php echo esc_html( $developer ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $genre ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">🎯 <?php esc_html_e( 'Genre', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value"><?php echo esc_html( $genre ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $platform ) && is_array( $platform ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">💻 <?php esc_html_e( 'Platform', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value game-platform-badges">
                <?php foreach ( $platform as $p ) : ?>
                    <span class="badge badge-muted" style="font-size: 9px;"><?php echo esc_html( $p ); ?></span>
                <?php endforeach; ?>
            </span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $license ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">📋 <?php esc_html_e( 'License', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value" style="color: var(--success); font-weight: 700;"><?php echo esc_html( $license ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $version ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">🔢 <?php esc_html_e( 'Version', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value"><?php echo esc_html( $version ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $size ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">📦 <?php esc_html_e( 'File Size', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value"><?php echo esc_html( $size ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $status ) ) : ?>
        <li class="game-spec-item">
            <span class="game-spec-label">📡 <?php esc_html_e( 'Status', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value">
                <span style="display:inline-flex; align-items:center; gap:5px; padding: 2px 10px; border-radius:999px; background-color:<?php echo esc_attr( $status_color ); ?>20; color:<?php echo esc_attr( $status_color ); ?>; font-size:11px; font-weight:700; border:1px solid <?php echo esc_attr( $status_color ); ?>40;">
                    <?php echo esc_html( $status ); ?>
                </span>
            </span>
        </li>
        <?php endif; ?>

        <li class="game-spec-item" style="border-bottom: none;">
            <span class="game-spec-label">🗓️ <?php esc_html_e( 'Last Updated', 'quantum-mentor-world' ); ?></span>
            <span class="game-spec-value">
                <time datetime="<?php echo esc_attr( $last_updated ?: get_the_modified_date( 'Y-m-d' ) ); ?>">
                    <?php echo esc_html( $formatted_date ); ?>
                </time>
            </span>
        </li>

    </ul>

    <!-- Category Tags -->
    <?php if ( ! empty( $game_cats ) && ! is_wp_error( $game_cats ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="games-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Categories', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $game_cats as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tags -->
    <?php if ( ! empty( $game_tags ) && ! is_wp_error( $game_tags ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="games-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Tags', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $game_tags as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</aside>

<!-- Verification Badge -->
<div class="game-verify-card glass-card p-4" aria-label="<?php esc_attr_e( 'Trust & Verification Badge', 'quantum-mentor-world' ); ?>">
    <div style="display: flex; flex-direction: column; gap: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
            <span style="font-size: 26px; flex-shrink: 0;">✅</span>
            <div>
                <p style="font-size: 13px; font-weight: 700; color: var(--success); margin-bottom: 2px;"><?php esc_html_e( 'Verified Legal Resource', 'quantum-mentor-world' ); ?></p>
                <p class="small-text" style="font-size: 11px; line-height: 1.5;"><?php esc_html_e( 'Officially sourced. Zero piracy policy enforced.', 'quantum-mentor-world' ); ?></p>
            </div>
        </div>

        <?php if ( $verified ) : ?>
        <div class="game-trust-check">
            <span class="game-trust-dot"></span>
            <span><?php esc_html_e( 'Verified Resource', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $official_conf ) : ?>
        <div class="game-trust-check">
            <span class="game-trust-dot"></span>
            <span><?php esc_html_e( 'Official Source Confirmed', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $safety_checked ) : ?>
        <div class="game-trust-check">
            <span class="game-trust-dot"></span>
            <span><?php esc_html_e( 'Safety Checked', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
