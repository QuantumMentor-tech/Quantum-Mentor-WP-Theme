<?php
/**
 * The template for displaying single posts fallback
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-4xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>

        <!-- Breadcrumbs Navigation -->
        <nav class="breadcrumbs mb-6 text-xs text-[#94A3B8] font-medium flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#00D4FF]">Home</a>
            <span>/</span>
            <span class="text-white"><?php the_title(); ?></span>
        </nav>

        <article class="glass-card p-8 md:p-12 space-y-6">
            
            <header class="border-b border-white/5 pb-6">
                <h1 class="font-display text-3xl md:text-4xl font-extrabold text-white mb-4"><?php the_title(); ?></h1>
                
                <div class="flex items-center space-x-4 text-xs text-[#94A3B8]">
                    <span>By <?php the_author(); ?></span>
                    <span>•</span>
                    <span><?php echo get_the_date( 'M d, Y' ); ?></span>
                </div>
            </header>

            <div class="prose prose-invert text-sm text-slate-300 space-y-4 leading-relaxed">
                <?php if ( has_post_thumbnail() ) : ?>
                    <div class="rounded-xl overflow-hidden mb-6">
                        <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-auto' ) ); ?>
                    </div>
                <?php endif; ?>

                <?php the_content(); ?>
            </div>

        </article>

        <!-- Comments Area -->
        <div class="mt-12">
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </div>

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
