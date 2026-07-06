<?php
/**
 * Featured Resources Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Query Featured Resources
$featured_args = array(
    'post_type'      => array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' ),
    'posts_per_page' => 4,
    'meta_query'     => array(
        array(
            'key'     => 'admin_priority',
            'value'   => 'Featured',
            'compare' => '=',
        ),
    ),
);

$featured_query = new WP_Query( $featured_args );
?>

<section id="featured-resources" class="py-16" style="border-bottom: 1px solid var(--border); background-color: rgba(30, 41, 59, 0.2);">
    <div class="container container-desktop">
        
        <div style="margin-bottom: var(--space-8); display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: var(--space-4);">
            <div>
                <h2 class="section-title" style="margin-bottom: 0;">
                    <?php esc_html_e( 'Featured Resources', 'quantum-mentor-world' ); ?>
                </h2>
                <p class="small-text" style="margin-top: var(--space-2); max-width: 600px;">
                    <?php esc_html_e( 'Handpicked tech releases, tutorials, and ebooks that represent the best legal utilities available.', 'quantum-mentor-world' ); ?>
                </p>
            </div>
        </div>

        <?php if ( $featured_query->have_posts() ) : ?>
            <div class="grid grid-cols-12 grid-cols-mobile-1 grid-cols-tablet-6 grid-desktop-4" style="gap: var(--space-6);">
                <?php 
                while ( $featured_query->have_posts() ) : $featured_query->the_post();
                    get_template_part( 'template-parts/cards/resource-card' );
                endwhile; 
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <!-- Empty state placeholder card -->
            <div class="glass-card" style="align-items: center; justify-content: center; text-align: center; padding: var(--space-16) var(--space-8); max-width: 640px; margin: 0 auto; gap: var(--space-4);">
                <span style="font-size: 48px; filter: grayscale(50%);">✨</span>
                <h3 class="card-title" style="color: var(--text-main); font-size: 20px;">
                    <?php esc_html_e( 'No resources added yet.', 'quantum-mentor-world' ); ?>
                </h3>
                <p class="small-text" style="max-width: 400px; margin: 0;">
                    <?php esc_html_e( 'We are currently curating open-source libraries and digital assets. Check back soon!', 'quantum-mentor-world' ); ?>
                </p>
                <?php if ( current_user_can( 'manage_options' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>" class="btn btn-secondary" style="margin-top: var(--space-2);">
                        <?php esc_html_e( 'Add Content from Admin', 'quantum-mentor-world' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
