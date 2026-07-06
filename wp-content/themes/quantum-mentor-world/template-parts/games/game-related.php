<?php
/**
 * Single Game — Related Games Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id  = $post->ID;
$platform = get_field( 'game_platform', $post_id );
$genre    = get_field( 'game_genre_field', $post_id );
$license  = get_field( 'game_license', $post_id );

// Build tax_query for game_category based on platform/genre/license taxonomy terms
$related_tax_query = array( 'relation' => 'OR' );
$game_cats = get_the_terms( $post_id, 'game_category' );
if ( ! empty( $game_cats ) && ! is_wp_error( $game_cats ) ) {
    $cat_ids = wp_list_pluck( $game_cats, 'term_id' );
    $related_tax_query[] = array(
        'taxonomy' => 'game_category',
        'field'    => 'term_id',
        'terms'    => $cat_ids,
        'operator' => 'IN',
    );
}

// Meta fallback: same genre via ACF
$meta_query_args = array( 'relation' => 'OR' );
if ( ! empty( $genre ) ) {
    $meta_query_args[] = array(
        'key'     => 'game_genre_field',
        'value'   => $genre,
        'compare' => '=',
    );
}
if ( ! empty( $license ) ) {
    $meta_query_args[] = array(
        'key'     => 'game_license',
        'value'   => $license,
        'compare' => '=',
    );
}

$related_args = array(
    'post_type'      => 'games',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'rand',
    'fields'         => 'ids',
);

if ( count( $related_tax_query ) > 1 ) {
    $related_args['tax_query'] = $related_tax_query;
} elseif ( count( $meta_query_args ) > 1 ) {
    $related_args['meta_query'] = $meta_query_args;
}

$related_query = new WP_Query( $related_args );

// If not enough results, widen to random games in same CPT
if ( $related_query->post_count < 2 ) {
    wp_reset_postdata();
    $related_args = array(
        'post_type'      => 'games',
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
     RELATED GAMES SECTION
     ============================================================ -->
<section class="game-related-section" aria-label="<?php esc_attr_e( 'Related Games', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6">
        <h2 class="section-title" style="font-size: 24px;">
            🎮 <?php esc_html_e( 'Related Games', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'games' ) ); ?>" class="section-view-all">
            <?php esc_html_e( 'View All Games', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="game-related-grid">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $r_id       = get_the_ID();
            $r_platform = get_field( 'game_platform', $r_id );
            $r_genre    = get_field( 'game_genre_field', $r_id );
            $r_license  = get_field( 'game_license', $r_id );
            $r_version  = get_field( 'game_version', $r_id );
        ?>
        <article class="glass-card game-related-card reveal">

            <!-- Cover image -->
            <a href="<?php the_permalink(); ?>" class="game-related-img-wrap" aria-label="<?php echo esc_attr( get_the_title() ); ?>" tabindex="-1">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'qmw-card', array(
                        'loading' => 'lazy',
                        'alt'     => esc_attr( get_the_title() ),
                        'style'   => 'width:100%; height:100%; object-fit:cover;',
                        'class'   => 'screenshot-thumb',
                    ) ); ?>
                <?php else : ?>
                    <div class="game-related-img-placeholder" aria-hidden="true">🎮</div>
                <?php endif; ?>
            </a>

            <!-- Info -->
            <div class="game-related-info">
                <!-- Badges -->
                <div style="display:flex; gap:var(--space-2); flex-wrap:wrap; margin-bottom:var(--space-2);">
                    <?php if ( ! empty( $r_license ) ) : ?>
                        <span class="badge badge-success" style="font-size:9px;"><?php echo esc_html( $r_license ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $r_genre ) ) : ?>
                        <span class="badge badge-secondary" style="font-size:9px;"><?php echo esc_html( $r_genre ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $r_version ) ) : ?>
                        <span class="badge badge-muted" style="font-size:9px;"><?php echo esc_html( $r_version ); ?></span>
                    <?php endif; ?>
                </div>

                <h3 class="game-related-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <p class="game-related-excerpt">
                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 12, '...' ) ); ?>
                </p>

                <!-- Platform badges -->
                <?php if ( ! empty( $r_platform ) && is_array( $r_platform ) ) : ?>
                <div style="display:flex; flex-wrap:wrap; gap:4px; margin-bottom:var(--space-3);">
                    <?php foreach ( array_slice( $r_platform, 0, 3 ) as $p ) : ?>
                        <span class="badge badge-muted" style="font-size:8px;"><?php echo esc_html( $p ); ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px;">
                    <?php esc_html_e( 'View Game', 'quantum-mentor-world' ); ?> →
                </a>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
