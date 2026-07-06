<?php
/**
 * Games Archive Template
 *
 * URL: /games/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Detect active filters
$has_filters = (
    ! empty( $_GET['platform'] )    ||
    ! empty( $_GET['genre'] )       ||
    ! empty( $_GET['license'] )     ||
    ! empty( $_GET['game_search'] )
);
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

// 1. Hero
get_template_part( 'template-parts/games/game-hero' );
?>

<div class="games-archive-wrapper">
    <div class="container container-laptop">

        <!-- 2. Filter Controls -->
        <?php get_template_part( 'template-parts/games/game-filters' ); ?>

        <!-- ============================================================
             3. FEATURED GAMES (page 1 only, no filters active)
             ============================================================ -->
        <?php
        if ( ! $has_filters && $paged === 1 ) :
            $featured_args = array(
                'post_type'      => 'games',
                'posts_per_page' => 6,
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
        <section class="games-featured-section" aria-label="<?php esc_attr_e( 'Featured Games', 'quantum-mentor-world' ); ?>">
            <div class="section-header mb-6">
                <h2 class="section-title" style="font-size: 24px;">
                    ✨ <?php esc_html_e( 'Featured Games', 'quantum-mentor-world' ); ?>
                </h2>
                <span class="featured-strip-badge">
                    <?php esc_html_e( 'FEATURED', 'quantum-mentor-world' ); ?>
                </span>
            </div>

            <div class="games-featured-grid">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                    <div class="game-featured-card-wrapper">
                        <?php get_template_part( 'template-parts/cards/game-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php
            endif; // have_posts
        endif; // !has_filters && page 1
        ?>

        <!-- ============================================================
             4. MAIN GAMES GRID
             ============================================================ -->
        <section class="games-directory-section" aria-label="<?php esc_attr_e( 'All Games', 'quantum-mentor-world' ); ?>">

            <div class="section-header mb-6">
                <h2 class="section-title" style="font-size: 24px;">
                    📂 <?php
                    if ( $has_filters ) {
                        esc_html_e( 'Filtered Results', 'quantum-mentor-world' );
                    } else {
                        esc_html_e( 'All Games', 'quantum-mentor-world' );
                    }
                    ?>
                </h2>
                <?php if ( have_posts() ) : ?>
                <span class="badge badge-muted" style="font-size: 12px;">
                    <?php echo esc_html( $wp_query->found_posts ); ?> <?php esc_html_e( 'games', 'quantum-mentor-world' ); ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="games-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/cards/game-card' ); ?>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="games-pagination-wrap">
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
                <!-- Clean empty state -->
                <div class="games-empty-state glass-card">
                    <div class="games-empty-icon" aria-hidden="true">🎮</div>
                    <h3 class="card-title" style="margin-bottom: var(--space-3);">
                        <?php esc_html_e( 'No Games Found', 'quantum-mentor-world' ); ?>
                    </h3>
                    <p class="small-text" style="margin-bottom: var(--space-6); max-width: 400px; margin-left: auto; margin-right: auto;">
                        <?php esc_html_e( 'No games match your search or filter selections. Please clear filters or try a different combination.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'games' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Reset Directory', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </section>

        <!-- ============================================================
             5. SEO INTRO CONTENT BLOCK
             ============================================================ -->
        <section class="games-seo-intro glass-card" aria-label="<?php esc_attr_e( 'About the Games Directory', 'quantum-mentor-world' ); ?>">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-4);">
                <?php esc_html_e( 'Verified Legal Games Directory', 'quantum-mentor-world' ); ?>
            </h2>
            <div style="display: grid; gap: var(--space-6);" class="games-seo-grid">
                <div>
                    <p>
                        <?php esc_html_e( 'Welcome to the Quantum Mentor World Games Directory — a curated, safe, and continuously updated index of legal, free, open-source, educational, and officially licensed games across multiple platforms. Whether you\'re looking for Windows PC games, Android mobile games, browser-based games, open-source indie titles, or educational games, you\'ll find verified resources here.', 'quantum-mentor-world' ); ?>
                    </p>
                    <p style="margin-top: var(--space-4);">
                        <?php esc_html_e( 'Every game listing on Quantum Mentor World is reviewed and verified. We only list freeware, open-source (GPL, MIT, etc.), official demo versions, freemium titles with official sources, public domain games, and paid games with official store links. All download buttons route directly to the developer\'s official website, GitHub repository, or trusted distribution platform.', 'quantum-mentor-world' ); ?>
                    </p>
                </div>
                <div>
                    <p>
                        <?php esc_html_e( 'Quantum Mentor World strictly enforces a zero-piracy policy. We do not support, host, link to, or promote cracked games, illegal license keys, activators, repacks, bypasses, trainer cheats, hacks, or unauthorized game files of any kind. Every resource listed must pass our legal and safety review before publication.', 'quantum-mentor-world' ); ?>
                    </p>
                    <!-- Internal SEO links by platform -->
                    <nav class="games-seo-links platform-seo-links" aria-label="<?php esc_attr_e( 'Browse by Platform', 'quantum-mentor-world' ); ?>" style="margin-top: var(--space-4);">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: var(--space-2);">
                            <?php esc_html_e( 'Browse by Platform:', 'quantum-mentor-world' ); ?>
                        </span>
                        <?php
                        $seo_platforms = array( 'windows', 'mac', 'linux', 'android', 'iphone', 'browser' );
                        $archive_url   = get_post_type_archive_link( 'games' );
                        foreach ( $seo_platforms as $p ) :
                        ?>
                        <a href="<?php echo esc_url( add_query_arg( 'platform', $p, $archive_url ) ); ?>" rel="nofollow">
                            <?php echo esc_html( ucfirst( $p ) ); ?> <?php esc_html_e( 'Games', 'quantum-mentor-world' ); ?>
                        </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- ============================================================
     6. FAQ SECTION (full-width outside container)
     ============================================================ -->
<?php get_template_part( 'template-parts/games/game-faq' ); ?>

<?php
get_footer();
