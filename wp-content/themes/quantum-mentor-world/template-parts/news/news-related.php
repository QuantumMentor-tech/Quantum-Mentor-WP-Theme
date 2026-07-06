<?php
/**
 * Single News — Related News Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id  = $post->ID;
$news_cat = get_field( 'news_category_field', $post_id );

$related_args = array(
    'post_type'      => 'news',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'rand',
);

if ( ! empty( $news_cat ) ) {
    $related_args['meta_query'] = array(
        array(
            'key'     => 'news_category_field',
            'value'   => $news_cat,
            'compare' => '=',
        ),
    );
}

$related_query = new WP_Query( $related_args );

// Fallback to general news posts if < 2 results match
if ( $related_query->post_count < 2 ) {
    wp_reset_postdata();
    $related_args = array(
        'post_type'      => 'news',
        'posts_per_page' => 4,
        'post__not_in'   => array( $post_id ),
        'orderby'        => 'rand',
    );
    $related_query = new WP_Query( $related_args );
}

if ( ! $related_query->have_posts() ) {
    wp_reset_postdata();
    return;
}
?>

<!-- ============================================================
     RELATED NEWS SECTION
     ============================================================ -->
<section class="watch-related-section" aria-label="<?php esc_attr_e( 'Related News', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="section-title" style="font-size: 22px; margin: 0;">
            📰 <?php esc_html_e( 'Related Updates', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>" class="section-view-all" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
            <?php esc_html_e( 'View All News', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="watch-related-grid" style="display: grid; gap: var(--space-6); grid-template-columns: repeat(1, 1fr);">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $r_id      = get_the_ID();
            $r_title   = get_field( 'news_title', $r_id ) ?: get_the_title();
            $r_cat     = get_field( 'news_category_field', $r_id );
            $r_date    = get_field( 'news_date', $r_id ) ?: get_the_date( 'Y-m-d' );
            $formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $r_date ) );
        ?>
        <article class="glass-card watch-related-card reveal">
            <!-- News Image Link if thumbnail exists -->
            <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="watch-related-img-wrap" style="aspect-ratio: 16 / 9; border-bottom: 1px solid var(--border); display: block; overflow: hidden; position: relative;">
                    <?php the_post_thumbnail( 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover; transition: transform var(--transition-speed);', 'class' => 'related-post-thumb' ) ); ?>
                    <div class="watch-related-overlay">
                        <span class="watch-related-play-icon">📖</span>
                    </div>
                </a>
            <?php endif; ?>

            <div class="watch-related-info" style="padding: var(--space-5); display: flex; flex-direction: column; gap: var(--space-2); height: 100%;">
                
                <div style="display:flex; justify-content: space-between; align-items: center; gap:var(--space-2);">
                    <?php if ( ! empty( $r_cat ) ) : ?>
                        <span class="badge badge-primary" style="font-size:8px; padding: 2px 8px;"><?php echo esc_html( $r_cat ); ?></span>
                    <?php endif; ?>
                    <span style="font-size: 10px; color: var(--text-muted);"><?php echo esc_html( $formatted_date ); ?></span>
                </div>

                <h3 class="watch-related-title" style="font-size: 14px; font-weight: 700; margin: 0; line-height: 1.4;">
                    <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;"><?php echo esc_html( $r_title ); ?></a>
                </h3>

                <p class="watch-related-excerpt" style="font-size: 12px; color: var(--text-muted); line-height: 1.5; margin: 0; flex: 1;">
                    <?php 
                    $desc = get_field( 'news_summary', $r_id );
                    if ( empty( $desc ) ) {
                        $desc = get_the_excerpt();
                    }
                    echo esc_html( wp_trim_words( $desc, 12, '...' ) ); 
                    ?>
                </p>

                <div style="margin-top: auto; padding-top: var(--space-3); border-top: 1px solid var(--border);">
                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px; width:100%; justify-content:center; border-color:var(--primary); color:var(--primary);" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
                        <?php esc_html_e( 'Read Article', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
