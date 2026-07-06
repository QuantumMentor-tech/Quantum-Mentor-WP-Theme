<?php
/**
 * The template for displaying search results pages
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<div class="search-results-page" style="padding: var(--space-12) 0;">
    <div class="container container-laptop">

        <!-- Page Header -->
        <header style="margin-bottom: var(--space-8); padding-bottom: var(--space-4); border-bottom: 1px solid var(--border);">
            <h1 class="section-title" style="margin-bottom: var(--space-2);">
                <?php
                printf(
                    /* translators: %s: search query */
                    esc_html__( 'Search Results for: "%s"', 'quantum-mentor-world' ),
                    '<span style="color: var(--primary);">' . esc_html( get_search_query() ) . '</span>'
                );
                ?>
            </h1>
            <?php if ( have_posts() ) : ?>
                <p class="small-text">
                    <?php
                    global $wp_query;
                    printf(
                        esc_html__( 'Found %s result(s) across our verified resource library.', 'quantum-mentor-world' ),
                        '<strong style="color: var(--text-main);">' . number_format_i18n( $wp_query->found_posts ) . '</strong>'
                    );
                    ?>
                </p>
            <?php endif; ?>
        </header>

        <?php if ( have_posts() ) : ?>

            <!-- Results Grid -->
            <div class="card-grid" style="margin-bottom: var(--space-12);">
                <?php
                while ( have_posts() ) :
                    the_post();
                    $post_type = get_post_type();
                    // Map post types to their card templates
                    $card_map = array(
                        'software'       => 'template-parts/cards/software-card',
                        'themes_plugins' => 'template-parts/cards/themes-plugin-card',
                        'books'          => 'template-parts/cards/book-card',
                        'watch'          => 'template-parts/cards/watch-card',
                        'tools'          => 'template-parts/cards/tool-card',
                        'news'           => 'template-parts/cards/news-card',
                        'github_repos'   => 'template-parts/cards/github-card',
                    );
                    if ( isset( $card_map[ $post_type ] ) ) {
                        get_template_part( $card_map[ $post_type ] );
                    } else {
                        get_template_part( 'template-parts/cards/card-default' );
                    }
                endwhile;
                ?>
            </div>

            <!-- Pagination -->
            <div style="display: flex; justify-content: center;">
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

            <!-- No Results State -->
            <div class="glass-card" style="padding: var(--space-12); text-align: center; max-width: 600px; margin: 0 auto;">
                <div style="font-size: 48px; margin-bottom: var(--space-4);">🔍</div>
                <h2 class="card-title" style="margin-bottom: var(--space-4);">
                    <?php esc_html_e( 'No Results Found', 'quantum-mentor-world' ); ?>
                </h2>
                <p class="small-text" style="margin-bottom: var(--space-6); line-height: 1.7;">
                    <?php printf(
                        esc_html__( 'Sorry, nothing matched "%s". Try different keywords or browse our resource categories.', 'quantum-mentor-world' ),
                        '<strong>' . esc_html( get_search_query() ) . '</strong>'
                    ); ?>
                </p>

                <!-- New search -->
                <div style="max-width: 420px; margin: 0 auto var(--space-6);">
                    <?php get_search_form(); ?>
                </div>

                <!-- Helpful Links -->
                <div style="display: flex; flex-wrap: wrap; gap: var(--space-3); justify-content: center;">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Back to Home', 'quantum-mentor-world' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" class="btn btn-secondary">
                        <?php esc_html_e( 'Browse Software', 'quantum-mentor-world' ); ?>
                    </a>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'tools' ) ); ?>" class="btn btn-secondary">
                        <?php esc_html_e( 'Browse Tools', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?php get_footer(); ?>
