<?php
/**
 * The template for displaying all static pages
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<main id="primary" class="main-content-area py-12 px-6 max-w-4xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card p-8 md:p-12 space-y-6' ); ?>>
            <header class="entry-header border-b border-white/5 pb-4">
                <h1 class="entry-title font-display text-2xl md:text-3xl font-extrabold text-white"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content prose prose-invert text-sm text-slate-300 space-y-4 leading-relaxed">
                <?php the_content(); ?>
            </div>
        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
