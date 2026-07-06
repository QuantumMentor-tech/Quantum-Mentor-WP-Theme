<?php
/**
 * The template for displaying the blog / news index page
 *
 * @package Quantum_Mentor_World
 */

get_header(); ?>

<main id="primary" class="main-content-area py-12 px-6 max-w-5xl mx-auto">
    <header class="page-header mb-10 border-b border-white/5 pb-4">
        <h1 class="page-title text-3xl font-extrabold text-white font-display">
            <?php esc_html_e( 'AI & Tech News Portal', 'quantum-mentor-world' ); ?>
        </h1>
        <p class="text-xs text-slate-400 mt-2">Discover verified news, updates, and releases in technology and open source industries.</p>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/cards/card', 'default' );
            endwhile;

            the_posts_navigation( array(
                'prev_text' => esc_html__( '← Older Articles', 'quantum-mentor-world' ),
                'next_text' => esc_html__( 'Newer Articles →', 'quantum-mentor-world' ),
            ) );
        else :
            ?>
            <div class="glass-card col-span-full p-8 text-center rounded-xl">
                <p class="text-slate-400 text-xs"><?php esc_html_e( 'No news articles registered yet.', 'quantum-mentor-world' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
