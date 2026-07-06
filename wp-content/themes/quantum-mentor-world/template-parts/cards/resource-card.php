<?php
/**
 * General Resource Card Component
 * Used for general search, featured resources, and trending grids
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();
$post_type = get_post_type();

// Map Post type to corresponding category taxonomies
$taxonomy_map = array(
    'software'       => 'software_category',
    'themes_plugins' => 'theme_plugin_category',
    'games'          => 'game_category',
    'books'          => 'book_category',
    'watch'          => 'watch_category',
    'tools'          => 'tool_category',
    'news'           => 'news_category',
    'github_repos'   => 'repo_category',
);

$taxonomy = isset( $taxonomy_map[$post_type] ) ? $taxonomy_map[$post_type] : 'category';
$terms = get_the_terms( $post_id, $taxonomy );
$term_label = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : ucfirst( str_replace( array('_', '-'), ' ', $post_type ) );

// Fetch ACF safety verified toggle state
$is_verified = get_field( 'admin_verified', $post_id );
if ( $is_verified === null ) {
    $is_verified = true; // Default to true if not set
}
?>

<article class="glass-card transition-all" style="height: 100%; display: flex; flex-direction: column;">
    
    <!-- Verified Badge Indicator -->
    <?php if ( $is_verified ) : ?>
        <div class="card-badge">
            <span class="badge badge-success" style="font-size: 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Card image wrapper -->
    <div style="aspect-ratio: 16 / 9; border-radius: var(--radius-sm); background-color: var(--bg-primary); overflow: hidden; margin-bottom: var(--space-4); border: 1px solid var(--border); position: relative;">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
        <?php else : ?>
            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 32px; filter: grayscale(50%); background-color: rgba(255,255,255,0.01);">
                ⚙
            </div>
        <?php endif; ?>
    </div>

    <!-- Category Label -->
    <div style="margin-bottom: var(--space-2);">
        <span class="badge badge-primary" style="font-size: 9px;"><?php echo esc_html( $term_label ); ?></span>
    </div>

    <!-- Title -->
    <h3 class="card-title" style="margin-bottom: var(--space-2); font-size: 18px;">
        <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;">
            <?php the_title(); ?>
        </a>
    </h3>

    <!-- Description / Excerpt -->
    <p class="small-text line-clamp-2" style="font-size: 13px; line-height: 1.5; color: var(--text-muted); margin-bottom: var(--space-6); flex: 1;">
        <?php 
        $excerpt = get_the_excerpt();
        if ( empty( $excerpt ) ) {
            $excerpt = wp_strip_all_tags( get_the_content() );
        }
        echo esc_html( wp_trim_words( $excerpt, 15, '...' ) ); 
        ?>
    </p>

    <!-- View permalink button -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; padding: 8px 12px; min-height: auto; font-size: 13px;">
            <?php esc_html_e( 'View Specifications', 'quantum-mentor-world' ); ?>
        </a>
    </div>

</article>
