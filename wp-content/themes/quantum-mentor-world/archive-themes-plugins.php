<?php
/**
 * Themes & Plugins Archive Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

// Determine if filters are active
$has_filters = ! empty( $_GET['category'] ) || ! empty( $_GET['platform'] ) || ! empty( $_GET['type'] ) || ! empty( $_GET['license'] ) || ! empty( $_GET['tp_search'] );

get_template_part( 'template-parts/themes-plugins/tp-hero' );
?>

<div class="tp-archive-wrapper mb-16">
    <div class="container container-laptop">
        
        <!-- Filters Selector Form -->
        <?php get_template_part( 'template-parts/themes-plugins/tp-filters' ); ?>

        <!-- 1. Featured Resources Section (Show on page 1 when no active filters) -->
        <?php 
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( ! $has_filters && $paged == 1 ) :
            $featured_args = array(
                'post_type'      => 'themes_plugins',
                'posts_per_page' => 3,
                'meta_query'     => array(
                    array(
                        'key'     => 'admin_priority',
                        'value'   => 'Featured',
                        'compare' => '=',
                    ),
                ),
            );
            $featured_query = new WP_Query( $featured_args );
            if ( $featured_query->have_posts() ) :
        ?>
            <section class="featured-tp-section mb-12">
                <h2 class="section-title mb-6" style="font-size: 24px;">
                    ✨ <?php esc_html_e( 'Featured Themes & Plugins', 'quantum-mentor-world' ); ?>
                </h2>
                
                <div class="grid grid-cols-mobile-1 grid-tablet-2 grid-desktop-3 gap-6">
                    <?php 
                    while ( $featured_query->have_posts() ) : $featured_query->the_post();
                        echo '<div class="featured-card-wrapper" style="border: 1px solid var(--border-hover); border-radius: var(--radius-card); box-shadow: var(--glow-secondary);">';
                        get_template_part( 'template-parts/cards/themes-plugin-card' );
                        echo '</div>';
                    endwhile; 
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        <?php 
            endif;
        endif; 
        ?>

        <!-- 2. Main Listings Loop Grid -->
        <section class="tp-directory-section mb-12">
            <h2 class="section-title mb-6" style="font-size: 24px;">
                📂 <?php esc_html_e( 'All Platform Resources', 'quantum-mentor-world' ); ?>
            </h2>

            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-mobile-1 grid-tablet-2 grid-desktop-3 gap-6">
                    <?php 
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/cards/themes-plugin-card' );
                    endwhile; 
                    ?>
                </div>

                <!-- Pagination navigation -->
                <div class="pagination-container mt-12" style="display: flex; justify-content: center; margin-top: var(--space-12);">
                    <?php
                    echo get_the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => esc_html__( '« Previous', 'quantum-mentor-world' ),
                        'next_text' => esc_html__( 'Next »', 'quantum-mentor-world' ),
                        'class'     => 'qmw-pagination',
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <!-- Empty State -->
                <div class="no-results-state glass-card p-12 text-center" style="padding: var(--space-12); text-align: center; max-width: 600px; margin: 0 auto;">
                    <div style="font-size: 48px; margin-bottom: var(--space-4);">🔍</div>
                    <h3 class="card-title mb-2"><?php esc_html_e( 'No Resources Found', 'quantum-mentor-world' ); ?></h3>
                    <p class="body-text text-muted mb-6" style="color: var(--text-muted); font-size: 14px;">
                        <?php esc_html_e( 'No themes, plugins, or templates found matching your selections. Try resetting your filters.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'themes_plugins' ) ); ?>" class="btn btn-accent">
                        <?php esc_html_e( 'Reset Directory', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <!-- 3. SEO Intro Text Section -->
        <section class="tp-seo-intro-block glass-card p-8 mb-12" style="background: rgba(30, 41, 59, 0.5); border: 1px solid var(--border); font-size: 14px; line-height: 1.7; color: var(--text-muted);">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-3);">
                <?php esc_html_e( 'Curated Open Source & GPL Themes & Plugins Directory', 'quantum-mentor-world' ); ?>
            </h2>
            
            <p style="margin-bottom: var(--space-3);">
                <?php esc_html_e( 'Welcome to the Quantum Mentor World themes and plugins resource directory. We host and catalog clean, verified, and GPL-compliant design themes, templates, functional extensions, and helper plugins for popular platforms including WordPress, WooCommerce, Shopify, Hostinger, GoDaddy, and Blogger.', 'quantum-mentor-world' ); ?>
            </p>
            
            <p style="margin-bottom: var(--space-3);">
                <?php esc_html_e( 'Our core mission is to promote legal, safe, and transparent web development practices. Every theme, plugin, or template listing indexed on our platform points to verified official sources, official directories (such as WordPress.org), or direct developer repositories. This completely protects your web projects from security vulnerabilities associated with cracked, unauthorized, or nulled files.', 'quantum-mentor-world' ); ?>
            </p>
            
            <div class="platform-seo-links" style="display: flex; gap: var(--space-4); margin-top: var(--space-4); flex-wrap: wrap; font-weight: 600;">
                <span style="color: var(--text-main);"><?php esc_html_e( 'Explore by Platform:', 'quantum-mentor-world' ); ?></span>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'wordpress', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'WordPress', 'quantum-mentor-world' ); ?></a>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'woocommerce', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'WooCommerce', 'quantum-mentor-world' ); ?></a>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'shopify', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'Shopify', 'quantum-mentor-world' ); ?></a>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'hostinger', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'Hostinger', 'quantum-mentor-world' ); ?></a>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'godaddy', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'GoDaddy', 'quantum-mentor-world' ); ?></a>
                <a href="<?php echo esc_url( add_query_arg( 'platform', 'blogger', get_post_type_archive_link('themes_plugins') ) ); ?>"><?php esc_html_e( 'Blogger', 'quantum-mentor-world' ); ?></a>
            </div>
        </section>

    </div>
</div>

<!-- 4. FAQ Accordion section -->
<?php get_template_part( 'template-parts/themes-plugins/tp-faq' ); ?>

<?php
get_footer();
