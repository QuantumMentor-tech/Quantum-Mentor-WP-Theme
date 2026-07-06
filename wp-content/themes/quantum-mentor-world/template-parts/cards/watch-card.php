<?php
/**
 * Watch Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id      = get_the_ID();
$watch_type   = get_field( 'watch_type', $post_id );
$genre        = get_field( 'watch_genre_field', $post_id );
$language     = get_field( 'watch_language_field', $post_id );
$status       = get_field( 'watch_status_field', $post_id );
$poster_id    = get_field( 'watch_poster', $post_id );
$summary      = get_field( 'short_description', $post_id );
$is_verified  = get_field( 'verified_resource', $post_id );

if ( $is_verified === null ) {
    $is_verified = get_field( 'admin_verified', $post_id );
    if ( $is_verified === null ) {
        $is_verified = true;
    }
}
?>

<article class="glass-card watch-card transition-all" style="height: 100%; display: flex; flex-direction: column; position: relative;">
    
    <!-- Verified Badge -->
    <?php if ( $is_verified ) : ?>
        <div class="watch-card-badge-wrap" style="position: absolute; top: var(--space-4); left: var(--space-4); z-index: 10;">
            <span class="badge badge-success" style="font-size: 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Watch poster image (2:3 aspect ratio) -->
    <div class="watch-cover-wrapper" style="aspect-ratio: 2 / 3; border-radius: var(--radius-sm); background-color: var(--bg-primary); overflow: hidden; margin-bottom: var(--space-4); border: 1px solid var(--border); position: relative;">
        <?php if ( ! empty( $poster_id ) ) : ?>
            <?php echo wp_get_attachment_image( $poster_id, 'medium_large', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
        <?php elseif ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
        <?php else : ?>
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 48px; filter: grayscale(50%); background-color: rgba(255,255,255,0.01);">
                🎬
            </div>
        <?php endif; ?>

        <!-- Play hover overlay -->
        <div class="watch-play-overlay">
            <div class="watch-play-icon-btn">
                ▶
            </div>
        </div>
    </div>

    <!-- Metadata Badges row -->
    <div class="watch-card-badges-row" style="margin-bottom: var(--space-2); display: flex; gap: var(--space-1); flex-wrap: wrap;">
        <?php if ( ! empty( $watch_type ) ) : ?>
            <span class="badge badge-primary" style="font-size: 8px;"><?php echo esc_html( $watch_type ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $status ) ) : ?>
            <span class="badge badge-secondary" style="font-size: 8px;"><?php echo esc_html( $status ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $language ) ) : ?>
            <span class="badge badge-muted" style="font-size: 8px;"><?php echo esc_html( $language ); ?></span>
        <?php endif; ?>
    </div>

    <!-- Watch Title -->
    <h3 class="watch-card-title" style="margin-bottom: var(--space-2); font-size: 16px; line-height: 1.3;">
        <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
            <?php the_title(); ?>
        </a>
    </h3>

    <!-- Description / Excerpt -->
    <p class="watch-card-excerpt" style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: var(--space-4); flex: 1;">
        <?php
        if ( ! empty( $summary ) ) {
            echo esc_html( wp_trim_words( $summary, 16, '...' ) );
        } else {
            echo esc_html( wp_trim_words( get_the_excerpt(), 16, '...' ) );
        }
        ?>
    </p>

    <!-- Watch Stream button -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; border-color: var(--primary); color: var(--primary); padding: 8px 12px; min-height: auto; font-size: 13px;" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
            <?php esc_html_e( 'Watch Now', 'quantum-mentor-world' ); ?>
        </a>
    </div>

</article>
