<?php
/**
 * Single Watch — Related Content Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id    = $post->ID;
$watch_type = get_field( 'watch_type', $post_id );
$genre      = get_field( 'watch_genre_field', $post_id );
$language   = get_field( 'watch_language_field', $post_id );
$status     = get_field( 'watch_status_field', $post_id );

$meta_query_args = array( 'relation' => 'OR' );
if ( ! empty( $watch_type ) ) {
    $meta_query_args[] = array(
        'key'     => 'watch_type',
        'value'   => $watch_type,
        'compare' => '=',
    );
}
if ( ! empty( $genre ) ) {
    $meta_query_args[] = array(
        'key'     => 'watch_genre_field',
        'value'   => $genre,
        'compare' => '=',
    );
}
if ( ! empty( $language ) ) {
    $meta_query_args[] = array(
        'key'     => 'watch_language_field',
        'value'   => $language,
        'compare' => '=',
    );
}
if ( ! empty( $status ) ) {
    $meta_query_args[] = array(
        'key'     => 'watch_status_field',
        'value'   => $status,
        'compare' => '=',
    );
}

$related_args = array(
    'post_type'      => 'watch',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'rand',
    'fields'         => 'ids',
);

if ( count( $meta_query_args ) > 1 ) {
    $related_args['meta_query'] = $meta_query_args;
}

$related_query = new WP_Query( $related_args );

// Fallback to random watch items if < 2 results match
if ( $related_query->post_count < 2 ) {
    wp_reset_postdata();
    $related_args = array(
        'post_type'      => 'watch',
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
     RELATED WATCH SECTION
     ============================================================ -->
<section class="watch-related-section" aria-label="<?php esc_attr_e( 'Related Videos', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6">
        <h2 class="section-title" style="font-size: 24px;">
            🎬 <?php esc_html_e( 'Related Content', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'watch' ) ); ?>" class="section-view-all">
            <?php esc_html_e( 'View All Watch', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="watch-related-grid">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $r_id      = get_the_ID();
            $r_type    = get_field( 'watch_type', $r_id );
            $r_genre   = get_field( 'watch_genre_field', $r_id );
            $r_lang    = get_field( 'watch_language_field', $r_id );
            $r_status  = get_field( 'watch_status_field', $r_id );
        ?>
        <article class="glass-card watch-related-card reveal">

            <!-- Poster image (2:3 aspect ratio) -->
            <a href="<?php the_permalink(); ?>" class="watch-related-img-wrap" aria-label="<?php echo esc_attr( get_the_title() ); ?>" tabindex="-1">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'medium_large', array(
                        'loading' => 'lazy',
                        'alt'     => esc_attr( get_the_title() ),
                        'style'   => 'width:100%; height:100%; object-fit:cover;',
                    ) ); ?>
                <?php else : ?>
                    <div class="watch-related-img-placeholder" aria-hidden="true">🎬</div>
                <?php endif; ?>
                
                <div class="watch-related-overlay" aria-hidden="true">
                    <span class="watch-related-play-icon">▶</span>
                </div>
            </a>

            <!-- Info -->
            <div class="watch-related-info">
                <!-- Badges -->
                <div style="display:flex; gap:var(--space-2); flex-wrap:wrap; margin-bottom:var(--space-2);">
                    <?php if ( ! empty( $r_type ) ) : ?>
                        <span class="badge badge-primary" style="font-size:9px;"><?php echo esc_html( $r_type ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $r_status ) ) : ?>
                        <span class="badge badge-secondary" style="font-size:9px;"><?php echo esc_html( $r_status ); ?></span>
                    <?php endif; ?>
                </div>

                <h3 class="watch-related-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <p class="watch-related-excerpt">
                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 10, '...' ) ); ?>
                </p>

                <div style="margin-top: auto; padding-top: var(--space-3);">
                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px; width:100%; justify-content:center; border-color:var(--primary); color:var(--primary);" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
                        <?php esc_html_e( 'Watch Now', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
