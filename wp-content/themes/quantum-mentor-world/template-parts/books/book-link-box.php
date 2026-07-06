<?php
/**
 * Single Book — Download / Link Box (Sidebar)
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id      = $post->ID;
$official_url = get_field( 'book_official_url', $post_id );
$download_url = get_field( 'book_download_url', $post_id );
$read_url     = get_field( 'book_read_online_url', $post_id );
$book_type    = get_field( 'book_type', $post_id );

// Nothing to show if no links exist
if ( empty( $official_url ) && empty( $download_url ) && empty( $read_url ) ) {
    return;
}
?>

<!-- ============================================================
     BOOK LINK / ACTIONS BOX
     ============================================================ -->
<div class="book-link-box glass-card p-6" aria-label="<?php esc_attr_e( 'Access and Download Options', 'quantum-mentor-world' ); ?>">

    <h2 class="book-meta-heading" style="margin-bottom: var(--space-4);">
        📖 <?php esc_html_e( 'Read or Download', 'quantum-mentor-world' ); ?>
    </h2>

    <?php if ( ! empty( $book_type ) ) : ?>
    <p style="font-size: 12px; color: var(--text-muted); margin-bottom: var(--space-4); display: flex; align-items: center; gap: 6px;">
        <span class="badge badge-warning" style="font-size: 10px;"><?php echo esc_html( $book_type ); ?></span>
        <?php esc_html_e( 'Verified legal publication', 'quantum-mentor-world' ); ?>
    </p>
    <?php endif; ?>

    <div style="display: flex; flex-direction: column; gap: var(--space-3);">

        <?php if ( ! empty( $download_url ) ) : ?>
        <a href="<?php echo esc_url( $download_url ); ?>"
           class="btn btn-accent"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center; font-size: 15px;"
           aria-label="<?php echo esc_attr( sprintf( __( 'Download legal copy of %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            ⬇️ <?php esc_html_e( 'Download E-Book', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

        <?php if ( ! empty( $read_url ) ) : ?>
        <a href="<?php echo esc_url( $read_url ); ?>"
           class="btn btn-primary"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center; font-size: 15px;"
           aria-label="<?php echo esc_attr( sprintf( __( 'Read %s online', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            📖 <?php esc_html_e( 'Read Online', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

        <?php if ( ! empty( $official_url ) ) : ?>
        <a href="<?php echo esc_url( $official_url ); ?>"
           class="btn btn-secondary"
           target="_blank"
           rel="nofollow noopener noreferrer"
           style="width: 100%; justify-content: center;"
           aria-label="<?php echo esc_attr( sprintf( __( 'Visit publisher page for %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            🌐 <?php esc_html_e( 'Publisher / Source page', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

    </div>

    <!-- Safety / Legal Note -->
    <div class="book-legal-note" style="margin-top: var(--space-4); padding: var(--space-3) var(--space-4); background: rgba(245,158,11,0.06); border: 1px solid rgba(245,158,11,0.2); border-radius: var(--radius-sm);">
        <p style="font-size: 11px; line-height: 1.6; color: var(--warning); margin: 0;">
            ⚠️ <?php esc_html_e( 'Quantum Mentor World strictly enforces a zero-piracy policy. We only list public-domain, open-access, creator-approved, or official paid links. No copyrighted novels, leaked PDFs, or pirated books are hosted.', 'quantum-mentor-world' ); ?>
        </p>
    </div>

    <!-- External link notice -->
    <p style="font-size: 10px; color: var(--text-muted); margin-top: var(--space-3); text-align: center; opacity: 0.7;">
        <?php esc_html_e( 'All external links open in a new window with rel="nofollow noopener".', 'quantum-mentor-world' ); ?>
    </p>
</div>
