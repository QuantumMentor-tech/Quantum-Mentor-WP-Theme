<?php
/**
 * Single Tool — Related Tools Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id     = $post->ID;
$tool_cat    = get_field( 'tool_type_field', $post_id );
$access_type = get_field( 'tool_access_type', $post_id );

$meta_query_args = array( 'relation' => 'OR' );
if ( ! empty( $tool_cat ) ) {
    $meta_query_args[] = array(
        'key'     => 'tool_type_field',
        'value'   => $tool_cat,
        'compare' => '=',
    );
}
if ( ! empty( $access_type ) ) {
    $meta_query_args[] = array(
        'key'     => 'tool_access_type',
        'value'   => $access_type,
        'compare' => '=',
    );
}

$related_args = array(
    'post_type'      => 'tools',
    'posts_per_page' => 4,
    'post__not_in'   => array( $post_id ),
    'orderby'        => 'rand',
    'fields'         => 'ids',
);

if ( count( $meta_query_args ) > 1 ) {
    $related_args['meta_query'] = $meta_query_args;
}

$related_query = new WP_Query( $related_args );

// Fallback to random tools if < 2 results match
if ( $related_query->post_count < 2 ) {
    wp_reset_postdata();
    $related_args = array(
        'post_type'      => 'tools',
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
     RELATED TOOLS SECTION
     ============================================================ -->
<section class="watch-related-section" aria-label="<?php esc_attr_e( 'Related Tools', 'quantum-mentor-world' ); ?>">

    <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
        <h2 class="section-title" style="font-size: 22px; margin: 0;">
            ⚙️ <?php esc_html_e( 'Related Tools', 'quantum-mentor-world' ); ?>
        </h2>
        <a href="<?php echo esc_url( get_post_type_archive_link( 'tools' ) ); ?>" class="section-view-all" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 600;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
            <?php esc_html_e( 'Browse Directory', 'quantum-mentor-world' ); ?> →
        </a>
    </div>

    <div class="watch-related-grid" style="display: grid; gap: var(--space-6); grid-template-columns: repeat(1, 1fr);">
        <?php while ( $related_query->have_posts() ) : $related_query->the_post();
            $r_id     = get_the_ID();
            $r_name   = get_field( 'tool_name', $r_id ) ?: get_the_title();
            $r_cat    = get_field( 'tool_type_field', $r_id );
            $r_access = get_field( 'tool_access_type', $r_id );
        ?>
        <article class="glass-card watch-related-card reveal">

            <!-- Title & Badges -->
            <div class="watch-related-info" style="padding: var(--space-5); display: flex; flex-direction: column; gap: var(--space-3); height: 100%;">
                
                <div style="display:flex; gap:var(--space-2); flex-wrap:wrap;">
                    <?php if ( ! empty( $r_cat ) ) : ?>
                        <span class="badge badge-primary" style="font-size:9px; padding: 2px 8px;"><?php echo esc_html( $r_cat ); ?></span>
                    <?php endif; ?>
                    <?php if ( ! empty( $r_access ) ) : ?>
                        <span class="badge badge-muted" style="font-size:9px; padding: 2px 8px;"><?php echo esc_html( $r_access ); ?></span>
                    <?php endif; ?>
                </div>

                <h3 class="watch-related-title" style="font-size: 15px; font-weight: 700; margin: 0; line-height: 1.4;">
                    <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;"><?php echo esc_html( $r_name ); ?></a>
                </h3>

                <p class="watch-related-excerpt" style="font-size: 12px; color: var(--text-muted); line-height: 1.5; margin: 0; flex: 1;">
                    <?php 
                    $desc = get_field( 'tool_description', $r_id );
                    if ( empty( $desc ) ) {
                        $desc = get_the_excerpt();
                    }
                    echo esc_html( wp_trim_words( $desc, 12, '...' ) ); 
                    ?>
                </p>

                <div style="margin-top: auto; padding-top: var(--space-3); border-top: 1px solid var(--border);">
                    <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="font-size:12px; padding:6px 14px; width:100%; justify-content:center; border-color:var(--primary); color:var(--primary);" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
                        <?php esc_html_e( 'Open Tool', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            </div>

        </article>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>

</section>
