<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 max-w-7xl mx-auto">
    <div class="content-header mb-8">
        <h1 class="text-3xl md:text-4xl font-bold text-slate-100 font-display">
            <?php
            if ( is_archive() ) {
                the_archive_title();
            } elseif ( is_search() ) {
                printf( esc_html__( 'Search Results for: %s', 'quantum-mentor' ), '<span>' . get_search_query() . '</span>' );
            } else {
                esc_html_e( 'Latest Resources', 'quantum-mentor' );
            }
            ?>
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                // Determine template part to load based on post type
                $post_type = get_post_type();
                if ( in_array( $post_type, array( 'software', 'tools', 'github_repos', 'watch' ) ) ) {
                    get_template_part( 'template-parts/card', $post_type );
                } else {
                    get_template_part( 'template-parts/card', 'default' );
                }
            endwhile;

            the_posts_navigation( array(
                'prev_text' => esc_html__( 'Newer resources', 'quantum-mentor' ),
                'next_text' => esc_html__( 'Older resources', 'quantum-mentor' ),
            ) );

        else :
            ?>
            <div class="glass-card col-span-full p-8 text-center rounded-xl border border-white/10 bg-slate-800/40 backdrop-blur-md">
                <p class="text-slate-400"><?php esc_html_e( 'No resources found matching your criteria.', 'quantum-mentor' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
