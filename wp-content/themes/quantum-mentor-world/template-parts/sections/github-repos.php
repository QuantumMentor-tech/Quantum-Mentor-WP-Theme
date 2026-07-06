<?php
/**
 * GitHub Repositories Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$repos_args = array(
    'post_type'      => 'github_repos',
    'posts_per_page' => 6,
);

$repos_query = new WP_Query( $repos_args );
?>

<section id="latest-repos" class="py-16" style="border-bottom: 1px solid var(--border);">
    <div class="container container-desktop">
        
        <div style="margin-bottom: var(--space-8); display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: var(--space-4);">
            <div>
                <h2 class="section-title" style="margin-bottom: 0;">
                    <?php esc_html_e( 'GitHub Repositories', 'quantum-mentor-world' ); ?>
                </h2>
                <p class="small-text" style="margin-top: var(--space-2); max-width: 600px;">
                    <?php esc_html_e( 'Browse curated, active open-source repositories, developer scripts, and coding libraries.', 'quantum-mentor-world' ); ?>
                </p>
            </div>
            <a href="<?php echo esc_url( home_url( '/github-repos/' ) ); ?>" class="btn btn-secondary" style="padding: 8px 18px; min-height: auto;">
                <?php esc_html_e( 'View All Repositories', 'quantum-mentor-world' ); ?>
            </a>
        </div>

        <?php if ( $repos_query->have_posts() ) : ?>
            <div class="grid grid-cols-12 grid-cols-mobile-1 grid-cols-tablet-6 grid-desktop-3" style="gap: var(--space-6);">
                <?php 
                while ( $repos_query->have_posts() ) : $repos_query->the_post();
                    get_template_part( 'template-parts/cards/github-card' );
                endwhile; 
                wp_reset_postdata();
                ?>
            </div>
        <?php else : ?>
            <!-- Empty state placeholder card -->
            <div class="glass-card" style="align-items: center; justify-content: center; text-align: center; padding: var(--space-12) var(--space-6); max-width: 640px; margin: 0 auto; gap: var(--space-4);">
                <span style="font-size: 40px; filter: grayscale(50%);">🐙</span>
                <h3 class="card-title" style="color: var(--text-main); font-size: 18px;">
                    <?php esc_html_e( 'No resources added yet.', 'quantum-mentor-world' ); ?>
                </h3>
                <p class="small-text" style="max-width: 400px; margin: 0;">
                    <?php esc_html_e( 'Check back soon for developer-friendly libraries and scripts.', 'quantum-mentor-world' ); ?>
                </p>
                <?php if ( current_user_can( 'manage_options' ) ) : ?>
                    <a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=github_repos' ) ); ?>" class="btn btn-secondary" style="margin-top: var(--space-2);">
                        <?php esc_html_e( 'Add Content from Admin', 'quantum-mentor-world' ); ?>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </div>
</section>
