<?php
/**
 * Single Book — Related Books Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id   = $post->ID;
$book_cats = get_the_terms( $post_id, 'book_category' );
$book_type = get_field( 'book_type', $post_id );

$related_tax_query = array( 'relation' => 'OR' );
if ( ! empty( $book_cats ) && ! is_wp_error( $book_cats ) ) {
    $cat_ids = wp_list_pluck( $book_cats, 'term_id' );
    $related_tax_query[] = array(
        'taxonomy' => 'book_category',
        'field'    => 'term_id',
        'terms'    => $cat_ids,
        'operator' => 'IN',
    );
}

$related_args = array(
    'post_type'      => 'books',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'rand',
    'fields'         => 'ids',
);

if ( count( $related_tax_query ) > 1 ) {
    $related_args['tax_query'] = $related_tax_query;
}

$related_query = new WP_Query( $related_args );

// Fallback to random books if not enough matching category items found
if ( $related_query->post_count < 2 ) {
    wp_reset_postdata();
    $related_args = array(
        'post_type'      => 'books',
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
     RELATED BOOKS SECTION
     ============================================================ -->
<section class="book-related-section" aria-label="<?php esc_attr_e( 'Related Books', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6">
        <h2 class="section-title" style="font-size: 24px;">
            📚 <?php esc_html_e( 'Related Books & Guides', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'books' ) ); ?>" class="section-view-all">
            <?php esc_html_e( 'View All Books', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="book-related-grid">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $r_id      = get_the_ID();
            $r_author  = get_field( 'book_author_field', $r_id );
            $r_type    = get_field( 'book_type', $r_id );
            $r_formats = get_field( 'book_format', $r_id );
        ?>
        <article class="glass-card book-related-card reveal">

            <!-- Cover image (3:4 aspect ratio) -->
            <a href="<?php the_permalink(); ?>" class="book-related-img-wrap" aria-label="<?php echo esc_attr( get_the_title() ); ?>" tabindex="-1">
                <?php if ( has_post_thumbnail() ) : ?>
                    <?php the_post_thumbnail( 'medium_large', array(
                        'loading' => 'lazy',
                        'alt'     => esc_attr( get_the_title() ),
                        'style'   => 'width:100%; height:100%; object-fit:cover;',
                    ) ); ?>
                <?php else : ?>
                    <div class="book-related-img-placeholder" aria-hidden="true">📚</div>
                <?php endif; ?>
            </a>

            <!-- Info -->
            <div class="book-related-info">
                <!-- Badges -->
                <div style="display:flex; gap:var(--space-2); flex-wrap:wrap; margin-bottom:var(--space-2);">
                    <?php if ( ! empty( $r_type ) ) : ?>
                        <span class="badge badge-warning" style="font-size:9px;"><?php echo esc_html( $r_type ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $r_formats ) && is_array( $r_formats ) ) : ?>
                        <span class="badge badge-muted" style="font-size:9px;"><?php echo esc_html( $r_formats[0] ); ?></span>
                    <?php endif; ?>
                </div>

                <h3 class="book-related-title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </h3>

                <?php if ( ! empty( $r_author ) ) : ?>
                    <p class="small-text" style="color: var(--text-muted); font-size: 11px; margin-bottom: var(--space-2);">
                        <?php esc_html_e( 'By', 'quantum-mentor-world' ); ?> <?php echo esc_html( $r_author ); ?>
                    </p>
                <?php endif; ?>

                <p class="book-related-excerpt">
                    <?php echo esc_html( wp_trim_words( get_the_excerpt(), 10, '...' ) ); ?>
                </p>

                <div style="margin-top: auto; padding-top: var(--space-3);">
                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px; width:100%; justify-content:center; border-color:var(--warning); color:var(--warning);" onmouseover="this.style.backgroundColor='var(--warning)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--warning)';">
                        <?php esc_html_e( 'Read Details', 'quantum-mentor-world' ); ?> →
                    </a>
                </div>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
