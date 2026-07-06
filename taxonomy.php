<?php
/**
 * The template for displaying taxonomy archive pages
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); 
$term = get_queried_object();
?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    
    <!-- Taxonomy Header -->
    <div class="content-header mb-10">
        <span class="badge badge-primary mb-2 text-xs font-semibold uppercase tracking-wider">
            <?php 
            $tax_obj = get_taxonomy( $term->taxonomy );
            echo esc_html( $tax_obj ? $tax_obj->labels->singular_name : 'Taxonomy' ); 
            ?>
        </span>
        <h1 class="text-3xl md:text-4xl font-extrabold text-white font-display"><?php echo esc_html( $term->name ); ?></h1>
        <?php if ( ! empty( $term->description ) ) : ?>
            <p class="text-xs text-[#94A3B8] max-w-2xl mt-2 leading-relaxed"><?php echo esc_html( $term->description ); ?></p>
        <?php endif; ?>
    </div>

    <!-- Grid Loop -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                
                // Load specific card based on queried post type
                $post_type = get_post_type();
                if ( in_array( $post_type, array( 'software', 'watch', 'github_repos' ) ) ) {
                    get_template_part( 'template-parts/card', $post_type );
                } else {
                    get_template_part( 'template-parts/card', 'default' );
                }
            endwhile;

            // Numeric Pagination
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => '← Previous',
                'next_text' => 'Next →',
            ) );

        else :
            ?>
            <div class="glass-card col-span-full p-12 text-center">
                <p class="text-slate-400 text-xs"><?php esc_html_e( 'No resources categorized under this term yet.', 'quantum-mentor' ); ?></p>
            </div>
            <?php
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>
