<?php
/**
 * Game Card — Reusable card for archive grids and homepage sections.
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id    = get_the_ID();
$platform   = get_field( 'game_platform', $post_id );
$genre      = get_field( 'game_genre_field', $post_id );
$license    = get_field( 'game_license', $post_id );
$version    = get_field( 'game_version', $post_id );
$developer  = get_field( 'game_developer', $post_id );
$priority   = get_field( 'admin_priority', $post_id );
$is_featured = ( 'Featured' === $priority );
$title_esc  = esc_attr( get_the_title() );

// License color map
$license_classes = array(
    'Freeware'          => 'badge-success',
    'Open Source'       => 'badge-primary',
    'Demo'              => 'badge-secondary',
    'Freemium'          => 'badge-warning',
    'Paid Official Link'=> 'badge-muted',
    'Public Domain'     => 'badge-success',
);
$license_class = isset( $license_classes[ $license ] ) ? $license_classes[ $license ] : 'badge-muted';
?>

<article class="glass-card game-card <?php echo $is_featured ? 'game-card--featured' : ''; ?> reveal"
    aria-label="<?php echo esc_attr( sprintf( __( 'Game: %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">

    <!-- Cover image (16:9) -->
    <a href="<?php the_permalink(); ?>" class="game-card-img-wrap" tabindex="-1" aria-hidden="true">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'qmw-card', array(
                'loading' => 'lazy',
                'decoding' => 'async',
                'alt'     => $title_esc,
                'class'   => 'game-card-img',
            ) ); ?>
        <?php else : ?>
            <div class="game-card-img-placeholder" aria-hidden="true">🎮</div>
        <?php endif; ?>

        <?php if ( $is_featured ) : ?>
        <div class="game-card-featured-badge" aria-label="<?php esc_attr_e( 'Featured Game', 'quantum-mentor-world' ); ?>">
            ✨ <?php esc_html_e( 'Featured', 'quantum-mentor-world' ); ?>
        </div>
        <?php endif; ?>
    </a>

    <!-- Card body -->
    <div class="game-card-body">

        <!-- Top badges row -->
        <div class="game-card-badges">
            <?php if ( ! empty( $license ) ) : ?>
                <span class="badge <?php echo esc_attr( $license_class ); ?>" style="font-size: 9px;"><?php echo esc_html( $license ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $genre ) ) : ?>
                <span class="badge badge-secondary" style="font-size: 9px;"><?php echo esc_html( $genre ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $version ) ) : ?>
                <span class="badge badge-muted" style="font-size: 9px;"><?php echo esc_html( $version ); ?></span>
            <?php endif; ?>
        </div>

        <!-- Title -->
        <h3 class="game-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Developer -->
        <?php if ( ! empty( $developer ) ) : ?>
        <p class="game-card-developer">
            <span aria-hidden="true">🧑‍💻</span> <?php echo esc_html( $developer ); ?>
        </p>
        <?php endif; ?>

        <!-- Excerpt -->
        <p class="game-card-excerpt">
            <?php echo esc_html( wp_trim_words( get_the_excerpt(), 18, '...' ) ); ?>
        </p>

        <!-- Platform pills -->
        <?php if ( ! empty( $platform ) && is_array( $platform ) ) : ?>
        <div class="game-card-platforms">
            <?php foreach ( array_slice( $platform, 0, 4 ) as $p ) : ?>
                <span class="badge badge-muted" style="font-size: 8px; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo esc_html( $p ); ?></span>
            <?php endforeach; ?>
            <?php if ( count( $platform ) > 4 ) : ?>
                <span class="badge badge-muted" style="font-size: 8px;">+<?php echo count( $platform ) - 4; ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <!-- Card footer -->
    <div class="game-card-footer">
        <a href="<?php the_permalink(); ?>"
           class="btn btn-accent game-card-btn"
           aria-label="<?php echo esc_attr( sprintf( __( 'View details for %s', 'quantum-mentor-world' ), get_the_title() ) ); ?>">
            <?php esc_html_e( 'View Details', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

</article>
