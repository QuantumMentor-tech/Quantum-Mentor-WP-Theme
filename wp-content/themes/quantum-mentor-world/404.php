<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<div class="py-16" style="padding: var(--space-16) 0; min-height: 60vh; display: flex; align-items: center;">
    <div class="container container-laptop" style="display: flex; justify-content: center;">
        <div class="glass-card p-8" style="text-align: center; max-width: 560px; width: 100%; padding: var(--space-12);">

            <div style="font-size: 80px; margin-bottom: var(--space-4); line-height: 1;">🔍</div>

            <h1 style="
                font-family: var(--font-display);
                font-size: 80px;
                font-weight: 800;
                line-height: 1;
                background: linear-gradient(135deg, var(--primary), var(--secondary));
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: var(--space-4);
            ">404</h1>

            <h2 style="font-family: var(--font-display); font-size: 22px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-4);">
                <?php esc_html_e( 'Page Not Found', 'quantum-mentor-world' ); ?>
            </h2>

            <p class="small-text" style="line-height: 1.7; margin-bottom: var(--space-8); color: var(--text-muted);">
                <?php esc_html_e( 'The resource you are looking for has been moved, removed, or is temporarily offline. Explore other safe technology resources using our navigation.', 'quantum-mentor-world' ); ?>
            </p>

            <!-- Quick links -->
            <div style="display: flex; flex-wrap: wrap; gap: var(--space-3); justify-content: center; margin-bottom: var(--space-6);">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                    <?php esc_html_e( '← Back to Home', 'quantum-mentor-world' ); ?>
                </a>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" class="btn btn-secondary">
                    <?php esc_html_e( 'Browse Software', 'quantum-mentor-world' ); ?>
                </a>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'tools' ) ); ?>" class="btn btn-secondary">
                    <?php esc_html_e( 'Browse Tools', 'quantum-mentor-world' ); ?>
                </a>
            </div>

            <!-- Search box -->
            <div style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
                <p class="small-text" style="margin-bottom: var(--space-3);">
                    <?php esc_html_e( 'Try searching for what you need:', 'quantum-mentor-world' ); ?>
                </p>
                <?php get_search_form(); ?>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); ?>
