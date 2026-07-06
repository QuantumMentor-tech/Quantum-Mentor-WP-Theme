<?php
/**
 * Book Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();
$author      = get_field( 'book_author_field', $post_id );
$book_type   = get_field( 'book_type', $post_id );
$formats     = get_field( 'book_format', $post_id );
$is_verified = get_field( 'verified_resource', $post_id );

if ( $is_verified === null ) {
    $is_verified = get_field( 'admin_verified', $post_id );
    if ( $is_verified === null ) {
        $is_verified = true;
    }
}
?>

<article class="glass-card book-card transition-all" style="height: 100%; display: flex; flex-direction: column;">
    
    <!-- Verified Badge -->
    <?php if ( $is_verified ) : ?>
        <div class="book-card-badge-wrap">
            <span class="badge badge-success" style="font-size: 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Cover Image Wrapper (3:4 aspect ratio) -->
    <div class="book-cover-wrapper" style="aspect-ratio: 3 / 4; border-radius: var(--radius-sm); background-color: var(--bg-primary); overflow: hidden; margin-bottom: var(--space-4); border: 1px solid var(--border); position: relative;">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
        <?php else : ?>
            <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 36px; filter: grayscale(50%); background-color: rgba(255,255,255,0.01);">
                <span>📖</span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Category / Type badge -->
    <div class="book-card-badges-row" style="margin-bottom: var(--space-2); display: flex; gap: var(--space-1); flex-wrap: wrap;">
        <?php if ( ! empty( $book_type ) ) : ?>
            <span class="badge badge-warning" style="font-size: 9px;"><?php echo esc_html( $book_type ); ?></span>
        <?php else : ?>
            <span class="badge badge-muted" style="font-size: 9px;"><?php esc_html_e( 'E-Book', 'quantum-mentor-world' ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $formats ) && is_array( $formats ) ) : ?>
            <span class="badge badge-muted" style="font-size: 9px;"><?php echo esc_html( $formats[0] ); ?></span>
        <?php endif; ?>
    </div>

    <!-- Book Title -->
    <h3 class="book-card-title" style="margin-bottom: var(--space-1); font-size: 16px; line-height: 1.3;">
        <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
            <?php the_title(); ?>
        </a>
    </h3>

    <!-- Author details -->
    <?php if ( ! empty( $author ) ) : ?>
        <p class="book-card-author" style="font-size: 13px; color: var(--text-muted); margin-bottom: var(--space-4);">
            <?php esc_html_e( 'By', 'quantum-mentor-world' ); ?> <?php echo esc_html( $author ); ?>
        </p>
    <?php else : ?>
        <div style="margin-bottom: var(--space-4);"></div>
    <?php endif; ?>

    <!-- View / Download Permalink -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; border-color: var(--warning); color: var(--warning); padding: 8px 12px; min-height: auto; font-size: 13px;" onmouseover="this.style.backgroundColor='var(--warning)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--warning)';">
            <?php esc_html_e( 'View E-Book', 'quantum-mentor-world' ); ?>
        </a>
    </div>

</article>
