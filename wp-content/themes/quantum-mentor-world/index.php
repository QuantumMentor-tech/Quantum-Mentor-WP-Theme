<?php
/**
 * The main template file
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<main id="primary" class="main-content-area py-12 px-6 max-w-7xl mx-auto">
    <header class="page-header mb-8">
        <h1 class="page-title text-3xl font-extrabold text-white font-display">
            <?php esc_html_e( 'Latest Resources', 'quantum-mentor-world' ); ?>
        </h1>
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
            get_template_part( 'template-parts/cards/card', 'none' );
        endif;
        ?>
    </div>
</main>

<?php
get_footer();
