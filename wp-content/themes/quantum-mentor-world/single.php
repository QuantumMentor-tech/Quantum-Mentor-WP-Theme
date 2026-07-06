<?php
/**
 * The template for displaying all single posts
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
            <header class="entry-header border-b border-white/5 pb-6">
                <h1 class="entry-title font-display text-3xl md:text-4xl font-extrabold text-white mb-4"><?php the_title(); ?></h1>
                
                <div class="entry-meta flex items-center space-x-4 text-xs text-slate-400">
                    <span class="posted-by"><?php the_author(); ?></span>
                    <span>•</span>
                    <span class="posted-on"><?php echo get_the_date( 'F j, Y' ); ?></span>
                </div>
            </header>

            <div class="entry-content prose prose-invert text-sm text-slate-300 space-y-4 leading-relaxed">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="post-thumbnail rounded-xl overflow-hidden mb-6 border border-white/5">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto object-cover' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php the_content(); ?>
            </div>
        </article>

        <!-- Comments Area -->
        <div class="comments-container mt-12">
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </div>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
