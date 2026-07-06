<?php
/**
 * Watch Archive Template
 *
 * URL: /watch/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Detect active filters
$has_filters = (
    ! empty( $_GET['type'] )     ||
    ! empty( $_GET['genre'] )    ||
    ! empty( $_GET['language'] ) ||
    ! empty( $_GET['status'] )   ||
    ! empty( $_GET['watch_search'] )
);
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

// 1. Hero Template (Includes the H1: Watch and subtitle)
get_template_part( 'template-parts/watch/watch-hero' );
?>

<div class="watch-archive-wrapper" style="padding: var(--space-8) 0;">
    <div class="container container-laptop">

        <!-- Breadcrumbs (SEO Requirement) -->
        <nav class="breadcrumbs mb-8" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php esc_html_e( 'Watch', 'quantum-mentor-world' ); ?></span>
        </nav>

        <!-- 2. Filter Controls Template -->
        <?php get_template_part( 'template-parts/watch/watch-filters' ); ?>

        <!-- ============================================================
             3. FEATURED WATCH CONTENT (page 1 only, no active filters)
             ============================================================ -->
        <?php
        if ( ! $has_filters && $paged === 1 ) :
            $featured_args = array(
                'post_type'      => 'watch',
                'posts_per_page' => 4, // 3 to 6 items
                'meta_query'     => array(
                    array(
                        'key'     => 'admin_priority',
                        'value'   => 'Featured',
                        'compare' => '=',
                    ),
                ),
                'no_found_rows'  => true,
            );
            $featured_query = new WP_Query( $featured_args );
            if ( $featured_query->have_posts() ) :
        ?>
        <section class="watch-featured-section" aria-label="<?php esc_attr_e( 'Featured Videos', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-12);">
            <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title" style="font-size: 24px; margin: 0;">
                    ✨ <?php esc_html_e( 'Featured Watch Content', 'quantum-mentor-world' ); ?>
                </h2>
                <span class="badge badge-success" style="font-size: 10px; padding: 4px 10px;">
                    <?php esc_html_e( 'FEATURED', 'quantum-mentor-world' ); ?>
                </span>
            </div>

            <div class="watch-grid grid grid-cols-12 gap-6">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                    <div class="col-span-12 md:col-span-6 lg:col-span-3">
                        <?php get_template_part( 'template-parts/cards/watch-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php
            endif; // have_posts
        endif; // !has_filters && page 1
        ?>

        <!-- ============================================================
             4. MAIN WATCH CONTENT GRID (4 columns desktop, 2 tablet, 1 mobile)
             ============================================================ -->
        <section class="watch-directory-section" aria-label="<?php esc_attr_e( 'All Watch Content', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-12);">

            <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title" style="font-size: 24px; margin: 0;">
                    📂 <?php
                    if ( $has_filters ) {
                        esc_html_e( 'Filtered Streams', 'quantum-mentor-world' );
                    } else {
                        esc_html_e( 'Watch Directory', 'quantum-mentor-world' );
                    }
                    ?>
                </h2>
                <?php if ( have_posts() ) : ?>
                <span class="badge badge-muted" style="font-size: 12px;">
                    <?php echo esc_html( $wp_query->found_posts ); ?> <?php esc_html_e( 'streams', 'quantum-mentor-world' ); ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="watch-grid grid grid-cols-12 gap-6">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-span-12 md:col-span-6 lg:col-span-3">
                            <?php get_template_part( 'template-parts/cards/watch-card' ); ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="watch-pagination-wrap" style="display: flex; justify-content: center; margin-top: var(--space-12);">
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
                <!-- Empty state fallback -->
                <div class="watch-empty-state glass-card" style="padding: var(--space-12); text-align: center; max-width: 600px; margin: 0 auto; border: 1px solid var(--border);">
                    <div class="watch-empty-icon" aria-hidden="true" style="font-size: 48px; margin-bottom: var(--space-4);">🎬</div>
                    <h3 class="card-title" style="margin-bottom: var(--space-3); font-size: 20px;">
                        <?php esc_html_e( 'No Streams Found', 'quantum-mentor-world' ); ?>
                    </h3>
                    <p class="small-text" style="margin-bottom: var(--space-6); color: var(--text-muted); line-height: 1.5;">
                        <?php esc_html_e( 'No video streams match your search or filter selections. Please clear filters or try a different query.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'watch' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Reset Catalog', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </section>

        <!-- ============================================================
             5. SEO INTRO CONTENT BLOCK
             ============================================================ -->
        <section class="watch-seo-intro glass-card" aria-label="<?php esc_attr_e( 'About the Watch Platform', 'quantum-mentor-world' ); ?>" style="padding: var(--space-8); border: 1px solid var(--border); border-radius: var(--radius-md); margin-bottom: var(--space-12);">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-4);">
                <?php esc_html_e( 'Safe & Legal Embedded Watch Platform', 'quantum-mentor-world' ); ?>
            </h2>
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 lg:col-span-6">
                    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: var(--space-4);">
                        <?php esc_html_e( 'Welcome to the Quantum Mentor World Watch Platform. We provide a professionally curated index of legal educational content, development tutorials, historical documentaries, and creator-approved animations. Our platform is designed to provide quick, structured learning streams directly from authorized public hosts.', 'quantum-mentor-world' ); ?>
                    </p>
                    <p style="color: var(--text-muted); line-height: 1.6;">
                        <?php esc_html_e( 'Every video stream in our index undergoes verification to ensure compliance with our safe-embedding standard. We only embed videos hosted on official developer channels, public-access networks, and trusted video networks (like YouTube, Vimeo, Dailymotion, Facebook Video, and the Internet Archive). We do not host any media files on our own servers.', 'quantum-mentor-world' ); ?>
                    </p>
                </div>
                <div class="col-span-12 lg:col-span-6">
                    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: var(--space-4);">
                        <?php esc_html_e( 'We strictly enforce a legal-only streaming directive. We do not host or embed pirated movies, commercial television programs, unauthorized anime/donghua streams, premium paid courses, or any content violating copyright laws. By linking to original publishers, we help you stream safely while respecting creators.', 'quantum-mentor-world' ); ?>
                    </p>
                    <!-- Internal SEO links by Content Type -->
                    <nav class="watch-seo-links" aria-label="<?php esc_attr_e( 'Browse by Content Type', 'quantum-mentor-world' ); ?>" style="margin-top: var(--space-4);">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: var(--space-2);">
                            <?php esc_html_e( 'Filter by Media Type:', 'quantum-mentor-world' ); ?>
                        </span>
                        <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                            <?php
                            $seo_types = array(
                                'course'      => 'Courses',
                                'tutorial'    => 'Tutorials',
                                'documentary' => 'Documentaries',
                                'movie'       => 'Movies',
                                'anime'       => 'Anime',
                                'donghua'     => 'Donghua',
                            );
                            $watch_archive = get_post_type_archive_link( 'watch' );
                            foreach ( $seo_types as $slug => $label ) :
                            ?>
                            <a href="<?php echo esc_url( add_query_arg( 'type', $slug, $watch_archive ) ); ?>" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 500;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
                                <?php echo esc_html( $label ); ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                    </nav>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- ============================================================
     6. FAQ SECTION (full-width outside container)
     ============================================================ -->
<?php get_template_part( 'template-parts/watch/watch-faq' ); ?>

<?php
get_footer();
