<?php
/**
 * Single Game — Download / Link Box (Sidebar)
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id      = $post->ID;
$official_url = get_field( 'game_official_url', $post_id );
$download_url = get_field( 'game_download_url', $post_id );
$trailer_url  = get_field( 'game_trailer_url', $post_id );
$license      = get_field( 'game_license', $post_id );

// Nothing to show if no links exist
if ( empty( $official_url ) && empty( $download_url ) && empty( $trailer_url ) ) {
    return;
}
?>

<!-- ============================================================
     GAME LINK / DOWNLOAD BOX
     ============================================================ -->
<div class="game-link-box glass-card p-6" aria-label="<?php esc_attr_e( 'Download and Links', 'quantum-mentor-world' ); ?>">

    <h2 class="game-meta-heading" style="margin-bottom: var(--space-4);">
        🎮 <?php esc_html_e( 'Get This Game', 'quantum-mentor-world' ); ?>
    </h2>

    <?php if ( ! empty( $license ) ) : ?>
    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: var(--space-4); display: flex; align-items: center; gap: 6px;">
        <span class="badge badge-success" style="font-size: 10px;"><?php echo esc_html( $license ); ?></span>
        <?php esc_html_e( 'Legal & officially licensed', 'quantum-mentor-world' ); ?>
    </p>
    <?php endif; ?>

    <div style="display: flex; flex-direction: column; gap: var(--space-3);">

        <?php if ( ! empty( $download_url ) ) : ?>
        <a href="<?php echo esc_url( $download_url ); ?>"
           class="btn btn-accent"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center; font-size: 15px;"
           aria-label="<?php echo esc_attr( sprintf( __( 'Download %s from official source', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            ⬇️ <?php esc_html_e( 'Download from Official Source', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

        <?php if ( ! empty( $official_url ) ) : ?>
        <a href="<?php echo esc_url( $official_url ); ?>"
           class="btn btn-secondary"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center;"
           aria-label="<?php echo esc_attr( sprintf( __( 'Visit official website for %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            🌐 <?php esc_html_e( 'Visit Official Website', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

        <?php if ( ! empty( $trailer_url ) ) : ?>
        <a href="<?php echo esc_url( $trailer_url ); ?>"
           class="btn"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center; background: rgba(124,58,237,0.1); border: 1px solid rgba(124,58,237,0.3); color: var(--secondary);"
           aria-label="<?php echo esc_attr( sprintf( __( 'Watch trailer for %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            ▶️ <?php esc_html_e( 'Watch Trailer', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

    </div>

    <!-- Safety / Legal Note -->
    <div class="game-legal-note" style="margin-top: var(--space-4); padding: var(--space-3) var(--space-4); background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.2); border-radius: var(--radius-sm);">
        <p style="font-size: 11px; line-height: 1.6; color: var(--warning); margin: 0;">
            ⚠️ <?php esc_html_e( 'Quantum Mentor World only lists legal, official, open-source, freeware, demo, educational, or properly licensed games. We do not promote cracked games, illegal keys, repacks, bypasses, cheats, hacks, or pirated downloads.', 'quantum-mentor-world' ); ?>
        </p>
    </div>

    <!-- External link notice -->
    <p style="font-size: 10px; color: var(--text-muted); margin-top: var(--space-3); text-align: center; opacity: 0.7;">
        <?php esc_html_e( 'External links open in a new tab and use rel="nofollow noopener".', 'quantum-mentor-world' ); ?>
    </p>
</div>
