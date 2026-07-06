<?php
/**
 * The template for displaying all pages
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-4xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article class="glass-card p-8 md:p-12 space-y-6">
            <header class="border-b border-white/5 pb-4">
                <h1 class="font-display text-2xl md:text-3xl font-extrabold text-white"><?php the_title(); ?></h1>
            </header>

            <div class="prose prose-invert text-sm text-slate-300 space-y-4 leading-relaxed">
                <?php the_content(); ?>
            </div>
        </article>

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
