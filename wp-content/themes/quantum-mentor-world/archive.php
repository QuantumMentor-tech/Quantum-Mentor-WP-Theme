<?php
/**
 * The template for displaying archive pages
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<main id="primary" class="main-content-area py-12 px-6 max-w-7xl mx-auto">
    <header class="page-header mb-10">
        <h1 class="page-title text-3xl font-extrabold text-white font-display">
            <?php the_archive_title(); ?>
        </h1>
        <?php the_archive_description( '<div class="archive-description text-xs text-slate-400 mt-2">', '</div>' ); ?>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/cards/card', get_post_type() );
            endwhile;

            the_posts_navigation();
        else :
            ?>
            <div class="glass-card col-span-full p-8 text-center rounded-xl">
                <p class="text-slate-400 text-xs"><?php esc_html_e( 'No resources registered under this archive yet.', 'quantum-mentor-world' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
