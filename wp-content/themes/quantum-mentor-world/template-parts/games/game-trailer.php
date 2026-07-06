<?php
/**
 * Single Game — Trailer Embed
 * Safe iframe embed from YouTube, Vimeo, or official game platforms.
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id     = $post->ID;
$trailer_url = get_field( 'game_trailer_url', $post_id );

if ( empty( $trailer_url ) ) {
    return;
}

/**
 * Build a safe embed URL from the raw input URL.
 * Allowed origins: YouTube, Vimeo.
 * Returns sanitised embed URL or empty string on failure.
 *
 * @param string $url Raw URL from ACF field.
 * @return string Safe embed URL or empty string.
 */
function qmw_get_game_trailer_embed_url( $url ) {
    $url = esc_url_raw( $url );

    // YouTube: youtu.be/ID or youtube.com/watch?v=ID
    if ( preg_match( '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches ) ) {
        return 'https://www.youtube-nocookie.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
    }

    // Vimeo: vimeo.com/ID
    if ( preg_match( '/vimeo\.com\/(\d+)/', $url, $matches ) ) {
        return 'https://player.vimeo.com/video/' . $matches[1] . '?dnt=1';
    }

    // Already a known embed URL (youtube-nocookie, player.vimeo)
    if ( strpos( $url, 'youtube-nocookie.com/embed/' ) !== false || strpos( $url, 'player.vimeo.com/video/' ) !== false ) {
        return $url;
    }

    // Reject anything else
    return '';
}

$embed_url = qmw_get_game_trailer_embed_url( $trailer_url );

if ( empty( $embed_url ) ) {
    return;
}

$game_title = get_the_title();
?>

<!-- ============================================================
     GAME TRAILER EMBED
     ============================================================ -->
<section class="game-trailer-section glass-card p-6" aria-label="<?php esc_attr_e( 'Game Trailer', 'quantum-mentor-world' ); ?>">

    <h2 class="section-title mb-4" style="font-size: 22px;">
        🎬 <?php esc_html_e( 'Game Trailer', 'quantum-mentor-world' ); ?>
    </h2>

    <div class="video-embed-wrapper">
        <?php
        // Build iframe with wp_kses for safety
        $allowed_iframe = array(
            'iframe' => array(
                'src'             => true,
                'title'           => true,
                'width'           => true,
                'height'          => true,
                'frameborder'     => true,
                'allowfullscreen' => true,
                'loading'         => true,
                'allow'           => true,
                'referrerpolicy'  => true,
                'class'           => true,
            ),
        );

        $iframe_html = sprintf(
            '<iframe src="%s" title="%s" frameborder="0" allowfullscreen loading="lazy" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" referrerpolicy="strict-origin-when-cross-origin" width="100%%" height="100%%"></iframe>',
            esc_url( $embed_url ),
            esc_attr( sprintf( __( 'Game trailer for %s', 'quantum-mentor-world' ), $game_title ) )
        );

        echo wp_kses( $iframe_html, $allowed_iframe );
        ?>
    </div>

    <p class="small-text" style="margin-top: var(--space-3); font-size: 11px; color: var(--text-muted); text-align: center;">
        <?php esc_html_e( 'Trailer from an official, trusted video platform. Autoplay is disabled.', 'quantum-mentor-world' ); ?>
    </p>

</section>
