<?php
/**
 * Software Archive Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

// Determine if any filters are currently active
$has_filters = ! empty( $_GET['category'] ) || ! empty( $_GET['platform'] ) || ! empty( $_GET['license'] ) || ! empty( $_GET['software_search'] );

get_template_part( 'template-parts/software/software-hero' );
?>

<div class="software-archive-wrapper mb-16">
    <div class="container container-laptop">
        
        <!-- Filter Controls -->
        <?php get_template_part( 'template-parts/software/software-filters' ); ?>

        <!-- 1. Featured Software Section (Only show on page 1 and when no filters are active) -->
        <?php 
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
        if ( ! $has_filters && $paged == 1 ) :
            $featured_args = array(
                'post_type'      => 'software',
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
            <section class="featured-software-section mb-12">
                <h2 class="section-title mb-6" style="font-size: 24px;">
                    ✨ <?php esc_html_e( 'Featured Software', 'quantum-mentor-world' ); ?>
                </h2>
                
                <div class="grid grid-cols-mobile-1 grid-tablet-2 grid-desktop-3 gap-6">
                    <?php 
                    while ( $featured_query->have_posts() ) : $featured_query->the_post();
                        // Render using software card but inject a wrapper class for featured highlight
                        echo '<div class="featured-card-wrapper" style="border: 1px solid var(--border-hover); border-radius: var(--radius-card); box-shadow: var(--glow-primary);">';
                        get_template_part( 'template-parts/cards/software-card' );
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

        <!-- 2. Main Software Directory List Grid -->
        <section class="software-directory-section mb-12">
            <h2 class="section-title mb-6" style="font-size: 24px;">
                📂 <?php esc_html_e( 'All Software Resources', 'quantum-mentor-world' ); ?>
            </h2>

            <?php if ( have_posts() ) : ?>
                <div class="grid grid-cols-mobile-1 grid-tablet-2 grid-desktop-3 gap-6">
                    <?php 
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/cards/software-card' );
                    endwhile; 
                    ?>
                </div>

                <!-- Custom numeric pagination layout -->
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
                <!-- Clean Empty State -->
                <div class="no-results-state glass-card p-12 text-center" style="padding: var(--space-12); text-align: center; max-width: 600px; margin: 0 auto;">
                    <div style="font-size: 48px; margin-bottom: var(--space-4);">🔍</div>
                    <h3 class="card-title mb-2"><?php esc_html_e( 'No Software Found', 'quantum-mentor-world' ); ?></h3>
                    <p class="body-text text-muted mb-6" style="color: var(--text-muted); font-size: 14px;">
                        <?php esc_html_e( 'No resources match your search or filter selections. Please clear filters or try another query.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Reset Directory', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>
        </section>

        <!-- 3. SEO Intro Content Block -->
        <section class="software-seo-intro-block glass-card p-8 mb-12" style="background: rgba(30, 41, 59, 0.5); border: 1px solid var(--border); font-size: 14px; line-height: 1.7; color: var(--text-muted);">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-3);">
                <?php esc_html_e( 'Verified Legal Software Downloads Directory', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="margin-bottom: var(--space-3);">
                <?php esc_html_e( 'Welcome to the Quantum Mentor World software archive. We provide a curated, secure, and continuously updated index of legal software resources across multiple operating systems, including Windows, macOS, Linux, Android, and iOS. All software directories listed on our platform are verified safe, open-source, freeware, or public domain releases.', 'quantum-mentor-world' ); ?>
            </p>
            <p>
                <?php esc_html_e( 'We are dedicated to building a safe technology environment. Quantum Mentor World strictly enforces a zero-piracy policy: we do not support, host, or distribute cracked installers, illegal licensing keys, activators, or unauthorized software links. Every download button routes to the official developer or confirmed releases page to ensure maximum file safety and security for your hardware.', 'quantum-mentor-world' ); ?>
            </p>
        </section>

    </div>
</div>

<!-- 4. FAQ accordions -->
<?php get_template_part( 'template-parts/software/software-faq' ); ?>

<?php
get_footer();
