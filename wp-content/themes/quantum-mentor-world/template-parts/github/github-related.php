<?php
/**
 * Single GitHub Repo — Related Repositories Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id     = $post->ID;
$acf_related = get_field( 'repo_related', $post_id );

$related_ids = array();

if ( ! empty( $acf_related ) ) {
    foreach ( $acf_related as $rel_post ) {
        if ( is_object( $rel_post ) ) {
            $related_ids[] = $rel_post->ID;
        } elseif ( is_numeric( $rel_post ) ) {
            $related_ids[] = $rel_post;
        }
    }
}

// Fallback to taxonomy matches if no custom relationships are selected
if ( count( $related_ids ) < 2 ) {
    $terms = get_the_terms( $post_id, 'repo_category' );
    $term_ids = array();
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        foreach ( $terms as $term ) {
            $term_ids[] = $term->term_id;
        }
    }

    $tax_query = array();
    if ( ! empty( $term_ids ) ) {
        $tax_query = array(
            array(
                'taxonomy' => 'repo_category',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ),
        );
    }

    $query_args = array(
        'post_type'      => 'github_repos',
        'posts_per_page' => 4 - count( $related_ids ),
        'post__not_in'   => array_merge( array( $post_id ), $related_ids ),
        'orderby'        => 'rand',
        'fields'         => 'ids',
    );
    if ( ! empty( $tax_query ) ) {
        $query_args['tax_query'] = $tax_query;
    }

    $fallback_query = new WP_Query( $query_args );
    if ( $fallback_query->have_posts() ) {
        $related_ids = array_merge( $related_ids, $fallback_query->posts );
    }
    wp_reset_postdata();
}

// Fallback to random if still empty
if ( count( $related_ids ) < 2 ) {
    $random_args = array(
        'post_type'      => 'github_repos',
        'posts_per_page' => 4,
        'post__not_in'   => array( $post_id ),
        'orderby'        => 'rand',
        'fields'         => 'ids',
    );
    $random_query = new WP_Query( $random_args );
    if ( $random_query->have_posts() ) {
        $related_ids = $random_query->posts;
    }
    wp_reset_postdata();
}

if ( empty( $related_ids ) ) {
    return;
}

$final_query = new WP_Query( array(
    'post_type'      => 'github_repos',
    'post__in'       => $related_ids,
    'posts_per_page' => 4,
    'orderby'        => 'post__in',
) );

if ( ! $final_query->have_posts() ) {
    wp_reset_postdata();
    return;
}
?>

<!-- ============================================================
     RELATED GITHUB REPOSITORIES
     ============================================================ -->
<section class="watch-related-section" aria-label="<?php esc_attr_e( 'Related GitHub Repositories', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="section-title" style="font-size: 22px; margin: 0;">
            🐙 <?php esc_html_e( 'Related Repositories', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'github_repos' ) ); ?>" class="section-view-all" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
            <?php esc_html_e( 'Browse Repos', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="watch-related-grid" style="display: grid; gap: var(--space-6); grid-template-columns: repeat(1, 1fr);">
        <?php while ( $final_query->have_posts() ) : $final_query->the_post();
            $r_id     = get_the_ID();
            $r_name   = get_field( 'repo_name', $r_id ) ?: get_the_title();
            $r_lang   = get_field( 'repo_language_field', $r_id );
            $r_lic    = get_field( 'repo_license_field', $r_id );
            $r_stars  = get_field( 'repo_stars_count', $r_id );
        ?>
        <article class="glass-card watch-related-card reveal">

            <div class="watch-related-info" style="padding: var(--space-5); display: flex; flex-direction: column; gap: var(--space-3); height: 100%;">
                
                <div style="display:flex; gap:var(--space-2); flex-wrap:wrap; align-items: center; justify-content: space-between;">
                    <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                        <?php if ( ! empty( $r_lang ) ) : ?>
                            <span class="badge badge-primary" style="font-size:8px; padding: 2px 8px;"><?php echo esc_html( $r_lang ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $r_lic ) ) : ?>
                            <span class="badge badge-muted" style="font-size:8px; padding: 2px 8px;"><?php echo esc_html( $r_lic ); ?></span>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $r_stars ) ) : ?>
                        <span style="font-size: 11px; color: var(--warning); font-weight: 700;">★ <?php echo number_format_i18n( $r_stars ); ?></span>
                    <?php endif; ?>
                </div>

                <h3 class="watch-related-title" style="font-size: 15px; font-weight: 700; margin: 0; line-height: 1.4;">
                    <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;"><?php echo esc_html( $r_name ); ?></a>
                </h3>

                <p class="watch-related-excerpt" style="font-size: 12px; color: var(--text-muted); line-height: 1.5; margin: 0; flex: 1;">
                    <?php 
                    $desc = get_field( 'repo_short_description', $r_id );
                    if ( empty( $desc ) ) {
                        $desc = get_the_excerpt();
                    }
                    echo esc_html( wp_trim_words( $desc, 12, '...' ) ); 
                    ?>
                </p>

                <div style="margin-top: auto; padding-top: var(--space-3); border-top: 1px solid var(--border);">
                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px; width:100%; justify-content:center; border-color:var(--primary); color:var(--primary);" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
                        <?php esc_html_e( 'View Details', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
