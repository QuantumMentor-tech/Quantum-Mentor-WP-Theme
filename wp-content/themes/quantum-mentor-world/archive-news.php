<?php
/**
 * AI & Tech News Archive Template
 *
 * URL: /news/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Detect active filters
$has_filters = (
    ! empty( $_GET['category'] )    ||
    ! empty( $_GET['news_search'] )
);
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

// 1. Hero Template (Includes title, stats, search topics)
get_template_part( 'template-parts/news/news-hero' );
?>

<div class="news-archive-wrapper" style="padding: var(--space-8) 0;">
    <div class="container container-laptop">

        <!-- Breadcrumbs (SEO Requirement) -->
        <nav class="breadcrumbs mb-8" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php esc_html_e( 'News', 'quantum-mentor-world' ); ?></span>
        </nav>

        <!-- 2. Filter Controls Template -->
        <?php get_template_part( 'template-parts/news/news-filters' ); ?>

        <!-- ============================================================
             3. FEATURED NEWS SECTION (page 1 only, no active filters)
             ============================================================ -->
        <?php
        if ( ! $has_filters && $paged === 1 ) :
            $featured_args = array(
                'post_type'      => 'news',
                'posts_per_page' => 3,
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
        <section class="news-featured-section" aria-label="<?php esc_attr_e( 'Featured News', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-12);">
            <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title" style="font-size: 24px; margin: 0;">
                    ✨ <?php esc_html_e( 'Featured Stories', 'quantum-mentor-world' ); ?>
                </h2>
                <span class="badge badge-success" style="font-size: 10px; padding: 4px 10px; background-color: var(--success); color: #ffffff;">
                    <?php esc_html_e( 'SPOTLIGHT', 'quantum-mentor-world' ); ?>
                </span>
            </div>

            <!-- Grid uses 3 columns desktop -->
            <div class="news-grid grid grid-cols-12 gap-6">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                    <div class="col-span-12 md:col-span-6 lg:col-span-4">
                        <?php get_template_part( 'template-parts/cards/news-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php
            endif; // have_posts
        endif; // !has_filters && page 1
        ?>

        <!-- ============================================================
             4. MAIN NEWS GRID (3 columns desktop, 2 tablet, 1 mobile)
             ============================================================ -->
        <section class="news-directory-section" aria-label="<?php esc_attr_e( 'All News', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-12);">

            <div class="section-header mb-6" style="display: flex; justify-content: space-between; align-items: center;">
                <h2 class="section-title" style="font-size: 24px; margin: 0;">
                    📂 <?php
                    if ( $has_filters ) {
                        esc_html_e( 'Filtered Articles', 'quantum-mentor-world' );
                    } else {
                        esc_html_e( 'Latest News', 'quantum-mentor-world' );
                    }
                    ?>
                </h2>
                <?php if ( have_posts() ) : ?>
                <span class="badge badge-muted" style="font-size: 12px;">
                    <?php echo esc_html( $wp_query->found_posts ); ?> <?php esc_html_e( 'stories', 'quantum-mentor-world' ); ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="news-grid grid grid-cols-12 gap-6">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-span-12 md:col-span-6 lg:col-span-4">
                            <?php get_template_part( 'template-parts/cards/news-card' ); ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="news-pagination-wrap" style="display: flex; justify-content: center; margin-top: var(--space-12);">
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
                <div class="news-empty-state glass-card" style="padding: var(--space-12); text-align: center; max-width: 600px; margin: 0 auto; border: 1px solid var(--border);">
                    <div class="news-empty-icon" aria-hidden="true" style="font-size: 48px; margin-bottom: var(--space-4);">📰</div>
                    <h3 class="card-title" style="margin-bottom: var(--space-3); font-size: 20px;">
                        <?php esc_html_e( 'No News Articles Found', 'quantum-mentor-world' ); ?>
                    </h3>
                    <p class="small-text" style="margin-bottom: var(--space-6); color: var(--text-muted); line-height: 1.5;">
                        <?php esc_html_e( 'No articles match your search or category filter. Please reset filters to view all stories.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Reset News Feed', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </section>

        <!-- ============================================================
             5. SEO INTRO SECTION
             ============================================================ -->
        <section class="news-seo-intro glass-card" aria-label="<?php esc_attr_e( 'About Quantum Mentor Tech News', 'quantum-mentor-world' ); ?>" style="padding: var(--space-8); border: 1px solid var(--border); border-radius: var(--radius-md); margin-bottom: var(--space-12);">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-4);">
                <?php esc_html_e( 'Curated Tech & AI News Feed', 'quantum-mentor-world' ); ?>
            </h2>
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 lg:col-span-6">
                    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: var(--space-4);">
                        <?php esc_html_e( 'Welcome to the Quantum Mentor World News Hub. We deliver clean, summarized, and verified news covering Artificial Intelligence releases, developer tools, custom plugins, operating system developments, and open-source updates. Our goal is to filter out the noise and provide clear, high-density reporting.', 'quantum-mentor-world' ); ?>
                    </p>
                    <p style="color: var(--text-muted); line-height: 1.6;">
                        <?php esc_html_e( 'To respect copyright law and maintain original reporting, we do not scrape or reproduce full articles from other publishers. Instead, we provide concise summaries and credit original reporting with outbound links directly to their source platforms.', 'quantum-mentor-world' ); ?>
                    </p>
                </div>
                <div class="col-span-12 lg:col-span-6">
                    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: var(--space-4);">
                        <?php esc_html_e( 'Our platform strictly maps category filters (such as AI, Games, OS, Themes, and Software News) dynamically. You can filter the feed using our category chips above to isolate stories of interest.', 'quantum-mentor-world' ); ?>
                    </p>
                    <!-- Internal SEO links by Category -->
                    <nav class="tools-seo-links" aria-label="<?php esc_attr_e( 'Browse by News Category', 'quantum-mentor-world' ); ?>" style="margin-top: var(--space-4);">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: var(--space-2);">
                            <?php esc_html_e( 'Quick links:', 'quantum-mentor-world' ); ?>
                        </span>
                        <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
                            <?php
                            $seo_categories = array(
                                'ai-news'       => 'AI News',
                                'software-news' => 'Software',
                                'games-news'    => 'Gaming',
                                'os-news'       => 'Operating Systems',
                                'themes-news'   => 'Themes & Plugins',
                                'tools-news'    => 'Tools',
                                'tech-general'  => 'General Tech',
                            );
                            foreach ( $seo_categories as $slug => $label ) :
                            ?>
                            <a href="<?php echo esc_url( add_query_arg( 'category', $slug, $news_archive ) ); ?>" style="color: var(--primary); text-decoration: none; font-size: 13px; font-weight: 500;" onmouseover="this.style.textDecoration='underline';" onmouseout="this.style.textDecoration='none';">
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
<?php get_template_part( 'template-parts/news/news-faq' ); ?>

<?php
get_footer();
