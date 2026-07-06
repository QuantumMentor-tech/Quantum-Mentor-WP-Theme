<?php
/**
 * The template for displaying software archives
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    
    <!-- Archive Header -->
    <div class="content-header mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white font-display mb-2">Software Directory</h1>
            <p class="text-xs text-[#94A3B8] max-w-xl">
                Explore our fully certified list of legal, open-source, and freeware software. All links point directly to official creator sites or direct verified repositories.
            </p>
        </div>

        <!-- Filter Tags/Categories Links -->
        <div class="flex flex-wrap gap-2">
            <?php
            $terms = get_terms( array(
                'taxonomy'   => 'software_category',
                'number'     => 5,
                'hide_empty' => true,
            ) );
            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) :
                foreach ( $terms as $term ) :
                ?>
                    <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="px-3 py-1.5 rounded-lg bg-[#1E293B] hover:bg-[#00D4FF]/10 hover:text-[#00D4FF] border border-white/5 text-xs font-semibold transition-colors">
                        <?php echo esc_html( $term->name ); ?>
                    </a>
                <?php
                endforeach;
            endif;
            ?>
        </div>
    </div>

    <!-- Software Grid Loop -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/card', 'software' );
            endwhile;

            // Numeric Pagination
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => sprintf( '← %s', esc_html__( 'Previous', 'quantum-mentor' ) ),
                'next_text' => sprintf( '%s →', esc_html__( 'Next', 'quantum-mentor' ) ),
            ) );

        else :
            ?>
            <div class="glass-card col-span-full p-12 text-center">
                <p class="text-slate-400 text-xs"><?php esc_html_e( 'No software files registered in this archive yet.', 'quantum-mentor' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
