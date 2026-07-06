<?php
/**
 * Trending Resources Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$trending_args = array(
    'post_type'      => array( 'software', 'books', 'tools', 'watch', 'github_repos' ),
    'posts_per_page' => 6,
    'meta_query'     => array(
        array(
            'key'     => 'admin_priority',
            'value'   => array( 'Trending', 'Popular' ),
            'compare' => 'IN',
        ),
    ),
);


$trending_query = new WP_Query( $trending_args );
?>

<section id="trending-resources" class="py-16" style="border-bottom: 1px solid var(--border);">
    <div class="container container-desktop">
        
        <div style="margin-bottom: var(--space-8);">
            <h2 class="section-title">
                <?php esc_html_e( 'Popular & Trending Resources', 'quantum-mentor-world' ); ?>
            </h2>
            <p class="small-text" style="margin-top: -12px; max-width: 600px;">
                <?php esc_html_e( 'The most active, highly searched, and downloaded legal technical assets on Quantum Mentor World.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <?php if ( $trending_query->have_posts() ) : ?>
            <div class="grid grid-cols-12 grid-cols-mobile-1 grid-cols-tablet-6 grid-desktop-3" style="gap: var(--space-6);">
                <?php 
                while ( $trending_query->have_posts() ) : $trending_query->the_post();
                    get_template_part( 'template-parts/cards/resource-card' );
                endwhile; 
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <!-- Empty state placeholder card -->
            <div class="glass-card" style="align-items: center; justify-content: center; text-align: center; padding: var(--space-12) var(--space-6); max-width: 640px; margin: 0 auto; gap: var(--space-4);">
                <span style="font-size: 40px; filter: grayscale(50%);">🔥</span>
                <h3 class="card-title" style="color: var(--text-main); font-size: 18px;">
                    <?php esc_html_e( 'No resources added yet.', 'quantum-mentor-world' ); ?>
                </h3>
                <p class="small-text" style="max-width: 400px; margin: 0;">
                    <?php esc_html_e( 'Popularity statistics are currently calculating. Try visiting individual directories above.', 'quantum-mentor-world' ); ?>
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
