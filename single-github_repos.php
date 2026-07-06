<?php
/**
 * The template for displaying GitHub Repository detail pages
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        $post_id = get_the_ID();

        // Retrieve metadata fields
        $stars    = get_post_meta( $post_id, 'repo_stars', true );
        $forks    = get_post_meta( $post_id, 'repo_forks', true );
        $license  = get_post_meta( $post_id, 'repo_license', true );
        $repo_url = get_post_meta( $post_id, 'repo_url', true );

        // Taxonomies
        $languages = wp_get_post_terms( $post_id, 'repo_language', array( 'fields' => 'names' ) );
        $language   = ! is_wp_error( $languages ) && ! empty( $languages ) ? $languages[0] : 'Open Source';
        ?>

        <!-- Breadcrumbs Navigation -->
        <nav class="breadcrumbs mb-6 text-xs text-[#94A3B8] font-medium flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#00D4FF]">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url( home_url( '/github-repos/' ) ); ?>" class="hover:text-[#00D4FF]">GitHub Repos</a>
            <span>/</span>
            <span class="text-white"><?php the_title(); ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Column (Details, Instructions) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Header Card -->
                <div class="glass-card p-8 border-t-4 border-[#7C3AED]">
                    <div class="flex items-center space-x-4 mb-4">
                        <svg class="w-12 h-12 text-[#7C3AED]" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
                        </svg>
                        <div>
                            <div class="flex flex-wrap gap-2 mb-1">
                                <span class="badge badge-secondary"><?php echo esc_html( $language ); ?></span>
                                <span class="badge badge-primary">Open Source</span>
                            </div>
                            <h1 class="font-display text-2xl font-extrabold text-white"><?php the_title(); ?></h1>
                        </div>
                    </div>

                    <p class="text-xs text-slate-400 mb-6 leading-relaxed"><?php echo esc_html( get_the_excerpt() ); ?></p>
                </div>

                <!-- Documentation -->
                <div class="glass-card p-8">
                    <h2 class="font-display text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Repository & Integration Guide</h2>
                    <div class="prose prose-invert text-sm text-slate-300 space-y-4">
                        <?php the_content(); ?>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column (Meta Card, URL CTA, Related Content) -->
            <div class="space-y-6">
                
                <!-- Action Card -->
                <div class="glass-card p-6 border-t-4 border-[#00D4FF]">
                    <h3 class="font-display text-md font-bold text-white mb-4">Repository Analytics</h3>
                    
                    <div class="space-y-3 mb-6 text-xs text-slate-300">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Stars Count:</span>
                            <span class="font-semibold text-[#00D4FF]"><?php echo esc_html( $stars ? $stars : '0' ); ?> ★</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Forks Count:</span>
                            <span class="font-semibold text-white"><?php echo esc_html( $forks ? $forks : '0' ); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">License:</span>
                            <span class="font-semibold text-white"><?php echo esc_html( $license ? $license : 'MIT' ); ?></span>
                        </div>
                    </div>

                    <?php if ( ! empty( $repo_url ) ) : ?>
                        <a href="<?php echo esc_url( $repo_url ); ?>" class="neon-btn text-center justify-center py-3 w-full" target="_blank" rel="noopener noreferrer">
                            Clone GitHub Repository
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Related Content -->
                <div class="glass-card p-6">
                    <h3 class="font-display text-md font-bold text-white mb-4">Related Repositories</h3>
                    <div class="space-y-4">
                        <?php
                        $related_args = array(
                            'post_type'      => 'github_repos',
                            'posts_per_page' => 3,
                            'post__not_in'   => array( $post_id ),
                            'orderby'        => 'rand',
                        );
                        $related_query = new WP_Query( $related_args );
                        if ( $related_query->have_posts() ) :
                            while ( $related_query->have_posts() ) : $related_query->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="flex items-center space-x-3 p-2 rounded hover:bg-white/5 transition-colors">
                                <div class="w-10 h-10 rounded bg-[#0F172A] flex-shrink-0 flex items-center justify-center border border-white/5">
                                    <span class="text-xs text-[#7C3AED]">⌥</span>
                                </div>
                                <div>
                                    <h4 class="font-display text-xs font-bold text-white line-clamp-1"><?php the_title(); ?></h4>
                                    <span class="text-[9px] text-[#00D4FF]"><?php echo esc_html( get_post_meta( get_the_ID(), 'repo_stars', true ) ); ?> Stars</span>
                                </div>
                            </a>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="text-[10px] text-slate-400">No related repositories found.</p>';
                        endif;
                        ?>
                    </div>
                </div>

            </div>

        </div>

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
