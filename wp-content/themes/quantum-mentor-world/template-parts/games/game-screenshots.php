<?php
/**
 * Single Game — Screenshots Gallery
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id     = $post->ID;
$screenshots = get_field( 'game_screenshots', $post_id );

if ( empty( $screenshots ) || ! is_array( $screenshots ) ) {
    return;
}
?>

<!-- ============================================================
     GAME SCREENSHOTS GALLERY
     ============================================================ -->
<section class="game-screenshots-section glass-card p-6" aria-label="<?php esc_attr_e( 'Game Screenshots Gallery', 'quantum-mentor-world' ); ?>">

    <h2 class="section-title mb-4" style="font-size: 22px;">
        🖼️ <?php esc_html_e( 'Screenshots', 'quantum-mentor-world' ); ?>
        <span class="badge badge-muted" style="font-size: 11px; margin-left: var(--space-2);">
            <?php echo count( $screenshots ); ?> <?php esc_html_e( 'images', 'quantum-mentor-world' ); ?>
        </span>
    </h2>

    <div class="game-screenshots-grid" role="list">
        <?php
        $count = 0;
        foreach ( $screenshots as $image ) :
            $count++;

            // Support both ID (integer) and image array (ACF gallery return type)
            if ( is_numeric( $image ) ) {
                $img_id   = (int) $image;
                $img_url  = wp_get_attachment_image_url( $img_id, 'qmw-screenshot' );
                $full_url = wp_get_attachment_image_url( $img_id, 'full' );
                $img_alt  = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
            } elseif ( is_array( $image ) ) {
                $img_id   = isset( $image['ID'] ) ? (int) $image['ID'] : 0;
                $img_url  = ! empty( $image['sizes']['qmw-screenshot'] ) ? $image['sizes']['qmw-screenshot'] : ( $image['url'] ?? '' );
                $full_url = $image['url'] ?? $img_url;
                $img_alt  = $image['alt'] ?? '';
            } else {
                continue;
            }

            if ( empty( $img_url ) ) {
                continue;
            }

            if ( empty( $img_alt ) ) {
                /* translators: %1$s = game title, %2$d = screenshot number */
                $img_alt = sprintf( esc_attr__( '%1$s — screenshot %2$d', 'quantum-mentor-world' ), get_the_title(), $count );
            }
        ?>
        <div class="game-screenshot-item reveal" role="listitem">
            <a href="<?php echo esc_url( $full_url ); ?>"
               class="lightbox-trigger game-screenshot-thumb"
               aria-label="<?php echo esc_attr( sprintf( __( 'View screenshot %d in fullscreen', 'quantum-mentor-world' ), $count ) ); ?>">
                <img
                    src="<?php echo esc_url( $img_url ); ?>"
                    alt="<?php echo esc_attr( $img_alt ); ?>"
                    loading="lazy"
                    decoding="async"
                    class="screenshot-thumb"
                    width="400"
                    height="225"
                    style="width:100%; height:100%; object-fit:cover;"
                >
                <!-- Overlay zoom icon -->
                <div class="game-screenshot-overlay" aria-hidden="true">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                    </svg>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

    <p class="small-text" style="margin-top: var(--space-4); font-size: 11px; color: var(--text-muted); text-align: center;">
        <?php esc_html_e( 'Click any screenshot to view fullscreen.', 'quantum-mentor-world' ); ?>
    </p>

</section>
