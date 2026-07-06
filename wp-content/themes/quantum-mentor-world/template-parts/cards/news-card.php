<?php
/**
 * News Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id      = get_the_ID();
$news_title   = get_field( 'news_title', $post_id ) ?: get_the_title();
$news_cat     = get_field( 'news_category_field', $post_id );
$news_summary = get_field( 'news_summary', $post_id ) ?: get_the_excerpt();
$news_date    = get_field( 'news_date', $post_id ) ?: get_the_date( 'Y-m-d' );
$news_author  = get_field( 'news_author_name', $post_id ) ?: get_the_author();

$display_date = date_i18n( get_option( 'date_format' ), strtotime( $news_date ) );

if ( empty( $news_cat ) ) {
    $terms = get_the_terms( $post_id, 'news_category' );
    $news_cat = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'General News', 'quantum-mentor-world' );
}
?>

<article class="glass-card card-news transition-all" style="height: 100%; display: flex; flex-direction: column; position: relative;">
    
    <!-- Thumbnail aspect ratio 16:9 -->
    <div class="news-thumbnail" style="aspect-ratio: 16 / 9; overflow: hidden; position: relative; border-bottom: 1px solid var(--border); background-color: var(--bg-primary);">
        <!-- Category Badge -->
        <div class="card-badge" style="position: absolute; top: var(--space-4); left: var(--space-4); z-index: 10;">
            <span class="badge badge-primary" style="font-size: 8px; font-weight: 700; background-color: rgba(0, 212, 255, 0.1); backdrop-filter: blur(8px); border-color: rgba(0, 212, 255, 0.25);">
                <?php echo esc_html( $news_cat ); ?>
            </span>
        </div>

        <a href="<?php the_permalink(); ?>" style="display: block; width: 100%; height: 100%;">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform var(--transition-speed);', 'loading' => 'lazy', 'class' => 'related-post-thumb' ) ); ?>
            <?php else : ?>
                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 32px; background-color: rgba(255, 255, 255, 0.01);">
                    📰
                </div>
            <?php endif; ?>
        </a>
    </div>

    <!-- Content Area -->
    <div class="news-content" style="display: flex; flex-direction: column; flex: 1; padding: var(--space-6);">
        <!-- Meta Row (Date & Author) -->
        <div class="news-meta" style="margin-bottom: var(--space-3); font-size: 11px; color: var(--text-muted); display: flex; gap: var(--space-3); align-items: center;">
            <time datetime="<?php echo esc_attr( get_the_date('c') ); ?>">
                📅 <?php echo esc_html( $display_date ); ?>
            </time>
            <span>•</span>
            <span style="font-weight: 600;">
                ✍️ <?php echo esc_html( $news_author ); ?>
            </span>
        </div>

        <!-- News Title -->
        <h3 class="card-title" style="margin-bottom: var(--space-3); font-size: 17px; font-weight: 700; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8em;">
            <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;" onmouseover="this.style.color='var(--primary)';" onmouseout="this.style.color='var(--text-main)';">
                <?php echo esc_html( $news_title ); ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="small-text" style="font-size: 13px; line-height: 1.6; color: var(--text-muted); margin-bottom: var(--space-6); flex: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
            <?php echo esc_html( wp_trim_words( $news_summary, 18, '...' ) ); ?>
        </p>

        <!-- Read More Button -->
        <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
            <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; padding: 8px 12px; min-height: auto; font-size: 13px;" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
                <?php esc_html_e( 'Read Full Article', 'quantum-mentor-world' ); ?>
            </a>
        </div>
    </div>

</article>
